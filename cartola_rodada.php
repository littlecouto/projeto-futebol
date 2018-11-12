<?php
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
$ri = 1;
$rf = 38;

for($ri; $ri<=$rf; $ri++){
	$json = 'http://api.cartola.globo.com/partidas/'.$ri.'.json';
	$fjson = file_get_contents($json);
	
	$djson = json_decode($fjson);
	$array = objectToArray($djson);
	//pre($array);
	foreach($array['partidas'] as $key => $val){
		echo $val['clube_casa']['nome'].' x '.$val['clube_visitante']['nome'].'<br>';
	}
	echo "<br>";
}




?>
