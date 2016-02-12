<?php
//Adiciona Controle de Sessao
include_once 'controleSessao.php'; //include do banco
sessao_valida();

// Adiciona a referencia ao banco
include_once 'banco/conexao.php';


//recebe variaveis
$dt1 = isset($_POST['dt1']) ? $_POST['dt1'] : null;
$dt2 = isset($_POST['dt2']) ? $_POST['dt2'] : null;
$pro1 = isset($_POST['pro1']) ? $_POST['pro1'] : null;
$pro2 = isset($_POST['pro2']) ? $_POST['pro2'] : null;
$tipomov =isset($_POST['tipomov']) ? $_POST['tipomov'] : null;

$buscaKardex = 'select k.*, p.descricao as pdescricao,e.descricao as edescricao,t.name as tdescricao,c.nome as cnome
    from kardexs k
    left join produtos p on (p.id=k.produto_id)
    left join estoques e on (e.id=k.estoque_id)
    left join tiposmovimentos t on (t.id=k.tiposmovimento_id)
     left join clifors c on (c.id=k.clifor_id) ';

$where = ' WHERE (k.created between "' . $dt1 . '" and "' . $dt2 . '")' .
        ' AND (k.produto_id between "' . $pro1 . '" and "' . $pro2 . '")';

if ($tipomov!=null) $where = $where . "AND tiposmovimento_id='".$tipomov."'";

$qry_kardex = mysql_query($buscaKardex . $where);



$linha = mysql_fetch_assoc($qry_kardex);


$titulo = "Period " . $dt1 . " between " . $dt2 . "Product " . $dt1 . " between " . $pro2;
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Kardex Report</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <h1>Kardex Report</h1>
        <p><?php echo $titulo; ?> Date/Time Printed:<?php echo date("d/m/Y h:i:s"); ?></p>
        <table border="1">
            <thead>
                <tr>
                    <th>id</th>
                    <th>date</th>
                    <th>type stock mov.</th>
                    <th>customer</th>
                    <th>product</th>
                    <th>stocking location</th>
                    <th>start signal</th>
                    <th>signal</th>
                    <th>quantity</th>
                    <th>final amount</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $saldoacc =0;
                do {
                    $qtd = isset($linha['qtdtotal']) ? $linha['qtdtotal'] : "0";
                    $saldoacc_pre=$saldoacc;
                    if ($linha['sinal']=='+'){
                    $saldoacc= $saldoacc+$linha['qtd'];    
                    }else{
                    $saldoacc= $saldoacc-$linha['qtd'];    
                    }
                    
                    
                    echo "
                <tr>
                <td>" . $linha['id'] . "</td>
                <td>" . $linha['created'] . "</td>
                    <td>" . $linha['tiposmovimento_id'] ." ".$linha['tdescricao']. "</td>
                        <td>" . $linha['clifor_id'] ." ".$linha['cnome'] . "</td>
                            <td>" . $linha['produto_id'] ." ".$linha['pdescricao']. "</td>
                                <td>" . $linha['estoque_id'] ." ".$linha['edescricao']. "</td>
                                    <td>" . $saldoacc_pre . "</td>
                                    <td>" . $linha['sinal'] . "</td>
                <td>" . $linha['qtd'] . "</td>
                <td>" . $saldoacc . "</td>
                </tr>";
                } while ($linha = mysql_fetch_assoc($qry_kardex));
                ?>
            </tbody>
        </table>

    </body>
</html>
