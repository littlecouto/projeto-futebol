<?php
session_start();
include_once 'include/classes/funcoes.php';
include_once 'include/php/config.php';

$admin = new admin;
if($_POST['ACAO']=='LOGAR'){
	$admin->login($_POST['usuario'], $_POST['senha']);
}

?>

<!doctype html>
<html>
<head>
<meta charset="iso-8859-1">
<title><?=$title?></title>
<link rel="stylesheet" href="include/css/login.css">
<link rel="stylesheet" href="include/css/cores.php">
<link rel="shortcut icon" type="image/png" href="<?=$URLSEG.$UrlFavicon?>/favicon-seg.png">
</head>

<body>

<div id="tudo">
<h1>LOGAR</h1>
<form action="" method="post">
	<p><input type="text" name="usuario" placeholder="USU&Aacute;RIO"></p>
	<p><input type="password" name="senha" placeholder="SENHA"></p>
	<p><input type="submit" name="ACAO" value="LOGAR"></p>
</form>

</div>
<script src="include/js/jquery-2.1.4.js"></script>
<script>
	$('input:not([type=submit])').on('focus',function(){
		$(this).css({'width':'400px', 'margin-left': '-100px'});
	}).blur(function(){
		$(this).css({'width':'200px', 'margin-left': '0px'});
	}).mouseout(function(e) {
		if($(this).is(':focus') == false){
			$(this).css({'width':'200px', 'margin-left': '0px'});        
		}
    });
</script>
</body>
</html>
