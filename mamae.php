<?php
/**
 * Criado por Fabio Alvaro
 * @fabioalvaro
 */
// definições de host, database, usuário e senha 
$host = "localhost";
$db = "controleestoquedb";
$user = "root";
$pass = "toor";
// conecta ao banco de dados 
$con = mysql_pconnect($host, $user, $pass) or trigger_error(mysql_error(), E_USER_ERROR);
// seleciona a base de dados em que vamos trabalhar 
mysql_select_db($db, $con);
// cria a instrução SQL que vai selecionar os dados 
$query = sprintf("SELECT id, descricao FROM departamentos");
// executa a query 
$dados = mysql_query($query, $con) or die(mysql_error());
// transforma os dados em um array 
$linha = mysql_fetch_assoc($dados);
// calcula quantos dados retornaram
$total = mysql_num_rows($dados);

var_dump($linha);
echo "<br>";

do {
echo "kikik<br>";
}while($linha = mysql_fetch_assoc($dados));


echo "<br>fim";




