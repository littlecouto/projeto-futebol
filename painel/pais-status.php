<?php

$row = mysql_fetch_array(mysql_query("SELECT ativo FROM pais WHERE idPai='$_GET[id]'"));
$status = $row['ativo']==1?'0':'1';

$desativar = mysql_query("UPDATE pais SET ativo='$status' WHERE idPai='$_GET[id]' LIMIT 1");
	
if($desativar==false){
	echo "<script> alert('Erro ao desativar time'); location.href='paises'; </script>";
	exit;
}
else{
	echo "<script> location.href='paises'; </script>";
	exit;
}
?>