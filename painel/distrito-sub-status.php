<?php

$row = mysql_fetch_array(mysql_query("SELECT ativo FROM pais_regiao_distrito_sub WHERE idSub='$_GET[id]'"));
$status = $row['ativo']==1?'0':'1';

$desativar = mysql_query("UPDATE pais_regiao_distrito_sub SET ativo='$status' WHERE idSub='$_GET[id]' LIMIT 1");
	
if($desativar==false){
	echo "<script> alert('Erro ao desativar time'); location.href='distritos-sub'; </script>";
	exit;
}
else{
	echo "<script> location.href='distritos-sub'; </script>";
	exit;
}
?>