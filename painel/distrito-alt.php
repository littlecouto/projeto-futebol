
<?php
if($_REQUEST['id'] == 0){
	$aviso = "Registro não encontrado!";
	echo "<script> alert('$aviso'); window.history.go(-1); </script>";	
	
	
}elseif($_REQUEST['id'] > 0 && @$_POST['ACAO'] == ''){
	
	// Resgatando os dados atuais 
	$row = mysql_fetch_array(mysql_query("SELECT * FROM pais_regiao_distrito WHERE idDis='$_REQUEST[id]'"));
	@$_POST['nome']			= stripslashes($_POST['nome']);
	@$_POST['descricao'] 	= stripslashes($_POST['descricao']);
	
}elseif($_REQUEST['id'] > 0 && $_POST['ACAO'] == 'ATUALIZAR'){
	$row = mysql_fetch_array(mysql_query("SELECT * FROM pais_regiao_distrito WHERE idDis='$_REQUEST[id]'"));
	
	if($_POST['titulo'] == ''){
		$aviso = 'Informe o nome da região';
		echo "<script> alert('$aviso'); history.go(-1); </script>";
	
	}elseif($_POST['pais'] <1){
		$aviso = 'Informe o país';
		echo "<script> alert('$aviso'); history.go(-1); </script>";
	
	}elseif($_POST['regiao'] <1){
		$aviso = 'Informe a regiao';
		echo "<script> alert('$aviso'); history.go(-1); </script>";
	
	}elseif($_POST['sigla2'] == ''){
		$aviso = 'Informe a sigla de duas letras';
		echo "<script> alert('$aviso'); history.go(-1); </script>";

	}else{
		
		
		include 'include/scripts/limpa_string.php';			// arquivo que limpa a string
		$filtro = array(' ' => '-' , '(' => '', ')' => '', '.' => '', ',' => '', '/' => '', ':' => '', '^' => '', '~' => '', ' - ' => '', '!' => '', '@' => '', '#' => '', '$' => '', '%' => '', '¨' => '', '&' => 'e', '*' => '', '_' => '-', '+' => '', '=' => '', '[' => '', '{' => '', '}' => '', ']' => '', 'ª' => 'a', 'º' => 'o', '¹' => '1', '²' => '2', '³' => '3', ';' => '', '"' => '', "'" => '', '¬' => '');
		$url 		= strtr($_POST['titulo'], $filtro);		// retirando os espaços
		$url 		= strtolower(limpa_string($url));
				
		$titulo		= addslashes($_POST['titulo']);
		$sigla		= addslashes($_POST['sigla2']);
		$pais		= addslashes($_POST['pais']);
		$regiao		= addslashes($_POST['regiao']);
		$ordem 		= addslashes($_POST['ordem']);
		
		$sigla 		= mb_convert_case($sigla, MB_CASE_UPPER, 'ISO-8859-1');

		
		// VERIFICAR SE JÁ EXISTE O ATUAL USUÁRIO ATUAL
		$qtdeUsu = mysql_query("SELECT idDis FROM pais_regiao_distrito WHERE titulo='$titulo' AND (idPai='$pais' OR idReg='$regiao') AND idDis<>$_REQUEST[id]");
		if(mysql_num_rows($qtdeUsu)>0){
			echo "<script> alert('Este distrito já está cadastrada neste país ou nesta região'); history.go(-1); </script>";
			exit;
		}
		//
		
		// Gravando os dados
		$query = "	UPDATE	pais_regiao_distrito
					SET 	idPai='$pais',
							idReg='$regiao',
							distrito='$titulo',
							sigla='$sigla',
							ordem='$ordem',
							url='$url'
					WHERE 	idDis='$_REQUEST[id]' 
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
			
			
			
			// UPLOAD DA IMAGEM
			if($_FILES["escudo"]['size'] > 0){ // Verificando se a imagem foi realmente selecionada
			
				// Aqui incluimos a classe 
				include('include/classes/upload.class.php'); 
				//
			
				// Resgatando o nome da imagem
				$row = mysql_fetch_array(mysql_query("SELECT idTim, escudo FROM times WHERE idTim=$_REQUEST[id]"));
				$nomeImg = $row['escudo'];
				//
				
				// Excluir imagem antiga
				if(file_exists($escudoAt)){
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
					$handle->image_ratio_x        	= false;			// dimensionar largura na proporção
					$handle->image_ratio_y     	 	= true;		// dimensionar altura na proporção
					$handle->image_x             	= 300;			// largura 
					//$handle->image_y       		= 300;			// altura 
					$handle->image_convert 			= 'png';		// converte para JPG
					$handle->jpeg_quality           = 85;			// qualidade
					$handle->file_new_name_body     = $nomeImg;		// nome do arquivo da imagem
					$handle->process($DirTime);					// Pasta onde a imagem será armazenada				
					$handle-> Clean();								// Excluir os arquivos temporarios
					
				}else{ // Caso Erro
					$aviso = "Erro ao gravar o arquivo!"; 		
					echo "<script> alert('$aviso'); </script>";
				} 
		
			}else{
				// Excluir imagem antiga
				if(file_exists($escudoAt)){
					rename($escudoAt, $DirTime.'/'.$url.'.png');
				}
				//

			}
			// FIM UPLOAD
			
			
		}
		echo "<script> alert('$aviso'); location.href='".($_REQUEST['ORIGEM'] == '' ? 'distritos' : $_REQUEST['ORIGEM'])."'; </script>";
	}
}
?>
<link rel="stylesheet" href="include/js/chosen/chosen.min.css">

<script type="text/javascript">
// DEL IMAGEM
function DelImg(id){
	decisao = confirm("Deseja mesmo excluir esta imagem?");
	
	if(decisao){
		location.href='del_noticia_img.php?id='+id;
	}
}
</script>


<!-- Fim TinyMCE -->
<div class="formulario">

    <form method="post" action="<?php echo $_SERVER['REQUEST_URI']?>" enctype="multipart/form-data">
        <input type="hidden" name="ORIGEM" value="<?= $_SERVER['HTTP_REFERER']?>" />
        <input type="hidden" name="id" value="<?php echo $_REQUEST['id'] ?>" />
        <input type="hidden" name="ACAO" value="ATUALIZAR" />
	<div class="area">
    
        <h2>INFOR&Ccedil;&Otilde;ES PRINCIPAIS</h2>
        <div class="linha">
          <div class="t_campo">*DISTRITO</div>
        <div class="campo"> <label> <input name="titulo" type="text" maxlength="100" value="<?=$row['distrito']?>" /> </label> <br />
        </div>
      </div>



        <div class="linha">
          <div class="t_campo">*PA&Itilde;S</div>
        <div class="campo"> <label> 
        	<select name="pais" data-placeholder="Selecione um pa&iacute;s">
            	<option value=""></option>
                
                <?php
                $resPai = mysql_query("SELECT idPai, titulo FROM pais WHERE ativo=1 ORDER BY ordem") or die(mysql_error());
				while($rowPai = mysql_fetch_array($resPai)){
					echo "<option value=\"$rowPai[idPai]\" ".($rowPai['idPai'] == $row['idPai'] ? 'selected' : '').">$rowPai[titulo]</option>";
				}

				?>
            </select> 
        </label> <br />
        </div>
      </div>
      


        <div class="linha">
          <div class="t_campo">*REGI&Atilde;O</div>
        <div class="campo"> <label> 
        	<select name="regiao" data-placeholder="Selecione uma regi&atilde;o">
            	<option value=""></option>
                
                <?php
                $resReg = mysql_query("SELECT idReg, titulo FROM pais_regiao WHERE ativo=1 ORDER BY ordem") or die(mysql_error());
				while($rowReg = mysql_fetch_array($resReg)){
					echo "<option value=\"$rowReg[idReg]\" ".($rowReg['idReg'] == $row['idReg'] ? 'selected' : '').">$rowReg[titulo]</option>";
				}

				?>
            </select> 
        </label> <br />
        </div>
      </div>
      
      
        <div class="linha">
          <div class="t_campo">*SIGLA 2 LETRAS</div>
        <div class="campo"> <label> <input name="sigla2" type="texto" maxlength="2" onblur="this.value=this.value.toUpperCase()" value="<?=$row['sigla']?>" /> </label> <br />
        </div>
      </div>


        <div class="linha">
          <div class="t_campo">ORDEM</div>
        <div class="campo"> <label> <input name="ordem" type="text" maxlength="4" value="<?=$row['ordem']?>" /> </label> <br />
        </div>
      </div>
      

    
    
         
    <button type="submit">Atualizar Informações</button>      
          
        
    </form>
    
    
    
<script src="include/js/chosen/chosen.jquery.js"></script>
<script>
	$("select").chosen({no_results_text: "Não encontramos", search_contains: true, width: "510px"});
</script>

