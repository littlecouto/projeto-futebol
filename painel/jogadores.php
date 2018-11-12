<div class="formulario"  style="width: 100%;">


	<?php

    include 'include/scripts/converte_data.php';
 
	$pais 	= $_GET['p'];
    $status = $_GET['s'];
    $time	= $_GET['t'];

    $filtro  = $pais	!= ''	? " AND A.idPai=$pais" : '';
    $filtro .= $status 	!= ''	? " AND A.ativo='$status'" : '';
    $filtro .= $time 	!= ''	? " AND D.idTim='$time'" : '';

    
    // PAGINAÇÃO
    $numreg = 20; // Qtde de registros por página
    $pg = $_REQUEST['pg'] == '' ? 0 : $_REQUEST['pg'];
    if (!isset($pg)) $pg = 0;
    //if (!isset($_REQUEST['pg'])) $pg = 0; else $pg = $_REQUEST['pg'];
	$inicial = $pg * $numreg;
	
	$sql = "SELECT A.idJgd, A.apelido, A.forca, C.titulo funcao, C.sigla abreviacao, A.lado, A.ativo FROM jogador A INNER JOIN jogador_x_funcao B ON A.idJgd=B.idJgd INNER JOIN jogador_funcao C ON B.idFun=C.idFun WHERE B.especialidade=1 $filtro GROUP BY A.idJgd ORDER BY forca DESC, estrela DESC, apelido";


	$sql = "SELECT * FROM jogador A INNER JOIN jogador_time D ON A.idJgd=D.idJgd WHERE A.ativo=1 $filtro ORDER BY forca DESC, estrela DESC, apelido";
    $result = mysql_query($sql." LIMIT $inicial, $numreg") or die(mysql_error().' na linha '.__LINE__);
    $quantreg = mysql_num_rows(mysql_query($sql)); // Qtde total de registros na tabela
    // FIM PAGINAÇÃO
    
    ?>

    <div class="area">    
        <form action="" method="get" id="filtro" name="pesquisa">
            <table class="semCor" style="width: 300px">
                <tr>
                    <td class="t_campo"><strong>PA&Iacute;S</strong></td>
                    <td class="t_campo"><strong>TIME</strong></td>
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
                        <select name="t" onchange="envia()" style="width:200px; font-size:16px; padding:5px;" >
                        <?php 
							$resTim = mysql_query("SELECT idTim, apelido FROM time WHERE ativo=1 ORDER BY apelido") or die(mysql_error());
							echo "<option value=\"\">Todas</option>";
							echo "<option value=\"0\" ".($_GET['t']=='0'?'selected':'').">Sem time</option>";
							while ($rowTim = mysql_fetch_array($resTim)) {
								echo "<option value='$rowTim[idTim]'".($time==$rowTim['idTim']?' selected':'').">$rowTim[apelido]</option>";
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
        <th width="5%" class="t_campo">FOR&Ccedil;A</th>
        <th width="30%" class="t_campo">T&Iacute;TULO</th>
        <th width="10%" class="t_campo">TIME</th>
        <th width="10%" class="t_campo">POSI&Ccedil;&Atilde;O</th>
        <th width="10%" class="t_campo">ESP/CAR</th>
        <th width="10%" class="t_campo">LADO</th>
        <th width="5%" class="t_campo">&nbsp;</th>
        <th width="5%" class="t_campo">&nbsp;</th>
        </tr>
    
        <?php
        // Listagem
        while($row = mysql_fetch_array($result)){
			$lado = $row['lado'];
           // Tratando dados
            if($row['ativo']){
				$status = 'ativo';
				$link   = 'des';
			}else{
				$status = 'inativo';
				$link   = 'ati';
			}
			$rowTim = mysql_fetch_array(mysql_query("SELECT A.apelido FROM time A INNER JOIN jogador_time B ON A.idTim=B.idTim WHERE B.idJgd='$row[idJgd]'"));
			
			$resCar = mysql_query("SELECT A.titulo FROM jogador_caracteristica A INNER JOIN jogador_x_caracteristica B ON A.idCar=B.idCar WHERE idJgd='$row[idJgd]' ORDER BY nivel DESC LIMIT 2") or die(mysql_error());
			$caracteristica = '';
			while($rowCar = mysql_fetch_array($resCar)){
				$caracteristica .= "$rowCar[titulo]/";
			}
			$caracteristica = substr($caracteristica, 0, -1);
			
            echo "	<tr class=\"status\">
                    <td> $row[forca] </td>
                    <td> $row[apelido] </td>
                    <td> $rowTim[apelido]</td>
                    <td title=\"$row[funcao]\"> $row[abreviacao]</td>
                    <td> $caracteristica </td>
                    <td> $lado </td>
					<td class=\"$status\" data-status=\"$status\" data-id=\"$row[idJgd]\"><a href=\"javascript:void(0)\"></a></td>
                    <td><a href='jogador-alt?id=$row[idJgd]' class=\"alterar\"><img src='include/img/bt/bt-engrenagem.png' alt='Alterar Registro' title='Alterar Registro' border='0' /></a></td>
                    </tr>";
        }
        ?> 	
    
    </table>


    <?php 
	include 'include/php/paginacao.php'; 
	echo "<p>Registros: $quantreg </p>";

	?>
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
			'jogador-status?id='+id, 
			function(s){}
		);
		
	}
);

</script>
    