<?php 
include 'include/php/config.php';
include 'painel/include/php/funcoes.php';
include 'painel/include/classes/conexao.class.php';

$con = new Conexao();
$con = $con->Conecta();

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?=$titulo_pagina?></title>
  </head>
  <body>
    <h1><?=$h1?></h1>
	
	<div id="tudo">
	
		<header class="topo">
			<div class="logo">
			
			</div>
		</header>
	
		<div class="conteudo">
			
		</div>
	
	
		<footer class="rodape">
			
		</footer>
	</div>

    <script src="include/js/jquery-2.1.4.js"></script>
  </body>
</html>
