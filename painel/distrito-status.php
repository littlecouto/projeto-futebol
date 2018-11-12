<?php

$row = mysql_fetch_array(mysql_query("SELECT ativo FROM pais_regiao_distrito WHERE idDis='$_GET[id]'"));
$status = $row['ativo']==1?'0':'1';

$desativar = mysql_query("UPDATE pais_regiao_distrito SET ativo='$status' WHERE idDis='$_GET[id]' LIMIT 1");
	
if($desativar==false){
	echo "<script> alert('Erro ao desativar time'); location.href='distritos'; </script>";
	exit;
}
else{
	echo "<script> location.href='distritos'; </script>";
	exit;
}
?>