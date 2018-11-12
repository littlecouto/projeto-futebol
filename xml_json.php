<?php
$db['server']       = 'localhost';
$db['user']         = 'root';
$db['password']     = '';
$db['dbname']       = 'brasfoot';

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
function xml2array ( $xmlObject, $out = array () )
{
    foreach ( (array) $xmlObject as $index => $node )
        $out[$index] = ( is_object ( $node ) ) ? xml2array ( $node ) : $node;

    return $out;
}

$xml = $_GET['x'];
/*
$json = json_encode(simplexml_load_file($xml));

$json = json_decode($json);
$json = objectToArray($json);

pre($json);
*/
$atrD = $_GET['D'];
$atrB = $_GET['B'];
$atrF = 'f';
$atrS = 's';

$json = simplexml_load_file($xml);
$jog = array('a'=>array(), 'b'=>array());
foreach ($json->$atrD->$atrB as $key) {
	$jogF = xml2array($key->attributes()->$atrS);
	$jogS = xml2array($key->attributes()->$atrF);
	$jogA = "$jogS[0] $jogF[0]";

	$jog['a'][] = $jogA;

	@$res  = mysql_fetch_array(mysql_query("SELECT * FROM jogador WHERE apelido='$jogF[0]'"));
	$jogB = $res['apelido'];
	$jog['b'][] = utf8_encode($jogB);
}
pre($jog);
?>
