<?php
$excluir = mysql_query("DELETE FROM painel_modulo_item WHERE idIte='$_GET[id]' LIMIT 1") or die (mysql_error());

if($excluir == true){
	$aviso = 'Registro excluido com sucesso!';
}elseif($excluir == false){
	$aviso = 'Registro excluido com sucesso!';
}
echo "<script> alert('$aviso'); location.href='master-modulo-ger'; </script>";
exit;
?>