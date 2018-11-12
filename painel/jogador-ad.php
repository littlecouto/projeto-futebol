
<?php 
if(isset($_POST['ACAO']) and $_POST['ACAO'] == 'ADICIONAR'){
	
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
		
		include 'include/scripts/limpa_string.php';			// arquivo que limpa a string
		$filtro = array(' ' => '-' , '(' => '', ')' => '', '.' => '', ',' => '', '/' => '', ':' => '', '^' => '', '~' => '', ' - ' => '', '!' => '', '@' => '', '#' => '', '$' => '', '%' => '', '¨' => '', '&' => 'e', '*' => '', '_' => '-', '+' => '', '=' => '', '[' => '', '{' => '', '}' => '', ']' => '', 'ª' => 'a', 'º' => 'o', '¹' => '1', '²' => '2', '³' => '3', ';' => '', '"' => '', "'" => '', '¬' => '');
		$url = strtr($_POST['titulo'], $filtro);		// retirando os espaços
		$url = strtolower(limpa_string($url));
						
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
		
		
		// VERIFICANDO SE O CADASTRO JÁ EXISTE
		// $query = "SELECT idJgd FROM jogador WHERE nome='$nome' AND idPai='$nacionalidade' AND forca='$forca' AND idPos='$posicao' AND idPe='$lado'";
		// $resultEx = mysql_query($query) or die(mysql_error());
		// if(mysql_num_rows($resultEx) > 0){
		/*/ 	echo "<script> alert('Provavelmente esta notícia já existe em nosso cadastro. Por favor verifique!'); history.go(-1); </script>";
		// }
		/*/
		
		if('1'=='1'){
		
			// Gravando informações principais
			$query = "	INSERT INTO jogador(
										idPai,
										nome,
										apelido,
										lado,
										forca,
										foto,
										url,
										estrela,
										evolucao,
										ativo)
								VALUES (
										'$pais',
										'$nome',
										'$apelido',
										'$lado',
										'$forca',
										'$url',
										'$url',
										'$craque',
										'$evolucao',
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
			  
			$rowJgd = mysql_fetch_array(mysql_query("SELECT idJgd FROM jogador ORDER BY idJgd DESC LIMIT 1"));
			$idJgd = $rowJgd['idJgd'];
			
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



	  		// UPLOAD DA IMAGEM
			if($_FILES["imagem"]['size'] > 0){ // Verificando se a imagem foi realmente selecionada
			
				// Aqui incluimos a classe 
				include('../../include/classes/upload.class.php'); 
				//
			
				// Resgatando o nome da imagem
				$row = mysql_fetch_array(mysql_query("SELECT idJgd, imagem FROM jogador ORDER BY idJgd DESC LIMIT 1"));
				$nomeImg = $row['imagem'];
				//
				
				// Instanciamos o objeto Upload   
				$handle = '';
				$handle = new Upload($_FILES["imagem"]);   
				// 
				
				// Então verificamos se o arquivo foi carregado corretamente    
				if ($handle->uploaded) { 
					// Aqui nos devifimos nossas configurações de imagem       
					$handle->image_resize           = true; 		// redimensinoar    
					$handle->image_ratio_x        	= false;			// dimensionar largura na proporção
					$handle->image_ratio_y     	 	= true;		// dimensionar altura na proporção
					$handle->image_x             	= 980;			// largura 
					//$handle->image_y       		= 300;			// altura 
					$handle->image_convert 			= 'jpg';		// converte para JPG
					$handle->jpeg_quality           = 95;			// qualidade
					$handle->file_new_name_body     = $nomeImg;		// nome do arquivo da imagem
					$handle->process($DirJogador);					// Pasta onde a imagem será armazenada				
					$handle-> Clean();								// Excluir os arquivos temporarios
					
				}else{ // Caso Erro
					$aviso = "Erro ao gravar o arquivo!"; 		
					echo "<script> alert('$aviso'); </script>";
				} 
		
			}
			// FIM UPLOAD
			  
		}
			
		echo "<script> alert('$aviso'); location.href='list_jogadores.php'; </script>";
		
	}
}
?>
<link rel="stylesheet" href="include/js/chosen/chosen.min.css">
<link rel="stylesheet" type="text/css" href="lib/checkbox/checkbox.css">
<link rel="stylesheet" type="text/css" href="lib/rangeSlider/dist/rangeSlider.css">


<div class="formulario">

    <form method="post" action="<?php echo $_SERVER['REQUEST_URI']?>" enctype="multipart/form-data">
    <input type="hidden" name="ACAO" value="ADICIONAR" />
	<div class="area">
    
        <h2>INFORMA&Ccedil;&Otilde;ES PRINCIPAIS</h2>
        <div class="linha">
          <div class="t_campo">*NOME</div>
        <div class="campo"> <label> <input name="titulo" type="text" maxlength="100" /> </label> </div>
      </div>
      
        <div class="linha">
          <div class="t_campo">*APELIDO</div>
        <div class="campo"> <label> <input name="apelido" type="text" maxlength="100" /> </label> </div>
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
        	<label><input type="radio" name="lado" id="lado" value="E" /> <span>ESQUERDO</span></label>
			<label><input type="radio" name="lado" id="lado" value="D" /> <span>DIREITO</span></label>
        </div>
      </div>

      
  
      
        <div class="linha">
          <div class="t_campo">*PAÍS</div>
        <div class="campo"> <label>
        	<select name="pais" data-placeholder="Selecione um pa&iacute;s">
        		<option value=""></option>
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
        <div class="campo"> <label> <input name="idade" type="number" min="18" value="18" max="50" /> </label> </div>
      </div>
      
        
        <div class="linha">
          <div class="t_campo">ESTRELA</div>
        <div class="campo">
        	<label><input type="checkbox" name="estrela" id="estrela" value="1" /> <span>Sim</span> </label>
        </div>
      </div>

    
    </div>
    
    
<!--    
    <div class="area">
    
    	<h2> IMAGEM</h2>
        
        <div class="linha">
        <div class="t_campo"> IMAGEM </div>
        <div class="campo"> 
        	<label> <input type="file" name="imagem" size="20" maxlength="400" />  </label> 
            <span class="comentario">Dimensões ideais: 400x300 px | Tamanho máximo de 1 MB</span>
		</div>
        </div>

	</div>
    
-->         
    <button type="submit">Cadastrar</button>      
          
        
    </form>
    
    
    

</div>

<script src="include/js/chosen/chosen.jquery.js"></script>
<script src="lib/checkbox/checkbox.js"></script>
<script src="lib/rangeSlider/dist/rangeSlider.min.js"></script>
<script>
	var selector = 'input.especialidade[data-rangeSlider]',
		elements = document.querySelectorAll(selector);
	
	if(elements.length >0){
		rangeSlider.create(elements, {min : 0, max : 100, step : 0.5});
	}

	var selector = 'input.outra_especialidade[data-rangeSlider]',
		elements = document.querySelectorAll(selector);
	if(elements.length >0){
		rangeSlider.create(elements, {min : 0, max : 75, step : 5});
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
					este[0].rangeSlider.update({min : 0, max : 100, step : 0.5});
				}else{
					este.parent().parent().parent().removeClass('especialidade').addClass('outra_especialidade');
					este[0].rangeSlider.update({min : 0, max : 75, step : 5});
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



