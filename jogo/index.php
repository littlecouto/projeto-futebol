<?php
session_start();
include_once 'include/classes/funcoes.php';
include_once 'include/php/config.php';
$admin = new admin;
$admin->verLogin();

$idUsu = $_SESSION['USUARIO_JOGO_LOGADO']['ID'];

$rowUsu = mysql_fetch_array(mysql_query("SELECT email, confirmado, primeiro_acesso FROM jogo_usuario WHERE idUsu='$idUsu'"));

$rowTec = mysql_fetch_array(mysql_query("SELECT idTec FROM jogo_tecnico WHERE idUsu='$idUsu'"));
if($rowUsu['primeiro_acesso'] == 1){
	header("Location: cadastro-plano");
}elseif($rowTec['idTec'] < 1){
	header("Location: cadastro-time");	
}

if($rowUsu['confirmado'] == 0){
	echo "<div class=\"confirmar_email\"><p>Verfique sua conta com um link que n&oacute;s enviamos ao email <strong>$rowUsu[email]</strong> que voc&ecirc; nos forneceu. <a href=\"#\">Reenviar e-mail</a></p></div>";
}


?>

