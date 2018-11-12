<?php
class Login extends Conexao{
	
	
	
	// AUTENTICAÇÃO DE USUÁRIO
	function EfetuaLogin($usuario, $senha) {
				
		if($usuario == '' or $senha == ''){	// Caso usuário ou senha não informadas
			return $aviso = 'Usuário ou senha não informados';
		}
		
		else{ // Caso preenchido
			$this->Conecta();
			$resultUsu 	= mysql_query("SELECT * FROM painel_usuario WHERE usuario='$usuario' AND ativo=1");
			$rowUsu 	= mysql_fetch_array($resultUsu);
			$this->Desconecta();
			
			$senha 		= md5($senha);
			
			
			if($usuario != $rowUsu['usuario'] or ($senha != $rowUsu['senha']) or $rowUsu['ativo'] == 0){ // Caso dados não confiram ou usuário inativo
				return 'erro';
			}
			
			elseif($usuario == $rowUsu['usuario'] and $senha == $rowUsu['senha'] and $rowUsu['ativo'] == 1){ // Caso tudo ok
				$_SESSION['LOGADO']			= true;
				$_SESSION['USUARIO']		= $rowUsu['idUsu'];
				$_SESSION['USUARIOSEG']		= $rowUsu['idUsu'];
				$_SESSION['USUARIONOME'] 	= $rowUsu['nome'];
				$_SESSION['IP']				= $_SERVER["REMOTE_ADDR"];
				
				// Gravando Dados de Acesso
				
					$datalogin = date("Y-m-d G:i:s");
				
					// resgatando o sistema operacional
					$so = "desconhecido";
					$user_agent = $_SERVER["HTTP_USER_AGENT"];
					if(preg_match("/Windows/",$user_agent) || preg_match("/WinNT/",$user_agent) || preg_match("/Win95/",$user_agent)) $so = "Windows";
					if(preg_match("/Mac/", $user_agent)) $so = "Macintosh";
					if(preg_match("/X11/", $user_agent)) $so = "Unix";
					
					// resgatando o browser
					if (preg_match('|MSIE ([0-9].[0-9]{1,2})|',$user_agent,$matched)) {
						$browser_version=$matched[1];
						$browser = 'IE';
					  } elseif (preg_match( '|Opera/([0-9].[0-9]{1,2})|',$user_agent,$matched)) {
						$browser_version=$matched[1];
						$browser = 'Opera';
					  } elseif(preg_match('|Firefox/([0-9\.]+)|',$user_agent,$matched)) {
						$browser_version=$matched[1];
						$browser = 'Firefox';
					  } elseif(preg_match('|Chrome/([0-9\.]+)|',$user_agent,$matched)) {
						$browser_version=$matched[1];
						$browser = 'Chrome';
					  } elseif(preg_match('|Safari/([0-9\.]+)|',$user_agent,$matched)) {
						$browser_version=$matched[1];
						$browser = 'Safari';
					  } else {
						// browser not recognized!
						$browser_version = 0;
						$browser= 'Outro';
					  }  
					$browser .= ' '.$browser_version;
				
				$this->Conecta();
				mysql_query("INSERT INTO painel_acesso(idUsu, datalogin, ip, so, browser)VALUES('$rowUsu[idUsu]', '$datalogin', '$_SERVER[REMOTE_ADDR]', '$so', '$browser')") or die("Erro MYSQL: ".mysql_error()." Na linha ".__LINE__);
				$this->Desconecta();
				
				return $_GET['url'];
			}
		}
		
	}
	//
	
	
	
	
	
	
	// VERIFICA SE O USUÁRIO ESTÁ LOGADO
	function VerLogin(){
		#.urlencode($_SERVER['REQUEST_URI'])
		if(!isset($_SESSION['LOGADO']) and !isset($_SESSION['USUARIO']) and !isset($_SESSION['IP'])){
			header("location: painel-login");
		}
		
		$this->Conecta();
		
		
			
	}
	//
	
	
	
	
	
	
	
	
	
	
	// ATUALIZA O CAMPO 'DATALOGOUT' A CADA MINUTO (TIMESTAMP)
	function AtualizaLog(){
		
		$datalogout = date("Y-m-d G:i:s");
		$this->Conecta();
		$rowAce = mysql_fetch_array(mysql_query("SELECT idAce FROM painel_acesso WHERE idUsu='$_SESSION[USUARIO]' ORDER BY datalogin DESC LIMIT 1"));
		mysql_query("UPDATE painel_acesso SET datalogout='$datalogout' WHERE idAce=$rowAce[idAce] LIMIT 1");
		$this->Desconecta();
		
	}
	//
	
	
	
	
	
	
	
	
	
	
	
	


	function EfetuaLogout(){
		// finalizando as sessões
		session_destroy();
		
		// redirecionando para o login
		header("location: painel-login");
	}
	
	
	
}
?>