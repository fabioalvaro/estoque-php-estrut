
<html>
<body bgcolor="blue"><font color='white'>
<?php

/**
 * Criado por Fabio Alvaro
 * @fabioalvaro
 */


echo "<h1>:(</h1><BR>";

echo "<p color='white'>Seu computador executou uma operação ilegal e sera fechado...<br>";

echo "<p color='white'>brincadeirinha... <br>";


echo "<p color='white'>Na verdade leia a mensagem abaixo e verifique<br>";

$motivo= isset($_GET['motivo'])?$_GET['motivo']:null;

if ($motivo=='sem_sessao'){
    $msg= "por favor faça o login... <a href='login.php'> Fazer login</a>";
}

echo '<p>'.$msg.'</p>';

?>
    
    
    
    </font>
</body>
</html>
