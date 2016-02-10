<?php include_once 'comum/topo.php'; ?>

<?php
include_once 'banco/conexao.php'; //include do banco

/** 
 * 
 * @param type $pagina página atual
 * @param type $total total de registro as serem paginados
 */
function navegacao($pagina=1,$total=0){
    //maximo de registros por tela
    $total_reg = 5;
    //calcula quantas telas
    $maxpaginas   =  intval($total / $total_reg);
    //adiciona mais uma tela em caso de divisao com quebra
    $temmod = $total % $total_reg;
     if( $temmod ) $maxpaginas = $maxpaginas +1;
    
    // decide primeira
    if ($pagina==1)
        $link_primeiro =" << ";
    else{       
          $link_primeiro = "<a href='?pagina=1'><<</a>";     
    }
    
    //decide anterior 
    if ($pagina==1)
        $link_anterior =" < ";
    else{
         $anterior = $pagina - 1;
        $link_anterior ="<a href='?pagina=".$anterior."'><</a>";         
    }    
    
    //decide proxima
    if($maxpaginas==$pagina)
        $link_posterior=" > ";            
        else{            
            $link_posterior="<a href='?pagina=". ($pagina+1) ."'> > </a>";
        }
    //decide ultima
   if($maxpaginas==$pagina)
        $link_ultimo=" >> ";            
        else{            
            $link_ultimo =  "<a href='?pagina=".$maxpaginas."'>>></a>";
        }
    
    //Monta a barra de Navegacao
    echo "<br>";
    echo $link_primeiro ."  |  ". $link_anterior." | ". $link_posterior. " | ". $link_ultimo  ;
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

?>




<div>Cadastro departamentos</div>
<?php

$_SESSION['pagina'] = isset($_GET['pagina'])?$_GET['pagina']:null;

//verifica se veio por post
if (sizeof($_POST) == 0) {
    // desenha o form
    criaform();
    mostraGrid();
} else {
    //mostra o que foi recebido do post
    salvaRegistro($_POST['descricao']);
    echo "Registro cadastrado com sucesso! ";
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

/**
 * 
 * @global type $con
 */
function mostraGrid() {
    $total_reg = "5"; // número de registros por página


    $pagina=$_SESSION['pagina'];
   // $pagina=1;            ;
    
   s
    if (!$pagina) 
        { $pc = "1"; } 
    else { 
        $pc = $pagina; }

    $inicio = $pc - 1; 
    $inicio = $inicio * $total_reg;


    global $con;
    $busca = 'SELECT * from departamentos';
    $query = sprintf("SELECT * from departamentos");
    $qry_limite = mysql_query("$busca LIMIT $inicio,$total_reg"); 
    $qry_todos = mysql_query("$busca");
    $query = $qry_limite;


    //$dados = mysql_query($query, $con) or die(mysql_error());
    //$dados = $qry_limite;
    $linha = mysql_fetch_assoc($qry_limite);
   // $total = mysql_num_rows($qry_limite);
    
    //Total de REgistros
    $sql_total = 'SELECT count(*)as total from departamentos';
    $qry_total = mysql_query($sql_total);
    $linha_total = mysql_fetch_assoc($qry_total); 
    $total = $linha_total['total'];
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
                <a href='cad_dep.php?acao=excluir&id=123&pagina=3'>excluir</a>  </td> 
                </tr>";
            } while ($linha = mysql_fetch_assoc($qry_limite));
            ?>
        </tbody>
    </table>
    <?php
    
    echo navegacao($pagina,$total);
    
}
?>












































<?php
include_once 'comum/base.php';
