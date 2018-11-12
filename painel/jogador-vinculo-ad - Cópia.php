<?php 
if(isset($_POST['ACAO']) and $_POST['ACAO'] == 'ADICIONAR'){
	
	if($_POST['time'] == ''){
		$aviso = 'Informe o título da notícia';
		echo "<script> alert('$aviso'); history.go(-1); </script>";
	
	}else{
		
		$time 	 = addslashes($_POST['time']);
		$jogador = addslashes($_POST['jogador']);

		$inicio	 = addslashes($_POST['inicio']);
		$final	 = addslashes($_POST['final']);
		$salario = addslashes($_POST['salario']);
		$multa 	 = addslashes($_POST['multa']);

        $multa   = ($salario*$multa)/100;
		

		
		// VERIFICANDO SE O CADASTRO JÁ EXISTE
		$query = "SELECT idCon FROM jogador_time WHERE ativo=1 AND idTim='$time' AND idJgd='$jogador'";
		$resultEx = mysql_query($query);
		if(mysql_num_rows($resultEx) > 0){
			//mysql_query("UPDATE jogador_time SET ativo=0 WHERE ativo=1 AND idTim='$time' AND idJgd='$jogador'");
		}
		//
		
		else{
		
			// Gravando informações principais
			$query = "	INSERT INTO jogador_time(
										idJgd,
										idTim,
										dataini,
										datafim,
										salario,
										multa)
								VALUES (
										'$jogador',
										'$time',
										'$inicio',
										'$final',
                                        '$salario',
										'$multa')";
							
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
			
		echo "<script> alert('$aviso'); location.href='list_jogadores.php'; </script>";
		
	}
}
?>
<link rel="stylesheet" href="include/js/chosen/chosen.min.css">
<link rel="stylesheet" type="text/css" href="lib/checkbox/checkbox.css">

<div class="formulario">

    <form method="post" action="<?php echo $_SERVER['REQUEST_URI']?>" enctype="multipart/form-data">
    <input type="hidden" name="ACAO" value="ADICIONAR" />
	<div class="area">
    
        <h2>INFORMA&Ccedil;&Otilde;ES PRINCIPAIS</h2>
      
         <div class="linha">
          <div class="t_campo">*TIME</div>
        <div class="campo"> <label>
            <select name="time">
                <option value="" disabled selected>SELECIONE UM TIME</option>
                <?php 
                    $resTim = mysql_query("SELECT idTim, apelido FROM time WHERE ativo=1 ORDER BY apelido") or die(mysql_error());
                    while($rowTim = mysql_fetch_array($resTim)){
                        echo "<option value='$rowTim[idTim]'>$rowTim[apelido]</option>";
                    }
                ?>
            </select>
        </label>
        </div>
      </div>
      
         <div class="linha">
          <div class="t_campo">*JOGADOR</div>
        <div class="campo"> <label>
            <select name="jogador">
                <option value="" disabled selected>SELECIONE UM JOGADOR</option>
                <?php 
				
					$resFun = mysql_query("SELECT idFun, titulo FROM jogador_funcao WHERE ativo=1 ORDER BY ordem");
					
					while($rowFun = mysql_fetch_array($resFun)){
						echo "<optgroup label=\"$rowFun[titulo]\">";
	                    $resJgd = mysql_query("SELECT A.idJgd, apelido, A.forca FROM jogador A INNER JOIN jogador_x_funcao B ON A.idJgd=B.idJgd INNER JOIN jogador_funcao C ON B.idFun=C.idFun WHERE B.especialidade=1 AND C.idFun='$rowFun[idFun]' AND A.ativo=1 ORDER BY A.forca DESC, A.apelido") or die(mysql_error());

	                    while($rowJgd = mysql_fetch_array($resJgd)){
	
    	                    echo "<option value='$rowJgd[idJgd]'>$rowJgd[apelido] ($rowJgd[forca])</option>";
        	            }
						echo "</optgroup>";
					}
                ?>
            </select>
        </label>
        </div>
      </div>
      
     
        <div class="linha">
          <div class="t_campo">*INÍCIO</div>
        <div class="campo"> <label> <input name="inicio" type="date" value="<?=date("Y-m-d")?>" /> </label> </div>
      </div>
      
     
        <div class="linha">
          <div class="t_campo">*FINAL</div>
        <div class="campo"> <label> <input name="final" type="date" value="2016-03-20" /> </label> </div>
      </div>
      
        <div class="linha">
          <div class="t_campo">*SALÁRIO</div>
        <div class="campo"> <label> <input name="salario" type="number" min="100000" value="100000" step="100000" max="1000000000" /> </label> </div>
      </div>
      
        <div class="linha">
          <div class="t_campo">*MULTA (%)</div>
        <div class="campo"> <label> <input name="multa" type="number" min="10" value="10" max="60" /> </label> </div>
      </div>
      
    </div>
    
    
    
         
    <button type="submit">Cadastrar</button>      
          
        
    </form>
    
    
    

</div>
<script src="include/js/chosen/chosen.jquery.js"></script>
<script src="lib/checkbox/checkbox.js"></script>
<script src="lib/rangeSlider/dist/rangeSlider.min.js"></script>
<script>
	

	$("select").chosen({no_results_text: "Não encontramos", search_contains: true, width: "510px"});
    $('input[type=checkbox], input[type=radio]').customRadioCheck();
	
</script>



