
<?php
if($_REQUEST['id'] == 0){
	$aviso = "Registro não encontrado!";
	echo "<script> alert('$aviso'); window.history.go(-1); </script>";	
	
	
}elseif($_REQUEST['id'] > 0 && @$_POST['ACAO'] == ''){
	
	// Resgatando os dados atuais 
	$row = mysql_fetch_array(mysql_query("SELECT * FROM time WHERE idTim='$_REQUEST[id]'"));
	@$_POST['nome']			= stripslashes($_POST['nome']);
	@$_POST['descricao'] 	= stripslashes($_POST['descricao']);
	
}elseif($_REQUEST['id'] > 0 && $_POST['ACAO'] == 'ATUALIZAR'){
	$row = mysql_fetch_array(mysql_query("SELECT * FROM time WHERE idTim='$_REQUEST[id]'"));
	
	if($_POST['nome'] == ''){
		$aviso = 'Informe o nome do time';
		echo "<script> alert('$aviso'); history.go(-1); </script>";
	
	}elseif($_POST['sigla'] == ''){
		$aviso = 'Informe a sigla';
		echo "<script> alert('$aviso'); history.go(-1); </script>";
	
	}elseif($_POST['subdistrito'] == ''){
		$aviso = 'Informe o sub distrito';
		echo "<script> alert('$aviso'); history.go(-1); </script>";
	
	}else{
		
		
		include 'include/scripts/limpa_string.php';					// arquivo que limpa a string
		$filtro 	= array(' ' => '-', '_' => '-', ' - ' => '_');	// filtro que subistitui (espaço) por _
		$url 		= strtr($_POST['nome'], $filtro);				// retirando os espaços
		$url 		= strtolower(limpa_string($url));
				
		$nome		= addslashes($_POST['nome']);
		$apelido	= addslashes($_POST['apelido']);
		$sigla		= addslashes($_POST['sigla']);


		$estadio	 = addslashes($_POST['estadio']);
		$local		 = addslashes($_POST['distrito']);
		$subdistrito = addslashes($_POST['subdistrito']);

		$escudoAt 	= $DirTime.'/'.$row['escudo'].'.png';
		
		$local 		= explode('.', $local);
		$pais	 	= $local[0];
		$distrito 	= $local[1];
		
		if($pais < 0){
			$aviso = 'Informe o país';
			echo "<script> alert('$aviso'); history.go(-1); </script>";
		
		}elseif($distrito < 0){
			$aviso = 'Informe o distrito';
			echo "<script> alert('$aviso'); history.go(-1); </script>";
		
		}		
		
		function limpaHash($str){
			return strtr($str, array('#'=> ''));
		}
		$cor_prin	= addslashes(limpaHash($_POST['cor_prin']));
		$cor_sec	= addslashes(limpaHash($_POST['cor_sec']));
		$cor_ter	= addslashes(limpaHash($_POST['cor_ter']));

		// VERIFICAR SE JÁ EXISTE O ATUAL USUÁRIO ATUAL
		$qtdeUsu = mysql_query("SELECT idTim FROM time WHERE nome='$nome' AND idTim<>$_REQUEST[id]");
		if(mysql_num_rows($qtdeUsu)>0){
			echo "<script> alert('Este time já está cadastrado'); history.go(-1); </script>";
		}
		//
		
		// Gravando os dados
		$query = "	UPDATE	time
					SET 	idPai='$pais',
							idDis='$distrito',
							idSub='$subdistrito',
							idEst='$estadio',
							nome='$nome',
							apelido='$apelido',
							sigla='$sigla',
							cor_prin='$cor_prin',
							cor_sec='$cor_sec',
							cor_ter='$cor_ter',
							escudo='$url',
							url='$url'
					WHERE 	idTim='$_REQUEST[id]' 
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
					
		echo "<script> alert('$aviso'); location.href='".($_REQUEST['ORIGEM'] == '' ? 'times' : $_REQUEST['ORIGEM'])."'; </script>";
	}
}
?>

<link rel="stylesheet" href="include/js/chosen/chosen.min.css">
<link rel="stylesheet" type="text/css" href="lib/jquery-files/src/jquery-filestyle.css">

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
        <div class="campo"> <label> <input name="nome" type="text" maxlength="100" value="<?php echo $row['nome'] ?>" /> </label> <br />
        </div>
      </div>


        <div class="linha">
          <div class="t_campo">*APELIDO</div>
        <div class="campo"> <label> <input name="apelido" type="text" maxlength="100" value="<?php echo $row['apelido'] ?>" /> </label> <br />
        </div>
      </div>
      
        <div class="linha">
          <div class="t_campo">*SIGLA</div>
        <div class="campo"> <label> <input name="sigla" type="text" maxlength="3" value="<?php echo $row['sigla'] ?>" onblur="this.value=this.value.toUpperCase()" /> </label> <br />
        </div>
      </div>
      
        <div class="linha">
          <div class="t_campo">*COR PRINCIPAL</div>
        <div class="campo cores"> <label> <input name="cor_prin" type="color" maxlength="100" value="#<?php echo $row['cor_prin'] ?>" onblur="this.value=this.value.toUpperCase()" /><span class="cor escolhido" style="border-color: #<?php echo $row['cor_prin'] ?>">#<?php echo $row['cor_prin']?></span> </label> <br />
        </div>
      </div>
      
        <div class="linha">
          <div class="t_campo">*COR SECUNDÁRIA</div>
        <div class="campo cores"> <label> <input name="cor_sec" type="color" maxlength="100" value="#<?php echo $row['cor_sec'] ?>"><span class="cor escolhido" style="border-color: #<?php echo $row['cor_sec'] ?>">#<?php echo $row['cor_sec']?></span> </label> <br />
        </div>
      </div>
      
        <div class="linha">
          <div class="t_campo">*COR TERCEÁRIA</div>
        <div class="campo cores"> <label> <input name="cor_ter" type="color" maxlength="100" value="#<?php echo $row['cor_ter'] ?>"><span class="cor escolhido" style="border-color: #<?php echo $row['cor_ter'] ?>">#<?php echo $row['cor_ter']?></span> </label> <br />
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
          <div class="t_campo">*SUB DISTRITO</div>
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
          <div class="t_campo">*EST&Aacute;DIO</div>
        <div class="campo"> <label>
        	<select name="estadio">
        		<option value="" selected disabled>SELECIONE UM ESTÁDIO</option>
        		<?php 
        			$resEst = mysql_query("SELECT A.idEst, A.idSub, A.apelido, A.capacidade, B.distrito FROM estadio A INNER JOIN pais_regiao_distrito B ON A.idDis=B.idDis INNER JOIN pais C ON B.idPai=C.idPai ORDER BY capacidade DESC, C.titulo, B.distrito, A.apelido") or die(mysql_error());
        			while($rowEst = mysql_fetch_array($resEst)){
						$rowEstSub = mysql_fetch_array(mysql_query("SELECT titulo FROM pais_regiao_distrito_sub WHERE idSub='$rowEst[idSub]'"));
						$subdistrito = "$rowEstSub[titulo], ";
						$capacidade = number_format($rowEst['capacidade'], 0, '', '.');
        				echo "<option value='$rowEst[idEst]' ".($row['idEst'] === $rowEst['idEst']?'selected':'').">$rowEst[apelido] - $capacidade pessoas ($subdistrito$rowEst[distrito])</option>";
        			}
        		?>
        	</select>
        </label>
        </div>
      </div>
      
    </div>
    
    
    
    
    
    
    
    
    <div class="area">
    
    	<h2> ESCUDO</h2>
        
        <div class="linha">
        <div class="t_campo"> ALTERAR ESCUDO </div>
        <div class="campo"> 
            <label> <input type="file" name="escudo" size="20" maxlength="400" />  </label>
            <span class="comentario">Dimensões ideais: 400x300 px | Tamanho máximo de 1 MB</span> 
        <?php
		if(file_exists("$DirTime/$row[escudo].png") == true){
			echo "	<div class=\"img\">
					<img src=\"$UrlTime/$row[escudo].png\" border=\"0\" width=\"50\">
					<a href=\"javascript:void(0)\" class=\"excluir\" data-id=\"$row[idTim]\"></a>
					</div>
					";

		}
		?>
        </div>
        </div>
        
        

	</div>
    
    
         
    <button type="submit">Atualizar Informações</button>      
          
        
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
$('select[name=estadio]').chosen({allow_single_deselect: true});

$('a.excluir').click(function(){
	decisao = confirm("Deseja mesmo excluir esta imagem?");
	id		= $(this).attr('data-id');
	
	if(decisao){
		location.href='time-imagem-del?id='+id;
	}
})

</script>
