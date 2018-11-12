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
// Excluindo imagem do perfil
$row = mysql_fetch_array(mysql_query("SELECT nome_url FROM noticias WHERE idNot=$_REQUEST[id]"));
if(file_exists("$DirNoticias/$row[nome_url].jpg"))	
	unlink("$DirNoticias/$row[nome_url].jpg");
//

// Excluindo cadastro
mysql_query("DELETE FROM noticias WHERE idNot='$_GET[id]' LIMIT 1") or die (mysql_error());

echo "<script> alert('Registro excluido com sucesso!'); location.href='list_noticias.php'; </script>";

?>