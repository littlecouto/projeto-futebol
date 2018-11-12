<?php
header('Content-Type: text/html; charset=ISO-8859-1',true);

// exit;
$db['server']     = 'mysql.ewebtecnologia.com.br';
$db['user']         = 'ewebtecnologia02';
$db['password']     = 'sql2585';
$db['dbname']     = 'ewebtecnologia02';

$db['server']       = 'localhost';
$db['user']         = 'root';
$db['password']     = '';
$db['dbname']       = 'futebol';

$conn = mysql_connect($db['server'],$db['user'],$db['password']);
mysql_select_db($db['dbname'],$conn);

//error_reporting(0);
echo "<pre>";
print_r($_POST);
echo "</pre>";
$_POST['jgdr'] = utf8_decode($_POST['jgdr']);

if($_POST['ACAO'] == 'FIMJOGO'){
    mysql_query("UPDATE jogo SET golM='$_POST[gol1]', golV='$_POST[gol2]', realizado='$_POST[stat]' WHERE idJog='$_POST[jogo]' LIMIT 1") or die(mysql_error());
}elseif($_POST['ACAO'] == 'EVENTO'){
	
	$resJgd = mysql_query("SELECT J.idJgd FROM jogador J WHERE J.apelido='$_POST[jgdr]'");
	$jog = 0;
	while ($rowJgd = mysql_fetch_array($resJgd) and $jog == 0) {
		$rowCon = mysql_fetch_array(mysql_query("SELECT idJgd FROM jogador_time WHERE idTim='$_POST[time]' AND idJgd='$rowJgd[idJgd]'"));
		if($rowCon>0){
			$jog = 1;
			$idJgd = $rowCon['idJgd'];
		}
	}
	$rowJogo = mysql_fetch_array(mysql_query("SELECT temporada FROM jogo WHERE idJog='$_POST[jogo]'"));
	if($idJgd>0){
	    mysql_query("INSERT INTO evento(idJog, idAca, idJgd, idTim, tempo, temporada)VALUE('$_POST[jogo]', '$_POST[even]', '$idJgd', '$_POST[time]', '$_POST[temp]', '$rowJogo[temporada]')") or die(mysql_error());
	}
}





?>