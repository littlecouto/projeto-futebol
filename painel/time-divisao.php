<?php 
if(isset($_POST['ACAO']) and $_POST['ACAO'] == 'ADICIONAR'){
	
	if($_POST['pais'] == ''){
		$aviso = "Informe o país";
		echo "<script>alert('$aviso'); history.go(-1);</script>";
		exit;
	}else{
		$idPai 		= $_POST['pais'];
		$divisao	= $_POST['divisao'];
		$times		= $_POST['time'];
		
		// DELETANDO VÍNCULOS DO TIME
		mysql_query("UPDATE time SET divisao=0 WHERE divisao='$divisao'") or die(mysql_error());
		
		foreach($times as $idTim){
			
			$idTim 	 = addslashes($idTim);
			$divisao = addslashes($divisao);
			
			$query = "	UPDATE 	time
						SET		divisao='$divisao'
						WHERE 	idTim='$idTim'
						LIMIT 	1";
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
		}
			
		echo "<script> alert('$aviso'); location.href='".($_REQUEST['ORIGEM'] == '' ? 'time-divisao' : $_REQUEST['ORIGEM'])."'; </script>";
		
	}
}
?>
<link rel="stylesheet" href="include/js/chosen/chosen.min.css">
<link rel="stylesheet" type="text/css" href="lib/checkbox/checkbox.css">

<div class="formulario">
<?php
    
	$qtdTim = mysql_num_rows(mysql_query("SELECT idTim, apelido FROM time WHERE idPai='$_GET[pais]' AND ativo=1 ORDER BY apelido"));
	$divisoes = ceil($qtdTim/20);
	
	
	?>
    
	<form method="get" action="" name="pesquisa">
        <div class="area">
          	<h2>TIME</h2>
             <div class="linha">
              <div class="t_campo">*PA&Iacute;S</div>
            <div class="campo"> <label>
                <select name="pais" onChange="envia()" data-placeholder="SELECIONE UM PA&Iacute;S">
                    <option value="" disabled selected></option>
                    <?php 
						$resCon = mysql_query("SELECT idCon, continente FROM continente WHERE ativo=1 ORDER BY continente") or die(mysql_error());
						while($rowCon = mysql_fetch_array($resCon)){
							echo "<optgroup label=\"$rowCon[continente]\"";

							$resPai = mysql_query("SELECT idPai, titulo FROM pais WHERE ativo=1 AND idCon='$rowCon[idCon]' ORDER BY ordem") or die(mysql_error());
							while($rowPai = mysql_fetch_array($resPai)){
									echo "<option value='$rowPai[idPai]' ".($rowPai['idPai']==$_GET['pais']? 'selected': '').">$rowPai[titulo]</option>";
							}
							echo "</optgroup>";
							
						}
                    ?>
                </select>
            </label>
            </div>
          </div>

             <div class="linha">
              <div class="t_campo">*DIVIS&Otilde;ES</div>
            <div class="campo"> <label>
                <select name="divisao" onChange="envia()" data-placeholder="SELECIONE UMA DIVIS&Atilde;O">
                    <option value="" disabled selected></option>
                    <?php 
					
						for($divisao = 1; $divisao<=$divisoes; $divisao++){
							echo "<option value='$divisao' ".($divisao==$_GET['divisao']? 'selected': '').">$divisao</option>";
						}
						
						
						$divisao = $_GET['divisao'];
                    ?>
                </select>
            </label>
            </div>
          </div>
          
        </div>
    </form>
    <form method="post" action="<?php echo $_SERVER['REQUEST_URI']?>" enctype="multipart/form-data">
    <input type="hidden" name="ORIGEM" value="<?= $_SERVER['HTTP_REFERER']?>" />
    <input type="hidden" name="ACAO" value="ADICIONAR" />
    <input type="hidden" name="pais" value="<?=$_GET['pais']?>" />
    <input type="hidden" name="divisao" value="<?=$_GET['divisao']?>" />
    <div class="area">
        <h2><?=$divisao?>ª DIVIS&Atilde;O</h2>
        <div class="linha">
            <div class="t_campo">*TIMES</div>
            <div class="campo"> 
                <label>
                    <select name="time[]" data-placeholder="SELECIONE UM time" multiple class="jogadores">
                        <option value="" disabled selected></option>
                        <?php 
                        
						$resTim = mysql_query("SELECT idTim, apelido, divisao FROM time WHERE idPai='$_GET[pais]' AND ativo=1 ORDER BY ordem, apelido") or die(mysql_error());				
						while($rowTim = mysql_fetch_array($resTim)){
							echo "<option value='$rowTim[idTim]' ".($rowTim['divisao']==$_GET['divisao']? 'selected': '').">$rowTim[apelido]</option>";
						}
                        ?>
                    </select>
                </label>
            </div>
        </div>
    </div>
    
    
         
    <button type="submit">Cadastrar</button>      
          
        
    </form>
    
    
    

</div>
<script src="include/js/chosen/chosen.jquery.js"></script>
<script src="lib/checkbox/checkbox.js"></script>
<script src="lib/rangeSlider/dist/rangeSlider.min.js"></script>
<script>
	

	function envia(){
		document.pesquisa.submit();
	}
	$("select[multiple]").chosen({max_selected_options:21});
	$("select").chosen({no_results_text: "Não encontramos", search_contains: true, width: "510px"});
    $('input[type=checkbox], input[type=radio]').customRadioCheck();
	
	
		
</script>



