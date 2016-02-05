<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Cadastro de Kardex</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <h1>Cadastro de Movimento / Kardex</h1>
        produto <select name="combo_prod">
            <option>Coca</option>
            <option>Pedra</option>
        </select><br>
        estoque <select name="combo_estoque">
            <option>1 Siri Cascudo</option>
            <option>2 Praia areia Branca</option>
        </select><br>
        quantidade <input type="text" name="qtd" value="50" />
        movimento 
        <select name="combo_mov">
            <option>Entrada +</option>
            <option>Saida -</option>
        </select><br>
        
        <input type="submit" value="salvar" name="lalalal" />
        <hr>
        <table border="1">
            <thead>
                <tr>
                    <th>id</th>
                    <th>descricao</th>
                    <th>acao</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="3">nenhum Registro</td>
                </tr>
                
            </tbody>
        </table>

    </body>
</html>
