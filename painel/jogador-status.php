<?php

$row = mysql_fetch_array(mysql_query("SELECT ativo FROM jogador WHERE idJgd='$_GET[id]'"));
$status = $row['ativo']==1?'0':'1';

$desativar = mysql_query("UPDATE jogador SET ativo='$status' WHERE idJgd='$_GET[id]' LIMIT 1");
	
if($desativar==false){
	echo "<script> alert('Erro ao desativar jogador'); location.href='jogadores'; </script>";
	exit;
}
else{
	echo "<script> location.href='jogadores'; </script>";
	exit;
}
?>