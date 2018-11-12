<?php 
session_start(); 

include_once '../../include/config.php';

// CONEXÃO
include_once '../../include/classes/conexao.class.php';
$con = new Conexao();
$conexao = $con->Conecta();

// VER LOGIN
include_once '../../include/classes/login.class.php';
$lgn = new Login();
$lgn->VerLogin();

// TITULO PAINEL
$resultPainel 	= mysql_query("SELECT nome FROM painel_empresa LIMIT 1");
$rowPainel		= mysql_fetch_array($resultPainel);
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859padrao" />
<title> <?php echo $rowPainel['nome'] ?>  - Sistema Eweb de Gestão </title>

<link href="../../include/css/layout.css" rel="stylesheet" type="text/css" />
<link href="../../include/css/form1.css" rel="stylesheet" type="text/css" />


<script type="text/javascript" src="../../include/js/jquery.min.js"></script>


</head>

<body>

<?php include '../../include/painel/topo.php' ?>

<div id="conteudo">

<!-- CONTEÚDO ABAIXO -->



<?php

$idUsu = $_REQUEST['idUsu'];
$chave = $_REQUEST['chave'];

if($chave != md5($idUsu)){	echo "<script> window.history.go(-1); </script>"; }


if($_POST['ACAO'] == 'ATUALIZAR'){
	if($_POST['nome'] == ""){
		$aviso = "Informe o nome!";
		echo "<script> alert('$aviso'); </script>";
	
	}elseif($_POST['email'] == ""){
		$aviso = "Informe o e-mail!";
		echo "<script> alert('$aviso'); </script>";
	
	}elseif($_POST['senha'] != $_POST['conf']){
		$aviso = "A senha informada não é igual a confirmação!";
		echo "<script> alert('$aviso'); </script>";
		
	}else{
		// Tratando os dados
		$nome 	= addslashes($_POST['nome']);
		$fone 	= addslashes($_POST['fone']);
		$email 	= addslashes($_POST['email']);
		$senha 	= addslashes($_POST['senha']);
		$obs 	= addslashes($_POST['obs']);
		$ativo 	= addslashes($_POST['ativo']);
		
		$nome = strtoupper($nome);
		$datacad = date("Y-m-d G:i:s");
		$email = strtolower($email);
		$senha = md5($senha);
		
		// Gravando os dados
		if($_POST['senha'] == ''){ // atualizando sem senha
			$query = "UPDATE painel_usuario SET datacad='$datacad', nome='$nome', fone='$fone', email='$email', obs='$obs', ativo='$ativo' WHERE idUsu='$idUsu' LIMIT 1";
		}else{ // atualizando com senha
			$query = "UPDATE painel_usuario SET datacad='$datacad', nome='$nome', fone='$_POST[fone]', email='$email', senha='$senha', obs='$_POST[obs]', ativo='$_POST[ativo]' WHERE idUsu='$idUsu' LIMIT 1";
		}
		
		$gravou = mysql_query($query) or die(mysql_error());
		
		// PAINEL HISTÓRICO
		$query = addslashes($query);
		mysql_query("INSERT INTO painel_historico(idUsu, acao, query) VALUE('$_SESSION[USUARIO]', 'UPDATE', '$query')") or die (mysql_error());
		//
					
		if($gravou == false) $aviso = 'Erro ao atualizar os dados!';
		if($gravou == true) $aviso  = 'Dados atualizados com sucesso!';
				
		echo "<script> alert('$aviso'); location.href='ger_usuarios.php'; </script>";
	}

}
		
		
		
//Selecionando dados do usuário a ser atualizado
$query = "SELECT * FROM painel_usuario WHERE idUsu=$idUsu";
$query = addslashes($query); // Proteção SQL Injection
$selUsu = mysql_fetch_array(mysql_query($query)) or die (mysql_error());
	
?>






<h1>Atualização de dados do usu&aacute;rio </h1>

<div class="formulario">

<form method="post" action="<?php echo $_SERVER['REQUEST_URI']?>">
<input type="hidden" name="ACAO" value="ATUALIZAR" />
	<div class="area">
    
        <h2>Atualizar Usu&aacute;rio</h2>
        <div class="linha">
        <div class="t_campo">*NOME</div>
        <div class="campo"><label><input name="nome" type="text" id="nome" size="72" maxlength="50" value="<?php echo $selUsu['nome']; ?>" /></label></div>
        </div>
      
        <div class="linha">
        <div class="t_campo">TELEFONE</div>
        <div class="campo"><label><input name="fone" type="text" id="fone" maxlength="30" value="<?php echo $selUsu['fone']; ?>" /></label></div>
        </div>
        
        <div class="linha">
        <div class="t_campo">*E-MAIL</div>
        <div class="campo"><label><input name="email" type="text" id="email" maxlength="70" value="<?php echo $selUsu['email']; ?>" /></label></div>
        </div>
        
        <div class="linha">
        <div class="t_campo">*USUÁRIO</div>
        <div class="campo"><label><input name="usuario" type="text" id="usuario" maxlength="32" value="<?php echo $selUsu['usuario']; ?>" readonly="readonly" /></label></div>
        </div>
        
        <div class="linha">
        <div class="t_campo">*SENHA </div>
        <div class="campo"><label><input name="senha" type="password" id="senha" maxlength="12" value="" /><br />(Caso queira alterar)</label></div>
        </div>
        
        <div class="linha">
        <div class="t_campo">*CONFIRMA&Ccedil;&Atilde;O</div>
        <div class="campo"><label><input name="conf" type="password" id="conf" maxlength="12" /></label></div>
        </div>
       
        <div class="linha">
        <div class="t_campo">OBSERVA&Ccedil;&Otilde;ES</div>
        <div class="campo"><label><textarea name="obs" id="obs" cols="48" rows="3"><?php echo $selUsu['obs']; ?></textarea></label></div>
        </div>
      
        <div class="linha">
        <div class="t_campo">ATIVO</div>
        <div class="campo">
        	<input name="ativo" type="radio" id="ativo" value="1" <?php if($selUsu['ativo']==1) echo'checked="checked"';?> /> Sim
         	<br />
            <input type="radio" name="ativo" id="ativo" value="0" <?php if($selUsu['ativo']==0) echo'checked="checked"';?> /> N&atilde;o
        </div>
        </div>
    
        <button type="submit"> ATUALIZAR INFORMAÇÕES </button>

     </div>
    
	</form>

</div>



















<!-- CONTEÚDO ACIMA -->

</div>
<?php include '../../include/painel/rodape.php' ?>