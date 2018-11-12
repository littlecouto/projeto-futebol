<?php
function select ($campo = '*', $tabela = 'tabela', $enquanto = '1', $ordem = NULL, $limit = NULL, $die = true, $return = 0){
	$parametros  = '';
	$parametros .= $enquanto 	!= '' ? "WHERE $enquanto": '';
	$parametros .= $ordem 		!= '' ? " ORDER BY $ordem": '';
	$parametros .= $limit 		!= '' ? " LIMIT $limit": '';
	$sql = "SELECT $campo FROM $tabela $parametros";
	$query = mysql_query($sql);
	if($query == false){
		return array(mysql_error());
	}
	if($return == true){
		return array($sql);
	}
	return $query;
}
function select_array ($campo = '*', $tabela = 'tabela', $enquanto = '1', $ordem = NULL, $limit = NULL, $die = true, $return = 0){
	$query = select($campo, $tabela, $enquanto, $ordem, $limit, $die, $return);
	if(is_array($query)){
		return $query[0];
	}
	while($row = mysql_fetch_assoc($query)){
		$query_array[] = $row;
	}
	
	return $query_array;
}


class debug {
	
	public function pre($array = array(), $tipo = 3){
		/*
			TIPOS
			1: RETURN
			2: ECHO
			3: ECHO AND EXIT
		*/
		
		if($tipo>1){
			echo "<pre>";
			print_r($array);
			echo "</pre>";

			if($tipo == 3) {
				exit;
			}
		}else{
			return $retorno;
		}
		

	}
}
class pre {
	
	public function __construct($array = array(), $tipo = 3){
		/*
			TIPOS
			1: RETURN
			2: ECHO
			3: ECHO AND EXIT
		*/
		
		if($tipo>1){
			echo "<pre>";
			print_r($array);
			echo "</pre>";

			if($tipo == 3) {
				exit;
			}
		}else{
			return $retorno;
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

function alert($msg = '', $location = '', $history = ''){
	$msg 		!= '' ? $msg 		= "alert('$msg')"				:'';
	$location 	!= '' ? $location 	= "location.href='$location'"	:'';
	$history 	!= '' ? $history 	= "history.go($history)"		:'';
	return "<script>$msg; $location; $history;</script>";
	
}
function aleatorio($num){
	if((boolean) rand(0,1)){
		return strrev($num);
	}
	return $num;
}

function email($email) {
    return preg_match("/^[a-zA-Z0-9\._-]+@[a-zA-Z0-9\._-]+.([a-zA-Z]{2,4})$/", $email);
}

function limpa_string($str){
	
	$a = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿºª';
	$b = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyoa';
	
	return strtr($str, $a, $b);
}

class jogos {
	public function jogo(array $times, $rodada = 0, $turno=1, $tipo=1){
		$times = array_unique($times);
		//shuffle($times);
		$qtd 		= count($times);
		$rodadas 	= $qtd-1;
		$rodadas2 	= $rodadas*2;
		
		if($rodada>$rodadas){
			$turno = 2;
			$rodada = $rodada-$rodadas;
		}
		
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
	
}
class mysql {
	
	public $host = 'localhost';
	public $base = '';
	public $user = 'root';
	public $pass = '';
	
	public function conectar(){
		$conexao = mysql_connect($this->host, $this->user, $this->pass) or die(mysql_error());
		mysql_select_db($this->base, $conexao) or die(mysql_error());
	}
}
class admin extends mysql {
	public function login($usuario, $senha){
		if($usuario == '' or $senha == ''){
			echo alert('Usuário ou senha inválidos', '','-1');
			exit;
		}
		$this->base = 'futebol_novo';
		$this->conectar();
		
		$senha = md5($senha);
		$rowUsu = mysql_fetch_array(mysql_query("SELECT idUsu FROM jogo_usuario WHERE usuario='$usuario' AND senha='$senha'"));
		if($rowUsu['idUsu']<1){
			echo alert('Usuário ou senha inválidos', '','-1');
			exit;
		}else{
			$_SESSION['USUARIO_JOGO_LOGADO'] = array('ID'=>$rowUsu['idUsu'], 'IP'=>$_SERVER['REMOTE_ADDR']);
			$datalogin = date("Y-m-d G:i:s");
		
			// resgatando o sistema operacional
			$so = "desconhecido";
			$user_agent = $_SERVER["HTTP_USER_AGENT"];
			if(preg_match("/Windows/",$user_agent) || preg_match("/WinNT/",$user_agent) || preg_match("/Win95/",$user_agent)) $so = "Windows";
			if(preg_match("/Mac/", $user_agent)) $so = "Macintosh";
			if(preg_match("/X11/", $user_agent)) $so = "Unix";
			
			// resgatando o browser
			if (preg_match('|MSIE ([0-9].[0-9]{1,2})|',$user_agent,$matched)) {
				$browser_version=$matched[1];
				$browser = 'IE';
			  } elseif (preg_match( '|Opera/([0-9].[0-9]{1,2})|',$user_agent,$matched)) {
				$browser_version=$matched[1];
				$browser = 'Opera';
			  } elseif(preg_match('|Firefox/([0-9\.]+)|',$user_agent,$matched)) {
				$browser_version=$matched[1];
				$browser = 'Firefox';
			  } elseif(preg_match('|Chrome/([0-9\.]+)|',$user_agent,$matched)) {
				$browser_version=$matched[1];
				$browser = 'Chrome';
			  } elseif(preg_match('|Safari/([0-9\.]+)|',$user_agent,$matched)) {
				$browser_version=$matched[1];
				$browser = 'Safari';
			  } else {
				// browser not recognized!
				$browser_version = 0;
				$browser= 'Outro';
			  }  
			$browser .= ' '.$browser_version;
		
		
			mysql_query("INSERT INTO jogo_acesso(idUsu, datalogin, ip, so, browser)VALUES('$rowUsu[idUsu]', '$datalogin', '$_SERVER[REMOTE_ADDR]', '$so', '$browser')") or die("Erro MYSQL: ".mysql_error()." Na linha ".__LINE__);
			
			echo alert('', 'index');
		}
	}
	public function verLogin(){
		if(!isset($_SESSION['USUARIO_JOGO_LOGADO']['ID'])){
			$this->logout();
			exit;
		}else{
			$this->base = 'futebol_novo';
			$this->conectar();
			
			$idUsu = $_SESSION['USUARIO_JOGO_LOGADO']['ID'];
			$rowUsu = mysql_fetch_array(mysql_query("SELECT idUsu FROM jogo_usuario WHERE idUsu='$idUsu'"));
			if($rowUsu['idUsu']<1){
				$this->logout();
			}
		}
	}
	
	
	public function logout(){
		session_destroy();
		echo alert('', 'login');
	}
}

class datas {
	public function filtro_intervalo($dias = array(), $intervalo){
		$dini = key($dias);
		$sini = $dias[$dini]['s'];
		$incr = 0;
		$return = array();
		$sm = 0;
		$tirar = 0;
		if($intervalo == 4){
			$max = 1;
			$tir = 2;
		}else{
			$max = 5;
			$tir = 0;
		}
		$mesAnt = $dias[$dini]['m']-1;
		foreach($dias as $dia=>$val){
			if($incr*$intervalo-$tirar == $dia){
			//	echo $mesAnt."<br>";
				if($mesAnt == $val['m']){
					$sm++;
				}else{
					$sm = 0;
				}
				if($sm>=$max){
					$tirar =+$tir;
				}else{
					$return[$dia] = $val;
				}
				$incr++;
				$mesAnt = $val['m'];
			}
		}
		foreach($return as $k=>$info){
			$data = $info['data'];
			$dataFinal[$data] = $info;
		}
		return $dataFinal;
	}
	public function dias($inicio, $fim, $dia = array(1), $intervalo = 1){
		// PEGA O VALOR DAS DATAS
		$dini = strtotime($inicio);
		$dfim = strtotime($fim);
		$hoje = strtotime(date("Y/m/d"));
		
		// ORGANIZA PARA EVITAR ERROS
		$dini = min($dini, $dfim);
		$dfim = max($dini, $dfim);
		$dini = $dini <= $hoje ? $hoje : $dini;
		
		// SEGUNDOS POR DIA (60*60*24)
		$segd = 60*60*24;
	
		$return = array();
		$semanaIni = date("W", $dini); // Semana referente ao ano
		
		while($dini <= $dfim){ //enquanto uma data for inferior a outra      
			$dt = date("Y-m-d",$dini);
			$dd = date("d",$dini);
			$mm = date("m",$dini);
			$aa = date("Y",$dini);
			
			$diasemana = date("w", $dini);
			$semanaAno = date("W", $dini);

			if(in_array($diasemana, $dia) and !is_array($return[$dt])){
				if($intervalo == 1){
					$return[$dt] = array('d'=>$dd, 'm'=>$mm, 'a'=>$aa, 's'=>$semanaAno, 'ds'=> $diasemana); 
				}else{
					$return[] = array('data'=>$dt, 'd'=>$dd, 'm'=>$mm, 'a'=>$aa, 's'=>$semanaAno, 'ds'=> $diasemana); 
				}
			}
			$dini += $segd; // adicionando mais 1 dia (em segundos) na data inicial
		}
		if($intervalo == 1){
			return $return;
		}
		return $this->filtro_intervalo($return, $intervalo);
		
	}
	 public function traduz_semana($semana, $abreviado = 0){
		switch($semana){
			case 0 : $semana = 'Domingo'; 	break;
			case 1 : $semana = 'Segunda'; 	break;
			case 2 : $semana = 'Terça'; 	break;
			case 3 : $semana = 'Quarta'; 	break;
			case 4 : $semana = 'Quinta'; 	break;
			case 5 : $semana = 'Sexta'; 	break;
			case 6 : $semana = 'Sábado'; 	break;
		}
		if($abreviado){
			return substr($semana, 0,3);
		}
		return $semana;
	}
	public function data($data, $formato = "dd/dm/da hh:hm:hs"){
		$data = strtr($data, array('/'=>'-', ','=>'-'));
		$dtEx = explode('', $data);
		return strtr($data, array('dd'=>''));
	}
}

?>