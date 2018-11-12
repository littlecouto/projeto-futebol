<?php


$excluir = mysql_query("DELETE FROM painel_modulo WHERE idMod='$_GET[id]' LIMIT 1") or die (mysql_error());

if($excluir == true){
	$query = "DELETE FROM painel_modulo_item WHERE idMod='$_GET[id]'";
	mysql_query($query) or die (mysql_error());
	
	// PAINEL HISTÓRICO
	$query = addslashes($query);
	mysql_query("INSERT INTO painel_historico(idUsu, acao, query) VALUE($_SESSION[USUARIO], 'DELETE', '$query')") or die (mysql_error());
	//
		
	echo "<script> alert('Registro excluído com sucesso!'); location.href='master-modulo-ger'; </script>";
	
}elseif($excluir == false){
	echo "<script> alert('Houve um erro ao excluir!'); location.href='master-modulo-ger'; </script>";
}



?>