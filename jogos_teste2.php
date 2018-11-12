<?php
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
$times = array('Tabuca Juniors', 'São Joaquim', 'FJM', 'Taboão da Serra', 'Pagode Alegria S/7x1');
$jogos = jogo($times);

/*
FJM 3 x 0 PSJ 2 x 2 FJM | FJM 5x2 PSJ
TJR 1 x 5 CAT 2 x 3 TJR | TJR 4x7 CAT

FJM 2 x 3 PSJ 6 x 2 FJM | FJM 4x9 PSJ
TJR 1 x 3 CAT 0 x 5 TJR | TJR 6x3 CAT
echo "<pre>";
print_r($jogos);
echo "</pre>";
exit;
*/
    foreach ($jogos as $key => $v) {
	echo ($key+1).'<br>';
    foreach ($v as $i) {
	echo "<br>";
	$TM = $i['m'];
	$TV = $i['v'];
	
	$GM = 0;
	$GV = 0;
	
	$BR = $BP = $PM = $PV = 50;
	
	$a = 0;
	$p = 1;
	$ac = 0;
	for($t=0; $t<=46; $t++){
		$RA = rand(0,15);
		$RE = rand(1,5);
		$RM = rand(0,10);
		$RV = rand(0,10);
		
		if($RA == $RM){
			$PM++;		
			$PV--;
			switch($RE){
				case 1 :
					$GM++;
					echo "$t do $p"."T: Gol do $TM<br>";
					break;
				case 2 : 
					$GV++;
					echo "$t do $p"."T: Gol do $TV<br>";
					break;
				default:
				$a++;
				break;			
			}
		}elseif($RA == $RV){
			$PM--;
			$PV++;
			switch($RE){
				case 1 :
				$GV++;
				echo "$t do $p"."T: Gol do $TV<br>";
				break;
				case 2 : 
				$GM++;
				echo "$t do $p"."T: Gol do $TM<br>";
				break;
				default:
				$a++;
				break;
			}
		}
		
		if($RE >2){
			$BP++;
			$BR--;
		}else{
			$BP--;
			$BR++;
		}
		
		if($t == 43 and $ac ==0){
			$t -= $a;
			$ac = 1;
		}elseif($t==45 and $p == 1){
			echo "<br>$a DE ACRÉSCIMO<br>";
			echo "FIM DO 1º TEMPO<br><br>";
			
			$t= $ac = $a = 0;
			$p=2;
		}
		if($t == 46){
			break;
		}
	}
	echo "<br>$a DE ACRÉSCIMO<br>";
	echo "FIM DE JOGO:<br>";
	echo "$TM $GM X $GV $TV<br>";
	
	echo "<br>POSSE DE BOLA: $PM X $PV<br>";
	echo "BOLA ROLANDO: $BR <br> BOLA PARADA: $BP";
        }
    }

?>