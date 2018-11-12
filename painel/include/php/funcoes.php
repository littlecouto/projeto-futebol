<?php
/* 
	echo pre($_POST);
	
	ARRAY
	(
		[var1] => valor1
		[var2] => valor2
		etc...
	)
*/
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



/* 
	echo maskFone('11 23456789'); // 11 2345-6789
	echo maskFone('11 923456789'); // 11 92345-6789
	echo maskFone('11 9-2-3-4-5-6-7-8-9'); // 11 92345-6789
	echo maskFone('9-2-3-4-5-6-7-8'); // 92345-6789
*/
function maskFone($num){

$filtro = array('-' => '', ' ' => '');
	$ex	= strtr($num, $filtro);
	$tam = strlen($ex);
	
	for($i = 0; $i<$tam; $i++){
		if($i == 2 and $tam > 9){
    $numero .= ' '.$ex{$i};
		}elseif($i == 4 and $tam == 8){
			$numero .= '-'.$ex{$i};
		}elseif($i == 5 and $tam == 9){
			$numero .= '-'.$ex{$i};
		}elseif($i == 6 and $tam == 10){
			$numero .= '-'.$ex{$i};
		}elseif($i == 7 and $tam == 11){
			$numero .= '-'.$ex{$i};
		}else{
			$numero .= $ex{$i};
		}
	}

	return $numero;
}
function strtotitle($titulo){
	strtolower($titulo);
	// Nosso array com as palavras que nao serao capitalizadas caso elas nao comecem a frase.
	$ignorar = array('a','as','às','o','os','e','é','nos','vos','em','és','ele','eles','ela','elas','eu','você','tu','nós','vós','aquele','aqueles','aquela','aquelas','essa','esta','esse','este','isso','isto','aquilo','','uma','um','umas','uns','algum','alguma','alguns','algumas','outro','outro','da','de','do','das','dos','pelo','pela','pelos','pelas','por','dela','dele','delas','deles','com','sem','ou','mas','porém','nem','se','com','senão','a partir','para','melhor','melhores','encomenda','encomendas','sob');

	// Separa todas as palavras do $titulo
	$palavras = explode(' ', $titulo);

	foreach ($palavras as $key => $palavra){
		if ($key == 0 or !in_array($palavra, $ignorar))
		$palavras[$key] = ucwords($palavra);
	}

	// Junta todas as palavras em uma frase
	$novoTitulo = implode(' ', $palavras);

	return $novoTitulo;
}


// CHECAR EMAIL
function check_email($eMailAddress){
	return preg_match("/^([[:alnum:]_.-]){3,}@([[:lower:][:digit:]_.-]{3,})(\.[[:lower:]]{2,3})(\.[[:lower:]]{2})?$/", $eMailAddress); 
}
//
function getmxrr_portable($hostname = "", &$mxhosts, &$weight){
	if(function_exists("getmxrr")){
		$result = getmxrr($hostname, $mxhosts, $weight);
	}else{
		$result = getmxrr_win($hostname, $mxhosts, $weight);
	}
	
	return $result; 
}
// CHECAR O DOMÍNIO
function check_dominio($email){
	$host=substr(strstr($email, '@'), 1);
	$host.=".";
	
	if(getmxrr_portable($host, $mxhosts[0], $mxhosts[1]) == true){
		array_multisort($mxhosts[1], $mxhosts[0]);
	}else{
		$mxhosts[0]=$host;
	}
	
	if(is_array($mxhosts[0])){
		return true;
	}
	
	return false;
}
?>