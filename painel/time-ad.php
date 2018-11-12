<?php 
if(isset($_POST['ACAO']) and $_POST['ACAO'] == 'ADICIONAR'){
	
	if($_POST['nome'] == ''){
		$aviso = 'Informe o título da notícia';
		echo "<script> alert('$aviso'); history.go(-1); </script>";
	
	}elseif($_POST['abreviacao'] == ''){
		$aviso = 'Informe a descrição da notícia';
		echo "<script> alert('$aviso'); history.go(-1); </script>";
	
	}else{

		include 'include/scripts/limpa_string.php';			// arquivo que limpa a string
		$filtro = array(' ' => '-' , '(' => '', ')' => '', '.' => '', ',' => '', '/' => '', ':' => '', '^' => '', '~' => '', ' - ' => '', '!' => '', '@' => '', '#' => '', '$' => '', '%' => '', '¨' => '', '&' => 'e', '*' => '', '_' => '-', '+' => '', '=' => '', '[' => '', '{' => '', '}' => '', ']' => '', 'ª' => 'a', 'º' => 'o', '¹' => '1', '²' => '2', '³' => '3', ';' => '', '"' => '', "'" => '', '¬' => '');
		$url 		= strtr($_POST['nome'], $filtro);		// retirando os espaços
		$url 		= strtolower(limpa_string($url));
				
		$nome		= addslashes($_POST['nome']);
		$apelido	= addslashes($_POST['apelido']);
		$abreviacao	= addslashes($_POST['abreviacao']);


		@$estadio	= addslashes($_POST['estadio']);
		$local 		= addslashes($_POST['estado']);
		
		$local 		= explode('.', $local);
		$pais	 	= $local[0];
		$estado 	= $local[1];

		
		function limpaHash($str){
			return strtr($str, array('#'=> ''));
		}
		$cor_prin	= addslashes(limpaHash($_POST['cor_prin']));
		$cor_sec	= addslashes(limpaHash($_POST['cor_sec']));
		$cor_ter	= addslashes(limpaHash($_POST['cor_ter']));
		
		
		// VERIFICANDO SE O CADASTRO JÁ EXISTE
		$query = "SELECT idTim FROM time WHERE nome='$nome'";
		$resultEx = mysql_query($query);
		if(mysql_num_rows($resultEx) > 0){
			echo "<script> alert('Provavelmente esta notícia já existe em nosso cadastro. Por favor verifique!'); history.go(-1); </script>";
		}
		//
		
		else{
		
			// Gravando informações principais
			$query = "	INSERT INTO time(
										nome,
										apelido,
										abreviacao,
										idPai,
										idUF,
										idEst,
										cor_prin,
										cor_sec,
										cor_ter,
										escudo)
								VALUES (
										'$nome',
										'$apelido',
										'$abreviacao',
										'$pais',
										'$estado',
										'$estadio',
										'$cor_prin',
										'$cor_sec',
										'$cor_ter',
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
			
		echo "<script> alert('$aviso'); location.href='".($_REQUEST['ORIGEM'] == '' ? 'times' : $_REQUEST['ORIGEM'])."'; </script>";
		
	}
}
?>

<link rel="stylesheet" href="include/js/chosen/chosen.min.css">
<link rel="stylesheet" type="text/css" href="lib/jquery-files/src/jquery-filestyle.css">

<div class="formulario">

    <form method="post" action="<?php echo $_SERVER['REQUEST_URI']?>" enctype="multipart/form-data">
    <input type="hidden" name="ORIGEM" value="<?= $_SERVER['HTTP_REFERER']?>" />
    <input type="hidden" name="ACAO" value="ADICIONAR" />
	<div class="area">
    
        <h2>INFOR&Ccedil;&Otilde;ES PRINCIPAIS</h2>
        <div class="linha">
          <div class="t_campo">*NOME</div>
        <div class="campo"> <label> <input name="nome" type="text" maxlength="100" /> </label> <br />
        </div>
      </div>


        <div class="linha">
          <div class="t_campo">*APELIDO</div>
        <div class="campo"> <label> <input name="apelido" type="text" maxlength="50"  /> </label> <br />
        </div>
      </div>
      
        <div class="linha">
          <div class="t_campo">*ABREVIA&Ccedil;&Atilde;O</div>
        <div class="campo"> <label> <input name="abreviacao" type="text" maxlength="3" onblur="this.value=this.value.toUpperCase()" /> </label> <br />
        </div>
      </div>
      
        <div class="linha">
          <div class="t_campo">*COR PRINCIPAL</div>
        <div class="campo cores"> <label> <input name="cor_prin" type="color" maxlength="7" value="#FFFFFF" onblur="this.value=this.value.toUpperCase()" /><span class="cor"></span> </label> <br />
        </div>
      </div>
      
        <div class="linha">
          <div class="t_campo">*COR SECUNDÁRIA</div>
        <div class="campo cores"> <label> <input name="cor_sec" type="color" maxlength="7" value="#FFFFFF" onblur="this.value=this.value.toUpperCase()" /><span class="cor"></span> </label> <br />
        </div>
      </div>
      
        <div class="linha">
          <div class="t_campo">*COR TERCEÁRIA</div>
        <div class="campo cores"> <label> <input name="cor_ter" type="color" maxlength="7" value="#FFFFFF" onblur="this.value=this.value.toUpperCase()" /><span class="cor"></span> </label> <br />
        </div>
      </div>
      
      
        <div class="linha">
          <div class="t_campo">*LOCAL</div>
        <div class="campo"> <label>
        	<select name="estado">
        		<option value="">SELECIONE UM</option>
        		<?php 
					$resPai = mysql_query("SELECT A.idPai, A.titulo, B.continente FROM pais A INNER JOIN continente B ON A.idCon=B.idCon WHERE A.ativo=1 AND B.ativo=1 ORDER BY continente, titulo") or die(mysql_error());
					while($rowPai = mysql_fetch_assoc($resPai)){
	        			$resLoc = mysql_query("SELECT idDis, distrito, sigla FROM pais_regiao_distrito WHERE ativo=1 AND idPai='$rowPai[idPai]' ORDER BY distrito") or die(mysql_error());
						echo "<optgroup label=\"$rowPai[titulo] ($rowPai[continente])\">";
						while($rowLoc = mysql_fetch_array($resLoc)){
							echo "<option value='$rowPai[idPai].$rowLoc[idDis]' title=\"$rowLoc[distrito]\">$rowLoc[sigla] </option>";
						}
						echo "</optgroup>";
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
					$resEstPai = mysql_query("SELECT A.idPai, A.titulo, B.continente FROM pais A INNER JOIN continente B ON A.idCon=B.idCon WHERE A.ativo=1 AND B.ativo=1 ORDER BY continente, titulo") or die(mysql_error());
					while($rowEstPai = mysql_fetch_assoc($resEstPai)){
						echo "<optgroup label=\"$rowEstPai[titulo] ($rowEstPai[continente])\">";
							$resEst = mysql_query("SELECT A.idEst, A.apelido, A.capacidade, B.distrito FROM estadio A INNER JOIN pais_regiao_distrito B ON A.idDis=B.idDis WHERE B.idPai='$rowEstPai[idPai]' ORDER BY B.distrito, capacidade DESC, A.apelido") or die(mysql_error());
							while($rowEst = mysql_fetch_array($resEst)){
								$capacidade = number_format($rowEst['capacidade'], 0, '', '.');
								echo "<option value='$rowEst[idEst]'>$rowEst[apelido] - $capacidade pessoas ($rowEst[distrito])</option>";
							}
						echo "</optgroup>";
					}
        		?>
        	</select>
        </label>
        </div>
      </div>
 
    
    
    
    
       
    
    <div class="area">
    
    	<h2> IMAGEM</h2>
        
        <div class="linha">
        <div class="t_campo"> IMAGEM </div>
        <div class="campo"> 
            <label> <input type="file" name="imagem1" size="20" maxlength="400" />  </label> 
            <br />
        	<span class="comentario"> Dimensões ideais: 400x300 px | Tamanho máximo de 1 MB</span>
		</div>
        </div>

	</div>
    
         
    <button type="submit">Cadastrar</button>      
          
        
    </form>
    
    
    

</div>
<script src="include/js/chosen/chosen.jquery.js"></script>
<script src="lib/jquery-files/src/jquery-filestyle.js"></script>
<script>
$("select").chosen({no_results_text: "Não encontramos", search_contains: true, width: "510px"});
$(":file").jfilestyle({buttonText: "Procurar", placeholder: "Nenhum arquivo selecionado", 'inputSize': '420px'});

$(function(){
	$('input[type=color]').change(function(e) {
		cor = $(this).val()
		$(this).next('span.cor').css('border-color', cor).addClass('escolhido').html(cor); 
    });
})
</script>
