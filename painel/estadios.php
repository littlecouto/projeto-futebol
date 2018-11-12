<div class="formulario"  style="width: 100%;">


	<?php


    include 'include/scripts/converte_data.php';
    
    $pais 			= $_GET['p'];
    $distrito		= $_GET['d'];
    $subdistrito	= $_GET['sd'];
    $status 		= $_GET['s'];

    $filtro  = $pais		!= ''	? " WHERE D.idPai=$pais" : '';
   	$filtro .= $distrito	!= ''	? ($filtro != ''?' AND':'WHERE')." C.idDis=$distrito": '';
   	$filtro .= $subdistrito	!= ''	? ($filtro != ''?' AND':'WHERE')." B.idSub=$subdistrito": '';
    $filtro .= $status 		!= ''	? ($filtro != ''?' AND':'WHERE')." A.ativo='$status'" : '';

		
	
    // PAGINAÇÃO
    $numreg = 25; // Qtde de registros por página
    $_GET['num'] != '' ? $numreg = $_GET['num']: '';
	
	if (!isset($pg)) $pg = 0;
    if (!isset($_REQUEST['pg'])) $pg = 0; else $pg = $_REQUEST['pg'];
	$inicial = $pg * $numreg;
    $sql = "
		SELECT A.idEst, A.apelido, B.titulo subdistrito, C.distrito, D.titulo pais, A.ativo FROM estadio A INNER JOIN pais_regiao_distrito_sub B ON A.idSub=B.idSUB INNER JOIN pais_regiao_distrito C ON A.idDis=C.idDis INNER JOIN pais D ON C.idPai=D.idPai $filtro ORDER BY A.apelido";
    $result = mysql_query($sql." LIMIT $inicial, $numreg") or die(mysql_error().' na linha '.__LINE__);
    $quantreg = mysql_num_rows(mysql_query($sql)); // Qtde total de registros na tabela
    // FIM PAGINAÇÃO
    
    ?>
    <div class="area">    
        <form action="" method="get" id="filtro" name="pesquisa">
            <table class="semCor" style="width: 300px">
                <tr>
                    <td class="t_campo"><strong>PA&Iacute;S</strong></td>
                    <td class="t_campo"><strong>DISTRITO</strong></td>
                    <td class="t_campo"><strong>SUB DISTRITO</strong></td>
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
                        <select name="d" onchange="envia()" style="width:200px; font-size:16px; padding:5px;" >
                        <?php 
							$filDis = $pais >0 ? "AND idPai='$pais'": '';
							$resDis = mysql_query("SELECT idDis, distrito FROM pais_regiao_distrito WHERE ativo=1 $filDis ORDER BY distrito") or die(mysql_error());
							echo "<option value=\"\">Todas</option>";
							echo "<option value=\"0\" ".($_GET['r']=='0'?'selected':'').">Sem distrito</option>";
							while ($rowDis = mysql_fetch_array($resDis)) {
								echo "<option value='$rowDis[idDis]'".($distrito==$rowDis['idDis']?' selected':'').">$rowDis[distrito]</option>";
							}
                    
						?>
                        </select>
                    </td>

                    <td>
                        <select name="sd" onchange="envia()" style="width:200px; font-size:16px; padding:5px;" >
                        <?php 
							$filSub = $distrito >0 ? "AND idDis='$distrito'": '';
							$resSub = mysql_query("SELECT idSub, titulo FROM pais_regiao_distrito_sub WHERE ativo=1 $filSub ORDER BY titulo") or die(mysql_error());
							echo "<option value=\"\">Todos</option>";
							echo "<option value=\"0\" ".($_GET['sd']=='0'?'selected':'').">Sem sub distrito</option>";
							while ($rowSub = mysql_fetch_array($resSub)) {
								echo "<option value='$rowSub[idSub]'".($subdistrito==$rowSub['idSub']?' selected':'').">$rowSub[titulo]</option>";
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
        <th width="18%" class="t_campo">EST&Aacute;DIO</th>
        <th width="18%" class="t_campo">SUB DISTRITO</th>
        <th width="18%" class="t_campo">DISTRITO</th>
        <th width="18%" class="t_campo">PA&Iacute;S</th>
        <th width="18%" class="t_campo">TIMES</th>
        <th width="5%" class="t_campo">&nbsp;</th>
        <th width="5%" class="t_campo">&nbsp;</th>
        <th width="5%" class="t_campo">&nbsp;</th>
        </tr>
        
        <?php
        // Listagem
        while($row = mysql_fetch_array($result)){
			$times = '';
			$resTim = mysql_query("SELECT apelido FROM time WHERE idEst='$row[idEst]'");
            while($rowTim = mysql_fetch_array($resTim)){
				$times .= "$rowTim[apelido], ";
			}
			$times = substr($times, 0, -2);
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
                    <td> $row[apelido]</td>
                    <td> $row[subdistrito] </td>
                    <td> $row[distrito] </td>
                    <td> $row[pais] </td>
                    <td> $times </td>
					<td class=\"statusInfo\" data-id=\"$row[idEst]\">".strtoupper($status)."</td>
					<td class=\"$status\" data-status=\"$status\" data-id=\"$row[idEst]\"><a href=\"javascript:void(0)\"></a></td>
                    <td><a href='estadio-alt?id=$row[idEst]' class=\"alterar\"><img src='include/img/bt/bt-engrenagem.png' alt='Alterar Registro' title='Alterar Registro' border='0' /></a></td>
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
