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
$rowNot = mysql_fetch_array(mysql_query("SELECT nome_url FROM noticias WHERE idNot=$_REQUEST[id]"));

// Excluindo imagem
unlink("$DirNoticias/$rowNot[nome_url].jpg");

echo "<script> alert('Imagem excluida com sucesso!'); history.go(-1); </script>";

?>