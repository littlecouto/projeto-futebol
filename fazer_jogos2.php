<?php
$jogos = array();
$iM = $iV = '';
$times = array('Time1', 'Time2', 'Time3', 'Time4', 'Time5', 'Time6', 'Time7', 'Time8', 'Time9', 'Time10');
$qtd = count($times);
for($i=0; $i<$qtd-1; $i++){
	$usados = array();
	$ult_t = end($times);
	$V = $qtd-1;
	$M = 1;
	$jogos[$i][] = array($ult_t, $times[$i]);
	$usados[] = $ult_t;
	$usados[] = $times[$i];
	while(count($usados)<8){
			@($iM >  7 or $iM == 0) ? $iM = $i : $iM = $iM;
			@($iV < $i or $iV == 0) ? $iV = 7  : $iV = $iV;
			
			$man = $times[$iM];
			$vis = $times[$iV];
			
			
			if((!in_array(array($man, $vis), $jogos) or !in_array(array($vis, $man), $jogos)) and $iM != $iV and (!in_array($man, $usados) or !in_array($vis, $usados))){
				$usados[] = $man;
				$usados[] = $vis;
								
				$jogos[$i][] = array($man, $vis);
			}
			$iM++;
			$iV--;
			$M++;
	}
	
}
echo "<pre>";
print_r($jogos);
echo "</pre>";
?>
