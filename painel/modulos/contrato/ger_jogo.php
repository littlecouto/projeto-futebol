<?php
session_start();

include_once '../../include/config.php';

// CONEXÃO
include_once '../../include/classes/conexao.class.php';
$con = new Conexao();
$conexao = $con->Conecta();
 
session_write_close();
function gera_jogos($times) {
    $num_times = count($times);
 
    $jogo = array();
    foreach ($times as $k => $m) {
        // Você não precisa passar todos os times de novo
        // Somente os que não foram passados
        for( $i = $k+1;$i < count($times);$i++) {
                $v = $times[$i];
            if ($m != $v AND !in_array(array('m' => $v, 'v' => $m), $jogo)) {
                $jogo[] = array('m' => $m, 'v' => $v);
            }
        }
    }
 
    $rodada = array();
    $times_usados = array();
    $jogos_usados = array();
 
    $num_rodadas = 1;
    $num_jogos = $num_times * $num_rodadas / 2;
    $num_jogos_realizados = 0;
 
    $rodada = array();
    shuffle($jogo);
    for ($i = 1; $i <= $num_rodadas; $i++) {
        foreach ($jogo as $c => $j) {
            if (!in_array($j['v'], $times_usados) AND !in_array($j['m'], $times_usados) AND !in_array($j, $jogos_usados)) {
                $rodada[$i][] = $j;
 
				
				$rowM = mysql_fetch_array(mysql_query("SELECT idJog FROM p_jogo WHERE (mandante='$j[m]' AND visitante='$j[v]') OR (mandante='$j[v]' AND visitante='$j[m]')"));
				//$rowV = mysql_fetch_array(mysql_query("SELECT idJog FROM p_jogo WHERE mandante='$j[v]' AND visitante='$j[m]'"));
				if($rowM['idJog']<1){
					mysql_query("INSERT INTO p_jogo(mandante, visitante)VALUE('$j[m]', '$j[v]')") or die(mysql_error());
					$times_usados[] = $j['v'];
					$times_usados[] = $j['m'];
	 
					$jogos_usados[] = $j;
	 
					$num_jogos_realizados++;
				}else{
					//mysql_query("INSERT INTO p_jogo(visitante, mandante)VALUE('$j[m]', '$j[v]')") or die(mysql_error());
				}
            }
        }
 
        $times_usados = array();
    }
 
   
    if ($num_jogos_realizados == $num_jogos) {
        return $rodada;
    } else {
        return false;
       
        $tentativa++;
    }
}
 
$times = array(
    'São Paulo',
    'Atlético Madri',
    'Atlético MG',
    'Barcelona',
    'Bayern',
    'Boca Juniors',
    'Borússia Dortmund',
    'Chelsea',
    'Corinthians',
    'Cruzeiro',
    'Juventos',
    'Lyon',
    'Manchester City',
    'Manchester United',
    'Milan',
    'Palmeiras',
    );
 shuffle($times);
$rodada = array();
 while ($rodada == false) {
    $rodada = gera_jogos($times);
    $tentativa++;
}

/* 
 */ 
 $jg = $rd = 0;
 $resJ = mysql_query("SELECT mandante, visitante FROM p_jogo");
 while($rowJ = mysql_fetch_array($resJ)){
	 if($jg == 0){
		 $rd++;
		 echo "<h2>RODADA $rd</h2>";		 
	 }
	 echo "<p>$rowJ[mandante] X $rowJ[visitante]</p>";
	 
	 $jg++;
	 if($jg == 8){
		 $jg = 0;
	 }
 }
 
foreach ($rodada as $c => $v) {
    echo "<h2>Rodada $c</h2>";
    foreach ($v as $i) {
        echo $i['m'], ' x ', $i['v'], '<br />';
    }
}
