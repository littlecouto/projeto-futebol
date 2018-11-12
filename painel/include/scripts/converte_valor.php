<?php

function valor($number){
	return number_format($number,"2",",",".");
}





function moeda($get_valor) {
	$source = array('.', ',');
	$replace = array('', '.');
	$valor = str_replace($source, $replace, $get_valor); //remove os pontos e substitui a virgula pelo ponto
	return $valor; //retorna o valor formatado para gravar no banco
	
	/*
	<script> 
	$(function(){
		$("#dolar").maskMoney()
		$("#valor").maskMoney({symbol:"R$",decimal:",",thousands:"."})
		$("#euro").maskMoney({symbol:"Euro",decimal:",",thousands:" "})
		$("#precision").maskMoney({decimal:",",thousands:" ",precision:3})
	 
	})
	 
	function removeMask(){
		$("#dolar").unmaskMoney();
	}
	</script>
	*/


}



		
//PARA MOSTRAR O VALOR NO FORMATO CERTO
//$valor_servico = ' R$ ' . number_format($l['valor_servico'], 2, ',', '.');


?>