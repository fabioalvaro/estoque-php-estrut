<?php
session_start();

//Adiciona a referencia ao banco
include_once 'banco/conexao.php'; //include do banco

// verifico se veio por get o numero da pagina
$_SESSION['pagina'] = isset($_GET['pagina']) ? $_GET['pagina'] : null;

$acao = isset($_GET['acao']) ? $_GET['acao'] : 'step1';

/**
 * Essa função cria um paginador style pra ficar junto do grid
 * que mostra os registros na tela.
 * 
 * @param type $pagina página atual
 * @param type $total total de registro as serem paginados
 */
function navegacao($pagina = 1, $total = 0) {
    //maximo de registros por tela
    $total_reg = 3;
    //calcula quantas telas
    $maxpaginas = intval($total / $total_reg);

    //adiciona mais uma tela em caso de divisao com quebra
    $temmod = $total % $total_reg;

    if ($temmod)
        $maxpaginas = $maxpaginas + 1;

    // decide primeira
    if ($pagina == 1)
        $link_primeiro = " << ";
    else {
        $link_primeiro = "<a href='?pagina=1'><<</a>";
    }

    //decide anterior 
    if ($pagina == 1)
        $link_anterior = " < ";
    else {
        $anterior = $pagina - 1;
        $link_anterior = "<a href='?pagina=" . $anterior . "'><</a>";
    }

    // decide proxima
    if ($maxpaginas == $pagina)
        $link_posterior = " > ";
    else {
        $link_posterior = "<a href='?pagina=" . ($pagina + 1) . "'> > </a>";
    }
    //decide ultima
    if ($maxpaginas == $pagina)
        $link_ultimo = " >> ";
    else {
        $link_ultimo = "<a href='?pagina=" . $maxpaginas . "'>>></a>";
    }

    $label_total = ' Total de Registros: ' . $total;

    //Monta a barra de Navegacao
    echo "<br>";
    echo $link_primeiro . "  |  " . $link_anterior . " | " . $link_posterior . " | " . $link_ultimo . " " . $label_total;
}

/**
 * Cria o formulario de exclusao para confirmar com o usuario
 * antes da operacao
 * @param type $id é o identificado do registro
 */
function criaformExclusao($id) {
    ?>
    <form name="frmdelete" action="cad_estoque.php" method="POST"
          style="background-color: yellow">
        <input type="hidden" name="id" id="id" value="<?php echo $id ?>" />        
        <input type="hidden" name="acao_post" id="acao_post" value="excluir" />
        Tem certeza que deseja excluir o registro <?php echo $id ?>?
        <input type="submit" value="SIM" name="btnsim" />
        <input type="reset" value="NAO" name="btnnao" onclick="window.history.back();"/>

    </form>
    <?php
}


/**
 *  Desenha o grid na tela
 * 
 * @global type $con
 */
function mostraGrid() {
    $total_reg = "3"; // número de registros por página


    $pagina = $_SESSION['pagina'];

    //Current Page / Pagina Atual
    if (!$pagina) {
        $pc = "1";
    } else {
        $pc = $pagina;
    }

    $inicio = $pc - 1;
    $inicio = $inicio * $total_reg;

    //Busca os registros para o Grid
    global $con;
    $busca = 'SELECT * from kardexs';
    $qry_limitada = mysql_query("$busca LIMIT $inicio,$total_reg");
    $linha = mysql_fetch_assoc($qry_limitada);
    

    // Total de Registros na tabela    
    $qry_total = mysql_query('SELECT count(*)as total from kardexs');
    $linha_total = mysql_fetch_assoc($qry_total); //recupera a linha
    $total_registros = $linha_total['total']; //pega o valor
    ?>

    <table border="1">
        <thead>
            <tr>
                <th>Id</th>
                <th>Data Movimento</th>
                <th>Produto</th>
                <th>Estoque</th>
                <th>Tipo Movimento</th>
                <th>Qtd</th>
                <th>Acao</th>
            </tr>
        </thead>
        <tbody>
            <?php
            do {
                echo "
                <tr>
                <td>" . $linha['id'] . "</td>
                <td>" . $linha['created'] . "</td>".
                "<td>" . $linha['produto_id'] . "</td>".
                 "<td>" . $linha['estoque_id'] . "</td>".
                          "<td>" . $linha['tiposmovimento_id'] . "</td>".
                "<td>" . $linha['qtd'] . "</td>".
                "<td> <a href='cad_kardex.php?acao=excluir'>Excluir</a></td>".
                "</tr>";
                
            } while ($linha = mysql_fetch_assoc($qry_limitada));
            ?>
        </tbody>
    </table>
    <?php
    echo navegacao($pc, $total_registros);
}



if ($acao == 'step2') {
    $_SESSION['produto_id'] = $_POST['combo_prod'];
}
if ($acao == 'step3') {
    $_SESSION['estoque_id'] = $_POST['combo_estoque'];
}
if ($acao == 'step4') {
    $_SESSION['qtd'] = $_POST['qtd'];
    $_SESSION['combo_mov'] = $_POST['combo_mov'];
}
if ($acao == 'step5') {
    //Grava no banco
    
    //insere na kardex
   
    $dados['tiposmovimento_id']=$_SESSION['combo_mov'];
    $dados['clifor_id']=1;
    $dados['produto_id']=$_SESSION['produto_id'];
    $dados['estoque_id']=$_SESSION['estoque_id'];   
    $dados['qtd']=$_SESSION['qtd']; 
    gravaKardex($dados);
    
    //atualiza estoque
    
}

function gravaKardex($dados){
    GLOBAL $con;


    //Validação Server Side
    $erro_mg = '';
    if (!isset($dados['tiposmovimento_id']) || $dados['tiposmovimento_id'] == '') {
        $erro_mg .=' tiposmovimento_id é um campo obrigatorio ' . PHP_EOL;
    };
    if (!isset($dados['produto_id']) || $dados['produto_id'] == '') {
        $erro_mg .=' produto_id é um campo obrigatorio ' . PHP_EOL;
    };
    if (!isset($dados['estoque_id']) || $dados['estoque_id'] == '') {
        $erro_mg .=' estoque_id é um campo obrigatorio ' . PHP_EOL;
    };
    if (strlen($erro_mg) > 0) {
        die("<h1>Erro de Validação!</h1>" . $erro_mg . " Verifique!");
    }


    //grava no Banco
    $dados['ativo'] = 1;
    $dados['created']='2016-01-01 00:00:00';
    $query = "INSERT INTO kardexs(created,tiposmovimento_id,clifor_id,produto_id,estoque_id,ativo,qtd)" .
            " VALUES('" . 
            $dados['created'] . "','" . 
            $dados['tiposmovimento_id'] . "','" . 
             $dados['clifor_id'] . "','" . 
             $dados['produto_id'] . "','" .             
            $dados['estoque_id'] . "','" . 
            $dados['ativo'] . "','" . 
            $dados['qtd'] . "')";
    
    echo $query;

    mysql_query($query, $con) or die(mysql_error());
}

 
?>
<!DOCTYPE html>

<html>
    <head>
        <title>Cadastro de Kardex</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>

        <h1>Cadastro de Movimento / Kardex</h1>
        <hr>
        <a href="cad_kardex.php?acao=step1">PASSO 1</a> > <a href="cad_kardex.php?acao=step2">PASSO 2</a> > <a href="cad_kardex.php?acao=step3">PASSO 3</a>
        <hr>

        <?php

        function mostraForm1() { ?>
            <form name="frm" action="cad_kardex.php?acao=step2" method="POST">
                <p>Selecione o produto que deseja movimentar e clique no botão próximo...</p>
                produto <select name="combo_prod" id="combo_prod">
                    <option value="1">Coca</option>
                    <option value="2">Pedra</option>
                </select><br><br>


                <input type="submit" value="Próximo >>" name="lalalal" />
            </form>
<?php } ?>
<?php

function mostraForm2() { ?>
            <form name="frm" action="cad_kardex.php?acao=step3" method="POST">
                <p>Selecione o Estoque que deseja movimentar o produto "
                    <?php if (isset($_SESSION['produto_id'])) echo $_SESSION['produto_id'] ?>"
                    e clique no botão próximo...</p>
                Estoque <select name="combo_estoque" id="combo_estoque">
                    <option value="1">1 Siri Cascudo</option>
                    <option value="2">2 Praia areia Branca</option>
                </select><br> <br> 

                <input type="submit" value="Próximo >>" name="lalalal" />
            </form>
<?php } ?>

<?php

function mostraForm3() { ?>
            <form name="frm" action="cad_kardex.php?acao=step4" method="POST">
                <p>Selecione a quantidade e o tipo de movimento que deseja 
                    movimentar.
                    </p>
                    <p>Estoque <?php if (isset($_SESSION['estoque_id'])) echo $_SESSION['estoque_id'] ?></p>
                    <p>Produto <?php if (isset($_SESSION['produto_id'])) echo $_SESSION['produto_id'] ?></p>                
                quantidade: <input type="text" name="qtd" id="qtd"value="50" />
                Tipo movimento :
                <select name="combo_mov" id="combo_mov">
                    <option value="1">Entrada +</option>
                    <option  value="2">Saida -</option>
                </select><br><br>

                <input type="submit" value="Próximo >>" name="lalalal" />
            </form>        
<?php } ?>

<?php

function mostraForm4() { ?>
            <form name="frm" action="cad_kardex.php?acao=step5" method="POST">
                <h2>Form 4</h2>
                    <p>Confirme os dados:</p>
                    <p>Estoque <?php if (isset($_SESSION['estoque_id'])) echo $_SESSION['estoque_id'] ?></p>
                    <p>Produto <?php if (isset($_SESSION['produto_id'])) echo $_SESSION['produto_id'] ?></p>     
                    <p>Quantidade <?php if (isset($_SESSION['qtd'])) echo $_SESSION['qtd'] ?></p>
                    <p>Tipo Movimento <?php if (isset($_SESSION['combo_mov'])) echo $_SESSION['combo_mov'] ?></p><br><br>
                <input type="submit" value="Finalizar >>" name="lalalal" />
            </form>        
<?php } ?>      
<?php

function mostraForm5() { ?>
            <form name="frm" action="cad_kardex.php?acao=step1" method="POST">
                <h2>Form 5</h2>
                    <p>Processo realizado com sucesso!</p><br><br>
                <input type="submit" value="Novo Movimento Kardex" name="lalalal" />
            </form>        
<?php } ?>           


        <?php
        if ($acao == 'step1') {
            mostraForm1();
        }
        if ($acao == 'step2') {
            mostraForm2();
        }
        if ($acao == 'step3') {
            mostraForm3();
        }
        if ($acao == 'step4') {
            mostraForm4();
        }
        if ($acao == 'step5') {
            mostraForm5();
        }
        ?>
<br>
<?php
        mostraGrid();
?>

    </body>
</html>
