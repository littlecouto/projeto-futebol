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

<!-- CALENDÁRIO -->
<script type="text/javascript" src="../../lib/calendario/calendario.js"></script>
<link href="../../lib/calendario/calendario.css" rel="stylesheet" type="text/css" />
<!-- FIM CALENDÁRIO -->


<!-- TinyMCE -->
<script type="text/javascript" src="../../lib/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
tinyMCE.init({
        // General options
        mode : "textareas",
        theme : "advanced",
        plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

        // Theme options
        theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,code",
        theme_advanced_buttons2 : "formatselect,fontsizeselect",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true,

        // Skin options
        skin : "o2k7",
        skin_variant : "silver",

        // Example content CSS (should be your site CSS)
        content_css : "css/example.css",

        // Drop lists for link/image/media/template dialogs
        template_external_list_url : "js/template_list.js",
        external_link_list_url : "js/link_list.js",
        external_image_list_url : "js/image_list.js",
        media_external_list_url : "js/media_list.js",

        // Replace values for the template plugin
        template_replace_values : {
                username : "Some User",
                staffid : "991234"
        }
});
</script>
<!-- Fim TinyMCE -->



</head>

<body>

<?php include '../../include/painel/topo.php' ?>

<div id="conteudo">

<!-- CONTEÚDO ABAIXO -->



<?php

if($_POST['ACAO'] == 'ATUALIZAR'){
	
	// Tratando dados
	$descricao	= addslashes($_POST['descricao']);
	
	
	// VERIFICANDO SE A TABELA JÁ POSSUI DADOS
	if(mysql_num_rows(mysql_query("SELECT descricao FROM servicos")) == 0){
				
		// GRAVAR DADOS
		$query = "INSERT INTO servicos(descricao) VALUES('$descricao')";
		$gravou = mysql_query($query) or die(mysql_error());
		
		// PAINEL HISTÓRICO
		$query = addslashes($query);
		mysql_query("INSERT INTO painel_historico(idUsu, acao, query) VALUE('$_SESSION[USUARIO]', 'INSERT', '$query')") or die (mysql_error());
		//		
		

	}
	
	else{
		
		// ATUALIZAR DADOS
		$query = "UPDATE servicos SET descricao='$descricao'";
		$gravou = mysql_query($query) or die(mysql_error());
		
		// PAINEL HISTÓRICO
		$query = addslashes($query);
		mysql_query("INSERT INTO painel_historico(idUsu, acao, query) VALUE('$_SESSION[USUARIO]', 'UPDATE', '$query')") or die (mysql_error());
		//
		
	}
	
	
	
	
				
	if($gravou == false) $aviso = 'Erro ao atualizar os dados!';
	if($gravou == true) $aviso  = 'Dados atualizados com sucesso!';
			
	echo "<script> alert('$aviso'); location.href='$SISTEMA[URL]'; </script>";

}
		
		
		
//Selecionando dados a serem atualizado
$query = "SELECT * FROM servicos LIMIT 1";
$query = addslashes($query); // Proteção SQL Injection
$sel = mysql_fetch_array(mysql_query($query)) or die (mysql_error());
?>






<h1>P&Aacute;GINA DE SERVI&Ccedil;OS</h1>

<div class="formulario">

<form method="post" action="<?php echo $_SERVER['REQUEST_URI']?>">
<input type="hidden" name="ACAO" value="ATUALIZAR" />
     
     
     <div class="area">
    
        <div class="linha">
        <div class="t_campo">DESCRI&Ccedil;&Atilde;O DOS SERVI&Ccedil;OS</div>
        <div class="campo"><label><textarea name="descricao" id="descricao" cols="48" class="grd"><?php echo stripslashes($sel['descricao'])?></textarea></label></div>
        </div>
        
    
        <button type="submit"> ATUALIZAR INFORMAÇÕES </button>

     </div>
    
	</form>

</div>



















<!-- CONTEÚDO ACIMA -->

</div>
<?php include '../../include/painel/rodape.php' ?>