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
$times = "Palmeiras x Atlético-MG".PHP_EOL.
	"Chapecoense x Coritiba".PHP_EOL.
	"Fluminense x Joinville".PHP_EOL.
	"Grêmio x Ponte Preta".PHP_EOL.
	"São Paulo x Flamengo".PHP_EOL.
	"Cruzeiro x Corinthians".PHP_EOL.
	"Atlético-PR x Internacional".PHP_EOL.
	"Sport x Figueirense".PHP_EOL.
	"Vasco x Goiás".PHP_EOL.
	"Avaí x Santos".PHP_EOL.
	"----".PHP_EOL.
	"Coritiba x Grêmio".PHP_EOL.
	"Goiás x Atlético-PR".PHP_EOL.
	"Corinthians x Chapecoense".PHP_EOL.
	"Figueirense x Vasco".PHP_EOL.
	"Santos x Cruzeiro".PHP_EOL.
	"Flamengo x Sport".PHP_EOL.
	"Atlético-MG x Fluminense".PHP_EOL.
	"Ponte Preta x São Paulo".PHP_EOL.
	"Internacional x Avaí".PHP_EOL.
	"Joinville x Palmeiras".PHP_EOL.
	"----".PHP_EOL.
	"São Paulo x Joinville".PHP_EOL.
	"Vasco x Internacional".PHP_EOL.
	"Grêmio x Figueirense".PHP_EOL.
	"Palmeiras x Goiás".PHP_EOL.
	"Fluminense x Corinthians".PHP_EOL.
	"Avaí x Flamengo".PHP_EOL.
	"Atlético-PR x Atlético-MG".PHP_EOL.
	"Chapecoense x Santos".PHP_EOL.
	"Cruzeiro x Ponte Preta".PHP_EOL.
	"Sport x Coritiba".PHP_EOL.
	"----".PHP_EOL.
	"Ponte Preta x Chapecoense".PHP_EOL.
	"Coritiba x Avaí".PHP_EOL.
	"Joinville x Atlético-PR".PHP_EOL.
	"Santos x Sport".PHP_EOL.
	"Corinthians x Palmeiras".PHP_EOL.
	"Internacional x São Paulo".PHP_EOL.
	"Atlético-MG x Vasco".PHP_EOL.
	"Goiás x Grêmio".PHP_EOL.
	"Flamengo x Fluminense".PHP_EOL.
	"Figueirense x Cruzeiro".PHP_EOL.
	"----".PHP_EOL.
	"Vasco x Ponte Preta".PHP_EOL.
	"Atlético-PR x Figueirense".PHP_EOL.
	"Chapecoense x Joinville".PHP_EOL.
	"São Paulo x Santos".PHP_EOL.
	"Grêmio x Corinthians".PHP_EOL.
	"Cruzeiro x Flamengo".PHP_EOL.
	"Avaí x Atlético-MG".PHP_EOL.
	"Fluminense x Coritiba".PHP_EOL.
	"Palmeiras x Internacional".PHP_EOL.
	"Sport x Goiás".PHP_EOL.
	"----".PHP_EOL.
	"Santos x Ponte Preta".PHP_EOL.
	"Flamengo x Chapecoense".PHP_EOL.
	"Atlético-MG x Cruzeiro".PHP_EOL.
	"São Paulo x Grêmio".PHP_EOL.
	"Atlético-PR x Vasco".PHP_EOL.
	"Joinville x Corinthians".PHP_EOL.
	"Internacional x Coritiba".PHP_EOL.
	"Fluminense x Sport".PHP_EOL.
	"Figueirense x Palmeiras".PHP_EOL.
	"Goiás x Avaí".PHP_EOL.
	"----".PHP_EOL.
	"Atlético-MG x Santos".PHP_EOL.
	"Corinthians x Internacional".PHP_EOL.
	"Coritiba x Flamengo".PHP_EOL.
	"Chapecoense x São Paulo".PHP_EOL.
	"Vasco x Cruzeiro".PHP_EOL.
	"Sport x Joinville".PHP_EOL.
	"Ponte Preta x Goiás".PHP_EOL.
	"Palmeiras x Fluminense".PHP_EOL.
	"Grêmio x Atlético-PR".PHP_EOL.
	"Avaí x Figueirense".PHP_EOL.
	"----".PHP_EOL.
	"Figueirense x Internacional".PHP_EOL.
	"Santos x Corinthians".PHP_EOL.
	"Flamengo x Atlético-MG".PHP_EOL.
	"Sport x Vasco".PHP_EOL.
	"Grêmio x Palmeiras".PHP_EOL.
	"Cruzeiro x Chapecoense".PHP_EOL.
	"São Paulo x Avaí".PHP_EOL.
	"Atlético-PR x Coritiba".PHP_EOL.
	"Joinville x Goiás".PHP_EOL.
	"Fluminense x Ponte Preta".PHP_EOL.
	"----".PHP_EOL.
	"Avaí x Grêmio".PHP_EOL.
	"Chapecoense x Sport".PHP_EOL.
	"Corinthians x Figueirense".PHP_EOL.
	"Atlético-MG x Joinville".PHP_EOL.
	"Palmeiras x São Paulo".PHP_EOL.
	"Ponte Preta x Atlético-PR".PHP_EOL.
	"Coritiba x Cruzeiro".PHP_EOL.
	"Goiás x Fluminense".PHP_EOL.
	"Vasco x Flamengo".PHP_EOL.
	"Internacional x Santos".PHP_EOL.
	"----".PHP_EOL.
	"Vasco x Avaí".PHP_EOL.
	"Sport x Internacional".PHP_EOL.
	"Palmeiras x Chapecoense".PHP_EOL.
	"Atlético-MG x Coritiba".PHP_EOL.
	"Grêmio x Cruzeiro".PHP_EOL.
	"Atlético-PR x São Paulo".PHP_EOL.
	"Joinville x Flamengo".PHP_EOL.
	"Corinthians x Ponte Preta".PHP_EOL.
	"Figueirense x Goiás".PHP_EOL.
	"Fluminense x Santos".PHP_EOL.
	"----".PHP_EOL.
	"Coritiba x Joinville".PHP_EOL.
	"Cruzeiro x Atlético-PR".PHP_EOL.
	"Chapecoense x Vasco".PHP_EOL.
	"Avaí x Sport".PHP_EOL.
	"São Paulo x Fluminense".PHP_EOL.
	"Santos x Grêmio".PHP_EOL.
	"Goiás x Corinthians".PHP_EOL.
	"Ponte Preta x Palmeiras".PHP_EOL.
	"Flamengo x Figueirense".PHP_EOL.
	"Internacional x Atlético-MG".PHP_EOL.
	"----".PHP_EOL.
	"Coritiba x Ponte Preta".PHP_EOL.
	"Goiás x Santos".PHP_EOL.
	"Chapecoense x Grêmio".PHP_EOL.
	"Palmeiras x Avaí".PHP_EOL.
	"Figueirense x Joinville".PHP_EOL.
	"Vasco x São Paulo".PHP_EOL.
	"Internacional x Flamengo".PHP_EOL.
	"Atlético-MG x Sport".PHP_EOL.
	"Corinthians x Atlético-PR".PHP_EOL.
	"Fluminense x Cruzeiro".PHP_EOL.
	"----".PHP_EOL.
	"Santos x Figueirense".PHP_EOL.
	"Grêmio x Vasco".PHP_EOL.
	"Ponte Preta x Atlético-MG".PHP_EOL.
	"São Paulo x Coritiba".PHP_EOL.
	"Flamengo x Corinthians".PHP_EOL.
	"Cruzeiro x Goiás".PHP_EOL.
	"Atlético-PR x Fluminense".PHP_EOL.
	"Joinville x Internacional".PHP_EOL.
	"Avaí x Chapecoense".PHP_EOL.
	"Sport x Palmeiras".PHP_EOL.
	"----".PHP_EOL.
	"Flamengo x Grêmio".PHP_EOL.
	"Internacional x Goiás".PHP_EOL.
	"Corinthians x Atlético-MG".PHP_EOL.
	"Atlético-PR x Chapecoense".PHP_EOL.
	"Palmeiras x Santos".PHP_EOL.
	"Fluminense x Vasco".PHP_EOL.
	"Figueirense x Coritiba".PHP_EOL.
	"Sport x São Paulo".PHP_EOL.
	"Cruzeiro x Avaí".PHP_EOL.
	"Joinville x Ponte Preta".PHP_EOL.
	"----".PHP_EOL.
	"Avaí x Atlético-PR".PHP_EOL.
	"Grêmio x Sport".PHP_EOL.
	"Atlético-MG x Figueirense".PHP_EOL.
	"Santos x Joinville".PHP_EOL.
	"Chapecoense x Fluminense".PHP_EOL.
	"São Paulo x Cruzeiro".PHP_EOL.
	"Ponte Preta x Internacional".PHP_EOL.
	"Coritiba x Corinthians".PHP_EOL.
	"Goiás x Flamengo".PHP_EOL.
	"Vasco x Palmeiras".PHP_EOL.
	"----".PHP_EOL.
	"Corinthians x Vasco".PHP_EOL.
	"Atlético-MG x São Paulo".PHP_EOL.
	"Fluminense x Grêmio".PHP_EOL.
	"Palmeiras x Atlético-PR".PHP_EOL.
	"Coritiba x Goiás".PHP_EOL.
	"Flamengo x Santos".PHP_EOL.
	"Internacional x Chapecoense".PHP_EOL.
	"Figueirense x Ponte Preta".PHP_EOL.
	"Joinville x Avaí".PHP_EOL.
	"Sport x Cruzeiro".PHP_EOL.
	"----".PHP_EOL.
	"Avaí x Fluminense".PHP_EOL.
	"Santos x Coritiba".PHP_EOL.
	"Vasco x Joinville".PHP_EOL.
	"Atlético-PR x Sport".PHP_EOL.
	"São Paulo x Corinthians".PHP_EOL.
	"Cruzeiro x Palmeiras".PHP_EOL.
	"Ponte Preta x Flamengo".PHP_EOL.
	"Goiás x Atlético-MG".PHP_EOL.
	"Grêmio x Internacional".PHP_EOL.
	"Chapecoense x Figueirense".PHP_EOL.
	"----".PHP_EOL.
	"Flamengo x Atlético-PR".PHP_EOL.
	"Coritiba x Palmeiras".PHP_EOL.
	"Santos x Vasco".PHP_EOL.
	"Goiás x Chapecoense".PHP_EOL.
	"Corinthians x Sport".PHP_EOL.
	"Internacional x Fluminense".PHP_EOL.
	"Figueirense x São Paulo".PHP_EOL.
	"Ponte Preta x Avaí".PHP_EOL.
	"Atlético-MG x Grêmio".PHP_EOL.
	"Joinville x Cruzeiro".PHP_EOL.
	"----".PHP_EOL.
	"Vasco x Coritiba".PHP_EOL.
	"Atlético-PR x Santos".PHP_EOL.
	"São Paulo x Goiás".PHP_EOL.
	"Palmeiras x Flamengo".PHP_EOL.
	"Fluminense x Figueirense".PHP_EOL.
	"Avaí x Corinthians".PHP_EOL.
	"Sport x Ponte Preta".PHP_EOL.
	"Cruzeiro x Internacional".PHP_EOL.
	"Grêmio x Joinville".PHP_EOL.
	"Chapecoense x Atlético-MG".PHP_EOL.
	"----".PHP_EOL.
	"Santos x Avaí".PHP_EOL.
	"Goiás x Vasco".PHP_EOL.
	"Figueirense x Sport".PHP_EOL.
	"Ponte Preta x Grêmio".PHP_EOL.
	"Coritiba x Chapecoense".PHP_EOL.
	"Corinthians x Cruzeiro".PHP_EOL.
	"Flamengo x São Paulo".PHP_EOL.
	"Internacional x Atlético-PR".PHP_EOL.
	"Joinville x Fluminense".PHP_EOL.
	"Atlético-MG x Palmeiras".PHP_EOL.
	"----".PHP_EOL.
	"Vasco x Figueirense".PHP_EOL.
	"São Paulo x Ponte Preta".PHP_EOL.
	"Grêmio x Coritiba".PHP_EOL.
	"Avaí x Internacional".PHP_EOL.
	"Palmeiras x Joinville".PHP_EOL.
	"Fluminense x Atlético-MG".PHP_EOL.
	"Sport x Flamengo".PHP_EOL.
	"Chapecoense x Corinthians".PHP_EOL.
	"Cruzeiro x Santos".PHP_EOL.
	"Atlético-PR x Goiás".PHP_EOL.
	"----".PHP_EOL.
	"Ponte Preta x Cruzeiro".PHP_EOL.
	"Internacional x Vasco".PHP_EOL.
	"Joinville x São Paulo".PHP_EOL.
	"Flamengo x Avaí".PHP_EOL.
	"Atlético-MG x Atlético-PR".PHP_EOL.
	"Corinthians x Fluminense".PHP_EOL.
	"Coritiba x Sport".PHP_EOL.
	"Goiás x Palmeiras".PHP_EOL.
	"Santos x Chapecoense".PHP_EOL.
	"Figueirense x Grêmio".PHP_EOL.
	"----".PHP_EOL.
	"São Paulo x Internacional".PHP_EOL.
	"Vasco x Atlético-MG".PHP_EOL.
	"Atlético-PR x Joinville".PHP_EOL.
	"Cruzeiro x Figueirense".PHP_EOL.
	"Chapecoense x Ponte Preta".PHP_EOL.
	"Palmeiras x Corinthians".PHP_EOL.
	"Fluminense x Flamengo".PHP_EOL.
	"Grêmio x Goiás".PHP_EOL.
	"Avaí x Coritiba".PHP_EOL.
	"Sport x Santos".PHP_EOL.
	"----".PHP_EOL.
	"Ponte Preta x Vasco".PHP_EOL.
	"Internacional x Palmeiras".PHP_EOL.
	"Atlético-MG x Avaí".PHP_EOL.
	"Figueirense x Atlético-PR".PHP_EOL.
	"Corinthians x Grêmio".PHP_EOL.
	"Santos x São Paulo".PHP_EOL.
	"Coritiba x Fluminense".PHP_EOL.
	"Goiás x Sport".PHP_EOL.
	"Flamengo x Cruzeiro".PHP_EOL.
	"Joinville x Chapecoense".PHP_EOL.
	"----".PHP_EOL.
	"Coritiba x Internacional".PHP_EOL.
	"Palmeiras x Figueirense".PHP_EOL.
	"Corinthians x Joinville".PHP_EOL.
	"Ponte Preta x Santos".PHP_EOL.
	"Vasco x Atlético-PR".PHP_EOL.
	"Grêmio x São Paulo".PHP_EOL.
	"Cruzeiro x Atlético-MG".PHP_EOL.
	"Chapecoense x Flamengo".PHP_EOL.
	"Avaí x Goiás".PHP_EOL.
	"Sport x Fluminense".PHP_EOL.
	"----".PHP_EOL.
	"Fluminense x Palmeiras".PHP_EOL.
	"Goiás x Ponte Preta".PHP_EOL.
	"Joinville x Sport".PHP_EOL.
	"Figueirense x Avaí".PHP_EOL.
	"Atlético-PR x Grêmio".PHP_EOL.
	"Santos x Atlético-MG".PHP_EOL.
	"Internacional x Corinthians".PHP_EOL.
	"Cruzeiro x Vasco".PHP_EOL.
	"São Paulo x Chapecoense".PHP_EOL.
	"Flamengo x Coritiba".PHP_EOL.
	"----".PHP_EOL.
	"Palmeiras x Grêmio".PHP_EOL.
	"Internacional x Figueirense".PHP_EOL.
	"Ponte Preta x Fluminense".PHP_EOL.
	"Corinthians x Santos".PHP_EOL.
	"Goiás x Joinville".PHP_EOL.
	"Vasco x Sport".PHP_EOL.
	"Atlético-MG x Flamengo".PHP_EOL.
	"Avaí x São Paulo".PHP_EOL.
	"Coritiba x Atlético-PR".PHP_EOL.
	"Chapecoense x Cruzeiro".PHP_EOL.
	"----".PHP_EOL.
	"Fluminense x Goiás".PHP_EOL.
	"Grêmio x Avaí".PHP_EOL.
	"Santos x Internacional".PHP_EOL.
	"Atlético-PR x Ponte Preta".PHP_EOL.
	"São Paulo x Palmeiras".PHP_EOL.
	"Flamengo x Vasco".PHP_EOL.
	"Figueirense x Corinthians".PHP_EOL.
	"Joinville x Atlético-MG".PHP_EOL.
	"Cruzeiro x Coritiba".PHP_EOL.
	"Sport x Chapecoense".PHP_EOL.
	"----".PHP_EOL.
	"Internacional x Sport".PHP_EOL.
	"Coritiba x Atlético-MG".PHP_EOL.
	"São Paulo x Atlético-PR".PHP_EOL.
	"Flamengo x Joinville".PHP_EOL.
	"Avaí x Vasco".PHP_EOL.
	"Santos x Fluminense".PHP_EOL.
	"Ponte Preta x Corinthians".PHP_EOL.
	"Cruzeiro x Grêmio".PHP_EOL.
	"Goiás x Figueirense".PHP_EOL.
	"Chapecoense x Palmeiras".PHP_EOL.
	"----".PHP_EOL.
	"Atlético-MG x Internacional".PHP_EOL.
	"Sport x Avaí".PHP_EOL.
	"Palmeiras x Ponte Preta".PHP_EOL.
	"Figueirense x Flamengo".PHP_EOL.
	"Joinville x Coritiba".PHP_EOL.
	"Fluminense x São Paulo".PHP_EOL.
	"Atlético-PR x Cruzeiro".PHP_EOL.
	"Corinthians x Goiás".PHP_EOL.
	"Vasco x Chapecoense".PHP_EOL.
	"Grêmio x Santos".PHP_EOL.
	"----".PHP_EOL.
	"Avaí x Palmeiras".PHP_EOL.
	"Joinville x Figueirense".PHP_EOL.
	"Ponte Preta x Coritiba".PHP_EOL.
	"Cruzeiro x Fluminense".PHP_EOL.
	"São Paulo x Vasco".PHP_EOL.
	"Flamengo x Internacional".PHP_EOL.
	"Atlético-PR x Corinthians".PHP_EOL.
	"Santos x Goiás".PHP_EOL.
	"Grêmio x Chapecoense".PHP_EOL.
	"Sport x Atlético-MG".PHP_EOL.
	"----".PHP_EOL.
	"Fluminense x Atlético-PR".PHP_EOL.
	"Internacional x Joinville".PHP_EOL.
	"Figueirense x Santos".PHP_EOL.
	"Palmeiras x Sport".PHP_EOL.
	"Corinthians x Flamengo".PHP_EOL.
	"Vasco x Grêmio".PHP_EOL.
	"Coritiba x São Paulo".PHP_EOL.
	"Chapecoense x Avaí".PHP_EOL.
	"Goiás x Cruzeiro".PHP_EOL.
	"Atlético-MG x Ponte Preta".PHP_EOL.
	"----".PHP_EOL.
	"São Paulo x Sport".PHP_EOL.
	"Ponte Preta x Joinville".PHP_EOL.
	"Avaí x Cruzeiro".PHP_EOL.
	"Coritiba x Figueirense".PHP_EOL.
	"Santos x Palmeiras".PHP_EOL.
	"Grêmio x Flamengo".PHP_EOL.
	"Atlético-MG x Corinthians".PHP_EOL.
	"Chapecoense x Atlético-PR".PHP_EOL.
	"Vasco x Fluminense".PHP_EOL.
	"Goiás x Internacional".PHP_EOL.
	"----".PHP_EOL.
	"Internacional x Ponte Preta".PHP_EOL.
	"Corinthians x Coritiba".PHP_EOL.
	"Atlético-PR x Avaí".PHP_EOL.
	"Fluminense x Chapecoense".PHP_EOL.
	"Palmeiras x Vasco".PHP_EOL.
	"Flamengo x Goiás".PHP_EOL.
	"Cruzeiro x São Paulo".PHP_EOL.
	"Figueirense x Atlético-MG".PHP_EOL.
	"Joinville x Santos".PHP_EOL.
	"Sport x Grêmio".PHP_EOL.
	"----".PHP_EOL.
	"Cruzeiro x Sport".PHP_EOL.
	"Atlético-PR x Palmeiras".PHP_EOL.
	"Goiás x Coritiba".PHP_EOL.
	"Ponte Preta x Figueirense".PHP_EOL.
	"Avaí x Joinville".PHP_EOL.
	"São Paulo x Atlético-MG".PHP_EOL.
	"Santos x Flamengo".PHP_EOL.
	"Vasco x Corinthians".PHP_EOL.
	"Chapecoense x Internacional".PHP_EOL.
	"Grêmio x Fluminense".PHP_EOL.
	"----".PHP_EOL.
	"Corinthians x São Paulo".PHP_EOL.
	"Palmeiras x Cruzeiro".PHP_EOL.
	"Fluminense x Avaí".PHP_EOL.
	"Flamengo x Ponte Preta".PHP_EOL.
	"Internacional x Grêmio".PHP_EOL.
	"Atlético-MG x Goiás".PHP_EOL.
	"Figueirense x Chapecoense".PHP_EOL.
	"Coritiba x Santos".PHP_EOL.
	"Sport x Atlético-PR".PHP_EOL.
	"Joinville x Vasco".PHP_EOL.
	"----".PHP_EOL.
	"São Paulo x Figueirense".PHP_EOL.
	"Palmeiras x Coritiba".PHP_EOL.
	"Fluminense x Internacional".PHP_EOL.
	"Vasco x Santos".PHP_EOL.
	"Grêmio x Atlético-MG".PHP_EOL.
	"Cruzeiro x Joinville".PHP_EOL.
	"Avaí x Ponte Preta".PHP_EOL.
	"Atlético-PR x Flamengo".PHP_EOL.
	"Sport x Corinthians".PHP_EOL.
	"Chapecoense x Goiás".PHP_EOL.
	"----".PHP_EOL.
	"Corinthians x Avaí".PHP_EOL.
	"Santos x Atlético-PR".PHP_EOL.
	"Ponte Preta x Sport".PHP_EOL.
	"Flamengo x Palmeiras".PHP_EOL.
	"Internacional x Cruzeiro".PHP_EOL.
	"Atlético-MG x Chapecoense".PHP_EOL.
	"Figueirense x Fluminense".PHP_EOL.
	"Coritiba x Vasco".PHP_EOL.
	"Goiás x São Paulo".PHP_EOL.
	"Joinville x Grêmio";
$times =  strtr($times, array(
	'Palmeiras'=>'$times[0]', 
	'Chapecoense'=>'$times[1]',
	'Fluminense'=>'$times[2]', 
	'Grêmio'=>'$times[3]',
	'São Paulo'=>'$times[4]',
	'Cruzeiro'=>'$times[5]',
	'Atlético-PR'=>'$times[6]', 
	'Sport'=>'$times[7]',
	'Vasco'=>'$times[8]', 
	'Avaí'=>'$times[9]',
	'Santos'=>'$times[10]', 
	'Goiás'=>'$times[11]',
	'Figueirense'=>'$times[12]', 
	'Internacional'=>'$times[13]',
	'Corinthians'=>'$times[14]', 
	'Flamengo'=>'$times[15]',
	'Ponte Preta'=>'$times[16]', 
	'Joinville'=>'$times[17]',
	'Coritiba'=>'$times[18]', 
	'Atlético-MG'=>'$times[19]',
));
//$times = nl2br($times);
$times = explode('----', $times);
$jg = array();
foreach($times as $jogos){
	$value = preg_replace('/[\r\n]+/', '--', $jogos);
	$jg[] = explode('--', $value);
}
$tj = 'array(<br>';
$R  = 1;
foreach($jg as $k => $j){
	$tj .= '// RODADA'.$R.'<br>';
	$tj .= '    array(';
	foreach($j as $a){
		if($a == ''){
			unset($a);
		}else{
			$a = explode(' x ', $a);
			$tj .= 'array(';
			$tj .= "".'$m=>'."$a[0], ".'$v=>'."$a[1]";
			$tj .= '),';
		}
	}
	$tj .= '),<br>';
	$R++;
}
$tj .= ');';
pre($tj);
?>