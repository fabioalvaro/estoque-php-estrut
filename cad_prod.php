
<?php include_once 'comum/topo.php'; ?>

<div>Cadastro de Produtos</div>
        Descricao  <input type="text" name="descricao" value="Coca Cola Lata" /><br>
         Valor  <input type="text" name="valor" value="3,50" /><br>
         Departamento <select name="combo_dep">
            <option>Servicos</option>
            <option>produtos</option>
        </select><br>
        <br><input type="submit" value="salvar" name="lalalal" />
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
                    <td>1</td>
                    <td>asd asd asd</td>
                    <td>alterar | excluir</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>zxc zc zxc </td>
                    <td><a href="#">alterar</a> | <a href="#">excluir</a></td>
                </tr>
            </tbody>
        </table>

<?php include_once 'comum/base.php'; ?>
