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
	

	
	//validando campos
	if(empty($_POST['nome'])){
		echo "<script>alert('Preencha o campo NOME!'); history.go(padrao);</script>";
	}elseif(empty($_POST['email'])){
		echo "<script>alert('Preencha o campo EMAIL!'); history.go(padrao);</script>";
	}elseif(empty($_POST['smtp_host'])){
		echo "<script>alert('Preencha o campo SMTP HOST!'); history.go(padrao);</script>";
	}elseif(empty($_POST['smtp_login'])){
		echo "<script>alert('Preencha o campo SMTP LOGIN!'); history.go(padrao);</script>";
	}else{
		// Tratando os dados
		$nome 			= addslashes($_POST['nome']);
		$email 			= addslashes($_POST['email']);
		$smtp_host 		= addslashes($_POST['smtp_host']);
		$smtp_porta 	= addslashes($_POST['smtp_porta']);
		$smtp_login 	= addslashes($_POST['smtp_login']);
		$smtp_senha 	= addslashes($_POST['smtp_senha']);
		$site 			= addslashes($_POST['site']);
		


		
		$query = "UPDATE painel_empresa SET idUsu='$_SESSION[USUARIO]', nome='$nome', email='$email', smtp_host='$smtp_host', smtp_porta='$smtp_porta', smtp_login='$smtp_login', smtp_senha='$smtp_senha', site='$site' WHERE idEmp='1' LIMIT 1";
		$gravou = mysql_query($query) or die (mysql_error());
		
		// PAINEL HISTÓRICO
		$query = addslashes($query);
		mysql_query("INSERT INTO painel_historico(idUsu, acao, query) VALUE($_SESSION[USUARIO], 'UPDATE', '$query')") or die (mysql_error());
		//
				
		if($gravou == false) $aviso = 'Erro ao gravar os dados!'; else $aviso = 'Dados atualizados com sucesso!';
		
					
		echo "<script> alert('$aviso'); location.href='$SISTEMA[URL]'; </script>";
			
	}
}




	if($_POST['ACAO'] == 'ATUALIZAR' and $_FILES['head']['size'] > 0 ){

			//GRAVANDO HEADER
			
		// Aqui incluimos a classe 
	include('../../include/classes/upload.class.php'); 
	//			
			
// CONFIGURAÇÕES GERAIS PARA UPLOAD DAS IMAGENS			
$url_header = 'contato/img';											// URL do header salvo
$dir_header = '/home/feijaodecordarestaurante/www/contato/img';			// Diretório
$nome_imagens = 'headeremails';
		
			

		// Instanciamos o objeto Upload   
			$handle = '';
			$handle = new Upload($_FILES["head"]);    
			// 
			
			// Então verificamos se o arquivo foi carregado corretamente    
			if ($handle->uploaded) 	{               
				// Aqui nos devifimos nossas configurações de imagem       
				$handle->image_resize           = true; 		// redimensinoar    
				$handle->image_ratio_x        	= false;			// dimensionar na proporção na altura 
				$handle->image_ratio_y     	 	= false;			// dimensionar na proporção na altura 
				//$handle->image_x              	= $w;			// largura 
				//$handle->image_y       			= $h;			// altura 
				$handle->image_convert 			= 'jpg';		// converte para JPG
				$handle->jpeg_quality           = 85;			// qualidade
				//$handle->image_watermark		= "../../../include/img/png/watermark.png";		// marca dágua
				//$handle->image_watermark_x      = 0;			// posição horizontal da marca dágua
				//$handle->image_watermark_y      = 0;			// posição vertical da marca dágua	
				//$handle->image_reflection_height = '15%';		// adiciona reflexo
				//$handle->image_reflection_opacity = 60;			// opacidade do reflexo
				
				$handle->file_new_name_body     = $nome_imagens;		// nome do arquivo da imagem
				
				$handle->Process($dir_header);					// Pasta onde a imagem será armazenada
				
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
				$gravou_dados = mysql_query("INSERT INTO painel_empresa(head)VALUES('$head')") or die(mysql_error());
				
				
				
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






<h1>Configurações do Proprietario </h1>

<div class="formulario">

<?php 
	//pegando dados do cliente
	$rowEmp = mysql_fetch_array(mysql_query("SELECT * FROM painel_empresa WHERE idEmp='1'")) or die (mysql_error());
?>

<form method="post" action="<?php $_SERVER['REQUEST_URI'] ?>">
<input type="hidden" name="ACAO" value="ATUALIZAR" />

	<div class="area">
        <h2>Atualizar Cliente</h2>
        <div class="linha">
        <div class="t_campo">NOME</div>
        <div class="campo"><label><input name="nome" type="text" id="nome" maxlength="50" value="<?php echo $rowEmp['nome']; ?>" /></label></div>
        </div>
        
        <div class="linha">
        <div class="t_campo">E-MAIL</div>
        <div class="campo"><label><input name="email" type="text" id="email" maxlength="70" value="<?php echo $rowEmp['email']; ?>" /></label></div>
        </div>
      
        <div class="linha">
        <div class="t_campo">SMTP HOST</div>
        <div class="campo"><label><input name="smtp_host" type="text" maxlength="100" value="<?php echo $rowEmp['smtp_host']; ?>" /></label></div>
        </div>
        
        <div class="linha">
        <div class="t_campo">SMTP PORTA</div>
        <div class="campo"><label><input name="smtp_porta" value="<?php echo $rowEmp['smtp_porta']; ?>" type="text" maxlength="4" /></label></div>
        </div>
        

        
        <div class="linha">
        <div class="t_campo">SMTP LOGIN</div>
        <div class="campo"><label><input name="smtp_login" type="text" maxlength="100" value="<?php echo $rowEmp['smtp_login']; ?>" /></label></div>
        </div>
        
        <div class="linha">
        <div class="t_campo">HEADER E-MAIL</div>
        <div class="campo"><label><input type="file" name="head" maxlength="400" value="<?php echo $rowEmp['smtp_login']; ?>" /></label></div>
        </div>
       
    
       
        <div class="linha">
        <div class="t_campo">SMTP SENHA</div>
        <div class="campo"><label><input name="smtp_senha" type="password" maxlength="100" value="<?php echo $rowEmp['smtp_senha']; ?>" /></label></div>
        </div>
        
        

    
       
        <div class="linha">
        <div class="t_campo">Site</div>
        <div class="campo"><label><input name="site" type="text" maxlength="70" value="<?php echo $rowEmp['site']; ?>" /></label></div>
        </div>
        
        
        <button type="submit">Atualizar Dados</button>
    
    </div>
                 
                
   
    
	</form>

</div>
















<!-- CONTEÚDO ACIMA -->

</div>
<?php include '../../include/painel/rodape.php' ?>