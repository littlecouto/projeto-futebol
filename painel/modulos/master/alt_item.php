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

if(isset($_POST['ACAO']) && $_POST['ACAO'] == 'ATUALIZAR'){
	
	// Tratando os dados
	$_POST['item'] = strtoupper($_POST['item']);
	
	// Tratando os dados
	$item 		= addslashes($_POST['item']);
	$url 		= addslashes($_POST['url']);
	$ativo		= addslashes($_POST['ativo']);
	$pagina 	= addslashes($_POST['pagina']);
	$item		= strtoupper($item);
	
	$query = "UPDATE painel_modulo_item SET nome='$item', url='$url', ativo='$ativo', pagina='$pagina' WHERE idIte='$_POST[idItem]' LIMIT 1";
	$gravou = mysql_query($query) or die (mysql_error());
	
	// PAINEL HISTÓRICO
	$query = addslashes($query);
	mysql_query("INSERT INTO painel_historico(idUsu, acao, query) VALUE($_SESSION[USUARIO], 'UPDATE', '$query')") or die (mysql_error());
	//
	
	if($gravou == true){
		echo "<script>alert('Atualização efetuada com sucesso!'); location.href='ger_modulos.php';</script>";
	}elseif($gravou == false){
		echo "<script>alert('Houve um erro ao atualizar!'); history.go(padrao);</script>";
	}
}

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859padrao" />
<title><?php echo $rowPainel['nome'] ?> - Sistema Eweb de Gestão </title>

<link href="../../include/css/layout.css" rel="stylesheet" type="text/css" />
<link href="../../include/css/form1.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="<?php echo $SISTEMA['JS']?>/jquery.min.js"></script>


</head>

<body>

<?php include '../../include/painel/topo.php' ?>

<div id="conteudo">

<!-- CONTEÚDO ABAIXO -->





<h1>Altera&ccedil;&atilde;o de Item</h1>


<div class="formulario">

	<!-- Cadastro de Item -->
    <form method="post" action="<?php echo $_SERVER['REQUEST_URI']?>">
    <input type="hidden" name="ACAO" value="ATUALIZAR" />
    <input type="hidden" name="idItem" value="<?php echo $_GET['idItem'] ?>" />
    
    <div class="area">
        <h2>INFORMAÇÕES DO ITEM</h2>
        
        <?php
         //pegando os dados do item a ser alterado
         $rowItem = mysql_fetch_array(mysql_query("SELECT * FROM painel_modulo_item WHERE idIte='$_GET[idItem]'")) or die (mysql_error());
         
        //pegando o módulo que o item está cadastrado
        $rowModulo = mysql_fetch_array(mysql_query("SELECT * FROM painel_modulo WHERE idMod='$rowItem[idMod]'")) or die (mysql_error());
        ?>
        
        <div class="linha">
            <div class="t_campo">M&oacute;dulo:</div>
            
                <div class="campo"><?php echo $rowModulo['nome']; ?> </div>
              
        </div>
        
        <div class="linha">
            <div class="t_campo">Item:</div>
            <div class="campo"><label><input type="text" id="item" name="item" size="38" maxlength="50" value="<?php echo $rowItem['nome']; ?>" /></label></div>
        </div>
        
        <div class="linha">
            <div class="t_campo">URL:</div>
            <div class="campo"><label><input type="text" id="url" name="url" size="38" maxlength="300" value="<?php echo $rowItem['url']; ?>" /></label></div>
        </div>
        
        <div class="linha">
            <div class="t_campo">Ativo:</div>
            <div class="campo">
                <input type="radio" name="ativo" id="ativo" value="1" <?php if($rowItem['ativo']==1) echo'checked=checked'?> /> Sim
                <br />
                <input type="radio" name="ativo" id="ativo" value="0" <?php if($rowItem['ativo']==0) echo'checked=checked'?> /> N&atilde;o
            </div>
        </div>
        
        <div class="linha">
            <div class="t_campo">Abertura da Pág.:</div>
            <div class="campo">
              <input type="radio" name="pagina" id="pagina" value="1"  <?php if($rowItem['pagina']==1) echo'checked=checked'?> /> Mesma P&aacute;gina
              <br />
              <input type="radio" name="pagina" id="pagina" value="0"  <?php if($rowItem['pagina']==0) echo'checked=checked'?> /> Nova P&aacute;gina
            </div>
        </div>
        
        <button type="submit">Alterar Item</button>
        
        
    </div>
    
</form>
<!-- Fim cadastro de Item -->



</div>












<!-- CONTEÚDO ACIMA -->

</div>
<?php include '../../include/painel/rodape.php' ?>