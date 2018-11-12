<?php

$row = mysql_fetch_array(mysql_query("SELECT ativo FROM time WHERE idTim='$_GET[id]'"));
$status = $row['ativo']==1?'0':'1';

$desativar = mysql_query("UPDATE time SET ativo='$status' WHERE idTim='$_GET[id]' LIMIT 1");
	
if($desativar==false){
	echo "<script> alert('Erro ao desativar time'); location.href='times'; </script>";
	exit;
}
else{
	echo "<script> location.href='times'; </script>";
	exit;
}
?>