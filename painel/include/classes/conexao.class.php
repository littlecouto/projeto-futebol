<?php

class Conexao {
	
	
	/* CONFIGURA��ES SERVIDOR WEB */
	public $hostname = "localhost";
	public $database = "futebol_novo";
	public $username = "root";
	public $password = "";
	
	
	// ABRIR CONEX�O
    public function Conecta() {
		$conexao = mysql_connect($this->hostname, $this->username, $this->password) or die(mysql_error());
		mysql_select_db($this->database) or die(mysql_error());
		
		return $conexao;
    }
	



	// FECHAR A CONEX�O
	public function Desconecta(){
		mysql_close();
		
		return true;
	}
	//

}

?>