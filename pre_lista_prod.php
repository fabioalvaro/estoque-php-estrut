<!DOCTYPE html>
<html>
    <head>
        <title>Lista Produtos</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div>
            <h1>Gerar Relatorio Produtos</h1>
            
            <form name="frm-pre-listaprod" id="frm-pre-listaprod" 
                  action="lista_prod.php" method="get">
                Ordem: 
                <select name="ordem" id="ordem">
                    <option value="alfabetica">Alfabetica</option>
                    <option value="codigo">Codigo</option>
                </select>
                <br>
                
                Tipo: 
                <select name="tipo" id="tipo">
                    <option value="simples">Lista Simples</option>
                    <option value="departamento">Departamento</option>
                </select><br>       
                Filtro Produtos Estoque zero: 
                <select name="filtro-zero" id="filtro-zero">
                    <option value="sim">Sim</option>
                    <option value="nao">Nao</option>
                </select><br>                  
                <input type="submit" value="Gerar Relatorio" name="btn-Gerar-Relatorio" />
            </form>
     
            
        </div>
    </body>
</html>
