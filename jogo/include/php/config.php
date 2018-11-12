<?php
# ARQUIVO DE CONFIGURAÇÃO

error_reporting(E_WARNING|E_ERROR);

if(file_exists('include/classes/funcoes.php')){
	include_once 'include/classes/funcoes.php';
}

$conectar = new mysql;
$conectar->base = 'futebol_novo';
$conectar->conectar();

$debug = new debug;


$resultVariavel = mysql_query("SELECT variavel, valor FROM painel_config_variavel WHERE ativo=1") or die(mysql_error());

$rowPainel = mysql_fetch_assoc(mysql_query("SELECT * FROM painel_config"));

$EMPRESA 	= $rowPainel['sistema_nome'];
$EMAIL 		= $rowPainel['sistema_email'];
$SENHA 		= $rowPainel['email_senha'];
$SMTP 		= $rowPainel['email_smtp'];
$PORTA 		= $rowPainel['email_porta'];

$cor_pri = $rowPainel['cor_pri'];
$cor_seg = $rowPainel['cor_seg'];

$title = $rowPainel['sistema_nome'];

while($rowVariavel = mysql_fetch_array($resultVariavel)){
	$rowVariavel['variavel'] = $rowVariavel['variavel'];
	$rowVariavel['valor'] 	 = $rowVariavel['valor'];

	$$rowVariavel['variavel'] = $rowVariavel['valor'];
}

?>