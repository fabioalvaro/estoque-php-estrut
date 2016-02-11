<?php

/**
 * Criado por Fabio Alvaro
 * @fabioalvaro
 */
//session_start(); //iniciei a sessao
//$_SESSION['idade']=36;

echo "POST<br>";
var_dump($_POST);
echo "GET<br>";

var_dump($_GET);
echo "REQUEST<br>";
var_dump($_REQUEST);

//setcookie("idade", 36);
//setcookie("senha", 'senhareal009');
//setcookie("email", 'fabio.alvaro@gmail.com');
//echo "Uhul setei o cookie!!";
?>

<!--<form name = "meuform" action = "teste2.php">
<input type = "text" name = "idade" value = "36" />
<input type="submit" value="chamar pagina 2" name="btnchamar" />    
</form>-->

<!--<form name = "meuform" action = "teste2.php" method="post">
    <h1>Vai por post</h1>
<input type = "text" name = "idade" value = "36" />
<input type="submit" value="chamar pagina 2" name="btnchamar" />    
</form>-->

