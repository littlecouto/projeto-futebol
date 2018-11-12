<?php
session_start();
include_once 'include/classes/funcoes.php';
include_once 'include/php/config.php';
$admin = new admin;
//$admin->verLogin();

$idUsu = $_SESSION['USUARIO_JOGO_LOGADO']['ID'];
$qtd = 20;
$sql = "SELECT LOWER(T.idTim) AS time, (SELECT SUM(J.forca) FROM jogador J, jogador_time C WHERE T.idTim=C.idTim AND C.idJgd=J.idJgd) as FORCAS FROM time T WHERE T.ativo=1 AND T.idPai=1 AND ativo=1 ORDER BY FORCAS DESC, apelido LIMIT $qtd";
$resTim = mysql_query($sql) or die(mysql_error());

while($rowTim = mysql_fetch_array($resTim)){
	$times[] = ucwords($rowTim['time']);
}
include_once 'include/php/jogos.php';


$rowTem = mysql_fetch_array(mysql_query("SELECT idTem, temporada FROM jogo_temporada WHERE idUsu='$idUsu' ORDER BY idTem DESC"));

$idTem = $rowTem['idTem'];

$rowCom = mysql_fetch_array(mysql_query("SELECT idCom FROM jogo_competicao WHERE idUsu='$idUsu' AND idTem='$idTem'"));
$idCom = $rowCom['idCom'];

if($_GET['ACAO'] == 'CRIAR'){
	$temporada = $rowTem['temporada'];
	if($rowTem['temporada'] <= 0){
		$temporada = date("Y");
	}else{
		$temporada++;
	}
	mysql_query("INSERT INTO jogo_temporada (idUsu, temporada)VALUES('$idUsu', '$temporada')") or die(mysql_error());
	$rowTem = mysql_fetch_array(mysql_query("SELECT idTem, temporada FROM jogo_temporada WHERE idUsu='$idUsu' ORDER BY idTem DESC"));
	$idTem = $rowTem['idTem'];
	
	
	
	mysql_query("INSERT INTO jogo_competicao (idUsu, idTem, idCam)VALUES('$idUsu', '$idTem', '1')") or die(mysql_error());

	$rowCom = mysql_fetch_array(mysql_query("SELECT idCom FROM jogo_competicao WHERE idUsu='$idUsu' AND idTem='$idTem'"));
	$idCom = $rowCom['idCom'];

}

echo "<pre>";
print_r($jg);
echo "</pre>";


exit;


foreach($jg as $r => $rodada){
	
	foreach($rodada as $info){
		$turn = $info['turno'];
		$dsem = $info['dia_semana'];
		$data = date("d/m/y", strtotime($info['data']));
		$hora = $info['horario'];
		$mand = $info['mandante'];
		$visi = $info['visitante'];
		
		
		
		
		$resVer = mysql_query("SELECT idJog FROM jogo WHERE idTem='$idTem' AND idCom='$idCom' AND mandante='$mand' AND visitante='$visi' AND turno='$turno'") or die(mysql_error());
		$rowVer = mysql_fetch_array($resVer);
		if($rowVer['idJog']<1){
			mysql_query("INSERT INTO jogo (idUsu, idTem, idCom, data_jogo, hora_jogo, divisao, turno, rodada, mandante, visitante, realizado)VALUES('$idUsu', '$idTem', '$idCom', '$data', '$hora', '1', '$turno', '$r', '$mand', '$visi', '0')") or die(mysql_error());
		}
		
	}
}

?>

