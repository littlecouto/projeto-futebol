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
if(isset($_POST['ACAO']) and $_POST['ACAO'] == 'ADICIONAR'){
	
	if($_POST['time'] == ''){
		$aviso = 'Informe o título da notícia';
		echo "<script> alert('$aviso'); history.go(-1); </script>";
	
	}else{
		
		$time 	 = addslashes($_POST['time']);
		$jogador = addslashes($_POST['jogador']);

        $inicio  = date("Y-m-d");
		$final	 = addslashes($_POST['final']);
		$salario = addslashes($_POST['salario']);

        $multa   = ($salario*3)/100;
		

		
		// VERIFICANDO SE O CADASTRO JÁ EXISTE
		$query = "SELECT idCon FROM jogador_time WHERE ativo=1 AND idTim='$time' AND idJgd='$jogador'";
		$resultEx = mysql_query($query);
		if(mysql_num_rows($resultEx) > 0){
			mysql_query("UPDATE jogador_time SET ativo=0 WHERE ativo=1 AND idTim='$time' AND idJgd='$jogador'");
		}
		//
		
		else{
		
			// Gravando informações principais
			$query = "	INSERT INTO jogador_time(
										idJgd,
										idTim,
										dataini,
										datafim,
										salario,
										multa)
								VALUES (
										'$jogador',
										'$time',
										'$inicio',
										'$final',
                                        '$salario',
										'$multa')";
							
			$gravou = mysql_query($query) or die(mysql_error());
			
		
		// PAINEL HISTÓRICO
		$query = addslashes($query);
		mysql_query("INSERT INTO painel_historico(idUsu, acao, query) VALUE('$_SESSION[USUARIO]', 'INSERT', '$query')") or die (mysql_error());
		//
		
		}
		
		// Verificando a gravação
		if($gravou == false) $aviso='Houve um erro no cadastro!';
		if($gravou == true){
			$aviso='Cadastro efetuado com sucesso!';
		}
			
		echo "<script> alert('$aviso'); location.href='list_jogadores.php'; </script>";
		
	}
}
?>








<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $rowPainel['nome'] ?>  - Sistema Eweb de Gestão </title>

<link href="../../include/css/layout.css" rel="stylesheet" type="text/css" />
<link href="../../include/css/form1.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="../../include/scripts/funcoes.js"></script>



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






<h1>CONTRATO</h1>



<div class="formulario">

    <form method="get" id="form">
	<div class="area">
    
        <h2>INFORMA&Ccedil;&Otilde;ES PRINCIPAIS</h2>
      
         <div class="linha">
          <div class="t_campo">*TIME</div>
        <div class="campo"> <label>
            <select name="time">
                <option value="" disabled>SELECIONE UM TIME</option>
                <?php 
                    $resTim = mysql_query("SELECT idTim, apelido FROM times WHERE ativo=1 ORDER BY apelido") or die(mysql_error());
                    while($rowTim = mysql_fetch_array($resTim)){
						if($_GET['time'] == $rowTim['idTim']){
							echo "<option value='$rowTim[idTim]' selected>$rowTim[apelido]</option>";
						}else{
							echo "<option value='$rowTim[idTim]'>$rowTim[apelido]</option>";							
						}
                    }
                ?>
            </select>
        </label>
        </div>
      </div>
      
         <div class="linha">
          <div class="t_campo">*JOGADOR</div>
        <div class="campo"> <label>
            <select name="jogador" class="jgd">
                <option value="" disabled selected>SELECIONE UM JOGADOR</option>
                <?php 
                    $resJgd = mysql_query("SELECT idJgd, apelido FROM jogador J WHERE ativo=1 AND (SELECT COUNT(*) FROM jogador_time C WHERE C.idJgd=J.idJgd AND idTim='$_GET[time]' AND ativo=1)>0 ORDER BY apelido") or die(mysql_error());
                    while($rowJgd = mysql_fetch_array($resJgd)){
						if($_GET['jogador'] == $rowJgd['idJgd']){
							echo "<option value='$rowJgd[idJgd]' selected>$rowJgd[apelido]</option>";
						}else{
							echo "<option value='$rowJgd[idJgd]'>$rowJgd[apelido]</option>";
						}
                    }
                ?>
            </select>
        </label>
        </div>
      </div>
        </form>
  
 	<?php
		$rowCon = mysql_fetch_array(mysql_query("SELECT datafim FROM jogador_time WHERE idJgd='$_GET[id]'"));
		if($_GET['jogador']>0){
	?>
      
    
    <form method="post" action="<?php echo $_SERVER['REQUEST_URI']?>" enctype="multipart/form-data">
    <input type="hidden" name="ACAO" value="ADICIONAR" />
    <input type="hidden" name="time" value="<?=$_GET['time']?>" />
    <input type="hidden" name="jogador" value="<?=$_GET['jogador']?>" />
    
        <div class="linha">
          <div class="t_campo">*FINAL</div>
	      <div class="campo"> <label> <input name="final" type="date" id="final" min="<?php echo date("Y-m-d") ?>" max="<?=$rowCon['datafim']?>" value="2016-03-<?php echo date("d") ?>" /> </label> </div>
      </div>
      
        <div class="linha">
          <div class="t_campo">*SALÁRIO</div>
        <div class="campo"> <label> <input name="salario" type="number" min="100000" value="100000" step="100000" max="1000000000" /> </label> </div>
      </div>
      
             <div class="linha">
          <div class="t_campo">*TIME</div>
        <div class="campo"> <label>
            <select name="time_emp" class="nao">
                <option value="" disabled>TIME PARA EMPRESTIMO</option>
                <?php 
                    $resTim = mysql_query("SELECT idTim, apelido FROM times WHERE ativo=1 AND idTim!='$_GET[time]' ORDER BY apelido") or die(mysql_error());
                    while($rowTim = mysql_fetch_array($resTim)){
						if($_GET['time'] == $rowTim['idTim']){
							echo "<option value='$rowTim[idTim]' selected>$rowTim[apelido]</option>";
						}else{
							echo "<option value='$rowTim[idTim]'>$rowTim[apelido]</option>";							
						}
                    }
                ?>
            </select>
        </label>
        </div>
      </div>

	  </div>
    
    
    <button type="submit">Cadastrar</button>      
          
        
    </form>
    
    
   <?php
	}
  ?>
   

</div>



<script src="../../include/js/jquery-3.0.0-alpha1.js"></script>
<script>
$('select:not(.nao)').change(function(){
	$('#form').submit();
});

</script>
<!-- CONTEÚDO ACIMA -->
</div>
<?php include '../../include/painel/rodape.php' ?>