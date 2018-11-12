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
	
	if($_POST['nome'] == ''){
		$aviso = 'Informe o título da notícia';
		echo "<script> alert('$aviso'); history.go(-1); </script>";
	
	}elseif($_POST['descricao'] == ''){
		$aviso = 'Informe a descrição da notícia';
		echo "<script> alert('$aviso'); history.go(-1); </script>";
	
	}else{
		

		include '../../include/scripts/limpa_string.php';			// arquivo que limpa a string
		$filtro 			= array(' ' => '_', '-' => '');			// filtro que subistitui (espaço) por _
		$nome_url 			= strtr($_POST['nome'], $filtro);		// retirando os espaços
		$nome_url 			= strtolower(limpa_string($nome_url));
		
		$nome 				= addslashes($_POST['nome']);
		$descricao			= addslashes($_POST['descricao']);
		$ativo		 		= addslashes($_POST['ativo']);
		
		
		// VERIFICANDO SE O CADASTRO JÁ EXISTE
		$query = "SELECT idNot FROM noticias WHERE nome='$nome'";
		$resultEx = mysql_query($query);
		if(mysql_num_rows($resultEx) > 0){
			echo "<script> alert('Provavelmente esta notícia já existe em nosso cadastro. Por favor verifique!'); history.go(-1); </script>";
		}
		//
		
		else{
		
			// Gravando informações principais
			$query = "	INSERT INTO noticias(
										nome,
										nome_url,
										descricao,
										ativo)
								VALUES (
										'$nome',
										'$nome_url',
										'$descricao',
										$ativo)";
							
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
			  
	  		// UPLOAD DA IMAGEM
			if($_FILES["imagem1"]['size'] > 0){ // Verificando se a imagem foi realmente selecionada
			
				// Aqui incluimos a classe 
				include('../../include/classes/upload.class.php'); 
				//
			
				// Resgatando o nome da imagem
				$row = mysql_fetch_array(mysql_query("SELECT idNot, nome_url FROM noticias ORDER BY idNot DESC LIMIT 1"));
				$nomeImg = $row['nome_url'];
				//
				
				// Instanciamos o objeto Upload   
				$handle = '';
				$handle = new Upload($_FILES["imagem1"]);   
				// 
				
				// Então verificamos se o arquivo foi carregado corretamente    
				if ($handle->uploaded) {    
					// Aqui nos devifimos nossas configurações de imagem       
					$handle->image_resize           = true; 		// redimensinoar    
					$handle->image_ratio_x        	= true;			// dimensionar largura na proporção
					$handle->image_ratio_y     	 	= false;		// dimensionar altura na proporção
					//$handle->image_x             	= 400;			// largura 
					$handle->image_y       			= 300;			// altura 
					$handle->image_convert 			= 'jpg';		// converte para JPG
					$handle->jpeg_quality           = 85;			// qualidade
					$handle->file_new_name_body     = $nomeImg;		// nome do arquivo da imagem
					$handle->process($DirNoticias);					// Pasta onde a imagem será armazenada				
					$handle-> Clean();								// Excluir os arquivos temporarios
					
				}else{ // Caso Erro
					$aviso = "Erro ao gravar o arquivo!"; 		
					echo "<script> alert('$aviso'); </script>";
				} 
		
			}
			// FIM UPLOAD
			  
		}
			
		echo "<script> alert('$aviso'); location.href='list_noticias.php'; </script>";
		
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






<h1>CADASTRO DE CURSOS</h1>



<div class="formulario">

    <form method="post" action="<?php echo $_SERVER['REQUEST_URI']?>" enctype="multipart/form-data">
    <input type="hidden" name="ACAO" value="ADICIONAR" />
	<div class="area">
    
        <h2>INFORMA&Ccedil;&Otilde;ES PRINCIPAIS</h2>
        <div class="linha">
          <div class="t_campo">*T&Iacute;TULO</div>
        <div class="campo"> <label> <input name="nome" type="text" maxlength="100" onkeyup="this.value=this.value.toUpperCase()" /> </label> </div>
      </div>
      
               
        
        <div id="verEndereco"></div>
        <div class="linha">
          <div class="t_campo">*DESCRI&Ccedil;&Atilde;O</div>
        <div class="campo"> <label><textarea name="descricao" class="grd" id="descricao"></textarea></label> </div>
        </div>
        
        
        
        <div class="linha">
          <div class="t_campo">Ativo</div>
        <div class="campo">
        	<input type="radio" name="ativo" id="ativo" value="1" checked="checked" /> Sim <br />
			<input type="radio" name="ativo" id="ativo" value="0" /> N&atilde;o
        </div>
      </div>
    
    </div>
    
    
    
    <div class="area">
    
    	<h2> IMAGEM</h2>
        
        <div class="linha">
        <div class="t_campo"> IMAGEM </div>
        <div class="campo"> 
        	<font size="1"> Dimensões ideais: 400x300 px | Tamanho máximo de 1 MB</font>
            <br />
            <label> <input type="file" name="imagem1" size="20" maxlength="400" />  </label> 
		</div>
        </div>

	</div>
    
         
    <button type="submit">Cadastrar</button>      
          
        
    </form>
    
    
    

</div>





<!-- CONTEÚDO ACIMA -->
</div>
<?php include '../../include/painel/rodape.php' ?>