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



<?php
//resgatando id passado pela URL
$idModu = $_REQUEST['idMod'];

//tratando dados
$_POST['nome_mod'] = strtoupper($_POST['nome_mod']);

if(isset($_POST['ACAO']) && $_POST['ACAO'] == 'ATUALIZAR'){
	
	// Tratando os dados
	$nome_mod 	= addslashes($nome_mod);
	$ativo		= addslashes($ativo);
	$nome_mod	= strtoupper($nome_mod);
	
	$query = "UPDATE painel_modulo SET	nome='$_POST[nome_mod]', ativo='$_POST[ativo]' WHERE idMod='$idModu' LIMIT 1";
	$gravou = mysql_query($query)or die (mysql_error());
	
	// PAINEL HISTÓRICO
	$query = addslashes($query);
	mysql_query("INSERT INTO painel_historico(idUsu, acao, query) VALUE($_SESSION[USUARIO], 'UPDATE', '$query')") or die (mysql_error());
	//
	
	
	
	if($gravou == true){
		echo "<script> alert('Informações atualizadas com sucesso!'); location.href='ger_modulos.php'; </script>";
	}elseif($gravou == false){
		echo "<script> alert('Houve um erro ao atualizar as informações!'); hitory.go(-1); </script>"; 
	}
}




// selecionando a tabela pAra resgatar os dados do módulo a ser alterado
$resultModu = mysql_fetch_array(mysql_query("SELECT * FROM painel_modulo WHERE idMod='$idModu'"));

?>




<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859" />
<title> <?php echo $rowPainel['nome'] ?> - Sistema Eweb de Gestão </title>

<link href="../../include/css/layout.css" rel="stylesheet" type="text/css" />
<link href="../../include/css/form1.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="<?php echo $SISTEMA['JS']?>/jquery.min.js"></script>


</head>

<body>

<?php include '../../include/painel/topo.php' ?>

<div id="conteudo">

<!-- CONTEÚDO ABAIXO -->




<h1>ATUALIZA&Ccedil;&Atilde;O DE M&Oacute;DULO</h1>


<div class="formulario">


<!-- Cadastro de módulos -->
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']?>">
    <input type="hidden" name="ACAO" value="ATUALIZAR" />
    <input type="hidden" name="idMod" value="<?php echo $idModu; ?>" />
    
    <div class="area">
    
        <h2>INFORMA&Ccedil;&Otilde;ES DO M&Oacute;DULO</h2>
       
        <div class="linha">
            <div class="t_campo">M&oacute;dulo:</div>
            <div class="campo"><label><input type="text" id="nome_mod" name="nome_mod" size="30" maxlength="50" value="<?php echo $resultModu['nome'] ?>" /></label></div>
        </div>
                                        
        <div class="linha">
            <div class="t_campo">Ativo:</div>
            <div class="campo">
                <input type="radio" name="ativo" id="ativo" value="1" <?php if($resultModu['ativo']==1) echo'checked="checked"';?> /> Sim
                <br />
                <input type="radio" name="ativo" id="ativo" value="0" <?php if($resultModu['ativo']==0) echo'checked="checked"';?> />N&atilde;o
            </div>
        </div>
        
        <button type="submit">ATUALIZAR INFORMAÇÕES</button>
                    
    </div>
	
    
</form>
<!-- Fim cadastro de módulos --> 
    
</div>










<!-- CONTEÚDO ACIMA -->

</div>
<?php include '../../include/painel/rodape.php' ?>