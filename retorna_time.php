<?php
header('Content-Type: text/html; charset=windows-1252',true);

$db['server'] 	  = 'mysql.ewebtecnologia.com.br';
$db['user'] 		= 'ewebtecnologia02';
$db['password'] 	= 'sql2585';
$db['dbname'] 	  = 'ewebtecnologia02';

$conn = mysql_connect($db['server'],$db['user'],$db['password']);
mysql_select_db($db['dbname'],$conn);

error_reporting(0);

/*echo "<pre>";
print_r($_POST);
echo "</pre>";

*/

if($_GET['ACAO'] === 'TIMES'){
	$time1 = utf8_decode($_POST['um']);
	$time2 = utf8_decode($_POST['dois']);
	
	$rowTim1 = mysql_fetch_array(mysql_query("SELECT abreviacao FROM times WHERE apelido='$time1'"));
	$rowTim2 = mysql_fetch_array(mysql_query("SELECT abreviacao FROM times WHERE apelido='$time2'"));
	
	$retorna = array('abr1'=>$rowTim1['abreviacao'], 'abr2'=>$rowTim2['abreviacao']);
	echo json_encode($retorna);
}
?>