<?php include_once 'comum/topo.php'; ?>

<?php 
include_once 'banco/conexao.php'; //include do banco

/**
 * Funcao que grava o departamento no banco
 * @global type $con variavel global
 * @param type $descricao valor a ser gravado.
 */
function salvaRegistro($descricao){
    GLOBAL $con;
    
    $query = "INSERT INTO departamentos(descricao)".
            " VALUES('" . $descricao . "')";

    mysql_query($query, $con) or die(mysql_error());    
}

?>




<div>Cadastro departamentos</div>
<?php
//verifica se veio por post
if (sizeof($_POST) == 0) {
    // desenha o form
    criaform();
} else {
    //mostra o que foi recebido do post
    salvaRegistro($_POST['descricao']);
    echo "Registro cadastrado: " . $_POST['descricao'];
    echo "<br><a href='cad_dep.php'> voltar</a>";
}

/**
 * Funcao que desenha o formulario
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












































<?php
include_once 'comum/base.php';
