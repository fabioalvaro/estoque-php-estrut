
<?php

    

    // Adiciona a referencia ao banco
    include_once 'banco/conexao.php'; 

    // Include do banco
    
    // Busca os registros para o Grid
    global $con;

    $ordem = isset($_GET['ordem']) ? $_GET['ordem'] : 'alfabetica';    
    $tipo =  isset($_GET['tipo']) ? $_GET['tipo'] : 'departamento';
    $filtro_zero =  isset($_GET['filtro-zero']) ? $_GET['filtro-zero'] : 'sim';

    $busca = 'select P.*,sum(pe.qtd) as qtdtotal,d.descricao as dep_descricao, d.id as dep_id  from produtos P
    left join departamentos d on (d.id = P.departamento_id) 
    left join produtos_estoques pe on (pe.idproduto=P.id) ';
    
    $where='';
    if ($filtro_zero=='sim')
    $where = ' WHERE pe.qtd >0 ';
    
     $groupby = " group by P.id";
    $busca = $busca . $where .$groupby;

    if ($tipo == 'simples') {
        $busca .=  " ORDER BY d.id";
    }
    
    if ($tipo == 'departamento') {
        $busca = $busca  . " ORDER BY P.departamento_id";
    }
    
    

    if ($ordem == 'alfabetica') {
        $busca = $busca  . " , P.descricao";
    }
    
    if ($ordem == 'codigo') {
       $busca = $busca  . " , P.id";
    }
    
   

    $qry_limitada = mysql_query($busca);
    $linha = mysql_fetch_assoc($qry_limitada);

   
    $titulo = "Ordem " . $ordem." tipo: ". $tipo;
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Lista Produtos</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <h1>Lista de Produtos</h1>
        <p><?php echo $titulo; ?> Data/Hora Impressão:<?php echo date("d/m/Y h:i:s"); ?></p>
      
        <?php  if ( $tipo == 'simples' ) {?>
        <table border="0">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Descricao</th>
                    <th>Custo</th>
                    <th>depto Id</th>
                    <th>depto Descricao</th>
                    <th>qtd total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                do {
                    $qtd = isset($linha['qtdtotal'])?$linha['qtdtotal']:"0";
                    echo "
                <tr>
                <td>" . $linha['id'] . "</td>
                <td>" . $linha['descricao'] . "</td> 
                <td>R$ " . $linha['custo'] . "</td>
                <td>" . $linha['dep_id'] . "</td>
                <td>" . $linha['dep_descricao'] . "</td>
                 <td>" . $qtd . "</td>
                </tr>";
                } while ($linha = mysql_fetch_assoc($qry_limitada));
                ?>
            </tbody>
        </table>
        <?php } ?>
        
        <?php  if ( $tipo == 'departamento' ) {?>
        <table border="0">
            <thead>
                <tr>
                    <th>Depto ID</th>
                    <th>Depto Descricao</th>                    
                    <th>ID</th>
                    <th>Descricao</th>  
                    <th>Custo</th>
                    <th>Qtd Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $accprod=0;
                $dep=null;
                do {
                     if ($dep!=$linha['dep_id']){
                         $dep=$linha['dep_id'];
                          
                          echo "<tr><td><h3>DEPARTAMENTO ".$linha['dep_descricao']."</h3></td></tr>";                          
                    }else{
                        $accprod++;
                    }
                    $qtd = isset($linha['qtdtotal'])?$linha['qtdtotal']:"0";
                    echo "<tr>
                          <td>" . $linha['dep_id'] . "</td>
                          <td>" . $linha['dep_descricao'] . "</td>
                          <td>" . $linha['id'] . "</td>
                          <td>" . $linha['descricao'] . "</td> 
                          <td>R$ " . $linha['custo'] . "</td>
                          <td>" . $qtd . "</td>
                          </tr>";
                   
                } while ($linha = mysql_fetch_assoc($qry_limitada));
                ?>
            </tbody>
        </table>
        <?php } ?>        

    </body>
</html>
