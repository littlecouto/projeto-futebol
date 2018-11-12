<?php

$row = mysql_fetch_array(mysql_query("SELECT ativo FROM pais_regiao WHERE idReg='$_GET[id]'"));
$status = $row['ativo']==1?'0':'1';

$desativar = mysql_query("UPDATE pais_regiao SET ativo='$status' WHERE idReg='$_GET[id]' LIMIT 1");
	
if($desativar==false){
	echo "<script> alert('Erro ao desativar time'); location.href='regioes'; </script>";
	exit;
}
else{
	echo "<script> location.href='regioes'; </script>";
	exit;
}
?>