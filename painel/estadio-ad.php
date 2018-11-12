<?php 
if(isset($_POST['ACAO']) and $_POST['ACAO'] == 'ADICIONAR'){
	
	if($_POST['titulo'] == ''){
		$aviso = 'Informe o nome do estádio';
		echo "<script> alert('$aviso'); history.go(-1); </script>";
	
	}elseif($_POST['apelido'] == ''){
		$aviso = 'Informe apelido do estádio';
		echo "<script> alert('$aviso'); history.go(-1); </script>";
	
	}elseif($_POST['distrito'] <1){
		$aviso = 'Informe o país';
		echo "<script> alert('$aviso'); history.go(-1); </script>";
	
	}elseif($_POST['capacidade'] < 1){
		$aviso = 'Informe a capacidade do estádio';
		echo "<script> alert('$aviso'); history.go(-1); </script>";
	
	}elseif($_POST['reputacao'] < 1){
		$aviso = 'Informe a reputação do estádio';
		echo "<script> alert('$aviso'); history.go(-1); </script>";
	
	}else{

		include 'include/scripts/limpa_string.php';			// arquivo que limpa a string
		$filtro = array(' ' => '-' , '(' => '', ')' => '', '.' => '', ',' => '', '/' => '', ':' => '', '^' => '', '~' => '', ' - ' => '', '!' => '', '@' => '', '#' => '', '$' => '', '%' => '', '¨' => '', '&' => 'e', '*' => '', '_' => '-', '+' => '', '=' => '', '[' => '', '{' => '', '}' => '', ']' => '', 'ª' => 'a', 'º' => 'o', '¹' => '1', '²' => '2', '³' => '3', ';' => '', '"' => '', "'" => '', '¬' => '');
		$url 		 = strtr($_POST['titulo'], $filtro);		// retirando os espaços
		$url 		 = strtolower(limpa_string($url));
				
		$titulo		 = addslashes($_POST['titulo']);
		$apelido	 = addslashes($_POST['apelido']);

		$capacidade	 = addslashes($_POST['capacidade']);
		$reputacao	 = addslashes($_POST['reputacao']);

		$local		 = addslashes($_POST['distrito']);
		$subdistrito = addslashes($_POST['subdistrito']);

		
		$local 		 = explode('.', $local);
		$pais	 	 = $local[0];
		$distrito 	 = $local[1];
		
		// VERIFICANDO SE O CADASTRO JÁ EXISTE
		$query = "SELECT idEst FROM estadio WHERE titulo='$titulo' AND (idPai='$pais' OR idReg='$regiao')";
		$resultEx = mysql_query($query);
		if(mysql_num_rows($resultEx) > 0){
			echo "<script> alert('Este estádio já está cadastrada neste país ou nesta região'); history.go(-1); </script>";
			exit;
		}
		//
		
		else{
		
			// Gravando informações principais
			$query = "	INSERT INTO estadio(
										idPai,
										idDis,
										idSub,
										nome,
										apelido,
										capacidade,
										reputacao,
										url,
										ativo)
								VALUES (
										'$pais',
										'$distrito',
										'$subdistrito',
										'$titulo',
										'$apelido',
										'$capacidade',
										'$reputacao',
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
			
		echo "<script> alert('$aviso'); location.href='".($_REQUEST['ORIGEM'] == '' ? 'distritos' : $_REQUEST['ORIGEM'])."'; </script>";
		
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
          <div class="t_campo">*NOME</div>
        <div class="campo"> <label> <input name="titulo" type="text" maxlength="100" /> </label> <br />
        </div>
      </div>

        <div class="linha">
          <div class="t_campo">*APELIDO</div>
        <div class="campo"> <label> <input name="apelido" type="text" maxlength="100" /> </label> <br />
        </div>
      </div>


        <div class="linha">
          <div class="t_campo">*DISTRITO</div>
        <div class="campo"> <label>
        	<select name="distrito">
        		<option value="">SELECIONE UM</option>
        		<?php 
					$resPai = mysql_query("SELECT A.idPai, A.titulo, B.continente FROM pais A INNER JOIN continente B ON A.idCon=B.idCon WHERE A.ativo=1 AND B.ativo=1 ORDER BY continente, titulo") or die(mysql_error());
					while($rowPai = mysql_fetch_assoc($resPai)){
	        			$resDis = mysql_query("SELECT idDis, distrito, sigla FROM pais_regiao_distrito WHERE ativo=1 AND idPai='$rowPai[idPai]' ORDER BY distrito") or die(mysql_error());
						echo "<optgroup label=\"$rowPai[titulo] ($rowPai[continente])\">";
						while($rowDis = mysql_fetch_array($resDis)){
							echo "<option value='$rowPai[idPai].$rowDis[idDis]' ".($row['idDis'] === $rowDis['idDis']?'selected ':'')." title=\"$rowDis[distrito]\">$rowDis[distrito] </option>";
						}
						echo "</optgroup>";
					}
        		?>
        	</select>
        </label>
        </div>
      </div>

        <div class="linha">
          <div class="t_campo">SUB DISTRITO</div>
        <div class="campo"> <label>
        	<select name="subdistrito">
        		<option value="">SELECIONE UM</option>
        		<?php 
					$resSub = mysql_query("SELECT idDis, idSub, titulo FROM pais_regiao_distrito_sub WHERE ativo=1 ORDER BY titulo") or die(mysql_error());
					while($rowSub = mysql_fetch_assoc($resSub)){
						echo "<option value='$rowSub[idSub]' ".($row['idSub'] == $rowSub['idSub']?'selected ':'')." ".($row['idDis'] != $rowSub['idDis']?'disabled':'')." data-id=\"$rowSub[idDis]\">$rowSub[titulo] </option>";
					}
        		?>
        	</select>
        </label>
        </div>
      </div>




      
        <div class="linha">
          <div class="t_campo">*CAPACIDADE</div>
        <div class="campo"> <label> <input name="capacidade" type="text" maxlength="6" /> </label> <br />
        </div>
      </div>


        <div class="linha">
          <div class="t_campo">*REPUTA&Ccedil;&Atilde;O</div>
        <div class="campo"> <label> <input name="reputacao" type="text" maxlength="1" /> </label> <br />
        <font style="width:	100%; float: left; font: normal 13px/1.5 Calibri">1 - Horr&iacute;vel; 10 - &Oacute;timo</font>
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
    
    
<script src="include/js/chosen/chosen.jquery.js"></script>
<script>
	$("select").chosen({no_results_text: "Não encontramos", search_contains: true, width: "510px"});
	$('select[name=distrito]').change(function(e) {
		var $this 	= $(this),
			valor 	= $this.val(),
			option 	= $('select[name=subdistrito] option'),
			id 		= valor.split('.'),
			id 		= id[1],
			opt;
		
		
		option.each(function() {
			opt = $(this);
			if(opt.attr('data-id') == id){
				opt.prop('disabled', false);
			}else{
				opt.prop('disabled', true);
			}
        });
		$('select[name=subdistrito]').val('').trigger("chosen:updated");
		
		
    });
</script>
</div>