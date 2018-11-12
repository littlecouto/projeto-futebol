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

// Dados da imagem
$rowImg = mysql_fetch_array(mysql_query("SELECT * FROM banner"));
 
// Verificando imagem principal
if($rowImg['principal'] == 0){
	// Excluindo registro
	$excluir = mysql_query("DELETE FROM banner LIMIT 1");
}
else {
	echo "<script> alert('A imagem principal não pode ser excluida'); location.href='atu_imagens.php; </script>";
	exit;	
}
 


	
if($excluir==false){
	echo "<script> alert('Erro ao excluir a imagem'); location.href='atu_imagens.php?id=$_GET[album]'; </script>";
	exit;
}
elseif($excluir==true){
	// Excluindo a imagem
	$DIR = $DirAlbum.'/'.$rowImg['imagem']; 
	unlink($DIR);
}
echo "<script> location.href='atu_imagens.php?id=$_GET[album]'; </script>";

?>