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
                Periodo: <input type="text" name="dt1" id="dt1" value="2016-02-12" /> até
                <input type="text" name="dt2" id="dt2" value="2016-02-12" /><br>
                Produto: <input type="text" name="pro1" id="pro1" value="1" /> até 
                <input type="text" name="pro2" id="pro2"value="999999" /><br>
                <input type="submit" value="Gerar Relatorio" name="btngerarKardex" />
            
            </form>
            
        </div>
    </body>
</html>
