<?php
function limpa_string($str){
	
	$a = '����������������������������������������������������������������';
	$b = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyoa';
	
	return strtr($str, $a, $b);
}
?>