
<?php
if($_REQUEST['id'] == 0){
	$aviso = "Registro não encontrado!";
	echo "<script> alert('$aviso'); window.history.go(-1); </script>";	
	
	
}elseif($_REQUEST['id'] > 0 && @$_POST['ACAO'] == ''){
	
	// Resgatando os dados atuais 
	$row = mysql_fetch_array(mysql_query("SELECT * FROM pais WHERE idPai='$_REQUEST[id]'"));
	@$_POST['nome']			= stripslashes($_POST['nome']);
	@$_POST['descricao'] 	= stripslashes($_POST['descricao']);
	
}elseif($_REQUEST['id'] > 0 && $_POST['ACAO'] == 'ATUALIZAR'){
	$row = mysql_fetch_array(mysql_query("SELECT * FROM pais WHERE idPai='$_REQUEST[id]'"));
	
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
		$aviso = 'Informe o continente';
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
		

		// VERIFICAR SE JÁ EXISTE O ATUAL USUÁRIO ATUAL
		$qtdeUsu = mysql_query("SELECT idPai FROM pais WHERE (titulo='$titulo' OR codigo='$codigo') AND idPai<>$_REQUEST[id]");
		if(mysql_num_rows($qtdeUsu)>0){
			echo "<script> alert('Este país ou este código já estão cadastrados'); history.go(-1); </script>";
			exit;
		}
		//
		
		// Gravando os dados
		$query = "	UPDATE	pais
					SET 	idCon='$continente',
							titulo='$titulo',
							sigla_2='$sigla2',
							sigla_3='$sigla3',
							codigo='$codigo',
							ordem='$ordem',
							url='$url'
					WHERE 	idPai='$_REQUEST[id]' 
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
					
		echo "<script> alert('$aviso'); location.href='".($_REQUEST['ORIGEM'] == '' ? 'paises' : $_REQUEST['ORIGEM'])."'; </script>";
	}
}
?>
<link rel="stylesheet" type="text/css" media="screen,projection" href="include/js/mapas/cssmap-continents/cssmap-continents.css" />

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
          <div class="t_campo">*NOME</div>
        <div class="campo"> <label> <input name="titulo" type="text" maxlength="100" value="<?=$row['titulo']?>" /> </label> <br />
        </div>
      </div>


        <div class="linha">
          <div class="t_campo">*SIGLA 2 LETRAS</div>
        <div class="campo"> <label> <input name="sigla2" type="text" maxlength="2" onblur="this.value=this.value.toUpperCase()" value="<?=$row['sigla_2']?>" /> </label> <br />
        </div>
      </div>
      
        <div class="linha">
          <div class="t_campo">*SIGLA 3 LETRAS</div>
        <div class="campo"> <label> <input name="sigla3" type="texto" maxlength="3" onblur="this.value=this.value.toUpperCase()" value="<?=$row['sigla_3']?>" /> </label> <br />
        </div>
      </div>

        <div class="linha">
          <div class="t_campo">C&Oacute;DIGO ISO</div>
        <div class="campo"> <label> <input name="codigo" type="text" maxlength="3" onblur="this.value=this.value.toUpperCase()" value="<?=$row['codigo']?>" /> </label> <br />
        </div>
      </div>

        <div class="linha">
          <div class="t_campo">ORDEM</div>
        <div class="campo"> <label> <input name="ordem" type="text" maxlength="4" onblur="this.value=this.value.toUpperCase()" value="<?=$row['ordem']?>" /> </label> <br />
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
        			$resCon = mysql_query("SELECT idCon, continente FROM continente WHERE ativo=1 ORDER BY FIELD(continente, 'África', 'Ásia', 'Oceânia', 'Europa', 'América do Norte e Central', 'América do Sul')") or die(mysql_error());
        			$i = 0;
					while($rowCon = mysql_fetch_array($resCon)){
						$i++;
         				echo "<input type=\"radio\" name=\"continente\" value='$rowCon[idCon]' ".($row['idCon']==$rowCon['idCon']?'checked':'')." data-id=\"$i\">";
        			}
        		?>
        </label>
        </div>
      </div>
      
    </div>
    
    
    
    
         
    <button type="submit">Atualizar Informações</button>      
          
        
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
			input = $('input[type=radio][data-id='+id+']');
		if(!input.prop('checked')){
				input.prop('checked', true);
			}else{
				input.prop('checked', false);
		}
		});
		$(window).load(function(){
			id = $('input[type=radio]:checked').attr('data-id');
			
			$('#map-continents li[data-id='+id+']').addClass('active-region');
		});
    </script>
</div>
