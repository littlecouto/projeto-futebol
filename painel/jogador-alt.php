<?php
if($_REQUEST['id'] == 0){
	$aviso = "Registro não encontrado!";
	echo "<script> alert('$aviso'); window.history.go(-1); </script>";	
	
	
}elseif($_REQUEST['id'] > 0 && @$_POST['ACAO'] == ''){
	
	// Resgatando os dados atuais 
	$row = mysql_fetch_array(mysql_query("SELECT * FROM jogador WHERE idJgd='$_REQUEST[id]'"));
	@$_POST['nome']			= stripslashes($_POST['nome']);
	@$_POST['descricao'] 	= stripslashes($_POST['descricao']);
	
}elseif($_REQUEST['id'] > 0 && $_POST['ACAO'] == 'ATUALIZAR'){
	$row = mysql_fetch_array(mysql_query("SELECT * FROM times WHERE idTim='$_REQUEST[id]'"));
	
	
	if($_POST['nome'] == ''){
		$aviso = 'Informe o nome do jogador';
		echo "<script> alert('$aviso'); history.go(-1); </script>";
		exit;

	}elseif($_POST['apelido'] == ''){
		$aviso = 'Informe apelido do jogador';
		echo "<script> alert('$aviso'); history.go(-1); </script>";
		exit;
	
	}elseif(strtr($_POST['funcao'], array('.1'=>'', '.0'=>'')) == 0){
		$aviso = 'Informe a função do jogador';
		echo "<script> alert('$aviso'); history.go(-1); </script>";
		exit;
	
	}elseif(count($_POST['caracteristica']) == 0){
		$aviso = 'Informe uma característica ao menos';
		echo "<script> alert('$aviso'); history.go(-1); </script>";
		exit;
	
	}elseif($_POST['lado'] == ''){
		$aviso = 'Informe o lado em que o jogador atua';
		echo "<script> alert('$aviso'); history.go(-1); </script>";
		exit;
	
	}elseif($_POST['pais'] == ''){
		$aviso = 'Informe o país em que o jogador nasceu';
		echo "<script> alert('$aviso'); history.go(-1); </script>";
		exit;
	
	}elseif($_POST['idade'] == ''){
		$aviso = 'Informe a idade do jogador';
		echo "<script> alert('$aviso'); history.go(-1); </script>";
		exit;
	
	}else{
		
		include 'include/scripts/limpa_string.php';				// arquivo que limpa a string
		$filtro = array(' ' => '-' , '(' => '', ')' => '', '.' => '', ',' => '', '/' => '', ':' => '', '^' => '', '~' => '', ' - ' => '', '!' => '', '@' => '', '#' => '', '$' => '', '%' => '', '¨' => '', '&' => 'e', '*' => '', '_' => '-', '+' => '', '=' => '', '[' => '', '{' => '', '}' => '', ']' => '', 'ª' => 'a', 'º' => 'o', '¹' => '1', '²' => '2', '³' => '3', ';' => '', '"' => '', "'" => '', '¬' => '');

		$url 		= strtr($_POST['nome'], $filtro);		// retirando os espaços
		$url 		= strtolower(limpa_string($url));
				
		$nome		= addslashes($_POST['nome']);
		$apelido	= addslashes($_POST['apelido']);

		$lado	= addslashes($_POST['lado']);
		$pais	= addslashes($_POST['pais']);
		$idade	= addslashes($_POST['idade']);
		
		$evolucao	= addslashes(3);

		$caracteristicas= $_POST['caracteristica'];
		$outras_funcoes	= $_POST['outras_funcoes'];

		$funcao = explode('.', $_POST['funcao']);
		$funcao = $funcao[0];
		
		$forca = $forCou = 0;
		foreach($caracteristicas as $forcas){
			if($forcas>0){
				$forca += $forcas;
				$forCou++;
			}
		}
		$craque	= addslashes($_POST['estrela']);
		$forca	= round(($forca + ($craque*50)) / $forCou );


		
		// Gravando os dados
		$query = "	UPDATE	jogador
					SET 	idPai='$pais',
							nome='$nome',
							apelido='$apelido',
							lado='$lado',
							idade='$idade',
							forca='$forca',
							foto='$url',
							url='$url',
							estrela='$craque',
							evolucao='$evolucao'
					WHERE 	idJgd='$_REQUEST[id]' 
					LIMIT 1";
		$gravou = mysql_query($query) or die("Erro na linha".__LINE__.": ".mysql_error());
		
		
		// PAINEL HISTÓRICO
		$query = addslashes($query);
		mysql_query("INSERT INTO painel_historico(idUsu, acao, query) VALUE('$_SESSION[USUARIO]', 'UPDATE', '$query')") or die (mysql_error());
		//
		
		
		
	
		// Verificando a gravação
		if($gravou==false)	$aviso="Houve um erro ao atualizar os dados!";
		if($gravou==true){
			$aviso="Dados atualizados com sucesso!";
			
			$idJgd = $_REQUEST['id'];
			
			mysql_query("DELETE FROM jogador_x_caracteristica WHERE idJgd='$idJgd'") or die(__LINE__.mysql_error()) ;
			foreach($caracteristicas as $caracteristica => $nivel){
				$caracteristica = addslashes($caracteristica);
				$nivel 			= addslashes($nivel);
				
				
				mysql_query(
					"INSERT INTO jogador_x_caracteristica(
						idJgd, 
						idCar, 
						nivel
					)VALUES(
						'$idJgd',
						'$caracteristica',
						'$nivel'
					)"
				) or die(__LINE__.mysql_error());
			}
			
			
			mysql_query("DELETE FROM jogador_x_funcao WHERE idJgd='$idJgd'") or die(__LINE__.mysql_error());
			foreach($outras_funcoes as $outra_funcao){
				$outra_funcao = addslashes($outra_funcao);
				
								
				mysql_query(
					"INSERT INTO jogador_x_funcao(
						idJgd, 
						idFun 
					)VALUES(
						'$idJgd',
						'$outra_funcao'
					)"
				) or die(__LINE__.mysql_error());
			}
			
			mysql_query(
				"INSERT INTO jogador_x_funcao(
					idJgd, 
					idFun, 
					especialidade
				)VALUES(
					'$idJgd',
					'$funcao',
					'1'
				)"
			) or die(__LINE__.mysql_error());
			
			//Renomeando a imagem
			$img_novo = $DirTime.'/'.$url.'.jpg';
			//
			
			
			// UPLOAD DA IMAGEM
			$_FILES["escudo"]['size'] == 0;
			if($_FILES["escudo"]['size'] > 0){ // Verificando se a imagem foi realmente selecionada
			
				// Aqui incluimos a classe 
				include('../../include/classes/upload.class.php'); 
				//
			
				// Resgatando o nome da imagem
				$row = mysql_fetch_array(mysql_query("SELECT idTim, escudo FROM times WHERE idTim=$_REQUEST[id]"));
				$nomeImg = $row['escudo'];
				//
				
				// Excluir imagem antiga
				if(file_exists($DirTime.'/'.$row['escudo'].'.png')){
					$escudoAt = $DirTime.'/'.$row['escudo'].'.png';
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
					$handle->image_ratio_x        	= true;			// dimensionar largura na proporção
					$handle->image_ratio_y     	 	= false;		// dimensionar altura na proporção
					//$handle->image_x             	= 400;			// largura 
					$handle->image_y       			= 300;			// altura 
					$handle->image_convert 			= 'png';		// converte para JPG
					$handle->jpeg_quality           = 85;			// qualidade
					$handle->file_new_name_body     = $nomeImg;		// nome do arquivo da imagem
					$handle->process($DirTime);					// Pasta onde a imagem será armazenada				
					$handle-> Clean();								// Excluir os arquivos temporarios
					
				}else{ // Caso Erro
					$aviso = "Erro ao gravar o arquivo!"; 		
					echo "<script> alert('$aviso'); </script>";
				} 
		
			}
			// FIM UPLOAD
			
			
		}
					
		echo "<script> alert('$aviso'); location.href='".($_REQUEST['ORIGEM'] == '' ? 'jogadores' : $_REQUEST['ORIGEM'])."'; </script>";
	}
}
?>
<link rel="stylesheet" href="include/js/chosen/chosen.min.css">
<link rel="stylesheet" type="text/css" href="lib/checkbox/checkbox.css">
<link rel="stylesheet" type="text/css" href="lib/rangeSlider/dist/rangeSlider.css">

<div class="formulario">
    <form method="post" action="<?php echo $_SERVER['REQUEST_URI']?>" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $_REQUEST['id'] ?>" />
    <input type="hidden" name="ORIGEM" value="<?= $_SERVER['HTTP_REFERER']?>" />
    <input type="hidden" name="ACAO" value="ATUALIZAR" />
	<div class="area">
    
        <h2>INFOR&Ccedil;&Otilde;ES PRINCIPAIS</h2>
        <div class="linha">
          <div class="t_campo">*NOME</div>
        <div class="campo"> <label> <input name="nome" type="text" maxlength="100" value="<?php echo $row['nome'] ?>" /> </label> <br />
        </div>
      </div>


        <div class="linha">
          <div class="t_campo">*APELIDO</div>
        <div class="campo"> <label> <input name="apelido" type="text" maxlength="100" value="<?php echo $row['apelido'] ?>" /> </label> <br />
        </div>
      </div>
      
        <div class="linha">
          <div class="t_campo">*POSI&Ccedil;&Atilde;O</div>
        <div class="campo"> <label> 
        <select name="funcao" data-placeholder="Escolha uma posi&ccedil;&atilde;o" id="funcao">
        <option></option>
        <?php
			$rowEsp = mysql_fetch_array(mysql_query("SELECT idFun FROM jogador_x_funcao WHERE idJgd='$_REQUEST[id]' AND especialidade=1"));
			$resFun = mysql_query("SELECT idFun, titulo, outra_funcao FROM jogador_funcao WHERE ativo=1 ORDER BY ordem") or die(mysql_error());
			while($rowFun = mysql_fetch_array($resFun)){
				
        		echo "<option value=\"$rowFun[idFun].$rowFun[outra_funcao]\" ".($rowFun['idFun']==$rowEsp['idFun']?'selected':'').">$rowFun[titulo]</option>";
			}
        ?>
        </select>
         </label> </div>
      </div>
        <div class="linha">
          <div class="t_campo">*OUT POSI&Ccedil;&Otilde;ES</div>
        <div class="campo"> <label> 
        <select name="outras_funcoes[]" multiple data-placeholder="Escolha uma posi&ccedil;&atilde;o" id="outras_funcoes">
        <?php
		
			$resFun = mysql_query("SELECT idFun, titulo FROM jogador_funcao WHERE ativo=1 AND outra_funcao=1 ORDER BY ordem") or die(mysql_error());
			while($rowFun = mysql_fetch_array($resFun)){
				$rowOutFun = mysql_fetch_array(mysql_query("SELECT idFun FROM jogador_x_funcao WHERE idJgd='$_REQUEST[id]' AND especialidade=0 AND idFun='$rowFun[idFun]'"));
        		echo "<option value=\"$rowFun[idFun]\" ".($rowFun['idFun']==$rowOutFun['idFun']?'selected':'').">$rowFun[titulo]</option>";
			}
        ?>
        </select>
         </label> </div>
      </div>

 		</div>
        
        <div class="area">
       <?php
			$resCar = mysql_query("SELECT idCar, titulo FROM jogador_caracteristica WHERE ativo=1 ORDER BY titulo") or die(mysql_error());
			while($rowCar = mysql_fetch_array($resCar)){
				$rowCarNiv = mysql_fetch_array(mysql_query("SELECT nivel FROM jogador_x_caracteristica WHERE idJgd='$_REQUEST[id]' AND idCar='$rowCar[idCar]'"));
				
				$car_fun = "";
				$resCarFun = mysql_query("SELECT idFun FROM jogador_caracteristica_funcao WHERE idCar='$rowCar[idCar]'");
				while($rowCarFun = mysql_fetch_array($resCarFun)){
					$car_fun .= "$rowCarFun[idFun],";
				}
				$car_fun = substr($car_fun, 0, -1);

				$rowCarAtu = mysql_fetch_array(mysql_query("SELECT idCar FROM jogador_caracteristica_funcao WHERE idFun='$rowEsp[idFun]' AND idCar='$rowCar[idCar]'"));
				
				$nivel = number_format($rowCarNiv['nivel'], 2);
				
				$classe = $rowCarAtu['idCar'] >0? 'especialidade': 'outra_especialidade';
        		echo "
				<div class=\"linha caracteristica $classe\" data-car=\"$rowCar[idCar]\">
					<div class=\"t_campo\">$rowCar[titulo]</div>
					<div class=\"campo\" style=\"width: 510px;\">
						<label><input type=\"range\" data-id=\"$rowCar[idCar]\" class=\"$classe\" value=\"$nivel\" name=\"caracteristica[$rowCar[idCar]]\" data-car=\"$car_fun\" data-rangeSlider><span data-id=\"$rowCar[idCar]\" class=\"valor\">$nivel</span></label>
					</div>
				</div>
				";
			}
        ?>
    
        <div class="linha">
          <div class="t_campo">PÉ PREFERIDO</div>
        <div class="campo">
        	<label><input type="radio" name="lado" id="lado" value="E" <?= $row['lado']=='E'?'checked':''?> /> ESQUERDO</label>
			<label><input type="radio" name="lado" id="lado" value="D" <?= $row['lado']=='D'?'checked':''?> /> DIREITO</label>
        </div>
      </div>

        <div class="linha">
          <div class="t_campo">ESTRELA</div>
        <div class="campo">
        	<label><input type="checkbox" name="estrela" id="estrela" value="1" <?= $row['estrela']==1?'checked':''?> /></label>
        </div>
      </div>

		</div>
        
        <div class="area">
      
        <div class="linha">
          <div class="t_campo">*PAÍS</div>
        <div class="campo"> <label>
        	<select name="pais">
        		<option value="" disabled>SELECIONE UM PAÍS</option>
        		<?php 
        			$resPai = mysql_query("SELECT A.idPai, B.continente, A.titulo FROM pais A INNER JOIN continente B ON A.idCon=B.idCon WHERE A.ativo=1 AND B.ativo=1 ORDER BY B.continente, A.titulo") or die(mysql_error());
        			while($rowPai = mysql_fetch_array($resPai)){
						echo "<option value='$rowPai[idPai]' ".($row['idPai'] === $rowPai['idPai']?'selected':'').">$rowPai[titulo] ($rowPai[continente])</option>";
        			}
        		?>
        	</select>
        </label>
        </div>
      </div>
      
        <div class="linha">
          <div class="t_campo">*IDADE</div>
        <div class="campo"> <label> <input name="idade" type="number" min="18" value="<?=$row['idade']?>" /> </label> </div>
      </div>
      
      
               
        
        
      
    </div>
    
    
    
    
    
    
    
    
<!--    <div class="area">
    
    	<h2> ESCUDO</h2>
        
        <div class="linha">
        <div class="t_campo"> ALTERAR ESCUDO </div>
        <div class="campo"> 
        	<font size="1"> Dimensões ideais: 400x300 px | Tamanho máximo de 1 MB</font>
            <br />
            <label> <input type="file" name="escudo" size="20" maxlength="400" />  </label> 
        <?php
		if(file_exists("$DirJogador/$row[imagem].jpg") == true){
			echo "	<br /><br />
					<img src=\"$UrlJogador/$row[imagem].png\" border=\"0\" width=\"50\">
					<a href=\"#\"> 
					<img src='../../include/img/bt/bt_excluir.gif' alt='Excluir Imagem' title='Excluir Imagem' border='0' onclick=\"DelImg($row[idTim]);\" /> 
					</a>
					";

		}
		?>
        </div>
        </div>
        
        

	</div>
    -->
    
         
    <button type="submit">Atualizar Informações</button>      
          
        
    </form>
    
    
    

</div>
<script src="include/js/chosen/chosen.jquery.js"></script>
<script src="lib/checkbox/checkbox.js"></script>
<script src="lib/rangeSlider/dist/rangeSlider.min.js"></script>
<script>
	var selector = 'input.especialidade[data-rangeSlider]',
		elements = document.querySelectorAll(selector);
	
	if(elements.length >0){
		rangeSlider.create(elements, {min : 0, max : 100, step : 1, buffer: 100});
	}

	var selector = 'input.outra_especialidade[data-rangeSlider]',
		elements = document.querySelectorAll(selector);
	if(elements.length >0){
		rangeSlider.create(elements, {min : 0, max : 75, step : 1, buffer: 100});
	}

	elements = document.querySelectorAll('input[type=range');
	function valueOutput(element) {
		var value = element.value,
				output = element.parentNode.getElementsByTagName('span')[0];
		output.innerHTML = value;
	}

	for (var i = elements.length - 1; i >= 0; i--) {
		valueOutput(elements[i]);
	}

	Array.prototype.slice.call(document.querySelectorAll('input[type="range"]')).forEach(function (el) {
		el.addEventListener('input', function (e) {
			valueOutput(e.target);
		}, false);
	});

	$("select").chosen({no_results_text: "Não encontramos", search_contains: true, width: "510px"});
    $('input[type=checkbox], input[type=radio]').customRadioCheck();
	
	$('select#funcao').change(function() {
		var $this 	= $('select#funcao'),
			out_fun = $('select#outras_funcoes'),
			option 	= $('select#outras_funcoes option'),
			range 	= $('input[type=range]'),

			out_pos = $this.val().split('.');
			funcao 	= out_pos[0];
			out_pos = out_pos[1];
			
			range.each(function() {
                este 	= $(this)
				e_fun 	= este.attr('data-car').split(',')
				
				if(e_fun.indexOf(funcao)>-1){
					este.parent().parent().parent().addClass('especialidade').removeClass('outra_especialidade')
					este[0].rangeSlider.update({min : 0, max : 100, step : 1, buffer: 100});
				}else{
					este.parent().parent().parent().removeClass('especialidade').addClass('outra_especialidade');
					este[0].rangeSlider.update({min : 0, max : 75, step : 1, buffer: 100});
				}	
				
				
            });			

			option.each(function() {
                opt = $(this)
				if(opt.val() == funcao){
					opt.prop('disabled', true);
				}else{
					opt.prop('disabled', false);
				}
				
            });
			
			if(out_pos == 0){
				out_fun.prop('disabled', true);
			}else{
				out_fun.prop('disabled', false);
			}

			out_fun.val('').trigger("chosen:updated");
		
		
    });
	
	
	
</script>



