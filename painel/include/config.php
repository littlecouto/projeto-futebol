<?php

error_reporting(E_ERROR|E_WARNING);
 
#DIRETÓRIOS

$resultVariavel = mysql_query("SELECT variavel, valor FROM painel_config_variavel WHERE ativo=1") or die(mysql_error());

$rowPainel = mysql_fetch_array(mysql_query("SELECT * FROM painel_config"));

while($rowVariavel = mysql_fetch_array($resultVariavel)){
	$rowVariavel['variavel'] = $rowVariavel['variavel'];
	$rowVariavel['valor'] 	 = $rowVariavel['valor'];

	$$rowVariavel['variavel'] = $rowVariavel['valor'];
}
?>