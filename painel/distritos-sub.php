<div class="formulario"  style="width: 100%;">


	<?php


    include 'include/scripts/converte_data.php';
    
    $continente	= $_GET['c'];
    $pais 		= $_GET['p'];
    $regiao		= $_GET['r'];
    $distrito	= $_GET['d'];
    $status 	= $_GET['s'];

    $filtro  = $continente	!= ''	? " WHERE E.idCon=$continente" : '';
    $filtro .= $pais		!= ''	? ($filtro != ''?' AND':'WHERE')." D.idPai=$pais": '';
    $filtro .= $regiao		!= ''	? ($filtro != ''?' AND':'WHERE')." C.idReg=$regiao": '';
    $filtro .= $distrito	!= ''	? ($filtro != ''?' AND':'WHERE')." B.idDis=$distrito": '';
    $filtro .= $status 		!= ''	? ($filtro != ''?' AND':'WHERE')." A.ativo='$status'" : '';

		
	
    // PAGINAÇÃO
    $numreg = 25; // Qtde de registros por página
    $_GET['num'] != '' ? $numreg = $_GET['num']: '';
	
	if (!isset($pg)) $pg = 0;
    if (!isset($_REQUEST['pg'])) $pg = 0; else $pg = $_REQUEST['pg'];
	$inicial = $pg * $numreg;
    $sql = "
		SELECT A.idSub, A.titulo, B.distrito, C.titulo regiao, D.titulo pais, E.continente, A.ativo FROM pais_regiao_distrito_sub A INNER JOIN pais_regiao_distrito B ON A.idDis=B.idDis INNER JOIN pais_regiao C ON B.idReg=C.idReg INNER JOIN pais D ON B.idPai=D.idPai INNER JOIN continente E ON D.idCon=E.idCon $filtro ORDER BY titulo, distrito, regiao, pais";
    $result = mysql_query($sql." LIMIT $inicial, $numreg") or die(mysql_error().' na linha '.__LINE__);
    $quantreg = mysql_num_rows(mysql_query($sql)); // Qtde total de registros na tabela
    // FIM PAGINAÇÃO
    
    ?>
    <div class="area">    
        <form action="" method="get" id="filtro" name="pesquisa">
            <table class="semCor" style="width: 300px">
                <tr>
                    <td class="t_campo"><strong>CONTINENTE</strong></td>
                    <td class="t_campo"><strong>PA&Iacute;S</strong></td>
                    <td class="t_campo"><strong>REGI&Atilde;O</strong></td>
					<?php if($_GET['p'] >0 or $_GET['r']>0){?>
                    <td class="t_campo"><strong>DISTRITO</strong></td>
                    <?php } ?>
                    <td class="t_campo"><strong>STATUS</strong></td>
                </tr>
                
                <tr>
                    <td>
                        <select name="c" onchange="envia()" style="width:200px; font-size:16px; padding:5px;" >
                        <?php 
							$resCon = mysql_query("SELECT idCon, continente FROM continente WHERE ativo=1 ORDER BY continente") or die(mysql_error());
							echo "<option value=\"\">Todos</option>";
							while ($rowCon = mysql_fetch_array($resCon)) {
								echo "<option value='$rowCon[idCon]'".($continente==$rowCon['idCon']?' selected':'').">$rowCon[continente]</option>";
							}
                    
						?>
                        </select>
                    </td>
                    
                    <td>
                        <select name="p" onchange="envia()" style="width:200px; font-size:16px; padding:5px;" >
                        <?php 
							$filPai = $continente == '' ? '': "AND idCon='$continente'";
							$resPai = mysql_query("SELECT idPai, titulo FROM pais WHERE ativo=1 $filPai ORDER BY ordem") or die(mysql_error());
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
                    
                    
					<?php if($_GET['p'] >0 or $_GET['r']>0){?>
                    <td>
                        <select name="d" onchange="envia()" style="width:200px; font-size:16px; padding:5px;" >
                        <?php 
							$filDis = "";
							if($regiao>0){
								$filDis .= " AND idReg='$regiao'";
							}
							if($pais>0){
								$filDis .= " AND idPai='$pais'";
							}
							
							
							$resDis = mysql_query("SELECT idDis, distrito FROM pais_regiao_distrito WHERE ativo=1 $filDis ORDER BY distrito") or die(mysql_error());
							echo "<option value=\"\">Todos</option>";
							echo "<option value=\"0\" ".($_GET['d']=='0'?'selected':'').">Sem sub distrito</option>";
							while ($rowDis = mysql_fetch_array($resDis)) {
								echo "<option value='$rowDis[idDis]'".($distrito==$rowDis['idDis']?' selected':'').">$rowDis[distrito]</option>";
							}
                    
						?>
                        </select>
                    </td>
                    <?php } ?>
                   
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
        <th width="20%" class="t_campo">SUB DISTRITO</th>
        <th width="20%" class="t_campo">DISTRITO</th>
        <th width="20%" class="t_campo">REGI&Atilde;O</th>
        <th width="20%" class="t_campo">PA&Iacute;S</th>
        <th width="20%" class="t_campo">CONTINENTE</th>
        <th width="5%" class="t_campo">&nbsp;</th>
        <th width="5%" class="t_campo">&nbsp;</th>
        <th width="5%" class="t_campo">&nbsp;</th>
        </tr>
        
        <?php
        // Listagem
        while($row = mysql_fetch_array($result)){
			
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
                    <td> $row[titulo] </td>
                    <td> $row[distrito] </td>
                    <td> $row[regiao]</td>
                    <td> $row[pais] </td>
                    <td> $row[continente] </td>
					<td class=\"statusInfo\" data-id=\"$row[idSub]\">".strtoupper($status)."</td>
					<td class=\"$status\" data-status=\"$status\" data-id=\"$row[idSub]\"><a href=\"javascript:void(0)\"></a></td>
                    <td><a href='distrito-sub-alt?id=$row[idSub]' class=\"alterar\"><img src='include/img/bt/bt-engrenagem.png' alt='Alterar Registro' title='Alterar Registro' border='0' /></a></td>
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
			'distrito-sub-status?id='+id, 
			function(s){}
		);
		
	}
);

</script>
