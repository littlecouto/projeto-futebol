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
// CONFIGURAÇÕES GERAIS PARA UPLOAD DAS IMAGENS
$tabela_imagens = 'banner';		// Tabela que armazenará as informações das imagens
$nome_imagens = $UrlBannerNomeimg;	// Prefixo das imagens
$qtde_imagens = 1;					// Qtde de campos que serão exibidos
$url_imagem = $UrlBanner;			// URL das imagens salvas
$dir_imagem = $DirBanner;			// Diretório onde serão salvas as imagens
//
?>










<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $rowPainel['nome'] ?>  - Sistema Eweb de Gestão </title>

<link href="../../include/css/layout.css" rel="stylesheet" type="text/css" />
<link href="../../include/css/form1.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="../../include/scripts/funcoes.js"></script>


<!-- AJAX -->
<script type="text/javascript" src="../banner - Copy/ajax/busca_cep.js"> </script>


<?php include '../../lib/lightbox_sistema/lightbox.php'; ?>



<script type="text/javascript">
//DEL IMAGEM
function DelImg(id){
	decisao = confirm("Deseja mesmo excluir esta imagem?");
	
	if(decisao){
		location.href='del_imagem.php?id='+id;
	}
}

</script>


</head>

<body>

<?php include '../../include/painel/topo.php' ?>
<div id="conteudo">
<!-- CONTEÚDO ABAIXO -->


<div class="formulario">




<?php
// ADICIONAR IMAGEM


// Definindo os parâmetros
if($_POST['ACAO'] == 'ADICIONAR_IMG'){
	

	if($_GET['id'] == '')	echo "<script> window.history.go(-1); </script>";	
	
	// Aqui incluimos a classe 
	include('../../include/classes/upload.class.php'); 
	//
	
	// Adicionar a qtde de imagens definida nas CONFIG. GERAIS
	for($i=1; $i<=$qtde_imagens; $i++){ 
	
		if($_FILES["imagem$i"]['size'] > 0){ // Verificando se a imagem foi realmente selecionada
		
	
			// Resgatando o ID do último registro
			$resultId = mysql_query("SELECT idBan FROM $tabela_imagens ORDER BY idBan DESC LIMIT 1");
			if(mysql_num_rows($resultId) == 0){ // caso não exista nenhuma imagem
				$idBan = 1; 
			}elseif(mysql_num_rows($resultId) >= 1){ // caso já existam imagens
				$rowId = mysql_fetch_array($resultId);
				$idBan = $rowId['idBan'] + 1;
			}
			//
			
			// Instanciamos o objeto Upload   
			$handle = '';
			$handle = new Upload($_FILES["imagem$i"]);    
			// 
			
			// Então verificamos se o arquivo foi carregado corretamente    
			if ($handle->uploaded) 	{               
				// Aqui nos devifimos nossas configurações de imagem       
				$handle->image_resize           = true; 		// redimensinoar    
				$handle->image_ratio_x        	= true;			// dimensionar na proporção na altura 
				$handle->image_ratio_y     	 	= true;			// dimensionar na proporção na altura 
				$handle->image_x              	= 280;			// largura 
				$handle->image_y       			= 100;			// altura 
				$handle->image_convert 			= 'jpg';		// converte para JPG
				$handle->jpeg_quality           = 85;			// qualidade
				$handle->image_watermark		= "../../../include/img/png/watermark.png";		// marca dágua
				$handle->image_watermark_x      = 0;			// posição horizontal da marca dágua
				$handle->image_watermark_y      = 0;			// posição vertical da marca dágua	
				//$handle->image_reflection_height = '15%';		// adiciona reflexo
				//$handle->image_reflection_opacity = 60;			// opacidade do reflexo
				
				$handle->file_new_name_body     = $nome_imagens.'_'.$idBan;		// nome do arquivo da imagem
				
				$handle->Process($dir_imagem);					// Pasta onde a imagem será armazenada
				
				$handle-> Clean();								// Excluir os arquivos temporarios
				
				$aviso = "Arquivo gravado com sucesso!"; 		// Definindo aviso UPLOAD TRUE
				$erro = false;
				
			}else{
				$aviso = "Erro ao gravar o arquivo!"; 		// Definindo aviso ERRO
				$erro = true;      
			} 
	
		
			// Verificando gravação
			if($erro == true) echo "<script> alert('$aviso'); window.history.go(-1); </script>";
			if($erro == false){
				
				// Aqui somente recupero o nome da imagem caso queira fazer um insert em banco de dados
				$nome_da_imagem = $handle->file_dst_name;

				
				// gravando o endereço da imagem
				$gravou_dados = mysql_query("INSERT INTO $tabela_imagens(idBan, banner)VALUES('$idBan', '$nome_da_imagem')") or die(mysql_error());
				
				echo "<script> window.location.href='atu_imagens.php'; </script>";
				
			}//
			
	
		}
	
	}
	// end for
	
	
}	
?>









	
    
    
    <form action="<?php $_SERVER['../banner - Copy/PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $_REQUEST['id']?>">
    <input type="hidden" name="ACAO" value="ADICIONAR_IMG" />

    
    <div class="area">
    	
        <h2>Adicionar Cliente</h2>
        
        
        
       
        <?php
		// EXIBE A QTDE DE CAMPOS SOLICITADOS NAS CONFIG. GERAIS
		for($i=1; $i<=$qtde_imagens; $i++){
			echo "	<div class=\"linha\">
						<div class=\"t_campo\"> Imagem $i: </div>
						<div class=\"campo\"> 
							<label><input type=\"file\" name=\"imagem$i\" size=\"20\" maxlength=\"400\" /> </label>  <br />
						</div>
					</div>";
		}
		?>
        
        <p>Imagem de tipo: JPEG<br />
        Dimensões ideais: 280x100 px<br />
        Tamanho m&aacute;ximo: 1 MB por imagem
        </p>
	</div>
    
    
    <button type="submit">Adicionar Imagens</button> 
    
    
    
    
    
    
    
    
    
    
    <div class="area">
        <h2>Imagens Atuais</h2>
        
        <?php 
        $n = 1;
        $resultImg = mysql_query("SELECT * FROM $tabela_imagens WHERE banner<>''");
		$qtde_img = mysql_num_rows($resultImg);
		echo "<p><strong>$qtde_img imagem(ns) </strong> cadastrada(s)</p>";
        while($rowImg = mysql_fetch_array($resultImg)){
			
            echo "
            <div class='lista_imagem'>
				<!-- <a href=\"../../../$url_imagem/$rowImg[banner]\" target=\"_blank\"> -->
				<!-- <img src=\"../../../$url_imagem/$rowImg[banner]\" height=\"100\" border=\"0\"> -->
					
				<a href=\"../../../$url_imagem/$rowImg[banner]\" rel=\"lightbox[roadtrip]\"><img src=\"../../include/scripts/thumbs.php?imagem=../../../$url_imagem/$rowImg[banner]&amp;w=120&amp;h=90\" border=\"0\" alt=\"$rowImg[descricao]\" title=\"$rowImg[descricao]\" /></a>
				
                <br />
                
<a href='#' onclick=\"DelImg($rowImg[idBan]);\"><img src='../../include/img/bt/bt_excluir.gif' alt='Excluir Imagem' title='Excluir Imagem' border='0' /></a>
            </div>
            ";
            
            $n++;
        }
        ?>
	</div>
    
    
    <button type="submit">Atualizar </button>
    
    </form>
    
    
    
    





<!-- CONTEÚDO ACIMA -->
</div>
<?php include '../../include/painel/rodape.php' ?>