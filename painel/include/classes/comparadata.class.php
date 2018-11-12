<?php

/* FUNวรO PARA COMPARAวรO DE DATAS */ 
function ComparaData($primeira, $segunda){
	
	
	// Convertendo a primeira data
	if(substr($primeira, 2, 1) == '-' or substr($primeira, 2, 1) == '/')
		$t1 =& mktime(0, 0, 0, substr($primeira,3,2), substr($primeira,0,2),  substr($primeira,6,4)); // Caso formato dd/mm/aaaa
	else
		$t1 =& mktime(0, 0, 0, substr($primeira,5,2), substr($primeira,8,2),  substr($primeira,0,4)); // Caso formato aaaa/mm/dd
	//
	
	// Convertendo a segunda data
	if(substr($primeira, 2, 1) == '-' or substr($primeira, 2, 1) == '/')
		$t2 =& mktime(0, 0, 0, substr($segunda,3,2), substr($segunda,0,2),  substr($segunda,6,4));	// Caso formato dd/mm/aaaa
	else
		$t2 =& mktime(0, 0, 0, substr($segunda,5,2), substr($segunda,8,2),  substr($segunda,0,4));	// Caso formato aaaa/mm/dd
	//
	
	
	// Comparando
	if($t1 < $t2)
		return -1; // 1ช ANTERIOR
			
	elseif($t1 > $t2)
		return 1; // 2ช POSTERIOR
	
	else
		return 0; // IGUAIS
	
}



/* EXEMPLO DE USO 
$data1 = "2011/02/24";
$data2 = "2010/02/03";
echo ComparaData($data1, $data2);
*/
?>