<?php
header('Content-Type: text/html; charset=ISO-8859-1',true);

$db['server']       = 'localhost';
$db['user']         = 'root';
$db['password']     = 'vinidb01';
$db['dbname']       = 'campeonato';

$db['server']     = 'mysql.ewebtecnologia.com.br';
$db['user']         = 'ewebtecnologia02';
$db['password']     = 'sql2585';
$db['dbname']     = 'ewebtecnologia02';

$conn = mysql_connect($db['server'],$db['user'],$db['password']);
mysql_select_db($db['dbname'],$conn);

//error_reporting(0);
echo "<pre>";
$_SERVER = print_r($_SERVER);
echo "</pre>";

$IP 	= $_SERVER['REMOTE_ADDR'];
$ORIGEM = $_SERVER['HTTP_REFERER'];

mysql_query("INSERT INTO facebook(ip, origem, server)VALUE('$IP', '$ORIGEM', '$_SERVER')") or die(mysql_error());





?>