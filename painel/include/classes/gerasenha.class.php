<?php
##############################################################
# ARQUIVO: GERAR SENHA                                       #
# AUTHOR:  EDSON OLIVEIRA ALCANTARA                          #
# E-MAIL:  edson@ewebtecnologia.com.br                       #
# EMPRESA: EWEB TECNOLOGIA                                   #
# SITE:    http://www.ewebtecnologia.com.br                  #
# OBJ:     RESPONSÁVEL PELA GERAÇÃO DE SENHAS                #
############################################################ #


class GeraSenha {


	function gerarsenha() {
		$sConso = 'bcdfghjklmnpqrstvwxyzbcdfghjklmnpqrstvwxyz'; 
		$sVogal = 'aeiou';
		$sNumer = '123456789'; 
		$passwd = ''; 
		$var_1x = strlen($sConso)-1; //conta o nº de caracteres da variável $sConso
		$var_2x = strlen($sVogal)-1; //conta o nº de caracteres da variável $sVogal
		$var_3x = strlen($sNumer)-1; //conta o nº de caracteres da variável $sNumer
		for($xvezes=0;$xvezes<=2;$xvezes++) {
			$rand1 = rand(0,$var_1x);
			$rand2 = rand(0,$var_2x); 
			$rand3 = rand(0,$var_3x); 
			$strc1 = substr($sConso,$rand1,1);
			$strv2 = substr($sVogal,$rand2,1); 
			$strn3 = substr($sNumer,$rand3,1);
			$passwd .= $strc1.$strv2.$strn3; 
		} 
		$rand3 = rand(0,$var_3x); 
		$strn3 = substr($sNumer,$rand3,1);
		$passwd .= $strn3; 
		return $passwd; 
	}






	
	function gerarchave($tamanho) {
		$vbase = "abcdefghijklmnopqrstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890"; 
		$vchave = ""; 
		$vcomprimento = strlen($vbase)-1;
		for($xvezes=1;$xvezes<=$tamanho;$xvezes++) {
			$vrandonizado = rand(0, $vcomprimento);
			$vnovocaractere = substr($vbase, $vrandonizado, 1);
			$vchave .= $vnovocaractere; 
		} 
		return $vchave; 
	}




}
?> 
