<?php 
if(isset($_POST['ACAO']) and $_POST['ACAO'] == 'ADICIONAR'){
	
	if($_POST['titulo'] == ''){
		$aviso = 'Informe o nome do país';
		echo "<script> alert('$aviso'); history.go(-1); </script>";
	
	}elseif($_POST['sigla2'] == ''){
		$aviso = 'Informe a sigla de duas letras';
		echo "<script> alert('$aviso'); history.go(-1); </script>";
	
	}elseif($_POST['sigla3'] == ''){
		$aviso = 'Informe a sigla de três letras';
		echo "<script> alert('$aviso'); history.go(-1); </script>";
	
	}elseif($_POST['continente'] == ''){
		$aviso = 'Informe a continente';
		echo "<script> alert('$aviso'); history.go(-1); </script>";
	
	}else{

		include 'include/scripts/limpa_string.php';			// arquivo que limpa a string
		$filtro = array(' ' => '-' , '(' => '', ')' => '', '.' => '', ',' => '', '/' => '', ':' => '', '^' => '', '~' => '', ' - ' => '', '!' => '', '@' => '', '#' => '', '$' => '', '%' => '', '¨' => '', '&' => 'e', '*' => '', '_' => '-', '+' => '', '=' => '', '[' => '', '{' => '', '}' => '', ']' => '', 'ª' => 'a', 'º' => 'o', '¹' => '1', '²' => '2', '³' => '3', ';' => '', '"' => '', "'" => '', '¬' => '');
		$url 		= strtr($_POST['titulo'], $filtro);		// retirando os espaços
		$url 		= strtolower(limpa_string($url));
				
		$titulo		= addslashes($_POST['titulo']);
		$continente	= addslashes($_POST['continente']);
		$sigla2		= addslashes($_POST['sigla2']);
		$sigla3		= addslashes($_POST['sigla3']);
		$codigo 	= addslashes($_POST['codigo']);
		$ordem 		= addslashes($_POST['ordem']);
		
		// VERIFICANDO SE O CADASTRO JÁ EXISTE
		$query = "SELECT idPai FROM pais WHERE titulo='$titulo' OR codigo='$codigo'";
		$resultEx = mysql_query($query);
		if(mysql_num_rows($resultEx) > 0){
			echo "<script> alert('Este país ou este código já estão cadastrados'); history.go(-1); </script>";
			exit;
		}
		//
		
		else{
		
			// Gravando informações principais
			$query = "	INSERT INTO pais(
										idCon,
										titulo,
										sigla_2,
										sigla_3,
										codigo,
										ordem,
										url,
										ativo)
								VALUES (
										'$continente',
										'$titulo',
										'$sigla2',
										'$sigla3',
										'$codigo',
										'$ordem',
										'$url',
										'1')";
							
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
			
		echo "<script> alert('$aviso'); location.href='".($_REQUEST['ORIGEM'] == '' ? 'paises' : $_REQUEST['ORIGEM'])."'; </script>";
		
	}
}
?>

<link rel="stylesheet" type="text/css" media="screen,projection" href="include/js/mapas/cssmap-continents/cssmap-continents.css" />

<div class="formulario">

    <form method="post" action="<?php echo $_SERVER['REQUEST_URI']?>" enctype="multipart/form-data">
    <input type="hidden" name="ORIGEM" value="<?= $_SERVER['HTTP_REFERER']?>" />
    <input type="hidden" name="ACAO" value="ADICIONAR" />
	<div class="area">
    
        <h2>INFOR&Ccedil;&Otilde;ES PRINCIPAIS</h2>
        <div class="linha">
          <div class="t_campo">*NOME</div>
        <div class="campo"> <label> <input name="titulo" type="text" maxlength="100" /> </label> <br />
        </div>
      </div>


        <div class="linha">
          <div class="t_campo">*SIGLA 2 LETRAS</div>
        <div class="campo"> <label> <input name="sigla2" type="text" maxlength="2" onblur="this.value=this.value.toUpperCase()" /> </label> <br />
        </div>
      </div>
      
        <div class="linha">
          <div class="t_campo">*SIGLA 3 LETRAS</div>
        <div class="campo"> <label> <input name="sigla3" type="texto" maxlength="3" onblur="this.value=this.value.toUpperCase()" /> </label> <br />
        </div>
      </div>

        <div class="linha">
          <div class="t_campo">C&Oacute;DIGO ISO</div>
        <div class="campo"> <label> <input name="codigo" type="text" maxlength="3" onblur="this.value=this.value.toUpperCase()" /> </label> <br />
        </div>
      </div>

        <div class="linha">
          <div class="t_campo">ORDEM</div>
        <div class="campo"> <label> <input name="ordem" type="text" maxlength="4" onblur="this.value=this.value.toUpperCase()" /> </label> <br />
        </div>
      </div>
      

        <div class="linha">
          <div class="t_campo continente">*CONTINENTE</div>
        <div class="campo"> 
		<div id="map-continents">
            <ul class="continents">
                <li class="c1" data-id="1"><a href="javascript:void(0)">África</a></li>
                <li class="c2" data-id="2"><a href="javascript:void(0)">Ásia</a></li>
                <li class="c3" data-id="3"><a href="javascript:void(0)">Oceânia</a></li>
                <li class="c4" data-id="4"><a href="javascript:void(0)">Europa</a></li>
                <li class="c5" data-id="5"><a href="javascript:void(0)">América do Norte e Central</a></li>
                <li class="c6" data-id="6"><a href="javascript:void(0)">América do Sul</a></li>
            </ul>
        </div>
      
	<label style="display: none">
        		<?php 
        			$resCon = mysql_query("SELECT idCon, continente FROM continente WHERE FIELD(continente, 'África', 'Ásia', 'Oceânia', 'Europa', 'América do Norte', 'América do Sul')>0 ORDER BY FIELD(continente, 'África', 'Ásia', 'Oceânia', 'Europa', 'América do Norte', 'América do Sul')") or die(mysql_error());
        			$i = 0;
					while($rowCon = mysql_fetch_array($resCon)){
						$i++;
         				echo "<input type=\"radio\" name=\"continente\" value='$rowCon[idCon]' data-id=\"$i\">";
        			}
        		?>
        </label>
        </div>
      </div>
      
    </div>
    
    
    
    
    
    
    
       
    
    <!--<div class="area">
    
    	<h2> IMAGEM</h2>
        
        <div class="linha">
        <div class="t_campo"> IMAGEM </div>
        <div class="campo"> 
        	<font size="1"> Dimensões ideais: 400x300 px | Tamanho máximo de 1 MB</font>
            <br />
            <label> <input type="file" name="imagem1" size="20" maxlength="400" />  </label> 
		</div>
        </div>

	</div>-->
    
         
    <button type="submit">Cadastrar</button>      
          
        
    </form>
    
    
	<script src="include/js/mapas/jquery.cssmap.js"></script>
	<script>
		$('#map-continents').cssMap({
			'size': 540,        // set map size to 750px wide;
			'tooltips': true,  // hide tooltips;
			'cities': false      // display cities;
			});
		$('#map-continents li').click(function(){
			id = $(this).attr('data-id');
			
			$('input[type=radio][data-id='+id+']').prop('checked', true);
		});
    </script>
</div>