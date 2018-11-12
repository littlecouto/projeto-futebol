<?php
header('Content-Type: text/html; charset=windows-1252',true);
echo md5('ledbetter');
$db['server'] 		= 'localhost';
$db['user']			= 'root';
$db['password']		= 'vinidb01';
$db['dbname']		= 'campeonato';

$conn = mysql_connect($db['server'],$db['user'],$db['password']);
mysql_select_db($db['dbname'],$conn);

error_reporting(0);

echo "<pre>";
print_r($_POST);
echo "</pre>";

switch($_POST['ev']){
	case 1: 
		$evento = 'Gol'; 
		break;
	case 2: 
		$evento = 'Cartão amarelo'; 
		break;
	case 3: 
		$evento = 'Cartão vermelho'; 
		break;
	case 4: 
		$evento = 'Contusão'; 
		break;
	case 5: 
		$evento = 'Gol contra'; 
		break;
	
}
$jogador = $_POST['jgd'];

$rowJgd = mysql_fetch_array(mysql_query("SELECT idJgd FROM jogador WHERE nome='$jogador'"));
$verEve = mysql_fetch_array(mysql_query("SELECT idAca FROM acao WHERE acao='$evento'"));

if($rowEve['idAca']<1){
	mysql_query("INSERT INTO acao(acao)VALUE('$evento')");
}
if($rowJgd['idJgd']<1){
	mysql_query("INSERT INTO jogador(nome)VALUE('$jogador')");
}

	$rowIdJ = mysql_fetch_array(mysql_query("SELECT idJgd FROM jogador WHERE nome='$jogador'"));
	$rowIdA = mysql_fetch_array(mysql_query("SELECT idAca FROM acao WHERE acao='$evento'"));
	$idJgd  = $rowIdJ['idJgd'];
	$idAca  = $rowIdA['idAca'];
if($idAca>0 and $idJgd>0){
	mysql_query("INSERT INTO evento(idAca, idJog)VALUE('$idAca', '$idJgd')");
}
?>