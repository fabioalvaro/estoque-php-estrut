<?php include_once 'comum/topo.php'; ?>
<div>Inventory Control<form name="login" action="login_valida.php" method="POST">
        Email<input type="text" name="email" id="email" value="" /> <br>
        Senha<input type="password" name="senha" id="senha" value="" /> <br>
        <input type="submit" value="entrar" name="entrar" />
        <?php 
        $erro = isset($_GET['erro'])?$_GET['erro']:null;
        if ($erro!=null){
         echo '<p style="color: red">Erro no usuario/senha</p>';    
        }
        ?>
        

    </form></div>
<?php include_once 'comum/base.php'; ?>