<?php

function SomarData($data, $dias, $meses, $ano){
	
	//passe a data no formato dd/mm/yyyy 
	$data = explode("/", $data);
	$newData = date("d/m/Y", mktime(0, 0, 0, $data[1] + $meses,	$data[0] + $dias, $data[2] + $ano) );
	return $newData;
	
}



/* EXEMPLO DE USO 
$dataini = date("d/m/Y");
echo $datafim = SomarData($dataini, 5, 0, 0);
*/
?>