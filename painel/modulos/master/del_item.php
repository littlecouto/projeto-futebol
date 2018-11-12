<?php 
session_start(); 

include_once '../../include/config.php';

// CONEXÃO
include_once '../../include/classes/conexao.class.php';
$con = new Conexao();
$conexao = $con->Conecta();

// VER LOGIN
include_once '../../include/classes/login.class.php';
$lgn = new Login();
$lgn->VerLogin();
?>



<?php
$excluir = mysql_query("DELETE FROM painel_modulo_item WHERE idIte='$_GET[id]' LIMIT 1") or die (mysql_error());

if($excluir == true){
	echo "<script> alert('Registro excluido com sucesso!'); location.href='ger_modulos.php'; </script>";
}elseif($excluir == false){
	echo "<script> alert('Houve um erro ao excluir!'); location.href='ger_modulos.php'; </script>";
}
?>