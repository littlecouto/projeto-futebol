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
if($_REQUEST['id'] == 0){
	$aviso = "Registro não encontrado!";
	echo "<script> alert('$aviso'); window.history.go(-1); </script>";	
	
	
}elseif($_REQUEST['id'] > 0 && @$_POST['ACAO'] == ''){
	
	// Resgatando os dados atuais 
	$row = mysql_fetch_array(mysql_query("SELECT * FROM jogador WHERE idJgd='$_REQUEST[id]'"));
	@$_POST['nome']			= stripslashes($_POST['nome']);
	@$_POST['descricao'] 	= stripslashes($_POST['descricao']);
	
}elseif($_REQUEST['id'] > 0 && $_POST['ACAO'] == 'ATUALIZAR'){
	$row = mysql_fetch_array(mysql_query("SELECT * FROM times WHERE idTim='$_REQUEST[id]'"));
	
	if($_POST['nome'] == ''){
		$aviso = 'Informe o título da notícia';
		echo "<script> alert('$aviso'); history.go(-1); </script>";
	
	}elseif($_POST['abreviacao'] == ''){
		$aviso = 'Informe a descrição da notícia';
		echo "<script> alert('$aviso'); history.go(-1); </script>";
	
	}else{
		
		
		include '../../include/scripts/limpa_string.php';				// arquivo que limpa a string
		$filtro 	= array(' ' => '-', '_' => '-', ' - ' => '_');			// filtro que subistitui (espaço) por _
		$url 		= strtr($_POST['nome'], $filtro);		// retirando os espaços
		$url 		= strtolower(limpa_string($url));
				
		$nome		= addslashes($_POST['nome']);
		$apelido	= addslashes($_POST['apelido']);
		$abreviacao	= addslashes($_POST['abreviacao']);


		$estadio	= addslashes($_POST['estadio']);
		$estado		= addslashes($_POST['estado']);
		$pais 		= addslashes($_POST['pais']);

		
		function limpaHash($str){
			return strtr($str, array('#'=> ''));
		}
		$cor_prin	= addslashes(limpaHash($_POST['cor_prin']));
		$cor_sec	= addslashes(limpaHash($_POST['cor_sec']));
		$cor_ter	= addslashes(limpaHash($_POST['cor_ter']));

		// VERIFICAR SE JÁ EXISTE O ATUAL USUÁRIO ATUAL
		$qtdeUsu = mysql_query("SELECT idTim FROM times WHERE nome='$nome' AND idTim<>$_REQUEST[id]");
		if(mysql_num_rows($qtdeUsu)>0){
			echo "<script> alert('Provavelmente esta notícia já existe em nosso cadastro. Por favor verifique!'); history.go(-1); </script>";
		}
		//
		
		// Gravando os dados
		$query = "	UPDATE	times
					SET 	nome='$nome',
							apelido='$apelido',
							abreviacao='$abreviacao',
							idPai='$pais',
							idUF='$estado',
							idEst='$estadio',
							cor_prin='$cor_prin',
							cor_sec='$cor_sec',
							cor_ter='$cor_ter',
							escudo='$url'
					WHERE 	idTim='$_REQUEST[id]' 
					LIMIT 1";
		$gravou = mysql_query($query) or die(mysql_error());
		
		
		// PAINEL HISTÓRICO
		$query = addslashes($query);
		mysql_query("INSERT INTO painel_historico(idUsu, acao, query) VALUE('$_SESSION[USUARIO]', 'UPDATE', '$query')") or die (mysql_error());
		//
		
		
		
	
		// Verificando a gravação
		if($gravou==false)	$aviso="Houve um erro ao atualizar os dados!";
		if($gravou==true){
			$aviso="Dados atualizados com sucesso!";
			
			
			//Renomeando a imagem
			$img_novo = $DirTime.'/'.$url.'.jpg';
			//
			
			
			// UPLOAD DA IMAGEM
			$_FILES["escudo"]['size'] == 0;
			if($_FILES["escudo"]['size'] > 0){ // Verificando se a imagem foi realmente selecionada
			
				// Aqui incluimos a classe 
				include('../../include/classes/upload.class.php'); 
				//
			
				// Resgatando o nome da imagem
				$row = mysql_fetch_array(mysql_query("SELECT idTim, escudo FROM times WHERE idTim=$_REQUEST[id]"));
				$nomeImg = $row['escudo'];
				//
				
				// Excluir imagem antiga
				if(file_exists($DirTime.'/'.$row['escudo'].'.png')){
					$escudoAt = $DirTime.'/'.$row['escudo'].'.png';
					unlink($escudoAt);
				}
				//
				
				// Instanciamos o objeto Upload   
				$handle = '';
				$handle = new Upload($_FILES["escudo"]);   
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
					$handle->process($DirTime);					// Pasta onde a imagem será armazenada				
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
<title><?php echo $rowPainel['nome'] ?> - Sistema Eweb de Gestão </title>

<link href="../../include/css/layout.css" rel="stylesheet" type="text/css" />
<link href="../../include/css/form1.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="../../include/scripts/funcoes.js"></script>

<!-- AJAX -->
<script type="text/javascript" src="ajax/busca_cep.js"> </script>


<script type="text/javascript">
// DEL IMAGEM
function DelImg(id){
	decisao = confirm("Deseja mesmo excluir esta imagem?");
	
	if(decisao){
		location.href='del_noticia_img.php?id='+id;
	}
}
</script>





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

<h1>ATUALIZAR TIME</h1>


<div class="formulario">

    <form method="post" action="<?php echo $_SERVER['REQUEST_URI']?>" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $_REQUEST['id'] ?>" />
    <input type="hidden" name="ACAO" value="TESTE ATUALIZAR" />
	<div class="area">
    
        <h2>INFOR&Ccedil;&Otilde;ES PRINCIPAIS</h2>
        <div class="linha">
          <div class="t_campo">*NOME</div>
        <div class="campo"> <label> <input name="nome" type="text" maxlength="100" value="<?php echo $row['nome'] ?>" onblur="this.value=this.value.toUpperCase()" /> </label> <br />
        </div>
      </div>


        <div class="linha">
          <div class="t_campo">*APELIDO</div>
        <div class="campo"> <label> <input name="apelido" type="text" maxlength="100" value="<?php echo $row['apelido'] ?>" onblur="this.value=this.value.toUpperCase()" /> </label> <br />
        </div>
      </div>
      
        <div class="linha">
          <div class="t_campo">*POSIÇÃO</div>
        <div class="campo"> <label> 
        <select name="posicao">
        	<option value="1" <?= $row['idPos']==1?'selected':''?>>GOLEIRO</option>
        	<option value="2" <?= $row['idPos']==2?'selected':''?>>ZAGUEIRO</option>
        	<option value="3" <?= $row['idPos']==3?'selected':''?>>LATERAL</option>
        	<option value="4" <?= $row['idPos']==4?'selected':''?>>MEIO-CAMPO</option>
        	<option value="5" <?= $row['idPos']==5?'selected':''?>>ATACANTE</option>
        </select>
         </label> </div>
      </div>

        <div class="linha">
          <div class="t_campo">PÉ PREFERIDO</div>
        <div class="campo">
        	<input type="radio" name="lado" id="lado" value="1" <?= $row['idPe']==1?'checked':''?> /> ESQUERDO <br />
			<input type="radio" name="lado" id="lado" value="2" <?= $row['idPe']==2?'checked':''?> /> DIREITO
        </div>
      </div>

      
        <div class="linha">
          <div class="t_campo">*ESPECIALIDADE</div>
        <div class="campo"> <label> 
        <select name="especialidade">
        	<option value="1" <?= $row['idEsp']==1?'selected':''?>>ARMAÇÃO</option>
        	<option value="2" <?= $row['idEsp']==2?'selected':''?>>CABECEIO</option>
        	<option value="3" <?= $row['idEsp']==3?'selected':''?>>CRUZAMENTO</option>
        	<option value="4" <?= $row['idEsp']==4?'selected':''?>>DESARME</option>
        	<option value="5" <?= $row['idEsp']==5?'selected':''?>>DRIBLE</option>
        	<option value="6" <?= $row['idEsp']==6?'selected':''?>>FINALIZAÇÃO</option>
        	<option value="7" <?= $row['idEsp']==7?'selected':''?>>MARCAÇÃO</option>
        	<option value="8" <?= $row['idEsp']==8?'selected':''?>>PASSE</option>
        	<option value="9" <?= $row['idEsp']==9?'selected':''?>>RESISTÊNCIA</option>
        	<option value="10" <?= $row['idEsp']==10?'selected':''?>>VELOCIDADE</option>
        </select>
         </label> </div>
      </div>
      
      
        <div class="linha">
          <div class="t_campo">*CARACTERÍSTICA</div>
        <div class="campo"> <label> 
        <select name="caracteristica">
        	<option value="1" <?= $row['idCar']==1?'selected':''?>>ARMAÇÃO</option>
        	<option value="2" <?= $row['idCar']==2?'selected':''?>>CABECEIO</option>
        	<option value="3" <?= $row['idCar']==3?'selected':''?>>CRUZAMENTO</option>
        	<option value="4" <?= $row['idCar']==4?'selected':''?>>DESARME</option>
        	<option value="5" <?= $row['idCar']==5?'selected':''?>>DRIBLE</option>
        	<option value="6" <?= $row['idCar']==6?'selected':''?>>FINALIZAÇÃO</option>
        	<option value="7" <?= $row['idCar']==7?'selected':''?>>MARCAÇÃO</option>
        	<option value="8" <?= $row['idCar']==8?'selected':''?>>PASSE</option>
        	<option value="9" <?= $row['idCar']==9?'selected':''?>>RESISTÊNCIA</option>
        	<option value="10" <?= $row['idCar']==10?'selected':''?>>VELOCIDADE</option>
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
						
    					echo "<option value='$rowPai[idPai]' ".($rowPai['idPai']==$row['idNac']?'selected':'').">$rowPai[pais]</option>";
        			}
        		?>
        	</select>
        </label>
        </div>
      </div>
      
      
        <div class="linha">
          <div class="t_campo">*PAÍS</div>
        <div class="campo"> <label>
        	<select name="pais">
        		<option value="" disabled>SELECIONE UM PAÍS</option>
        		<?php 
        			$resPai = mysql_query("SELECT idPai, pais, continente FROM pais WHERE ativo=1 ORDER BY continente, pais") or die(mysql_error());
        			while($rowPai = mysql_fetch_array($resPai)){
        				if($row['idPai'] === $rowPai['idPai']){
        					echo "<option value='$rowPai[idPai]' selected>$rowPai[pais] ($rowPai[continente])</option>";
        				}else{
        					echo "<option value='$rowPai[idPai]'>$rowPai[pais] ($rowPai[continente])</option>";
        				}
        			}
        		?>
        	</select>
        </label>
        </div>
      </div>
      
        <div class="linha">
          <div class="t_campo">*IDADE</div>
        <div class="campo"> <label> <input name="idade" type="number" min="18" value="<?=$row['idade']?>" /> </label> </div>
      </div>
      
        <div class="linha">
          <div class="t_campo">*FORÇA INICIAL</div>
        <div class="campo"> <label> <input name="forca" type="number" min="40" value="<?=$row['forca']?>" max="1000" /> </label> </div>
      </div>
      
               
        
        
        <div class="linha">
          <div class="t_campo">ESTRELA</div>
        <div class="campo">
        	<input type="radio" name="estrela" id="estrela" value="1" <?= $row['estrela']==1?'checked':''?> /> Sim <br />
			<input type="radio" name="estrela" id="estrela" value="0" <?= $row['estrela']==2?'checked':''?> /> N&atilde;o
        </div>
      </div>
      
    </div>
    
    
    
    
    
    
    
    
<!--    <div class="area">
    
    	<h2> ESCUDO</h2>
        
        <div class="linha">
        <div class="t_campo"> ALTERAR ESCUDO </div>
        <div class="campo"> 
        	<font size="1"> Dimensões ideais: 400x300 px | Tamanho máximo de 1 MB</font>
            <br />
            <label> <input type="file" name="escudo" size="20" maxlength="400" />  </label> 
        <?php
		if(file_exists("$DirJogador/$row[imagem].jpg") == true){
			echo "	<br /><br />
					<img src=\"$UrlJogador/$row[imagem].png\" border=\"0\" width=\"50\">
					<a href=\"#\"> 
					<img src='../../include/img/bt/bt_excluir.gif' alt='Excluir Imagem' title='Excluir Imagem' border='0' onclick=\"DelImg($row[idTim]);\" /> 
					</a>
					";

		}
		?>
        </div>
        </div>
        
        

	</div>
    -->
    
         
    <button type="submit">Atualizar Informações</button>      
          
        
    </form>
    
    
    

</div>


    
<!-- CONTEÚDO ACIMA -->
</div>
<?php include '../../include/painel/rodape.php' ?>