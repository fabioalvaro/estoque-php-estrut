<?php

    

    // Adiciona a referencia ao banco
    include_once 'banco/conexao.php'; 
    
var_dump($_POST);
//recebe variaveis
$dt1 = isset($_POST['dt1'])?$_POST['dt1']:null;
$dt2 = isset($_POST['dt2'])?$_POST['dt2']:null;
$pro1 = isset($_POST['pro1'])?$_POST['pro1']:null;
$pro2 = isset($_POST['pro2'])?$_POST['pro2']:null;

   $buscaKardex = 'select * from kardexs';
  

    $qry_kardex = mysql_query($buscaKardex);
    $linha = mysql_fetch_assoc($qry_kardex);

   
    $titulo = "Periodo " . $dt1." entre ". $dt2. "Produto ".$dt1." até ".$pro2;   

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Lista Kardex</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
          <h1>Lista Kardex</h1>
          <p><?php echo $titulo; ?> Data/Hora Impressão:<?php echo date("d/m/Y h:i:s"); ?></p>
        <table border="1">
            <thead>
                <tr>
                    <th>id</th>
                    <th>descricao</th>
                    <th>Data</th>
                    <th>movimento</th>
                    <th>qtd</th>
                    <th>saldo</th>
                </tr>
            </thead>
           <tbody>
                <?php
                do {
                    $qtd = isset($linha['qtdtotal'])?$linha['qtdtotal']:"0";
                    echo "
                <tr>
                <td>" . $linha['id'] . "</td>
                <td>" . $linha['created'] . "</td>                 
                <td>" . $qtd . "</td>
                </tr>";
                } while ($linha = mysql_fetch_assoc($qry_kardex));
                ?>
            </tbody>
        </table>

    </body>
</html>
