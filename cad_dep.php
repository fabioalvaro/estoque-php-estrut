

<?php
include_once 'banco/conexao.php'; //include do banco

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
    $busca = 'SELECT * from departamentos';
    $qry_limitada = mysql_query("$busca LIMIT $inicio,$total_reg");
    $linha = mysql_fetch_assoc($qry_limitada);

    // Total de Registros na tabela    
    $qry_total = mysql_query('SELECT count(*)as total from departamentos');
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
                <td> <a href='cad_dep.php?acao=edit&id=123'>alterar</a> | 
                <a href='cad_dep.php?acao=excluir&id=123'>excluir</a>  </td> 
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

    //decide proxima
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
 * Funcao que grava o departamento no banco
 * @global type $con variavel global
 * @param type $descricao valor a ser gravado.
 */
function salvaRegistro($descricao) {
    GLOBAL $con;

    $query = "INSERT INTO departamentos(descricao)" .
            " VALUES('" . $descricao . "')";

    mysql_query($query, $con) or die(mysql_error());
}

/**
 * Funcao que desenha o formulario na tela
 * @param nao precisa
 * @return Formulario HTML
 */
function criaform() {
    //formulario aqui
    ?>
    <form action="cad_dep.php" 
          method="post" 
          style="background-color: grey">
        Descricao:<input type="text" name="descricao" id="descricao">
        <input type="submit" value="Inserir">
    </form>
    <?php
}
?>



<!-- Continua o fluxo de desenhar a página -->

<h1>Cadastro departamentos</h1>
<?php
//insere o topo da pagina
include_once 'comum/topo.php';

// verifico se veio por get o numero da pagina
$_SESSION['pagina'] = isset($_GET['pagina']) ? $_GET['pagina'] : null;

//verifica se veio por post pagina (salvou?)
if (sizeof($_POST) == 0) {
    // desenha o form
    criaform();
    mostraGrid();
} else {
    //mostra o que foi recebido do post e apenas informo
    salvaRegistro($_POST['descricao']);
    echo "Registro cadastrado com sucesso! ";
    echo "<br><a href='cad_dep.php'> voltar</a>";
}

//Insere o rodape da pagina.
include_once 'comum/base.php';
?>