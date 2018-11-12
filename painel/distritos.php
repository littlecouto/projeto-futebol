<div class="formulario"  style="width: 100%;">


	<?php


    include 'include/scripts/converte_data.php';
    
    $pais 	= $_GET['p'];
    $regiao	= $_GET['r'];
    $status = $_GET['s'];

    $filtro  = $pais	!= ''	? " WHERE A.idPai=$pais" : '';
    $filtro .= $regiao	!= ''	? ($filtro != ''?' AND':'WHERE')." A.idReg=$regiao": '';
    $filtro .= $status 	!= ''	? ($filtro != ''?' AND':'WHERE')." A.ativo='$status'" : '';

		
	
    // PAGINAÇÃO
    $numreg = 25; // Qtde de registros por página
    $_GET['num'] != '' ? $numreg = $_GET['num']: '';
	
	if (!isset($pg)) $pg = 0;
    if (!isset($_REQUEST['pg'])) $pg = 0; else $pg = $_REQUEST['pg'];
	$inicial = $pg * $numreg;
    $sql = "
		SELECT A.idDis, B.titulo regiao, C.titulo pais, A.idReg, A.distrito, A.sigla, A.tipo, A.ativo FROM pais_regiao_distrito A INNER JOIN pais_regiao B ON A.idReg=B.idReg INNER JOIN pais C ON A.idPai=C.idPai $filtro ORDER BY A.ordem, B.ordem, C.ordem, A.distrito";
    $result = mysql_query($sql." LIMIT $inicial, $numreg") or die(mysql_error().' na linha '.__LINE__);
    $quantreg = mysql_num_rows(mysql_query($sql)); // Qtde total de registros na tabela
    // FIM PAGINAÇÃO
    
    ?>
    <div class="area">    
        <form action="" method="get" id="filtro" name="pesquisa">
            <table class="semCor" style="width: 300px">
                <tr>
                    <td class="t_campo"><strong>PA&Iacute;S</strong></td>
                    <td class="t_campo"><strong>REGI&Atilde;O</strong></td>
                    <td class="t_campo"><strong>STATUS</strong></td>
                </tr>
                
                <tr>
                    <td>
                        <select name="p" onchange="envia()" style="width:200px; font-size:16px; padding:5px;" >
                        <?php 
							$resPai = mysql_query("SELECT idPai, titulo FROM pais WHERE ativo=1 ORDER BY ordem") or die(mysql_error());
							echo "<option value=\"\">Todas</option>";
							echo "<option value=\"0\" ".($_GET['p']=='0'?'selected':'').">Sem pa&iacute;s</option>";
							while ($rowPai = mysql_fetch_array($resPai)) {
								echo "<option value='$rowPai[idPai]'".($pais==$rowPai['idPai']?' selected':'').">$rowPai[titulo]</option>";
							}
                    
						?>
                        </select>
                    </td>
                    
                    
                    <td>
                        <select name="r" onchange="envia()" style="width:200px; font-size:16px; padding:5px;" >
                        <?php 
							$resReg = mysql_query("SELECT idReg, titulo FROM pais_regiao WHERE ativo=1 ORDER BY ordem") or die(mysql_error());
							echo "<option value=\"\">Todas</option>";
							echo "<option value=\"0\" ".($_GET['r']=='0'?'selected':'').">Sem regi&atilde;o</option>";
							while ($rowReg = mysql_fetch_array($resReg)) {
								echo "<option value='$rowReg[idReg]'".($regiao==$rowReg['idReg']?' selected':'').">$rowReg[titulo]</option>";
							}
                    
						?>
                        </select>
                    </td>
                    
                    
                    
                    <td><select name="s" onchange="envia()" style="width:200px; font-size:16px; padding:5px;" >
                    <option value=""  <?=$_GET['s']=='' ?'selected':''?>>Todos</option>    
                    <option value="1" <?=$_GET['s']=='1'?'selected':''?>>Ativo</option>
                    <option value="0" <?=$_GET['s']=='0'?'selected':''?>>Inativo</option>
                    </select></td>
                </tr>
            </table>
        </form>
   </div>     
   
    <table class="listagem" width="100%" border="0" cellpadding="3" cellspacing="0">
        <tr>
        <th width="22%" class="t_campo">DISTRITO</th>
        <th width="21%" class="t_campo">REGI&Atilde;O</th>
        <th width="21%" class="t_campo">PA&Iacute;S</th>
        <th width="10%" class="t_campo">SIGLA</th>
        <th width="5%" class="t_campo">&nbsp;</th>
        <th width="5%" class="t_campo">&nbsp;</th>
        <th width="5%" class="t_campo">&nbsp;</th>
        </tr>
        
        <?php
        // Listagem
        while($row = mysql_fetch_array($result)){
			
            $rowPai = mysql_fetch_array(mysql_query("SELECT titulo FROM pais WHERE idPai='$row[idPai]'"));
            $rowReg = mysql_fetch_array(mysql_query("SELECT titulo FROM pais_regiao WHERE idReg='$row[idReg]'"));
            // Tratando dados
            if($row['ativo']){
				$status = 'ativo';
				$link   = 'des';
			}else{
				$status = 'inativo';
				$link   = 'ati';
			}
			
			$regiao = $rowReg['titulo'] == '' ? 'Sem regi&atilde;o': $rowReg['titulo'];
			
            echo "	<tr class=\"status\">
                    <td> $row[distrito] </td>
                    <td> $row[regiao]</td>
                    <td> $row[pais] </td>
                    <td> $row[sigla] </td>
					<td class=\"statusInfo\" data-id=\"$row[idDis]\">".strtoupper($status)."</td>
					<td class=\"$status\" data-status=\"$status\" data-id=\"$row[idDis]\"><a href=\"javascript:void(0)\"></a></td>
                    <td><a href='distrito-alt?id=$row[idDis]' class=\"alterar\"><img src='include/img/bt/bt-engrenagem.png' alt='Alterar Registro' title='Alterar Registro' border='0' /></a></td>
                    </tr>";
        }


        ?> 	
    </table>


    <?php 
	include 'include/php/paginacao.php'; 
	echo "<p>Registros: $quantreg </p>";

	?>
    
    
    
    
    
    
<!-- CONTEÚDO ACIMA -->
</div>
<script src="include/js/jquery-2.1.4.js"></script>
<script>
function envia(){
	document.pesquisa.submit();
}

$('td[class*=ativo').click(
	function(){
		var id 		= $(this).attr('data-id'),
			status	= $(this).attr('data-status');

		if(status === 'ativo'){
			$(this).removeClass('ativo').addClass('inativo').attr('data-status', 'inativo');
			$('.statusInfo[data-id='+id+']').html('INATIVO');
		}else{
			$(this).removeClass('inativo').addClass('ativo').attr('data-status', 'ativo');
			$('.statusInfo[data-id='+id+']').html('ATIVO');
		}
		
		$.ajax(
			'distrito-status?id='+id, 
			function(s){}
		);
		
	}
);

</script>
