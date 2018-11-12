
<?php
if($_REQUEST['id'] == 0){
	$aviso = "Registro não encontrado!";
	echo "<script> alert('$aviso'); window.history.go(-1); </script>";	
	
	
}elseif($_REQUEST['id'] > 0 && @$_POST['ACAO'] == ''){
	
	// Resgatando os dados atuais 
	$row = mysql_fetch_array(mysql_query("SELECT * FROM pais_regiao_distrito_sub WHERE idSub='$_REQUEST[id]'"));
	@$_POST['nome']			= stripslashes($_POST['nome']);
	@$_POST['descricao'] 	= stripslashes($_POST['descricao']);
	
}elseif($_REQUEST['id'] > 0 && $_POST['ACAO'] == 'ATUALIZAR'){
	$row = mysql_fetch_array(mysql_query("SELECT * FROM pais_regiao_distrito_sub WHERE idSub='$_REQUEST[id]'"));
	
	if($_POST['titulo'] == ''){
		$aviso = 'Informe o nome da região';
		echo "<script> alert('$aviso'); history.go(-1); </script>";
	
	}elseif($_POST['distrito'] == ''){
		$aviso = 'Informe o distrito';
		echo "<script> alert('$aviso'); history.go(-1); </script>";
	
	}else{
		
		
		include 'include/scripts/limpa_string.php';			// arquivo que limpa a string
		$filtro = array(' ' => '-' , '(' => '', ')' => '', '.' => '', ',' => '', '/' => '', ':' => '', '^' => '', '~' => '', ' - ' => '', '!' => '', '@' => '', '#' => '', '$' => '', '%' => '', '¨' => '', '&' => 'e', '*' => '', '_' => '-', '+' => '', '=' => '', '[' => '', '{' => '', '}' => '', ']' => '', 'ª' => 'a', 'º' => 'o', '¹' => '1', '²' => '2', '³' => '3', ';' => '', '"' => '', "'" => '', '¬' => '');
		$url 		= strtr($_POST['titulo'], $filtro);		// retirando os espaços
		$url 		= strtolower(limpa_string($url));
				
		$titulo		= addslashes($_POST['titulo']);
		$distrito	= addslashes($_POST['distrito']);
		
		// VERIFICAR SE JÁ EXISTE O ATUAL USUÁRIO ATUAL
		$qtdeUsu = mysql_query("SELECT idSub FROM pais_regiao_distrito_sub WHERE titulo='$titulo' AND idDis='$distrito' AND idSub<>$_REQUEST[id]");
		if(mysql_num_rows($qtdeUsu)>0){
			echo "<script> alert('Este sub distrito já está cadastrado neste distrito'); history.go(-1); </script>";
			exit;
		}
		//
		
		// Gravando os dados
		$query = "	UPDATE	pais_regiao_distrito_sub
					SET 	idDis='$distrito',
							titulo='$titulo',
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
					
		echo "<script> alert('$aviso'); location.href='".($_REQUEST['ORIGEM'] == '' ? 'distritos-sub' : $_REQUEST['ORIGEM'])."'; </script>";
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
          <div class="t_campo">*SUB DISTRITO</div>
        <div class="campo"> <label> <input name="titulo" type="text" maxlength="100" value="<?=$row['titulo']?>" /> </label> <br />
        </div>
      </div>



      
      
        <div class="linha">
          <div class="t_campo">*DISTRITO</div>
        <div class="campo"> <label> 
        	<select name="distrito" data-placeholder="Selecione um distrito">
            	<option value=""></option>
                
                <?php
                $resPai = mysql_query("SELECT idPai, titulo FROM pais WHERE ativo=1 ORDER BY ordem") or die(mysql_error());
				while($rowPai = mysql_fetch_array($resPai)){
					echo "<optgroup label=\"$rowPai[titulo]\">";
					
					$resReg = mysql_query("SELECT idDis, distrito FROM pais_regiao_distrito WHERE ativo=1 AND idPai='$rowPai[idPai]' ORDER BY ordem") or die(mysql_error());
					while($rowReg = mysql_fetch_array($resReg)){
						echo "<option value=\"$rowReg[idDis]\" ".($rowReg['idDis'] == $row['idDis'] ? 'selected': '').">$rowReg[distrito]</option>";
					}
					echo "</optgroup>";
				}
				?>
            </select> 
        </label> <br />
        </div>
      </div>
      

    
    
         
    <button type="submit">Atualizar Informações</button>      
          
        
    </form>
    
    
    
<script src="include/js/chosen/chosen.jquery.js"></script>
<script>
	$("select").chosen({no_results_text: "Não encontramos", search_contains: true, width: "510px"});
</script>

