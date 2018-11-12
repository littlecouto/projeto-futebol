<?php
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
 
                $times_usados[] = $j['v'];
                $times_usados[] = $j['m'];
 
                $jogos_usados[] = $j;

                $num_jogos_realizados++;
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



function jogo(array $times, $rodada = 0, $turno=1, $tipo=1){
	$times = array_unique($times);
	//shuffle($times);
	$qtd 		= count($times);
	$rodadas 	= $qtd-1;
	$rodadas2 	= $rodadas*2;

	if($turno == 2){
		$m = 'v';
		$v = 'm';
	}elseif ($turno == '1') {
		$m = 'm';
		$v = 'v';
	}
	if($tipo == 2){
		if($qtd == 8){
			$jogos = array(
				array(
					array($m=>$times[7],$v=>$times[0]),
					array($m=>$times[6],$v=>$times[1]),
					array($m=>$times[5],$v=>$times[2]),
					array($m=>$times[4],$v=>$times[3])
				),
				array(
					array($m=>$times[3],$v=>$times[0]),
					array($m=>$times[2],$v=>$times[1])
				),
				array(

					array($m=>$times[1],$v=>$times[0])
				),
			);
		}	
	}else{
		if($qtd == 3){
			$jogos = array(
				array(array($m=>$times[0],$v=>$times[1])),
				array(array($m=>$times[0],$v=>$times[2])),
				array(array($m=>$times[1],$v=>$times[2]))
			);
		}elseif($qtd == 4){
			$jogos = array(
				array(array($m=>$times[0],$v=>$times[1]),array($m=>$times[2],$v=>$times[3])),
				array(array($m=>$times[0],$v=>$times[2]),array($m=>$times[3],$v=>$times[1])),
				array(array($m=>$times[3],$v=>$times[0]),array($m=>$times[2],$v=>$times[1]))
			);
		}elseif($qtd == 5){
			$jogos = array(
				array(array($m=>$times[0],$v=>$times[1]),array($m=>$times[2],$v=>$times[3])),
				array(array($m=>$times[2],$v=>$times[0]),array($m=>$times[1],$v=>$times[4])),
				array(array($m=>$times[4],$v=>$times[0]),array($m=>$times[3],$v=>$times[1])),
				array(array($m=>$times[0],$v=>$times[3]),array($m=>$times[4],$v=>$times[2])),
				array(array($m=>$times[1],$v=>$times[2]),array($m=>$times[3],$v=>$times[4]))
			);
		}elseif($qtd == 10){
			$jogos = array(
				// RODADA 1
				array(array($m=>$times[0],$v=>$times[9]),array($m=>$times[1],$v=>$times[8]),array($m=>$times[2],$v=>$times[7]),array($m=>$times[3],$v=>$times[6]),array($m=>$times[4],$v=>$times[5])),
				
				// RODADA 2
				array(array($m=>$times[9],$v=>$times[5]),array($m=>$times[6],$v=>$times[4]),array($m=>$times[7],$v=>$times[3]),array($m=>$times[8],$v=>$times[2]),array($m=>$times[0],$v=>$times[1])),
				
				// RODADA 3
				array(array($m=>$times[1],$v=>$times[9]),array($m=>$times[2],$v=>$times[0]),array($m=>$times[3],$v=>$times[8]),array($m=>$times[4],$v=>$times[7]),array($m=>$times[5],$v=>$times[6])),
				
				// RODADA 4
				array(array($m=>$times[9],$v=>$times[6]),array($m=>$times[7],$v=>$times[5]),array($m=>$times[8],$v=>$times[4]),array($m=>$times[0],$v=>$times[3]),array($m=>$times[1],$v=>$times[2])),
				
				// RODADA 5
				array(array($m=>$times[2],$v=>$times[9]),array($m=>$times[3],$v=>$times[1]),array($m=>$times[4],$v=>$times[0]),array($m=>$times[5],$v=>$times[8]),array($m=>$times[6],$v=>$times[7])),
				
				// RODADA 6
				array(array($m=>$times[9],$v=>$times[7]),array($m=>$times[8],$v=>$times[6]),array($m=>$times[0],$v=>$times[5]),array($m=>$times[1],$v=>$times[4]),array($m=>$times[2],$v=>$times[3])),
				
				// RODADA 7
				array(array($m=>$times[3],$v=>$times[9]),array($m=>$times[4],$v=>$times[2]),array($m=>$times[5],$v=>$times[1]),array($m=>$times[6],$v=>$times[0]),array($m=>$times[7],$v=>$times[8])),
				
				// RODADA 8
				array(array($m=>$times[9],$v=>$times[8]),array($m=>$times[0],$v=>$times[7]),array($m=>$times[1],$v=>$times[6]),array($m=>$times[2],$v=>$times[5]),array($m=>$times[3],$v=>$times[4])),
				
				// RODADA 9
				array(array($m=>$times[4],$v=>$times[9]),array($m=>$times[5],$v=>$times[3]),array($m=>$times[6],$v=>$times[2]),array($m=>$times[7],$v=>$times[1]),array($m=>$times[8],$v=>$times[0])),
			);
		}elseif($qtd == 20){
			$jogos = array(
				// RODADA 1
				array(array($m=>$times[0], $v=>$times[19]),array($m=>$times[1], $v=>$times[18]),array($m=>$times[2], $v=>$times[17]),array($m=>$times[3], $v=>$times[16]),array($m=>$times[4], $v=>$times[15]),array($m=>$times[5], $v=>$times[14]),array($m=>$times[6], $v=>$times[13]),array($m=>$times[7], $v=>$times[12]),array($m=>$times[8], $v=>$times[11]),array($m=>$times[9], $v=>$times[10])),
				
				// RODADA 2
				array(array($m=>$times[18], $v=>$times[3]),array($m=>$times[11], $v=>$times[6]),array($m=>$times[14], $v=>$times[1]),array($m=>$times[12], $v=>$times[8]),array($m=>$times[10], $v=>$times[5]),array($m=>$times[15], $v=>$times[7]),array($m=>$times[19], $v=>$times[2]),array($m=>$times[16], $v=>$times[4]),array($m=>$times[13], $v=>$times[9]),array($m=>$times[17], $v=>$times[0])),
				
				// RODADA 3
				array(array($m=>$times[4], $v=>$times[17]),array($m=>$times[8], $v=>$times[13]),array($m=>$times[3], $v=>$times[12]),array($m=>$times[0], $v=>$times[11]),array($m=>$times[2], $v=>$times[14]),array($m=>$times[9], $v=>$times[15]),array($m=>$times[6], $v=>$times[19]),array($m=>$times[1], $v=>$times[10]),array($m=>$times[5], $v=>$times[16]),array($m=>$times[7], $v=>$times[18])),
				
				// RODADA 4
				array(array($m=>$times[16], $v=>$times[1]),array($m=>$times[18], $v=>$times[9]),array($m=>$times[17], $v=>$times[6]),array($m=>$times[10], $v=>$times[7]),array($m=>$times[14], $v=>$times[0]),array($m=>$times[13], $v=>$times[4]),array($m=>$times[19], $v=>$times[8]),array($m=>$times[11], $v=>$times[3]),array($m=>$times[15], $v=>$times[2]),array($m=>$times[12], $v=>$times[5])),
				
				// RODADA 5
				array(array($m=>$times[8], $v=>$times[16]),array($m=>$times[6], $v=>$times[12]),array($m=>$times[1], $v=>$times[17]),array($m=>$times[4], $v=>$times[10]),array($m=>$times[3], $v=>$times[14]),array($m=>$times[5], $v=>$times[15]),array($m=>$times[9], $v=>$times[19]),array($m=>$times[2], $v=>$times[18]),array($m=>$times[0], $v=>$times[13]),array($m=>$times[7], $v=>$times[11])),
				
				// RODADA 6
				array(array($m=>$times[10], $v=>$times[16]),array($m=>$times[15], $v=>$times[1]),array($m=>$times[19], $v=>$times[5]),array($m=>$times[4], $v=>$times[3]),array($m=>$times[6], $v=>$times[8]),array($m=>$times[17], $v=>$times[14]),array($m=>$times[13], $v=>$times[18]),array($m=>$times[2], $v=>$times[7]),array($m=>$times[12], $v=>$times[0]),array($m=>$times[11], $v=>$times[9])),
				
				// RODADA 7
				array(array($m=>$times[19], $v=>$times[10]),array($m=>$times[14], $v=>$times[13]),array($m=>$times[18], $v=>$times[15]),array($m=>$times[1], $v=>$times[4]),array($m=>$times[8], $v=>$times[5]),array($m=>$times[7], $v=>$times[17]),array($m=>$times[16], $v=>$times[11]),array($m=>$times[0], $v=>$times[2]),array($m=>$times[3], $v=>$times[6]),array($m=>$times[9], $v=>$times[12])),
				
				// RODADA 8
				array(array($m=>$times[12], $v=>$times[13]),array($m=>$times[10], $v=>$times[14]),array($m=>$times[15], $v=>$times[19]),array($m=>$times[7], $v=>$times[8]),array($m=>$times[3], $v=>$times[0]),array($m=>$times[5], $v=>$times[1]),array($m=>$times[4], $v=>$times[9]),array($m=>$times[6], $v=>$times[18]),array($m=>$times[17], $v=>$times[11]),array($m=>$times[2], $v=>$times[16])),
				
				// RODADA 9
				array(array($m=>$times[9], $v=>$times[3]),array($m=>$times[1], $v=>$times[7]),array($m=>$times[14], $v=>$times[12]),array($m=>$times[19], $v=>$times[17]),array($m=>$times[0], $v=>$times[4]),array($m=>$times[16], $v=>$times[6]),array($m=>$times[18], $v=>$times[5]),array($m=>$times[11], $v=>$times[2]),array($m=>$times[8], $v=>$times[15]),array($m=>$times[13], $v=>$times[10])),
				
				// RODADA 10
				array(array($m=>$times[8], $v=>$times[9]),array($m=>$times[7], $v=>$times[13]),array($m=>$times[0], $v=>$times[1]),array($m=>$times[19], $v=>$times[18]),array($m=>$times[3], $v=>$times[5]),array($m=>$times[6], $v=>$times[4]),array($m=>$times[17], $v=>$times[15]),array($m=>$times[14], $v=>$times[16]),array($m=>$times[12], $v=>$times[11]),array($m=>$times[2], $v=>$times[10])),
				
				// RODADA 11
				array(array($m=>$times[18], $v=>$times[17]),array($m=>$times[5], $v=>$times[6]),array($m=>$times[1], $v=>$times[8]),array($m=>$times[9], $v=>$times[7]),array($m=>$times[4], $v=>$times[2]),array($m=>$times[10], $v=>$times[3]),array($m=>$times[11], $v=>$times[14]),array($m=>$times[16], $v=>$times[0]),array($m=>$times[15], $v=>$times[12]),array($m=>$times[13], $v=>$times[19])),
				
				// RODADA 12
				array(array($m=>$times[18], $v=>$times[16]),array($m=>$times[11], $v=>$times[10]),array($m=>$times[1], $v=>$times[3]),array($m=>$times[0], $v=>$times[9]),array($m=>$times[12], $v=>$times[17]),array($m=>$times[8], $v=>$times[4]),array($m=>$times[13], $v=>$times[15]),array($m=>$times[19], $v=>$times[7]),array($m=>$times[14], $v=>$times[6]),array($m=>$times[2], $v=>$times[5])),
				
				// RODADA 13
				array(array($m=>$times[10], $v=>$times[12]),array($m=>$times[3], $v=>$times[8]),array($m=>$times[16], $v=>$times[19]),array($m=>$times[4], $v=>$times[18]),array($m=>$times[15], $v=>$times[14]),array($m=>$times[5], $v=>$times[11]),array($m=>$times[6], $v=>$times[2]),array($m=>$times[17], $v=>$times[13]),array($m=>$times[9], $v=>$times[1]),array($m=>$times[7], $v=>$times[0])),
				
				// RODADA 14
				array(array($m=>$times[15], $v=>$times[3]),array($m=>$times[13], $v=>$times[11]),array($m=>$times[14], $v=>$times[19]),array($m=>$times[6], $v=>$times[1]),array($m=>$times[0], $v=>$times[10]),array($m=>$times[2], $v=>$times[8]),array($m=>$times[12], $v=>$times[18]),array($m=>$times[7], $v=>$times[4]),array($m=>$times[5], $v=>$times[9]),array($m=>$times[17], $v=>$times[16])),
				
				// RODADA 15
				array(array($m=>$times[9], $v=>$times[6]),array($m=>$times[3], $v=>$times[7]),array($m=>$times[19], $v=>$times[12]),array($m=>$times[10], $v=>$times[17]),array($m=>$times[1], $v=>$times[2]),array($m=>$times[4], $v=>$times[5]),array($m=>$times[16], $v=>$times[13]),array($m=>$times[18], $v=>$times[14]),array($m=>$times[11], $v=>$times[15]),array($m=>$times[8], $v=>$times[0])),
				
				// RODADA 16
				array(array($m=>$times[14], $v=>$times[8]),array($m=>$times[19], $v=>$times[4]),array($m=>$times[2], $v=>$times[3]),array($m=>$times[0], $v=>$times[6]),array($m=>$times[18], $v=>$times[11]),array($m=>$times[15], $v=>$times[10]),array($m=>$times[13], $v=>$times[1]),array($m=>$times[12], $v=>$times[16]),array($m=>$times[17], $v=>$times[9]),array($m=>$times[7], $v=>$times[5])),
				
				// RODADA 17
				array(array($m=>$times[9], $v=>$times[2]),array($m=>$times[10], $v=>$times[18]),array($m=>$times[8], $v=>$times[17]),array($m=>$times[6], $v=>$times[7]),array($m=>$times[4], $v=>$times[14]),array($m=>$times[5], $v=>$times[0]),array($m=>$times[16], $v=>$times[15]),array($m=>$times[11], $v=>$times[19]),array($m=>$times[3], $v=>$times[13]),array($m=>$times[1], $v=>$times[12])),
				
				// RODADA 18
				array(array($m=>$times[15], $v=>$times[6]),array($m=>$times[18], $v=>$times[0]),array($m=>$times[10], $v=>$times[8]),array($m=>$times[11], $v=>$times[1]),array($m=>$times[14], $v=>$times[7]),array($m=>$times[13], $v=>$times[2]),array($m=>$times[12], $v=>$times[4]),array($m=>$times[16], $v=>$times[9]),array($m=>$times[19], $v=>$times[3]),array($m=>$times[17], $v=>$times[5])),
				
				// RODADA 19
				array(array($m=>$times[8], $v=>$times[18]),array($m=>$times[6], $v=>$times[10]),array($m=>$times[4], $v=>$times[11]),array($m=>$times[0], $v=>$times[15]),array($m=>$times[2], $v=>$times[12]),array($m=>$times[9], $v=>$times[14]),array($m=>$times[7], $v=>$times[16]),array($m=>$times[5], $v=>$times[13]),array($m=>$times[3], $v=>$times[17]),array($m=>$times[1], $v=>$times[19])),
				
				// RODADA 20
				array(array($m=>$times[10], $v=>$times[9]),array($m=>$times[11], $v=>$times[8]),array($m=>$times[12], $v=>$times[7]),array($m=>$times[16], $v=>$times[3]),array($m=>$times[18], $v=>$times[1]),array($m=>$times[14], $v=>$times[5]),array($m=>$times[15], $v=>$times[4]),array($m=>$times[13], $v=>$times[6]),array($m=>$times[17], $v=>$times[2]),array($m=>$times[19], $v=>$times[0])),
				
				// RODADA 21
				array(array($m=>$times[8], $v=>$times[12]),array($m=>$times[4], $v=>$times[16]),array($m=>$times[3], $v=>$times[18]),array($m=>$times[9], $v=>$times[13]),array($m=>$times[0], $v=>$times[17]),array($m=>$times[2], $v=>$times[19]),array($m=>$times[7], $v=>$times[15]),array($m=>$times[1], $v=>$times[14]),array($m=>$times[5], $v=>$times[10]),array($m=>$times[6], $v=>$times[11])),
				
				// RODADA 22
				array(array($m=>$times[16], $v=>$times[5]),array($m=>$times[13], $v=>$times[8]),array($m=>$times[17], $v=>$times[4]),array($m=>$times[15], $v=>$times[9]),array($m=>$times[19], $v=>$times[6]),array($m=>$times[14], $v=>$times[2]),array($m=>$times[18], $v=>$times[7]),array($m=>$times[11], $v=>$times[0]),array($m=>$times[10], $v=>$times[1]),array($m=>$times[12], $v=>$times[3])),
				
				// RODADA 23
				array(array($m=>$times[4], $v=>$times[13]),array($m=>$times[8], $v=>$times[19]),array($m=>$times[6], $v=>$times[17]),array($m=>$times[5], $v=>$times[12]),array($m=>$times[1], $v=>$times[16]),array($m=>$times[0], $v=>$times[14]),array($m=>$times[2], $v=>$times[15]),array($m=>$times[3], $v=>$times[11]),array($m=>$times[9], $v=>$times[18]),array($m=>$times[7], $v=>$times[10])),
				
				// RODADA 24
				array(array($m=>$times[16], $v=>$times[8]),array($m=>$times[13], $v=>$times[0]),array($m=>$times[19], $v=>$times[9]),array($m=>$times[12], $v=>$times[6]),array($m=>$times[14], $v=>$times[3]),array($m=>$times[10], $v=>$times[4]),array($m=>$times[18], $v=>$times[2]),array($m=>$times[11], $v=>$times[7]),array($m=>$times[15], $v=>$times[5]),array($m=>$times[17], $v=>$times[1])),
				
				// RODADA 25
				array(array($m=>$times[18], $v=>$times[13]),array($m=>$times[0], $v=>$times[12]),array($m=>$times[14], $v=>$times[17]),array($m=>$times[16], $v=>$times[10]),array($m=>$times[8], $v=>$times[6]),array($m=>$times[3], $v=>$times[4]),array($m=>$times[5], $v=>$times[19]),array($m=>$times[1], $v=>$times[15]),array($m=>$times[9], $v=>$times[11]),array($m=>$times[7], $v=>$times[2])),
				
				// RODADA 26
				array(array($m=>$times[2], $v=>$times[0]),array($m=>$times[11], $v=>$times[16]),array($m=>$times[17], $v=>$times[7]),array($m=>$times[12], $v=>$times[9]),array($m=>$times[6], $v=>$times[3]),array($m=>$times[10], $v=>$times[19]),array($m=>$times[13], $v=>$times[14]),array($m=>$times[5], $v=>$times[8]),array($m=>$times[4], $v=>$times[1]),array($m=>$times[15], $v=>$times[18])),
				
				// RODADA 27
				array(array($m=>$times[0], $v=>$times[3]),array($m=>$times[13], $v=>$times[12]),array($m=>$times[16], $v=>$times[2]),array($m=>$times[14], $v=>$times[10]),array($m=>$times[11], $v=>$times[17]),array($m=>$times[8], $v=>$times[7]),array($m=>$times[19], $v=>$times[15]),array($m=>$times[9], $v=>$times[4]),array($m=>$times[18], $v=>$times[6]),array($m=>$times[1], $v=>$times[5])),
				
				// RODADA 28
				array(array($m=>$times[2], $v=>$times[11]),array($m=>$times[3], $v=>$times[9]),array($m=>$times[10], $v=>$times[13]),array($m=>$times[6], $v=>$times[16]),array($m=>$times[4], $v=>$times[0]),array($m=>$times[15], $v=>$times[8]),array($m=>$times[12], $v=>$times[14]),array($m=>$times[17], $v=>$times[19]),array($m=>$times[5], $v=>$times[18]),array($m=>$times[7], $v=>$times[1])),
				
				// RODADA 29
				array(array($m=>$times[13], $v=>$times[7]),array($m=>$times[18], $v=>$times[19]),array($m=>$times[4], $v=>$times[6]),array($m=>$times[15], $v=>$times[17]),array($m=>$times[9], $v=>$times[8]),array($m=>$times[10], $v=>$times[2]),array($m=>$times[16], $v=>$times[14]),array($m=>$times[5], $v=>$times[3]),array($m=>$times[11], $v=>$times[12]),array($m=>$times[1], $v=>$times[0])),
				
				// RODADA 30
				array(array($m=>$times[19], $v=>$times[13]),array($m=>$times[7], $v=>$times[9]),array($m=>$times[0], $v=>$times[16]),array($m=>$times[12], $v=>$times[15]),array($m=>$times[17], $v=>$times[18]),array($m=>$times[2], $v=>$times[4]),array($m=>$times[6], $v=>$times[5]),array($m=>$times[14], $v=>$times[11]),array($m=>$times[8], $v=>$times[1]),array($m=>$times[3], $v=>$times[10])),
				
				// RODADA 31
				array(array($m=>$times[9], $v=>$times[0]),array($m=>$times[17], $v=>$times[12]),array($m=>$times[16], $v=>$times[18]),array($m=>$times[5], $v=>$times[2]),array($m=>$times[4], $v=>$times[8]),array($m=>$times[15], $v=>$times[13]),array($m=>$times[6], $v=>$times[14]),array($m=>$times[10], $v=>$times[11]),array($m=>$times[3], $v=>$times[1]),array($m=>$times[7], $v=>$times[19])),
				
				// RODADA 32
				array(array($m=>$times[2], $v=>$times[6]),array($m=>$times[13], $v=>$times[17]),array($m=>$times[12], $v=>$times[10]),array($m=>$times[0], $v=>$times[7]),array($m=>$times[14], $v=>$times[15]),array($m=>$times[8], $v=>$times[3]),array($m=>$times[18], $v=>$times[4]),array($m=>$times[1], $v=>$times[9]),array($m=>$times[11], $v=>$times[5]),array($m=>$times[19], $v=>$times[16])),
				
				// RODADA 33
				array(array($m=>$times[4], $v=>$times[7]),array($m=>$times[16], $v=>$times[17]),array($m=>$times[9], $v=>$times[5]),array($m=>$times[18], $v=>$times[12]),array($m=>$times[10], $v=>$times[0]),array($m=>$times[3], $v=>$times[15]),array($m=>$times[19], $v=>$times[14]),array($m=>$times[1], $v=>$times[6]),array($m=>$times[8], $v=>$times[2]),array($m=>$times[11], $v=>$times[13])),
				
				// RODADA 34
				array(array($m=>$times[13], $v=>$times[16]),array($m=>$times[14], $v=>$times[18]),array($m=>$times[6], $v=>$times[9]),array($m=>$times[2], $v=>$times[1]),array($m=>$times[0], $v=>$times[8]),array($m=>$times[15], $v=>$times[11]),array($m=>$times[5], $v=>$times[4]),array($m=>$times[12], $v=>$times[19]),array($m=>$times[17], $v=>$times[10]),array($m=>$times[7], $v=>$times[3])),
				
				// RODADA 35
				array(array($m=>$times[5], $v=>$times[7]),array($m=>$times[6], $v=>$times[0]),array($m=>$times[11], $v=>$times[18]),array($m=>$times[16], $v=>$times[12]),array($m=>$times[9], $v=>$times[17]),array($m=>$times[4], $v=>$times[19]),array($m=>$times[10], $v=>$times[15]),array($m=>$times[8], $v=>$times[14]),array($m=>$times[1], $v=>$times[13]),array($m=>$times[3], $v=>$times[2])),
				
				// RODADA 36
				array(array($m=>$times[14], $v=>$times[4]),array($m=>$times[0], $v=>$times[5]),array($m=>$times[2], $v=>$times[9]),array($m=>$times[15], $v=>$times[16]),array($m=>$times[13], $v=>$times[3]),array($m=>$times[19], $v=>$times[11]),array($m=>$times[12], $v=>$times[1]),array($m=>$times[18], $v=>$times[10]),array($m=>$times[7], $v=>$times[6]),array($m=>$times[17], $v=>$times[8])),
				
				// RODADA 37
				array(array($m=>$times[4], $v=>$times[12]),array($m=>$times[0], $v=>$times[18]),array($m=>$times[2], $v=>$times[13]),array($m=>$times[8], $v=>$times[10]),array($m=>$times[3], $v=>$times[19]),array($m=>$times[5], $v=>$times[17]),array($m=>$times[9], $v=>$times[16]),array($m=>$times[6], $v=>$times[15]),array($m=>$times[7], $v=>$times[14]),array($m=>$times[1], $v=>$times[11])),
				
				// RODADA 38
				array(array($m=>$times[14], $v=>$times[9]),array($m=>$times[10], $v=>$times[6]),array($m=>$times[16], $v=>$times[7]),array($m=>$times[15], $v=>$times[0]),array($m=>$times[13], $v=>$times[5]),array($m=>$times[19], $v=>$times[1]),array($m=>$times[12], $v=>$times[2]),array($m=>$times[18], $v=>$times[8]),array($m=>$times[11], $v=>$times[4]),array($m=>$times[17], $v=>$times[3]))
			);



		}else{
			return false;
		}
	}

	if($rodada>0){
		return array($jogos[$rodada-1]);
	}
	return $jogos;

}


/*

$rodadas = jogo(array('Atletico de Madrid', 'Barcelona', 'Real Madrid', 'Atletico Bilbao', 'Sevilla', 'Villarreal', 'Real Sociedad', 'Valencia', 'Celta', 'Levante', 'Malaga', 'Rayo Vallecano', 'Getafe', 'Espanyol', 'Granada', 'Eibar', 'Deportivo la Coluña', 'Sporting de Gijón', 'Real Betis', 'UD Las Palmas'));


    foreach ($rodadas as $key => $v) {
    	echo '<br><h5>'.($key+1).'</h5><br>';
        foreach ($v as $i) {
        	echo '<p>'.$i['m'].' x '.$i['v'].'</p>';
        }
    }


// echo "<pre>";
// print_r($rodadas);
// echo "</pre>";

*/


?>