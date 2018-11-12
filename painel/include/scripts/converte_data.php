<?php
function dataddmmaaaa($conv_data){
	//converte a data de aaaa/mm/dd para dd/mm/aaaa
	$conv_data = substr($conv_data, 8, 2) . "/" . substr($conv_data, 5, 2) . "/" . substr($conv_data, 0, 4);
	return $conv_data;
}

function dataaaaammdd($conv_data){
	//converte a data de dd/mm/aaaa para aaaa/mm/dd
	$conv_data = substr($conv_data, 6, 4) . "/" . substr($conv_data, 3, 2) . "/" . substr($conv_data, 0, 2);
	return $conv_data;
}


function datetime($conv_data){
	// converte a data de aaaa/mm/dd para dd/mm/aaaa 00:00:00
	$conv_data = explode(" ", $conv_data);
	$data = dataddmmaaaa($conv_data[0]);
	$hora = $conv_data[1];
	return $data." ".$hora;
}
?>