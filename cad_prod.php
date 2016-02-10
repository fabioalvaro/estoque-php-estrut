<?php
/**
 * Cadastro de Departamentos CRUD
 * 
 * @author Fabio Alvaro
 */
//Adiciona a referencia ao banco
include_once 'banco/conexao.php'; //include do banco

/**
 * Remove o registro pelo ID  
 * @param type $id 
 */
function removeRegistro($id) {
    GLOBAL $con;

    $query = "delete from produtos where id='" . $id . "'";

    mysql_query($query, $con) or die(mysql_error());
}

/**
 * Cria o formulario de exclusao para confirmar com o usuario
 * antes da operacao
 * @param type $id é o identificado do registro
 */
function criaformExclusao($id) {
    ?>
    <form name="frmdelete" action="cad_prod.php" method="POST"
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
 * Cria o Formulario de edicao
 * @param type $idProduto id que ira ser editado
 */
function criaformEdicao($idProduto) {
    //ir no banco e buscar o registro completamente    
    global $con;

    $qry_limitada = mysql_query('SELECT * from produtos WHERE id=' . $idProduto);
    $linha = mysql_fetch_assoc($qry_limitada);
    //var_dump($linha);
    ?>
    <form name="formeditar" id="formeditar" action="cad_prod.php" 
          method="POST"  style="background-color: green">
        <input type="hidden" name="acao_post" id="acao_post" value="editar" />
        Id: <?php echo $idProduto; ?><input type="hidden" id="id" name="id" value="<?php echo $idProduto; ?>" /><br>
        Descrição:<input type="text" id="descricao" name="descricao" value="<?php echo $linha['descricao'] ?>" /><br>
        <input type="submit" value="Atualizar" name="btnatualizar" />
    </form>  
    <?php
}

/**
 * Cria o formulario de insercao
 * @param nao precisa
 * @return Formulario HTML
 */
function criaform($iddep = null) {
    //formulario aqui
    ?>
    <form action="cad_prod.php" 
          method="post" 
          style="background-color: grey">
        Departamento : <input type="text" id="departamento_id" name="departamento_id" value="<?php echo $iddep ?>"  /> | <a href="cad_prod.php?acao=buscadep">Buscar Departamentos </a><br>          
        Descricao  <input type="text" name="descricao" value="Coca Cola Lata" /><br>
        Custo  <input type="text" id="custo" name="custo" value="3,50" /><br>

        <input type="submit" value="Inserir">

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
    $busca = 'select P.*,d.descricao as dep_descricao,d.id as dep_id from produtos P
left join departamentos d on (d.id=P.departamento_id)';
    $qry_limitada = mysql_query("$busca LIMIT $inicio,$total_reg");
    $linha = mysql_fetch_assoc($qry_limitada);

    // Total de Registros na tabela    
    $qry_total = mysql_query('SELECT count(*)as total from produtos');
    $linha_total = mysql_fetch_assoc($qry_total); //recupera a linha
    $total_registros = $linha_total['total']; //pega o valor
    ?>

    <table border="1">
        <thead>
            <tr>
                <th>id</th>

                <th>descricao</th>
                <th>custo</th>
                <th>depto</th>
                <th>acao</th>
            </tr>
        </thead>
        <tbody>
            <?php
            do {
                echo "
                <tr>
                
                <td>" . $linha['id'] . "</td>                
                <td>" . $linha['descricao'] . "</td>
                <td>" . $linha['custo'] . "</td>
                <td>" . $linha['dep_id'] . " " . $linha['dep_descricao'] . "</td>
                <td> <a href='cad_prod.php?acao=editar&id=" . $linha['id'] . "'>alterar</a> | 
                <a href='cad_prod.php?acao=excluir&id=" . $linha['id'] . "'>excluir</a>  </td> 
                </tr>";
            } while ($linha = mysql_fetch_assoc($qry_limitada));
            ?>
        </tbody>
    </table>
    <?php
    echo navegacao($pc, $total_registros);
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
 * Funcao que grava o produto no banco
 * 
 * @param array $dados conjunto de valores a serem gravados
 */
function salvaRegistro($dados) {
    GLOBAL $con;


    //Validação Server Side
    $erro_mg = '';
    if (!isset($dados['descricao']) || $dados['descricao'] == '') {
        $erro_mg .=' descricao é um campo obrigatorio ' . PHP_EOL;
    };
    if (!isset($dados['custo']) || $dados['custo'] == '') {
        $erro_mg .=' custo é um campo obrigatorio ' . PHP_EOL;
    };
    if (!isset($dados['departamento_id']) || $dados['departamento_id'] == '') {
        $erro_mg .=' Departamento é um campo obrigatorio ' . PHP_EOL;
    };
    if (strlen($erro_mg) > 0) {
       die("<h1>Erro de Validação!</h1>" . $erro_mg . " Verifique!");      
    }


    //grava no Banco
    $dados['ativo'] = 1;
    $query = "INSERT INTO produtos(descricao,departamento_id,custo,ativo)" .
            " VALUES('" . $dados['descricao'] . "','" . $dados['departamento_id'] . "','" . $dados['custo'] . "','" . $dados['ativo'] . "')";

    mysql_query($query, $con) or die(mysql_error());
}

/**
 * Funcao que atualiza os registros do banco de dados referente a tabela 
 * Departamentos 
 * @param type $dados um array que simboliza os dados a serem persistidos na
 * tabela
 */
function atualizaRegistro($dados) {
    GLOBAL $con;

    //recebendo os valores do array de entrada.
    $id = $dados['id'];
    $descricao = $dados['descricao'];


    $query = "UPDATE produtos set descricao=" .
            " '" . $descricao . "' where id='" . $id . "'";

    mysql_query($query, $con) or die(mysql_error());
}
?>



<!-- Continua o fluxo de desenhar a página -->


<h1>Cadastro de Produtos</h1>
<?php
//insere o topo da pagina
include_once 'comum/topo.php';

// verifico se veio por get o numero da pagina
$_SESSION['pagina'] = isset($_GET['pagina']) ? $_GET['pagina'] : null;

//verifica se veio por post pagina (salvou?)
if (sizeof($_POST) == 0) {




    // Desenha o form de inserir 
    $acao = isset($_GET['acao']) ? $_GET['acao'] : null;
    $id = isset($_GET['id']) ? $_GET['id'] : null;


    if ($acao == null) {
        criaform();
        mostraGrid();
    }
    if ($acao == 'cadastro') {
        $iddep = isset($_GET['iddep']) ? $_GET['iddep'] : null;
        criaform($iddep);
        mostraGrid();
    }

    //mostra form de edicao
    if ($acao == 'editar') {
        criaformEdicao($id);
    }
    //mostra o form de exclusao
    if ($acao == 'excluir') {
        criaformExclusao($id);
    }

    //buscar departamentos
    if ($acao == 'buscadep') {
        criaFormBuscadep();
    }
} else {


    // mostra o que foi recebido do post e 
    // faco uma acao dependendo do que foi requisitado
    //estou vindo do inserir ou do atualizar ou excluir?
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $acao_post = isset($_POST['acao_post']) ? $_POST['acao_post'] : null;

    if ($id == null && $acao_post == null) {
        salvaRegistro($_POST);
        echo "Registro cadastrado com sucesso! ";
        echo "<br><a href='cad_prod.php'> voltar</a>";
    }

    //Atualizar
    if ($id != null && $acao_post == 'editar') {
        $pacoteenvio['id'] = $id;
        $pacoteenvio['descricao'] = $_POST['descricao'];
        atualizaRegistro($pacoteenvio);
        echo "Registro Atualizado com sucesso! ";
        echo "<br><a href='cad_prod.php'> Voltar</a>";
    }

    // Excluir
    if ($id != null && $acao_post == 'excluir') {
        removeRegistro($id);
        echo "Registro Removido com sucesso! ";
        echo "<br><a href='cad_prod.php'> Voltar</a>";
    }

    //Post do buscar departamentos
    if ($acao_post == 'buscadep') {
        criaFormBuscadep($_POST['busca']);
    }
}

/**
 * Busca o Departamento
 * @param string $texto campo que deve ser preenchida a busca por default
 */
function criaFormBuscadep($texto = null) {
    //mostra resultados caso tenha sido informado
    if ($texto != null) {

        global $con;
        $busca = 'select * from departamentos where upper(descricao) like upper("%' . $texto . '%")';

        if (strlen($texto) < 3) {
            echo "<h3> Voce deve digitar no minimo 3 caracteres</h3>";
            $busca = 'select * from departamentos where id =-1';
        }
        $qry_limitada = mysql_query($busca);
        $linha = mysql_fetch_assoc($qry_limitada);
    } else {
        
    }
    ?>
    <form name="frmbusca" action="cad_prod.php?acao=buscadep&acao2=post" method="POST">
        <h2>Cad.Produtos > Busca departamentos</h2>
        <input type="hidden" name="acao_post" id="acao_post" value="buscadep" />
        Descricao do departamento: <input type="text" name="busca" id="busca" value="<?php echo $texto ?>" /><br>
        <input type="submit" value="Buscar" name="btnbuscardep" /><br><hr>
        Retorno:<br>
        <table border="1">
            <thead>
                <tr>
                    <th>id</th>
                    <th>descricao</th>
                    <th>acao</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (strlen($texto) < 3) {
                    echo "<tr ><td colspan='3'>Nenhum Registro</td></tr>";
                } else
                    do {
                        echo "
                        <tr>

                        <td>" . $linha['id'] . "</td>                
                        <td>" . $linha['descricao'] . "</td>                
                        <td> <a href='cad_prod.php?acao=cadastro&iddep=" . $linha['id'] . "'>Selecionar</a> </td> 
                        </tr>";
                    } while ($linha = mysql_fetch_assoc($qry_limitada));
                ?>
            </tbody>
        </table>




    </form>
    <?php
}
