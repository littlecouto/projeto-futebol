<?php

// Dados da imagem
$rowImg = mysql_fetch_array(mysql_query("SELECT escudo FROM time WHERE idTim='$_GET[id]'"));
 
	$url = "$DirTime/$rowImg[escudo].png";
	$excluir = unlink($url) or die("<h2>Erro ao excluir escudo</h2>");


	
echo "<script> location.href='time-alt?id=$_GET[id]'; </script>";

?>