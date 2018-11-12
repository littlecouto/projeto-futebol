<?php
header("Content-Type: text/html; charset=iso-8859-1");

$db['server'] 	  = 'mysql.ewebtecnologia.com.br';
$db['user'] 		= 'ewebtecnologia02';
$db['password'] 	= 'sql2585';
$db['dbname'] 	  = 'ewebtecnologia02';

$conn = mysql_connect($db['server'],$db['user'],$db['password']);
mysql_select_db($db['dbname'],$conn);



function pre($var1 = '',$var2 = '',$exit = false, $show = true){
	if($show){
		$var[0] = $var1;
		$var[1] = $var2;
		if($var[0] and $var[0] != ''){
			echo "<pre>";
			print_r($var[0]);
			echo "</pre>";
		}
		if($var[1] and $var[1] != ''){
			echo "<pre>";
			print_r($var[1]);
			echo "</pre>";
		}
		if($exit){
			exit;
		}
	}
}
function objectToArray($d) {
	if (is_object($d)) {
		// Gets the properties of the given object
		// with get_object_vars function
		$d = get_object_vars($d);
	}
	
	if (is_array($d)) {
		/*
		* Return array converted to object
		* Using __FUNCTION__ (Magic constant)
		* for recursive call
		*/
		return array_map(__FUNCTION__, $d);
	}
	else {
		// Return array
		return $d;
	}
}


$opts = array(
  'http'=>array(
    'method'=>"GET",
    'header'=>"Accept-language: en\r\n" .
              'Cookie:nvgoas=_; __utmt_b=1; __gads=ID=8408a083393bfffe:T=1443728938:S=ALNI_MYTxIaXOsC5MiPYNbappI2O3wPntA; fbm_289255557788943=base_domain=.globo.com; nav13574=21651006002|2_91__; fbsr_289255557788943=K2lyJ8r1Fr6RGswPMdBHdWniXS7oFxJMvtSjf3Hl3gE.eyJhbGdvcml0aG0iOiJITUFDLVNIQTI1NiIsImNvZGUiOiJBUUNiYUlTdHRudzdHNzRhZHVnNnZzUXZFS2ZmakthU3hOUTRWWUVwbTJsWG1Ya0ZmTzFnWG83RERNNWdMTmV3WW9GNzZPRElBSXprb0pQZkk5RTNsa2dFWHo5c1lfSnh6N3drSldCZlVQdUJyTDhoRWJXNFcxdnNjWG9wNS01R0lmcTg5c3BDMlctSWxVdzVWLVl2eUlZZkFibEJESS1GR3VjRjlPb25Qc3ZINUplV1lCLXNKcDZvNFBEY3Z5ZnBaNVVOX1Q1N1k1YU53SF9TNXluc1d4bjN4YlRmME51Z3VPSVV5cEhlQ2JTMnFmUG9pSl9JaHpJaHNYeUVwaTRfMkd2eG52TFJ5RnNlM3A3WVkzM05rZ083cl9qWFN1SF9uNnJTVGFvaFdrdkpXNURyYlZHdGFEdDZ1dzBBSVdDaUstTWl0SE4wU0EwNi1HS2p1ODlfUGFuLSIsImlzc3VlZF9hdCI6MTQ0MzcyODk2NSwidXNlcl9pZCI6IjEwMDAwMzg0OTU4ODA0MyJ9; GLBID=198614c59b9049b93772fce2e4d6274654c5a4d775a444635734c76386d6b3936304f6d76676d374e374e4d636955596875334a316c575065694f744a6e7272377a70554462723241787347615473715a3a303a76696e69636975732e636f7574696e686f2e736f7540676d61696c2e636f6d; CADUN_ID="0056533856IDAwU1BWaW5pY2l1cyBDb3V0aW5obyBkZSBTb3V6YSAgICA="; CEP=06773230; ESTADO=26; PAIS=1; CIDADE=9707; CARTOLAID="MTAyNTQxMzY=|1443729123|b938cd1b8d6b6d0221f773402123563a1c3bd64d"; newsfeed-hostId-=14437291267737265076679177582; NEWSFEEDAUTH=4429b322c0854a0e821cec1afcace013; __utmt=1; __utma=112245142.152865986.1443729128.1443729128.1443729128.1; __utmb=112245142.1.10.1443729128; __utmc=112245142; __utmz=112245142.1443729128.1.1.utmcsr=globoesporte.globo.com|utmccn=(referral)|utmcmd=referral|utmcct=/cartola-fc/; utag_main=v_id:015024f35123000b5b36b29bd8190606d00250650086e$_sn:1$_ss:0$_pn:8%3Bexp-session$_st:1443730929911$ses_id:1443728937251%3Bexp-session; cartolaSportv=cartolafc; glb_uid="mgRp_hiKb9oZAciPygUH7EArXYaXyRuoIKpmjaT0rA0="; __utma=100629313.1114738043.1443728939.1443728939.1443728939.1; __utmb=100629313.6.10.1443728939; __utmc=100629313; __utmz=100629313.1443728939.1.1.utmcsr=google|utmccn=(organic)|utmcmd=organic|utmctr=(not%20provided)'
  )
);

$context = stream_context_create($opts);
$geral = '';
$array = array(
	'j'=>array(
	)
);

$jogadores = array('GOL'=>array(), 'ZAG'=>array(), 'LAT'=>array(), 'MEI'=>array(), 'ATA'=>array(), 'TEC'=>array());
for($i=1;$i<=42;$i++){
	$json = file_get_contents('http://cartolafc.globo.com/mercado/filtrar.json?page='.$i, false, $context);
	$json = json_decode($json);
	$json = objectToArray($json);


	//pre($json['atleta'][5], '', 1);
	$atletas = $json['atleta'];
	
	foreach($atletas as $atleta){
		$nome = utf8_decode($atleta['apelido']);
		$posi = $atleta['posicao']['abreviacao'];
		
		$prec = $atleta['preco']*10000;

		$mult = rand(10, 60);
		$mult = round(($prec*$mult)/100);

		$medi = round($atleta['media']*50);
		if($medi<39){
			$medi = 40 + rand(rand(5,10), rand(10,15));
		}elseif($medi>=400) {
			$medi = ceil($medi/2);
		}
/*
		}elseif($medi>=60) {
			$medi = 40 + rand(rand(5,10), rand(10,15));
*/
		$time = mb_strtoupper(utf8_decode($atleta['clube']['nome']), 'iso-8859-1');
		$abbr = mb_strtoupper(utf8_decode($atleta['clube']['abreviacao']), 'iso-8859-1');

		$cara = rand(1,10);
		$espe = rand(1,10);
		$lado = rand(1,2);
		$idad = rand(21, 28);
		if($medi>600){
			$estr = 1;
		}elseif($medi > 550 and $medi < 600){
			$estr = rand(0,1);
		}else{
			$estr = 0;
		}
		
		switch($posi){
			case 'GOL' : 
				array_push($jogadores['GOL'], $nome);
				$idPos = '1';
				break;
			case 'ZAG' : 
				array_push($jogadores['ZAG'], $nome);
				$idPos = '2';
				break;
			case 'LAT' : 
				array_push($jogadores['LAT'], $nome);
				$idPos = '3';
				break;
			case 'MEI' : 
				array_push($jogadores['MEI'], $nome);
				$idPos = '4';
				break;
			case 'ATA' : 
				array_push($jogadores['ATA'], $nome);
				$idPos = '5';
				break;
			case 'TEC':
				array_push($jogadores['TEC'], $nome);
				$idPos = '6';
				break;
			default : 
				$idPos = '6';
				break;
		}
		

		$array['j'][$nome] = 
			array(
				'POS' => $posi,
				'VAL' => $prec,
				'MUL' => $mult,
				'FOR' => $medi,
				'MED' => $atleta['media'],
				'CAR' => array(
						$cara, 
						$espe
					),
				'LAD' => $lado,
				'IDA' => $idad
			);
		



		$rowTim = mysql_fetch_array(mysql_query("SELECT idTim FROM times WHERE apelido='$time' OR nome='$time'"));
		if($rowTim['idTim']<1){
			mysql_query("INSERT INTO times(
				idPai, nome, apelido, abreviacao, ativo
			)VALUE(
				'1', UPPER('$time'), UPPER('$time'), '$abbr', '1'
			)");

			$rowTim = mysql_fetch_array(mysql_query("SELECT idTim FROM times ORDER BY idTim DESC"));

		}

		$idTim = $rowTim['idTim'];

		@$rowJog = mysql_fetch_array(mysql_query("SELECT idJgd FROM jogador WHERE apelido='$nome' OR nome='$nome'"));
		if($rowJog['idJgd']<1){
			mysql_query("INSERT INTO jogador(
				idPos, idPe, idEsp, idCar, idNac, nome, apelido, idade, forca, estrela, ativo
			)VALUE(
				'$idPos', '$lado', '$espe', '$cara', '1', UPPER('$nome'), UPPER('$nome'), '$idad', '$medi', '$estr', '1'
			)");
	
			$rowJog = mysql_fetch_array(mysql_query("SELECT idJgd FROM jogador ORDER BY idJgd DESC"));
		}else{
			mysql_query("UPDATE jogador SET forca='$medi' WHERE idJgd='$rowJog[idJgd]' LIMIT 1");
		}

		$idJgd = $rowJog['idJgd'];

		$rowCon = mysql_fetch_array(mysql_query("SELECT idCon FROM jogador_time WHERE idJgd='$idJgd' AND idTim='$idTim' AND ativo='1'"));
		if($rowCon['idCon']<1 and $idJgd>0 and $idTim >0){
			mysql_query("INSERT INTO jogador_time(
					idJgd, idTim, dataini, datafim, salario, multa, ativo
				)VALUE(
					'$idJgd', '$idTim', '2015-09-30', '2018-09-30', '$prec', '$mult', '1'
				) 
			") or die(mysql_error());
		}elseif($rowCon['idCon']>0 and $idJgd>0 and $idTim >0){
			mysql_query("UPDATE jogador_time SET salario='$prec', multa='$mult' WHERE idCon='$rowCon[idCon]' LIMIT 1");
		}


		$geral .= $posi.' - '.$nome. '('.$medi.')'. PHP_EOL;
	}
}

$file = fopen('cartola.txt', 'w');
fwrite($file, $geral);
fclose($file);

//sort($jogadores);
pre($array);

?>		