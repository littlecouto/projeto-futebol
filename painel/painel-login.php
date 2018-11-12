<?php
session_start();

// LOGIN
	include_once 'include/classes/conexao.class.php';
	$con = new Conexao;
	$con->Conecta();
	include_once 'include/config.php';
	include_once 'include/classes/login.class.php';
	
	$rowCor = mysql_fetch_array(mysql_query("SELECT cor_pri, cor_seg FROM painel_config"));
	$cor_pri = $rowCor['cor_pri'];
	$cor_seg = $rowCor['cor_seg'];
	
	echo "
	<style>
		button {
			background-color: $cor_pri;
		}
	
	</style>";
	

if(isset($_POST['ACAO']) and $_POST['ACAO'] == 'login' and $_POST['usuario'] != 'USUÁRIO' and $_POST['senha'] != 'SENHA'){
	
	
	// Tratando dados
	$usuario = addslashes($_POST['usuario']);
	$senha = addslashes($_POST['senha']);
	
	// LOGIN
	$lgn = new Login();
	$login = $lgn->EfetuaLogin($usuario, $senha);
	
	
	if($login == 'erro'){
		echo "<script>alert('Erro!'); </script>";
		exit;
	}elseif($login == ''){
		echo "<script> location.href='$URLSEG'; </script>";
		exit;
	}elseif($login != ''){
		echo "<script> location.href='$login'; </script>";
		exit;
	}


	//
}


else{
	session_destroy();
}

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Login</title>
<link href="include/css/login.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="include/js/limparcampo.js"> </script>


</head>

<body>






<div id="form">
<form action="" method="post">
	<div id="logo"><img src="<?php echo "$UrlLogo/logo-seg.png" ?>" border="0" /></div>
    <input type="hidden" name="ACAO" value="login" />
    
    <label><input name="usuario" type="text" maxlength="32" placeholder="USUÁRIO" tabindex="0" required /></label>
    <label><input name="senha" type="password" maxlength="32" placeholder="SENHA" required /></label>    
   
    <button type="submit"> 	ENTRAR </button>
    
</form>
</div>


</body>
</html>