<?php 
include '../includes/admin.php';
include '../includes/conexao.php';
include '../includes/verlogin.php';

//verificando se � um usu�rio master que est� acessando a p�gina
$verUsu = mysql_fetch_array(mysql_query("SELECT idUsu FROM painel_usuario WHERE idUsu='$_SESSION[loginUsu]'")) or die (mysql_error());

if($verUsu[idUsu] != 1 || $verUsu[idUsu] != 2){
	echo "<script>alert('Voc� n�o tem permiss�o para acessar essa p�gina!'); history.go(padrao);</script>";
}else{
	echo "Hello";
}

?>