
<?php
if($_REQUEST['id'] == 0){
	$aviso = "Registro n�o encontrado!";
	echo "<script> alert('$aviso'); window.history.go(-1); </script>";	
	
	
}elseif($_REQUEST['id'] > 0 && @$_POST['ACAO'] == ''){
	
	// Resgatando os dados atuais 
	$row = mysql_fetch_array(mysql_query("SELECT * FROM jogador_funcao WHERE idFun='$_REQUEST[id]'"));
	@$_POST['nome']			= stripslashes($_POST['nome']);
	@$_POST['descricao'] 	= stripslashes($_POST['descricao']);
	
}elseif($_REQUEST['id'] > 0 && $_POST['ACAO'] == 'ATUALIZAR'){
	$row = mysql_fetch_array(mysql_query("SELECT * FROM jogador_funcao WHERE idFun='$_REQUEST[id]'"));
	
	if($_POST['titulo'] == ''){
		$aviso = 'Informe o nome da fun��o';
		echo "<script> alert('$aviso'); history.go(-1); </script>";
	
	}elseif($_POST['sigla'] == ''){
		$aviso = 'Informe a sigla';
		echo "<script> alert('$aviso'); history.go(-1); </script>";
	
	}elseif(count($_POST['caracteristicas']) <1){
		$aviso = 'Informe ao menos uma caracter�stica';
		echo "<script> alert('$aviso'); history.go(-1); </script>";
	
	}else{
		
		
		include 'include/scripts/limpa_string.php';			// arquivo que limpa a string
		$filtro = array(' ' => '-' , '(' => '', ')' => '', '.' => '', ',' => '', '/' => '', ':' => '', '^' => '', '~' => '', ' - ' => '', '!' => '', '@' => '', '#' => '', '$' => '', '%' => '', '�' => '', '&' => 'e', '*' => '', '_' => '-', '+' => '', '=' => '', '[' => '', '{' => '', '}' => '', ']' => '', '�' => 'a', '�' => 'o', '�' => '1', '�' => '2', '�' => '3', ';' => '', '"' => '', "'" => '', '�' => '');
		$url 		= strtr($_POST['titulo'], $filtro);		// retirando os espa�os
		$url 		= strtolower(limpa_string($url));
				
				
		$titulo				= addslashes($_POST['titulo']);
		$sigla				= addslashes($_POST['sigla']);
		$ordem				= addslashes($_POST['ordem']);
		$caracteristicas	= $_POST['caracteristicas'];
		

		// VERIFICAR SE J� EXISTE O ATUAL USU�RIO ATUAL
		$qtdeUsu = mysql_query("SELECT idFun FROM jogador_funcao WHERE titulo='$titulo' AND idFun<>$_REQUEST[id]");
		if(mysql_num_rows($qtdeUsu)>0){
			echo "<script> alert('Esta fun��o j� est� cadastrada'); history.go(-1); </script>";
			exit;
		}
		//
		
		// Gravando os dados
		$query = "	UPDATE	jogador_funcao
					SET 	titulo='$titulo',
							sigla='$sigla',
							ordem='$ordem',
							url='$url'
					WHERE 	idFun='$_REQUEST[id]' 
					LIMIT 1";
		$gravou = mysql_query($query) or die(mysql_error());
		
		
		// PAINEL HIST�RICO
		$query = addslashes($query);
		mysql_query("INSERT INTO painel_historico(idUsu, acao, query) VALUE('$_SESSION[USUARIO]', 'UPDATE', '$query')") or die (mysql_error());
		//
		
		
		
	
		// Verificando a grava��o
		if($gravou==false)	$aviso="Houve um erro ao atualizar os dados!";
		if($gravou==true){
			$aviso="Dados atualizados com sucesso!";
			
			$idFun = $_REQUEST['id'];
			
			mysql_query("DELETE FROM jogador_caracteristica_funcao WHERE idFun='$idFun'") or die(mysql_error());
			
			foreach($caracteristicas as $caracteristica){
				$caracteristica = addslashes($caracteristica);
				
				$query = "	INSERT INTO jogador_caracteristica_funcao(
											idCar,
											idFun,
											ativo)
									VALUES (
											'$caracteristica',
											'$idFun',
											'1')";
				$gravou = mysql_query($query) or die(mysql_error());
				
				
				// PAINEL HIST�RICO
				$query = addslashes($query);
				mysql_query("INSERT INTO painel_historico(idUsu, acao, query) VALUE('$_SESSION[USUARIO]', 'INSERT', '$query')") or die (mysql_error());
				//
			}
			
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
				
				// Ent�o verificamos se o arquivo foi carregado corretamente    
				if ($handle->uploaded) {    
					// Aqui nos devifimos nossas configura��es de imagem       
					$handle->image_resize           = true; 		// redimensinoar    
					$handle->image_ratio_x        	= false;			// dimensionar largura na propor��o
					$handle->image_ratio_y     	 	= true;		// dimensionar altura na propor��o
					$handle->image_x             	= 300;			// largura 
					//$handle->image_y       		= 300;			// altura 
					$handle->image_convert 			= 'png';		// converte para JPG
					$handle->jpeg_quality           = 85;			// qualidade
					$handle->file_new_name_body     = $nomeImg;		// nome do arquivo da imagem
					$handle->process($DirTime);					// Pasta onde a imagem ser� armazenada				
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
          <div class="t_campo">*FUN&Ccedil;&Atilde;O</div>
        <div class="campo"> <label> <input name="titulo" type="text" maxlength="100" value="<?=$row['titulo']?>" /> </label> <br />
        </div>
      </div>



        <div class="linha">
            <div class="t_campo">SIGLA</div>
            <div class="campo"> <label> <input name="sigla" type="text" maxlength="3" value="<?=$row['sigla']?>" /> </label> <br />
            </div>
        </div>
    
         <div class="linha">
          <div class="t_campo">*CARACTER&Iacute;STICAS</div>
        <div class="campo"> <label> 
        	<select name="caracteristicas[]" data-placeholder="Selecione uma caracter&iacute;stica" multiple>
            	<option value=""></option>
                
                <?php
                $resCar = mysql_query("SELECT idCar, titulo FROM jogador_caracteristica WHERE ativo=1 ORDER BY  titulo") or die(mysql_error());
				while($rowCar = mysql_fetch_array($resCar)){
					$rowCarAtu = mysql_fetch_array(mysql_query("SELECT idCar FROM jogador_caracteristica_funcao WHERE idFun='$_REQUEST[id]' AND idCar='$rowCar[idCar]'"));
					echo "<option value=\"$rowCar[idCar]\"".($rowCarAtu['idCar']>0? 'selected': '').">$rowCar[titulo]</option>";
				}
				?>
            </select> 
        </label> <br />
        </div>
      </div>
     
        <div class="linha">
          <div class="t_campo">ORDEM</div>
        <div class="campo"> <label> <input name="ordem" type="text" maxlength="6" value="<?=$row['ordem'] ?>" /> </label> <br />
        </div>
      </div>
    </div>


    
    
         
    <button type="submit">Atualizar Informa��es</button>      
          
        
    </form>
    
    
    
<script src="include/js/chosen/chosen.jquery.js"></script>
<script src="include/js/maskmoney/src/jquery.maskMoney.js"></script>
<script>
	$("select").chosen({no_results_text: "N�o encontramos", search_contains: true, width: "510px"});
	$("input[name=ordem]").maskMoney({
		prefix: '',
		thousands: '',
		decimal: '.',
		precision: 2,
		allowZero: true
	});
</script>
