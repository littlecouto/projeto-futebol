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
	
// selecionando o diretório para excluir a pasta de imagens
$row = mysql_fetch_array(mysql_query("SELECT * FROM cat_curso WHERE idCat='$_REQUEST[id]'"));

//
			
			
// excluindo os dados		
$excluir = mysql_query("DELETE FROM cat_curso WHERE idCat='$_REQUEST[id]' LIMIT 1");
// 
	
	
	
if($excluir == false){$aviso = "Houve um erro ao excluir!";}
if($excluir == true){
	$aviso = "Dados excluidos com sucesso! ";
}

echo "<script> alert('$aviso'); location.href='list_categorias.php'; </script>";
?>