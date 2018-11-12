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
	
	}elseif($_POST['abreviacao'] == ''){
		$aviso = 'Informe a descrição da notícia';
		echo "<script> alert('$aviso'); history.go(-1); </script>";
	
	}else{

		include '../../include/scripts/limpa_string.php';			// arquivo que limpa a string
		$filtro 	= array(' ' => '-', '_' => '-', ' - ' => '_');			// filtro que subistitui (espaço) por _
		$url 		= strtr($_POST['nome'], $filtro);		// retirando os espaços
		$url 		= strtolower(limpa_string($url));
				
		$nome		= addslashes($_POST['nome']);
		$apelido	= addslashes($_POST['apelido']);
		$abreviacao	= addslashes($_POST['abreviacao']);


		@$estadio	= addslashes($_POST['estadio']);
		$estado		= addslashes($_POST['estado']);
		$pais 		= addslashes($_POST['pais']);

		
		function limpaHash($str){
			return strtr($str, array('#'=> ''));
		}
		$cor_prin	= addslashes(limpaHash($_POST['cor_prin']));
		$cor_sec	= addslashes(limpaHash($_POST['cor_sec']));
		$cor_ter	= addslashes(limpaHash($_POST['cor_ter']));
		
		
		// VERIFICANDO SE O CADASTRO JÁ EXISTE
		$query = "SELECT idTim FROM times WHERE nome='$nome'";
		$resultEx = mysql_query($query);
		if(mysql_num_rows($resultEx) > 0){
			echo "<script> alert('Provavelmente esta notícia já existe em nosso cadastro. Por favor verifique!'); history.go(-1); </script>";
		}
		//
		
		else{
		
			// Gravando informações principais
			$query = "	INSERT INTO times(
										nome,
										apelido,
										abreviacao,
										idPai,
										idUF,
										idEst,
										escudo)
								VALUES (
										'$nome',
										'$apelido',
										'$abreviacao',
										'$pais',
										'$estado',
										'$estadio',
										'$url')";
							
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
				$row = mysql_fetch_array(mysql_query("SELECT idTim, escudo FROM times ORDER BY idTim DESC LIMIT 1"));
				$nomeImg = $row['escudo'];
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
					$handle->image_convert 			= 'png';		// converte para JPG
					$handle->jpeg_quality           = 85;			// qualidade
					$handle->file_new_name_body     = $nomeImg;		// nome do arquivo da imagem
					$handle->process($DirTime);						// Pasta onde a imagem será armazenada				
					$handle-> Clean();								// Excluir os arquivos temporarios
					
				}else{ // Caso Erro
					$aviso = "Erro ao gravar o arquivo!"; 		
					echo "<script> alert('$aviso'); </script>";
				} 
		
			}
			// FIM UPLOAD
			  
		}
			
		echo "<script> alert('$aviso'); location.href='list_times.php'; </script>";
		
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
    
      
        <div class="linha">
          <div class="t_campo">*JOGADORES</div>
        <div class="campo"> <label>
        		<?php 
        			$resLoc = mysql_query("SELECT j.apelido, j.idJgd, j.forca, j.idPos FROM jogador j INNER JOIN jogador_time c ON j.idJgd=c.idJgd INNER JOIN times t ON c.idTim=t.idTim WHERE t.idTim=$_GET[time] AND j.idPos<6 ORDER BY idPos, forca") or die(mysql_error());
        			while($rowLoc = mysql_fetch_array($resLoc)){
						switch($rowLoc['idPos']){
		                    case '1' : 
		                        $idPos = 'G';
		                        break;
		                    case '2' : 
		                        $idPos = 'Z';
		                        break;
		                    case '3' : 
		                        $idPos = 'L';
		                        break;
		                    case '4' : 
		                        $idPos = 'M';
		                        break;
		                    case '5' : 
		                        $idPos = 'A';
		                        break;
		                }

        				echo "<label><input type='checkbox' value='$rowLoc[idJgd]' name='jogadores[]'>$idPos - $rowLoc[apelido] $rowLoc[forca]</label>";
        			}
        		?>
        </label>
        </div>
      </div>
      
        <div class="linha">
          <div class="t_campo">*PAÍS</div>
        <div class="campo"> <label>
        	<select name="pais">
        		<option value="" selected disabled>SELECIONE UM PAÍS</option>
        		<?php 
        			$resPai = mysql_query("SELECT idPai, pais, continente FROM pais WHERE ativo=1 ORDER BY continente, pais") or die(mysql_error());
        			while($rowPai = mysql_fetch_array($resPai)){
       					echo "<option value='$rowPai[idPai]'>$rowPai[pais] ($rowPai[continente])</option>";
        			}
        		?>
        	</select>
        </label>
        </div>
      </div>
      
        <div class="linha">
          <div class="t_campo">*EST&Aacute;DIO</div>
        <div class="campo"> <label>
        	<select name="estadio">
        		<option value="" selected disabled>SELECIONE UM ESTÁDIO</option>
        		<?php 
        			$resEst = mysql_query("SELECT idEst, nome, capacidade FROM estadio ORDER BY nome") or die(mysql_error());
        			while($rowEst = mysql_fetch_array($resEst)){
         				echo "<option value='$rowEst[idEst]'>$rowEst[nome] ($rowEst[capacidade])</option>";
        			}
        		?>
        	</select>
        </label>
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



<script src="https://code.jquery.com/jquery-2.1.4.js"></script>
<script>

$(function(){
  var input = $('input[type=checkbox]');
  
  input.click(function(){
    if($('input[type=checkbox]:checked').size() >=11){
      input.not(':checked').prop('disabled',true);
    }else{
      input.not(':checked').prop('disabled',false);		
	}
  });
});
</script>	


<!-- CONTEÚDO ACIMA -->
</div>
<?php include '../../include/painel/rodape.php' ?>