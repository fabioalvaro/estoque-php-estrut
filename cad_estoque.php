<?php
/**
 * Cadastro de Estoques CRUD
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

    $query = "delete from estoques where id='" . $id . "'";

    mysql_query($query, $con) or die(mysql_error());
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
 * Cria o Formulario de edicao
 * @param type $idEstoque id que ira ser editado
 */
function criaformEdicao($idEstoque) {
    //ir no banco e buscar o registro completamente    
    global $con;

    $qry_limitada = mysql_query('SELECT * from estoques WHERE id=' . $idEstoque);
    $linha = mysql_fetch_assoc($qry_limitada);
    //var_dump($linha);
    ?>
    <form name="formeditar" id="formeditar" action="cad_estoque.php" 
          method="POST"  style="background-color: green">
        <input type="hidden" name="acao_post" id="acao_post" value="editar" />
        Id: <?php echo $idEstoque; ?><input type="hidden" id="id" name="id" value="<?php echo $idEstoque; ?>" /><br>
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
function criaform() {
    //formulario aqui
    ?>
    <form action="cad_estoque.php" 
          method="post" 
          style="background-color: grey">
        Descricao:<input type="text" name="descricao" id="descricao">
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
    $busca = 'SELECT * from estoques';
    $qry_limitada = mysql_query("$busca LIMIT $inicio,$total_reg");
    $linha = mysql_fetch_assoc($qry_limitada);

    // Total de Registros na tabela    
    $qry_total = mysql_query('SELECT count(*)as total from estoques');
    $linha_total = mysql_fetch_assoc($qry_total); //recupera a linha
    $total_registros = $linha_total['total']; //pega o valor
    ?>

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
            do {
                echo "
                <tr>
                <td>" . $linha['id'] . "</td>
                <td>" . $linha['descricao'] . "</td>
                <td> <a href='cad_estoque.php?acao=editar&id=" . $linha['id'] . "'>alterar</a> | 
                <a href='cad_estoque.php?acao=excluir&id=" . $linha['id'] . "'>excluir</a>  </td> 
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
 * Funcao que grava o estoque no banco
 * @global type $con variavel global
 * @param type $descricao valor a ser gravado.
 */
function salvaRegistro($descricao) {

    //Validação Server Side
    $erro_mg = '';
    if (!isset($dados['descricao']) || $dados['descricao'] == '') {
        $erro_mg .=' descricao é um campo obrigatorio ' . PHP_EOL;
    };
    if (strlen($erro_mg) > 0) {
        die("<h1>Erro de Validação!</h1>" . $erro_mg . " Verifique!");
    }


    GLOBAL $con;

    $query = "INSERT INTO estoques(descricao)" .
            " VALUES('" . $descricao . "')";

    mysql_query($query, $con) or die(mysql_error());
}

/**
 * Funcao que atualiza os registros do banco de dados referente a tabela 
 * Estoques 
 * @param type $dados um array que simboliza os dados a serem persistidos na
 * tabela
 */
function atualizaRegistro($dados) {
    GLOBAL $con;

    //recebendo os valores do array de entrada.
    $id = $dados['id'];
    $descricao = $dados['descricao'];


    $query = "UPDATE estoques set descricao=" .
            " '" . $descricao . "' where id='" . $id . "'";

    mysql_query($query, $con) or die(mysql_error());
}
?>



<!-- Continua o fluxo de desenhar a página -->

        <div>Cadastro de Estoque</div>
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
    //mostra form de edicao
    if ($acao == 'editar') {
        criaformEdicao($id);
    }
    //mostra o form de exclusao
    if ($acao == 'excluir') {
        criaformExclusao($id);
    }
} else {
    // mostra o que foi recebido do post e 
    // faco uma acao dependendo do que foi requisitado
    //estou vindo do inserir ou do atualizar ou excluir?
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $acao_post = isset($_POST['acao_post']) ? $_POST['acao_post'] : null;

    if ($id == null) {
        salvaRegistro($_POST['descricao']);
        echo "Registro cadastrado com sucesso! ";
        echo "<br><a href='cad_estoque.php'> voltar</a>";
    }

    //Atualizar
    if ($id != null && $acao_post == 'editar') {
        $pacoteenvio['id'] = $id;
        $pacoteenvio['descricao'] = $_POST['descricao'];
        atualizaRegistro($pacoteenvio);
        echo "Registro Atualizado com sucesso! ";
        echo "<br><a href='cad_estoque.php'> Voltar</a>";
    }

    // Excluir
    if ($id != null && $acao_post == 'excluir') {
        removeRegistro($id);
        echo "Registro Removido com sucesso! ";
        echo "<br><a href='cad_estoque.php'> Voltar</a>";
    }
}




//Insere o rodape da pagina.
include_once 'comum/base.php';
?>