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
	
	}elseif($_POST['apelido'] == ''){
		$aviso = 'Informe a descrição da notícia';
		echo "<script> alert('$aviso'); history.go(-1); </script>";
	
	}else{
		
		include '../../include/scripts/limpa_string.php';			// arquivo que limpa a string
		$filtro 		= array(' ' => '-', '_' => '-', ' - ' => '_');			// filtro que subistitui (espaço) por _
		$url 			= strtr($_POST['nome'], $filtro);		// retirando os espaços
		$url 			= strtolower(limpa_string($url));
		
		$nome 			= addslashes($_POST['nome']);
		$apelido		= addslashes($_POST['apelido']);

		$posicao		= addslashes($_POST['posicao']);
		$lado		 	= addslashes($_POST['lado']);
		$especialidade 	= addslashes($_POST['especialidade']);
		$caracteristica	= addslashes($_POST['caracteristica']);
		$nacionalidade 	= addslashes($_POST['nacionalidade']);
		$idade		 	= addslashes($_POST['idade']);
		$forca		 	= addslashes($_POST['forca']);

		$ativo		 	= addslashes($_POST['ativo']);
		$estrela 		= addslashes($_POST['estrela']);
		
		
		// VERIFICANDO SE O CADASTRO JÁ EXISTE
		// $query = "SELECT idJgd FROM jogador WHERE nome='$nome' AND idPai='$nacionalidade' AND forca='$forca' AND idPos='$posicao' AND idPe='$lado'";
		// $resultEx = mysql_query($query) or die(mysql_error());
		// if(mysql_num_rows($resultEx) > 0){
		/*/ 	echo "<script> alert('Provavelmente esta notícia já existe em nosso cadastro. Por favor verifique!'); history.go(-1); </script>";
		// }
		/*/
		
		if('1'=='1'){
		
			// Gravando informações principais
			$query = "	INSERT INTO jogador(
										nome,
										apelido,
										idPos,
										idPe,
										idEsp,
										idCar,
										idNac,
										idade,
										forca,
										estrela,
										imagem,
										ativo)
								VALUES (
										'$nome',
										'$apelido',
										'$posicao',
										'$lado',
										'$especialidade',
										'$caracteristica',
										'$nacionalidade',
										'$idade',
										'$forca',
										'$estrela',
										'$url',
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
			if($_FILES["imagem"]['size'] > 0){ // Verificando se a imagem foi realmente selecionada
			
				// Aqui incluimos a classe 
				include('../../include/classes/upload.class.php'); 
				//
			
				// Resgatando o nome da imagem
				$row = mysql_fetch_array(mysql_query("SELECT idJgd, imagem FROM jogador ORDER BY idJgd DESC LIMIT 1"));
				$nomeImg = $row['imagem'];
				//
				
				// Instanciamos o objeto Upload   
				$handle = '';
				$handle = new Upload($_FILES["imagem"]);   
				// 
				
				// Então verificamos se o arquivo foi carregado corretamente    
				if ($handle->uploaded) { 
					// Aqui nos devifimos nossas configurações de imagem       
					$handle->image_resize           = true; 		// redimensinoar    
					$handle->image_ratio_x        	= false;			// dimensionar largura na proporção
					$handle->image_ratio_y     	 	= true;		// dimensionar altura na proporção
					$handle->image_x             	= 980;			// largura 
					//$handle->image_y       		= 300;			// altura 
					$handle->image_convert 			= 'jpg';		// converte para JPG
					$handle->jpeg_quality           = 95;			// qualidade
					$handle->file_new_name_body     = $nomeImg;		// nome do arquivo da imagem
					$handle->process($DirJogador);					// Pasta onde a imagem será armazenada				
					$handle-> Clean();								// Excluir os arquivos temporarios
					
				}else{ // Caso Erro
					$aviso = "Erro ao gravar o arquivo!"; 		
					echo "<script> alert('$aviso'); </script>";
				} 
		
			}
			// FIM UPLOAD
			  
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






<h1>CADASTRO DE CURSOS</h1>



<div class="formulario">

    <form method="post" action="<?php echo $_SERVER['REQUEST_URI']?>" enctype="multipart/form-data">
    <input type="hidden" name="ACAO" value="ADICIONAR" />
	<div class="area">
    
        <h2>INFORMA&Ccedil;&Otilde;ES PRINCIPAIS</h2>
        <div class="linha">
          <div class="t_campo">*NOME</div>
        <div class="campo"> <label> <input name="nome" type="text" maxlength="100" onblur="this.value=this.value.toUpperCase()" /> </label> </div>
      </div>
      
        <div class="linha">
          <div class="t_campo">*APELIDO</div>
        <div class="campo"> <label> <input name="apelido" type="text" maxlength="100" onblur="this.value=this.value.toUpperCase()" /> </label> </div>
      </div>
      
        <div class="linha">
          <div class="t_campo">*POSIÇÃO</div>
        <div class="campo"> <label> 
        <select name="posicao">
        	<option value="1">GOLEIRO</option>
        	<option value="2">ZAGUEIRO</option>
        	<option value="3">LATERAL</option>
        	<option value="4">MEIO-CAMPO</option>
        	<option value="5">ATACANTE</option>
        </select>
         </label> </div>
      </div>

        <div class="linha">
          <div class="t_campo">PÉ PREFERIDO</div>
        <div class="campo">
        	<input type="radio" name="lado" id="lado" value="1" /> ESQUERDO <br />
			<input type="radio" name="lado" id="lado" value="2" /> DIREITO
        </div>
      </div>

      
        <div class="linha">
          <div class="t_campo">*ESPECIALIDADE</div>
        <div class="campo"> <label> 
        <select name="especialidade">
        	<option value="1">ARMAÇÃO</option>
        	<option value="2">CABECEIO</option>
        	<option value="3">CRUZAMENTO</option>
        	<option value="4">DESARME</option>
        	<option value="5">DRIBLE</option>
        	<option value="6">FINALIZAÇÃO</option>
        	<option value="7">MARCAÇÃO</option>
        	<option value="8">PASSE</option>
        	<option value="9">RESISTÊNCIA</option>
        	<option value="10">VELOCIDADE</option>
        </select>
         </label> </div>
      </div>
      
      
        <div class="linha">
          <div class="t_campo">*CARACTERÍSTICA</div>
        <div class="campo"> <label> 
        <select name="caracteristica">
        	<option value="1">ARMAÇÃO</option>
        	<option value="2">CABECEIO</option>
        	<option value="3">CRUZAMENTO</option>
        	<option value="4">DESARME</option>
        	<option value="5">DRIBLE</option>
        	<option value="6">FINALIZAÇÃO</option>
        	<option value="7">MARCAÇÃO</option>
        	<option value="8">PASSE</option>
        	<option value="9">RESISTÊNCIA</option>
        	<option value="10">VELOCIDADE</option>
        </select>
         </label> </div>
      </div>
      
         <div class="linha">
          <div class="t_campo">*NACIONALIDADE</div>
        <div class="campo"> <label>
        	<select name="nacionalidade">
        		<option value="" disabled selected>SELECIONE UM PAÍS</option>
        		<?php 
        			$resPai = mysql_query("SELECT idPai, pais, continente FROM pais WHERE ativo=1 ORDER BY pais") or die(mysql_error());
        			while($rowPai = mysql_fetch_array($resPai)){
    					echo "<option value='$rowPai[idPai]'>$rowPai[pais]</option>";
        			}
        		?>
        	</select>
        </label>
        </div>
      </div>
      
     
        <div class="linha">
          <div class="t_campo">*IDADE</div>
        <div class="campo"> <label> <input name="idade" type="number" min="18" value="25" /> </label> </div>
      </div>
      
        <div class="linha">
          <div class="t_campo">*FORÇA INICIAL</div>
        <div class="campo"> <label> <input name="forca" type="number" min="40" value="100" max="1000" /> </label> </div>
      </div>
      
               
        
        
        <div class="linha">
          <div class="t_campo">ESTRELA</div>
        <div class="campo">
        	<input type="radio" name="estrela" id="estrela" value="1" /> Sim <br />
			<input type="radio" name="estrela" id="estrela" value="0" checked="checked" /> N&atilde;o
        </div>
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
            <label> <input type="file" name="imagem" size="20" maxlength="400" />  </label> 
		</div>
        </div>

	</div>
    
         
    <button type="submit">Cadastrar</button>      
          
        
    </form>
    
    
    

</div>





<!-- CONTEÚDO ACIMA -->
</div>
<?php include '../../include/painel/rodape.php' ?>