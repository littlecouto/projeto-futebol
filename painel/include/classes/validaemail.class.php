<?php
##############################################################
# ARQUIVO: VALIDAÇÃO DE E-MAILS                              #
# AUTHOR:  EDSON OLIVEIRA ALCANTARA                          #
# E-MAIL:  edson@ewebtecnologia.com.br                       #
# EMPRESA: EWEB TECNOLOGIA                                   #
# SITE:    http://www.ewebtecnologia.com.br                  #
# OBJ:     RESPONSÁVEL PELA VALIDAÇÃO DE E-MAILS             #
############################################################ #


class ValidaEmail {



	// CHECAR EMAIL
	function check_email($eMailAddress){
		return preg_match("/^([[:alnum:]_.-]){3,}@([[:lower:][:digit:]_.-]{3,})(\.[[:lower:]]{2,3})(\.[[:lower:]]{2})?$/", $eMailAddress); 
	}
	//
		
	// FUNÇÕES GERAIS
	function getmxrr_win($hostname = "", &$mxhosts, &$weight){
		$weight = array();
		$mxhosts = array();
		$result = false;
	 
	 
		$command = "nslookup -type=mx " . escapeshellarg($hostname);
		exec ($command, $result);
		$i = 0;
		while (list ($key, $value) = each ($result)){
			if(strstr ($value, "mail exchanger")){
				$nslookup[$i] = $value; $i++;
			}
		}
		
	 
		 while(list($key, $value) = each($nslookup)){
			$temp = explode (" ", $value);
			$mx[$key][0] = substr($temp[3],0,-1);
			$mx[$key][1] = $temp[7];
			$mx[$key][2] = gethostbyname($temp[7]);
		}
		
		array_multisort($mx);
	 
		foreach ($mx as $value){ 
			$mxhosts[] = $value[1];
			$weight[] = $value[0];
		} 
	 
		$result = count($mxhosts) > 0;
		return $result;
	}
	
	
	function getmxrr_portable($hostname = "", &$mxhosts, &$weight){
		if(function_exists("getmxrr")){
			$result = getmxrr($hostname, $mxhosts, $weight);
		}else{
			$result = getmxrr_win($hostname, $mxhosts, $weight);
		}
		
		return $result; 
	}
	///
	
	
	
	
	
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
	//


}
?>