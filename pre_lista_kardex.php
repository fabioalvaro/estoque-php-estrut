<?php 
//Adiciona Controle de Sessao
include_once 'controleSessao.php'; //include do banco

//Adiciona a referencia ao banco
include_once 'banco/conexao.php'; //include do banco

sessao_valida();
    //Lista de Tipos de Movimentacao
    global $con;
    $busca_tipos = 'select id,name,sinal from tiposmovimentos where active=1';
    $res_tipomov = mysql_query($busca_tipos);
    $linha = mysql_fetch_assoc($res_tipomov);


?>

<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Lista Kardex</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div>
            <h1>Gerar Relatorio Kardex</h1>
            <form name="frm-pre-kardex" action="lista_kardex.php" method="POST">
                Periodo: <input type="text" name="dt1" id="dt1" value="2016-01-01" /> até
                <input type="text" name="dt2" id="dt2" value="2016-12-31" /><br>
                Produto: <input type="text" name="pro1" id="pro1" value="2" /> até 
                <input type="text" name="pro2" id="pro2"value="2" /><br>
                
                Type of Mov.:<select name="tipomov" id="tipomov">
                    <option value=""  selected>Todos</option>
                    <?php 
                    //Preenche a lista de Produtos 
            do {
                echo "<option value='" . $linha['id'] . "'>".$linha['id'] ." " . $linha['name'] ." ".$linha['sinal']. "</option>";
            } while ($linha = mysql_fetch_assoc($res_tipomov));
                    ?>
                </select><br><br>
                <input type="submit" value="Gerar Relatorio" name="btngerarKardex" />
            
            </form>
            
        </div>
    </body>
</html>
