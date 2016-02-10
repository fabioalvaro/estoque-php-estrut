<?php
/**
 * Criado por Fabio Alvaro
 * @fabioalvaro
 */
$host = "localhost";
$db = "fabioalvaro13_dev";
$user = "root";
$pass = "toor";
$con = mysql_connect($host, $user, $pass)
        or trigger_error(mysql_error(), E_USER_ERROR);
mysql_select_db($db, $con);





