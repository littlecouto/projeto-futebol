<?php 
if(isset($_POST['ACAO']) and $_POST['ACAO'] == 'ADICIONAR'){
	
	if($_POST['titulo'] == ''){
		$aviso = 'Informe o nome da �rea';
		echo "<script> alert('$aviso'); history.go(-1); </script>";
	
	}else{

		include 'include/scripts/limpa_string.php';			// arquivo que limpa a string
		$filtro = array(' ' => '-' , '(' => '', ')' => '', '.' => '', ',' => '', '/' => '', ':' => '', '^' => '', '~' => '', ' - ' => '', '!' => '', '@' => '', '#' => '', '$' => '', '%' => '', '�' => '', '&' => 'e', '*' => '', '_' => '-', '+' => '', '=' => '', '[' => '', '{' => '', '}' => '', ']' => '', '�' => 'a', '�' => 'o', '�' => '1', '�' => '2', '�' => '3', ';' => '', '"' => '', "'" => '', '�' => '');
		$url 		= strtr($_POST['titulo'], $filtro);		// retirando os espa�os
		$url 		= strtolower(limpa_string($url));
				
		$titulo		= addslashes($_POST['titulo']);
		$ordem		= addslashes($_POST['ordem']);
		
		// VERIFICANDO SE O CADASTRO J� EXISTE
		$query = "SELECT idAre FROM jogador_area WHERE titulo='$titulo'";
		$resultEx = mysql_query($query);
		if(mysql_num_rows($resultEx) > 0){
			echo "<script> alert('Esta �rea j� est� cadastrada'); history.go(-1); </script>";
			exit;
		}
		//
		
		else{
		
			// Gravando informa��es principais
			$query = "	INSERT INTO jogador_area(
										titulo,
										ordem,
										url,
										ativo)
								VALUES (
										'$titulo',
										'$ordem',
										'$url',
										'1')";
							
			$gravou = mysql_query($query) or die(mysql_error());
			
		
		// PAINEL HIST�RICO
		$query = addslashes($query);
		mysql_query("INSERT INTO painel_historico(idUsu, acao, query) VALUE('$_SESSION[USUARIO]', 'INSERT', '$query')") or die (mysql_error());
		//
		
		}
		
		// Verificando a grava��o
		if($gravou == false) $aviso='Houve um erro no cadastro!';
		if($gravou == true){
			
			
			$aviso='Cadastro efetuado com sucesso!';
			  
	  		// UPLOAD DA IMAGEM
			if($_FILES["imagem1"]['size'] > 0){ // Verificando se a imagem foi realmente selecionada
			
				// Aqui incluimos a classe 
				include('include/classes/upload.class.php'); 
				//
			
				// Resgatando o nome da imagem
				$row = mysql_fetch_array(mysql_query("SELECT idTim, escudo FROM times ORDER BY idTim DESC LIMIT 1"));
				$nomeImg = $row['escudo'];
				//
				
				// Instanciamos o objeto Upload   
				$handle = '';
				$handle = new Upload($_FILES["imagem1"]);   
				// 
				
				// Ent�o verificamos se o arquivo foi carregado corretamente    
				if ($handle->uploaded) {    
					// Aqui nos devifimos nossas configura��es de imagem       
					$handle->image_resize           = true; 		// redimensinoar    
					$handle->image_ratio_x        	= true;			// dimensionar largura na propor��o
					$handle->image_ratio_y     	 	= false;		// dimensionar altura na propor��o
					//$handle->image_x             	= 400;			// largura 
					$handle->image_y       			= 300;			// altura 
					$handle->image_convert 			= 'png';		// converte para JPG
					$handle->jpeg_quality           = 85;			// qualidade
					$handle->file_new_name_body     = $nomeImg;		// nome do arquivo da imagem
					$handle->process($DirTime);						// Pasta onde a imagem ser� armazenada				
					$handle-> Clean();								// Excluir os arquivos temporarios
					
				}else{ // Caso Erro
					$aviso = "Erro ao gravar o arquivo!"; 		
					echo "<script> alert('$aviso'); </script>";
				} 
		
			}
			// FIM UPLOAD
			  
		}
			
		echo "<script> alert('$aviso'); location.href='".($_REQUEST['ORIGEM'] == '' ? 'distritos-sub' : $_REQUEST['ORIGEM'])."'; </script>";
		
	}
}
?>

<link rel="stylesheet" href="include/js/chosen/chosen.min.css">

<div class="formulario">

    <form method="post" action="<?php echo $_SERVER['REQUEST_URI']?>" enctype="multipart/form-data">
    <input type="hidden" name="ACAO" value="ADICIONAR" />
    <input type="hidden" name="ORIGEM" value="<?= $_SERVER['HTTP_REFERER']?>" />
	<div class="area">
    
        <h2>INFOR&Ccedil;&Otilde;ES PRINCIPAIS</h2>
        <div class="linha">
          <div class="t_campo">*&Aacute;REA</div>
        <div class="campo"> <label> <input name="titulo" type="text" maxlength="100" /> </label> <br />
        </div>
      </div>


        <div class="linha">
          <div class="t_campo">ORDEM</div>
        <div class="campo"> <label> <input name="ordem" type="text" maxlength="4" /> </label> <br />
        </div>
      </div>


      
      

      
    </div>
    
    
    
    
    
    
    
       
    
    <!--<div class="area">
    
    	<h2> IMAGEM</h2>
        
        <div class="linha">
        <div class="t_campo"> IMAGEM </div>
        <div class="campo"> 
        	<font size="1"> Dimens�es ideais: 400x300 px | Tamanho m�ximo de 1 MB</font>
            <br />
            <label> <input type="file" name="imagem1" size="20" maxlength="400" />  </label> 
		</div>
        </div>

	</div>-->
    
         
    <button type="submit">Cadastrar</button>      
          
        
    </form>
    
    
<script src="include/js/chosen/chosen.jquery.js"></script>
<script>
	$("select").chosen({no_results_text: "N�o encontramos", search_contains: true, width: "510px"});
</script>
</div>