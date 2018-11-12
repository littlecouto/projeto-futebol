<?php 
include '../includes/admin.php';
include '../includes/conexao.php';
include '../includes/verlogin.php';

//verificando se é um usuário master que está acessando a página
$verUsu = mysql_fetch_array(mysql_query("SELECT idUsu FROM painel_usuario WHERE idUsu='$_SESSION[loginUsu]'")) or die (mysql_error());

if($verUsu[idUsu] != 1 || $verUsu[idUsu] != 2){
	echo "<script>alert('Você não tem permissão para acessar essa página!'); history.go(padrao);</script>";
}else{
	echo "Hello";
}

?>