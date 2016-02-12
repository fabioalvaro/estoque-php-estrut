<?php
//inicia a sessao
session_start();

//Adiciona a referencia ao banco
include_once 'banco/conexao.php'; //include do banco
// verifico se veio por get o numero da pagina
$_SESSION['pagina'] = isset($_GET['pagina']) ? $_GET['pagina'] : null;

$acao = isset($_GET['acao']) ? $_GET['acao'] : 'step1';

/**
 * Remove o registro pelo ID  
 * @param type $id 
 */
function removeRegistro($id) {
    GLOBAL $con;

    //busca info
    $querybusca = "select * from kardexs where id='" . $id . "'";
    $qry = mysql_query($querybusca);
    $linha = mysql_fetch_assoc($qry);

    //Apagua
    $query = "delete from kardexs where id='" . $id . "'";
    mysql_query($query, $con) or die(mysql_error());

    if (saldoExiste($linha['produto_id'], $linha['estoque_id'])) {
        //atualiza retirando saldo
        $saldoAtual = saldoByEstoque($linha['produto_id'], $linha['estoque_id']);
        if ($linha['sinal'] == '+') {
            $saldoAtual_acerto = $saldoAtual - $linha['qtd'];
        } else {
            $saldoAtual_acerto = $saldoAtual + $linha['qtd'];
        }


        saldo_atualiza($linha['produto_id'], $linha['estoque_id'], $saldoAtual_acerto);
    }
}

function saldoExiste($produto, $estoque) {
    global $con;
    $busca = 'select * from produtos_estoques where idproduto =' . $produto . ' and ' .
            ' idestoque=' . $estoque . '';
    $qry = mysql_query($busca);


    $linha = mysql_fetch_assoc($qry);
    if (sizeof($linha) > 1) {
        return 1;
    } else {
        return 0;
    }
}

/**
 * Essa função cria um paginador style pra ficar junto do grid
 * que mostra os registros na tela.
 * 
 * @param type $pagina página atual
 * @param type $total total de registro as serem paginados
 */
function navegacao($pagina = 1, $total = 0) {
    //maximo de registros por tela
    $total_reg = 20;
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
    <form name="frmdelete" action="cad_kardex.php?acao=confirmaExcluir&id=<?php echo $id ?>" 
          method="POST"
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
    $total_reg = "20"; // número de registros por página


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
    $busca = 'select k.*, p.descricao as pdescricao,e.descricao as edescricao
    from kardexs k
    left join produtos p on (p.id=k.produto_id)
    left join estoques e on (e.id=k.estoque_id)';
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
                <th>P. Descricao</th>
                <th>Estoque</th>
                                
                <th>Estoque</th>
                <th>Tipo Movimento</th>
                <th>sinal</th>
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
                <td>" . $linha['created'] . "</td>" .
        "<td>" . $linha['produto_id'] . "</td>" .
        "<td>" . $linha['pdescricao'] . "</td>" .
        "<td>" . $linha['estoque_id'] . "</td>" .
       
        "<td>" . $linha['edescricao'] . "</td>" .
                 "<td>" . $linha['tiposmovimento_id'] . "</td>" .
        "<td>" . $linha['sinal'] . "</td>" .
        "<td>" . $linha['qtd'] . "</td>" .
        "<td> <a href='cad_kardex.php?acao=confirmaExcluir&id=" . $linha['id'] . "'>Excluir</a></td>" .
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

            $dados['tiposmovimento_id'] = $_SESSION['combo_mov'];
            $dados['sinal'] = ($_SESSION['combo_mov'] == 1) ? '+' : '-';
            $dados['clifor_id'] = 1;
            $dados['produto_id'] = $_SESSION['produto_id'];
            $dados['estoque_id'] = $_SESSION['estoque_id'];
            $dados['qtd'] = $_SESSION['qtd'];
            gravaKardex($dados);

            //atualiza estoque
        }

        function gravaKardex($dados) {
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
            $dados['created'] = date("Y-m-d h:i:s");
            $query = "INSERT INTO kardexs(created,tiposmovimento_id,clifor_id,"
                    . "produto_id,estoque_id,ativo,qtd,sinal)" .
                    " VALUES('" .
                    $dados['created'] . "','" .
                    $dados['tiposmovimento_id'] . "','" .
                    $dados['clifor_id'] . "','" .
                    $dados['produto_id'] . "','" .
                    $dados['estoque_id'] . "','" .
                    $dados['ativo'] . "','" .
                    $dados['qtd'] . "', '" . $dados['sinal'] . "')";

            //echo $query;

            mysql_query($query, $con) or die(mysql_error());

            // Saldo    
            saldo_grava($dados['produto_id'], $dados['estoque_id'], $dados['qtd'], $dados['sinal']);
        }

        function saldo_grava($produto_id, $estoque_id, $qtd, $sinal) {

            $existe = saldoExiste($produto_id, $estoque_id);


            if ($existe == false) {


                saldo_insere($produto_id, $estoque_id, $qtd);
            }
            if ($existe == true) {


                $saldoatual = saldoByEstoque($produto_id, $estoque_id);
                if ($sinal == '+') {
                    saldo_atualiza($produto_id, $estoque_id, $saldoatual + $qtd);
                } else {
                    saldo_atualiza($produto_id, $estoque_id, $saldoatual - $qtd);
                }
            }

            //die("teste");
        }

        function saldo_insere($produto_id, $estoque_id, $qtd) {
            GLOBAL $con;
            //insere
            $query_insert = "INSERT INTO produtos_estoques(idproduto,idestoque,qtd)" .
                    " VALUES('" .
                    $produto_id . "','" .
                    $estoque_id . "','" .
                    $qtd . "')";
            //echo $query_insert;
            mysql_query($query_insert, $con) or die(mysql_error());
        }

        function saldoByEstoque($produto_id, $estoque_id) {
            global $con;
            $busca = 'select qtd from produtos_estoques where idproduto =' . $produto_id . ' and ' .
                    ' idestoque=' . $estoque_id . '';
            $qry = mysql_query($busca);


            $linha = mysql_fetch_assoc($qry);
            return $linha['qtd'];
        }

        function saldo_atualiza($produto_id, $estoque_id, $qtd) {
            GLOBAL $con;
            //insere
            $query_update = "update produtos_estoques set qtd='" . $qtd . "' where " .
                    " idproduto ='" . $produto_id . "' and idestoque='" .
                    $estoque_id . "'";
            mysql_query($query_update, $con) or die(mysql_error());
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

        <h1><a href="home.php">Cadastro de Movimento / Kardex</a></h1>
        <hr>
        <a href="cad_kardex.php?acao=step1">PASSO 1</a> > <a href="cad_kardex.php?acao=step2">PASSO 2</a> > <a href="cad_kardex.php?acao=step3">PASSO 3</a>
        <hr>

<?php

function mostraForm1() {
    //Busca os Produtos
    global $con;
    $busca = 'select id,descricao from produtos';
    $res_prod = mysql_query($busca);
    $linha = mysql_fetch_assoc($res_prod);
    ?>
            <form name="frm" action="cad_kardex.php?acao=step2" method="POST">
                <p>Selecione o produto que deseja movimentar e clique no botão próximo...</p>
                produto <select name="combo_prod" id="combo_prod">


            <?php
            //Preenche a lista de Produtos 
            do {
                echo "<option value='" . $linha['id'] . "'>" . $linha['descricao'] . "</option>";
            } while ($linha = mysql_fetch_assoc($res_prod));
            ?>

                </select><br><br>


                <input type="submit" value="Próximo >>" name="lalalal" />
            </form>
                <?php } ?>
<?php

function mostraForm2() {
    //Busca os Estoques
    global $con;
    $busca = 'select id,descricao from estoques';
    $res_estoques = mysql_query($busca);
    $linha = mysql_fetch_assoc($res_estoques);
    ?>
            <form name="frm" action="cad_kardex.php?acao=step3" method="POST">
                <p>Selecione o Estoque que deseja movimentar o produto "
            <?php if (isset($_SESSION['produto_id'])) echo $_SESSION['produto_id'] ?>"
                    e clique no botão próximo...</p>
                Estoque <select name="combo_estoque" id="combo_estoque">
            <?php
            //Preenche a lista de Produtos 
            do {
                echo "<option value='" . $linha['id'] . "'>" . $linha['descricao'] . "</option>";
            } while ($linha = mysql_fetch_assoc($res_estoques));
            ?>
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
//valida acoes da pagina
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
if ($acao == 'confirmaExcluir') {

    $acao_post = isset($_POST['acao_post']) ? $_POST['acao_post'] : null;
    $id = isset($_GET['id']) ? $_GET['id'] : null;

    if ($acao_post != null) {
        removeRegistro($id);
        mostraForm1();
    } else {
        criaformExclusao($id);
    }
}
?>
        <br>
        <?php
        mostraGrid();
        ?>

    </body>
</html>
