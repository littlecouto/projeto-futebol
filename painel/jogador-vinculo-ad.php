<?php 
if(isset($_POST['ACAO']) and $_POST['ACAO'] == 'ADICIONAR'){
	
	if($_POST['time'] == ''){
		$aviso = "Informe o time";
		echo "<script>alert('$aviso'); history.go(-1);</script>";
		exit;
	}else{
		$idTim 		= $_POST['time'];
		$jogadores 	= $_POST['jogador'];
		
		// DELETANDO VÍNCULOS DO TIME
		mysql_query("DELETE FROM jogador_time WHERE idTim='$idTim'") or die(mysql_error());
		
		
		foreach($jogadores as $idJgd){
			// DELETANDO VÍNCULOS DOS JOGADORES COM OUTROS TIMES
			mysql_query("DELETE FROM jogador_time WHERE idJgd='$idJgd' AND idTim!='$idTim'") or die(mysql_error());
			
			$idTim = addslashes($idTim);
			$idJgd = addslashes($idJgd);
			
			$query = "	INSERT INTO jogador_time(
										idJgd,
										idTim)
								VALUES (
										'$idJgd',
										'$idTim')";
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
			
		echo "<script> alert('$aviso'); location.href='jogador-vinculos'; </script>";
		
	}
}
?>
<link rel="stylesheet" href="include/js/chosen/chosen.min.css">
<link rel="stylesheet" type="text/css" href="lib/checkbox/checkbox.css">

<div class="formulario">

	<form method="get" action="" name="pesquisa">
        <div class="area">
          	<h2>TIME</h2>
             <div class="linha">
              <div class="t_campo">*TIME</div>
            <div class="campo"> <label>
                <select name="time" onChange="envia()" data-placeholder="SELECIONE UM TIME">
                    <option value="" disabled selected></option>
                    <?php 
						$resCon = mysql_query("SELECT idCon, continente FROM continente WHERE ativo=1 ORDER BY continente") or die(mysql_error());
						while($rowCon = mysql_fetch_array($resCon)){
							$resPai = mysql_query("SELECT idPai, titulo FROM pais WHERE ativo=1 AND idCon='$rowCon[idCon]' ORDER BY ordem") or die(mysql_error());
							echo "<option value=\"\" disabled class=\"continente\">$rowCon[continente]</option>";
							while($rowPai = mysql_fetch_array($resPai)){
								echo "<optgroup label=\"$rowPai[titulo]\">";
								$resTim = mysql_query("SELECT idTim, apelido FROM time WHERE ativo=1 AND idPai='$rowPai[idPai]' ORDER BY apelido") or die(mysql_error());
								while($rowTim = mysql_fetch_array($resTim)){
									echo "<option value='$rowTim[idTim]' ".($rowTim['idTim']==$_GET['time']? 'selected': '').">$rowTim[apelido]</option>";
								}
								echo "</optgroup>";
							}
							
						}
                    ?>
                </select>
            </label>
            </div>
          </div>
          
        </div>
    </form>
    <form method="post" action="<?php echo $_SERVER['REQUEST_URI']?>" enctype="multipart/form-data">
    <input type="hidden" name="ACAO" value="ADICIONAR" />
    <input type="hidden" name="time" value="<?=$_GET['time']?>" />
    <div class="area">
        <h2>INFORMA&Ccedil;&Otilde;ES PRINCIPAIS</h2>
        <div class="linha">
            <div class="t_campo">*JOGADOR</div>
            <div class="campo"> 
                <label>
                    <select name="jogador[]" data-placeholder="SELECIONE UM JOGADOR" multiple class="jogadores">
                        <option value="" disabled selected></option>
                        <?php 
                        
                        $resFun = mysql_query("SELECT idFun, titulo FROM jogador_funcao WHERE ativo=1 ORDER BY ordem");
                        while($rowFun = mysql_fetch_array($resFun)){
                            echo "<optgroup label=\"$rowFun[titulo]\">";
                            $resJgd = mysql_query("SELECT A.idJgd, apelido, A.forca FROM jogador A INNER JOIN jogador_x_funcao B ON A.idJgd=B.idJgd INNER JOIN jogador_funcao C ON B.idFun=C.idFun WHERE B.especialidade=1 AND C.idFun='$rowFun[idFun]' AND A.ativo=1 ORDER BY A.forca DESC, A.apelido") or die(mysql_error());				
                            while($rowJgd = mysql_fetch_array($resJgd)){
	                            $vinculo = mysql_num_rows(mysql_query("SELECT idJgd FROM jogador_time WHERE idTim='$_REQUEST[time]' AND idJgd='$rowJgd[idJgd]'"));
                                echo "<option value='$rowJgd[idJgd]' ".($vinculo>0? 'selected': '').">$rowJgd[apelido] ($rowJgd[forca])</option>";
                            }
                            echo "</optgroup>";
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
	$("select[multiple]").chosen({max_selected_options:30});
	$("select").chosen({no_results_text: "Não encontramos", search_contains: true, width: "510px"});
    $('input[type=checkbox], input[type=radio]').customRadioCheck();
	
</script>



