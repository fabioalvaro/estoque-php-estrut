
<?php
//Adiciona a referencia ao banco
include_once 'banco/conexao.php'; //include do banco
//
//Busca os registros para o Grid
global $con;
$busca = 'SELECT * from estoques';
$qry_limitada = mysql_query($busca);
$linha = mysql_fetch_assoc($qry_limitada);

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Lista Estoques</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <h1>Lista de Estoques</h1>
        <p>Tipo: Completa | Data/Hora Impressão:<?php echo date("d/m/Y h:i:s");?></p>
        <table border="0">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Descricao</th>
                </tr>
            </thead>
            <tbody>
                 <?php
            do {
                echo "
                <tr>
                <td>" . $linha['id'] . "</td>
                <td>" . $linha['descricao'] . "</td>                
                </tr>";
            } while ($linha = mysql_fetch_assoc($qry_limitada));
            ?>
            </tbody>
        </table>

    </body>
</html>
