<?php


$ativar = mysql_query("UPDATE time SET ativo=1 WHERE idTim='$_GET[id]' LIMIT 1");
	
if($ativar==false){
	echo "<script> alert('Erro ao ativar time'); location.href='times'; </script>";
	exit;
}
else{
	echo "<script> location.href='times'; </script>";
	exit;
}
?>