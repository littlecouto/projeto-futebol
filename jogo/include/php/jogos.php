
<?php
// INICIANDO AS CLASSES
$debug = new debug;
$datas = new datas;
$jogar = new jogos;

// GERANDO AS DATAS
$DINI = date("Y/m/d", strtotime('first friday of february')); // PRIMEIRA SEXTA DE FEVEREIRO
//$DINI = date("Y/m/d", strtotime($DINI.' +1 day'));

//$DFIM = date("Y/m/d", strtotime('first day of december')); 
$DFIM = date("Y/m/d", strtotime($DINI.' +1 year')); 
$DJGS = array(0, 3, 4, 6);

$VINI = date("Y/m/d", strtotime('first sunday of february')); // PRIMEIRO DOMINGO DE FEVEREIRO
$VINI = date("Y/m/d", strtotime($VINI.' + 2 weeks')); 

$VFIM = date("Y/m/d", strtotime('first sunday of october')); // PRIMEIRO DOMINGO DE OUTUBRO
$VFIM = date("Y/m/d", strtotime($VFIM.' + 2 weeks')); 

$dias = $datas->dias($DINI, $DFIM, $DJGS, 1);
//$debug->pre($dias, 3);

if(!isset($times)){
	// INFORMANDO OS TIMES
	$times = array('São Paulo', 'Flamengo', 'Taboão da Serra', 'Corinthians', 'Palmeiras', 'Santos', 'Vasco', 'Botafogo', 'Fluminense', 'Cruzeiro', 'Chapecoense', 'Atlético-MG', 'Internacional', 'Grêmio', 'Figueirense', 'Sport', 'Santa Cruz', 'Bahia', 'Vitória', 'Ponte Preta');
}
$qtdTim = count($times);
$qtdRod = $qtdTim-1;

//shuffle($times);

// SETANDO OS FORMATOS DOS JOGOS
$formato = array(
	20 => array( // 20 TIMES
		1=> array(1=>'0.0.0.10', 2=>'8.2.0.0', 3=>'1.3.6.0', 4=>'3.2.2.3'), 
		2=> array(1=>'0.0.0.10', 2=>'7.3.0.0', 3=>'1.2.7.0', 4=>'2.1.2.5'),
		3=> array(1=>'0.0.0.10', 2=>'6.4.0.0', 3=>'1.4.5.0', 4=>'3.1.2.4'),
		4=> array(1=>'0.0.0.10', 2=>'5.5.0.0', 3=>'2.3.5.0', 4=>'2.2.2.4'),
		5=> array(1=>'0.0.0.10', 2=>'2.8.0.0', 3=>'6.3.1.0', 4=>'2.3.3.2'), 
		6=> array(1=>'0.0.0.10', 2=>'3.7.0.0', 3=>'7.2.1.0', 4=>'5.2.1.2'),
		7=> array(1=>'0.0.0.10', 2=>'4.6.0.0', 3=>'5.4.1.0', 4=>'4.2.1.3'),
		8=> array(1=>'0.0.0.10', 2=>'5.5.0.0', 3=>'5.3.2.0', 4=>'4.2.2.2'),
	),
	10 => array( // 10 TIMES
		1=> array(1=>'0.0.0.5', 2=>'3.2.0.0', 3=>'1.2.2.0', 4=>'1.1.1.2'), 
		2=> array(1=>'0.0.0.5', 2=>'1.4.0.0', 3=>'1.1.3.0', 4=>'1.1.2.1'),
		3=> array(1=>'0.0.0.5', 2=>'4.1.0.0', 3=>'3.1.1.0', 4=>'1.2.1.1'),
		4=> array(1=>'0.0.0.5', 2=>'2.3.0.0', 3=>'2.2.1.0', 4=>'2.1.1.1'),
	),
	5 => array( // 5 TIMES
		1=> array(1=>'0.0.0.2', 2=>'1.1.0.0', 3=>'0.1.1.0', 4=>'1.1.0.0'), 
		2=> array(1=>'0.0.0.2', 2=>'1.1.0.0', 3=>'1.0.1.0', 4=>'0.1.1.0'),
		3=> array(1=>'0.0.0.2', 2=>'0.2.0.0', 3=>'1.1.0.0', 4=>'0.0.1.1'),
		4=> array(1=>'0.0.0.2', 2=>'2.0.0.0', 3=>'0.0.2.0', 4=>'1.0.0.1'),
	),
	4 => array( // 4 TIMES
		1=> array(1=>'0.0.0.2', 2=>'1.1.0.0', 3=>'0.1.1.0', 4=>'1.1.0.0'), 
		2=> array(1=>'0.0.0.2', 2=>'1.1.0.0', 3=>'1.0.1.0', 4=>'0.1.1.0'),
		3=> array(1=>'0.0.0.2', 2=>'0.2.0.0', 3=>'1.1.0.0', 4=>'0.0.1.1'),
		4=> array(1=>'0.0.0.2', 2=>'2.0.0.0', 3=>'0.0.2.0', 4=>'1.0.0.1'),
	),
	3 => array( // 3 TIMES
		1=> array(1=>'0.0.0.1', 2=>'1.0.0.0', 3=>'0.1.0.0', 4=>'0.1.0.0'), 
		2=> array(1=>'0.0.0.1', 2=>'0.1.0.0', 3=>'1.0.0.0', 4=>'0.0.1.0'),
		3=> array(1=>'0.0.0.1', 2=>'0.0.1.0', 3=>'0.0.1.0', 4=>'0.0.0.1'),
		4=> array(1=>'0.0.0.1', 2=>'0.0.0.1', 3=>'0.0.0.1', 4=>'1.0.0.0'),
	),
);

$formato = $formato[$qtdTim];
$qtdeFor = count($formato); // QUANTIDADE DE FORMATOS

$hora = array(
	0=>array(
		'10:00', '16:00', '16:00', '18:30', '16:00', '16:00', '16:00'
	),
	1=>array(
		'18:30', '22:00'
	),
	2=>array(
		'18:30', '19:00', '21:00'
	),
	3=>array(
		'18:30', '19:00', '21:00', '22:00', '21:00', '22:00', '19:30', '21:00', '22:00'
	),
	4=>array(
		'18:30', '19:00', '21:00'
	),
	5=>array(
		'18:30', '19:00'
	),
	6=>array(
		'18:30', '19:00', '21:00'
	),
);

// SEMANAS
$semanas = array();
$si = 1;
foreach($dias as $d=>$s){
	$s 	= $s['s'];
	$semanas[$s][] = $d;
}
// CLASSIFICANDO SEMANAS
sort($semanas);
//$debug->pre($semanas,3);

for($rodada = 1; $rodada<=$qtdRod*2; $rodada++){ // PASSANDO PELAS RODADAS
	// ESCOLHENDO UM FORMATO ALETATÓRIO
	$rand = rand(1, $qtdeFor);
	$forAtu = $formato[$rand];
	
	//$debug->pre($formato, 0);
	
	// VERIFICANDO TURNO
	$turno 	= $rodada > $qtdRod ? 2: 1;
	
	// CRIANDO RODADA
	$jogos = $jogar->jogo($times, $rodada,  $turno, 1);
	
	// $debug->pre($jogos, 2);
	
	foreach($jogos as $key=>$val){ // PASSANDO PELA RODADA ATUAL
		$data = $semanas[$rodada]; // PEGANDO AS DATAS

		$qtdDt = count($data); // QUANTIDADE DE DATAS
		
		$forAtu = $forAtu[$qtdDt]; // FORMATO ADEQUADO
		
		$forAtu = explode('.', $forAtu); // EXPLODE NO FORMATO PARA SABER QUANTOS JOGOS SERÃO POR DIA
		
		$val = array_reverse($val); // RANDOMIZANDO RODADA
		$jj = 0;
		for($di = 0; $di<$qtdDt; $di++){ // PASSANDO PELOS DIAS
			for($aj = 0; $aj<$forAtu[$di]; $aj++){ // PASSANDO DE JOGO EM JOGO E DEFININDO DATAS
				$dataAt = $data[$di]; // PEGANDO DATA ATUAL
				$diaSem = date("w", strtotime($dataAt)); // PEGANDO DIA DA SEMANA
				
				$d_sem = $datas->traduz_semana($diaSem); // TRADUZINDO SEMANA (ABREVIANDO)
				
				$horaAtu = $hora[$diaSem];
				$horaAtu = $horaAtu[rand(0, count($horaAtu)-1)];
				
				if(strtotime($dataAt)<strtotime($VINI) or strtotime($dataAt)>strtotime($VFIM)){
					if($horaAtu ==  '16:00'){
						$horaAtu = '17:00';
					}elseif($horaAtu ==  '18:30'){
						$horaAtu = '19:30';
					}
				}
				
				$jg[$rodada][] = array('turno'=>$turno, 'dia_semana'=>$d_sem, 'data'=>$dataAt, 'horario'=>$horaAtu, 'mandante'=>$val[$jj]['m'], 'visitante'=>$val[$jj]['v']); // GRAVANDO JOGO
				$jj++;
			}
		}
		
		
		
	}
}
?>
