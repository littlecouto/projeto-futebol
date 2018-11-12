<div class="formulario"  style="width: 100%;">


	<?php


    include 'include/scripts/converte_data.php';
    
    $continente 	= $_GET['c'];
    $status = $_GET['s'];

    $filtro  = $continente 	== ''  ? '' : " WHERE idCon=$continente";
    $filtro .= $status != '' ? ($filtro != ''?' AND':'WHERE')." ativo='$status'" : '';

		
	
    // PAGINAÇÃO
    $numreg = 25; // Qtde de registros por página
    $_GET['num'] != '' ? $numreg = $_GET['num']: '';
	
	if (!isset($pg)) $pg = 0;
    if (!isset($_REQUEST['pg'])) $pg = 0; else $pg = $_REQUEST['pg'];
	$inicial = $pg * $numreg;
    $sql = "
		SELECT idPai, idCon, titulo, sigla_3, ordem,  ativo FROM pais $filtro ORDER BY ordem , titulo";
    $result = mysql_query($sql." LIMIT $inicial, $numreg") or die(mysql_error().' na linha '.__LINE__);
    $quantreg = mysql_num_rows(mysql_query($sql)); // Qtde total de registros na tabela
    // FIM PAGINAÇÃO
    
    ?>
    <div class="area">    
        <form action="" method="get" id="filtro" name="pesquisa">
            <table class="semCor" style="width: 300px">
                <tr>
                    <td class="t_campo"><strong>CONTINENTE</strong></td>
                    <td class="t_campo"><strong>STATUS</strong></td>
                    <td class="t_campo"><strong>QUANTIDADE</strong></td>
                </tr>
                
                <tr>
                    <td><select name="c" onchange="envia()" style="width:200px; font-size:16px; padding:5px;" >
                    <?php 
                    $resCon = mysql_query("SELECT idCon, continente FROM continente WHERE ativo=1 ORDER BY continente") or die(mysql_error());
                    echo "<option value=\"\">Todos</option>";
                    echo "<option value=\"0\" ".($_GET['c']=='0'?'selected':'').">Sem continente</option>";
                    while ($rowCon = mysql_fetch_array($resCon)) {
                        echo "<option value='$rowCon[idCon]'".($continente==$rowCon['idCon']?' selected':'').">$rowCon[continente]</option>";
                    }
                
                     ?>
                    </select></td>
                    
                    <td><select name="s" onchange="envia()" style="width:200px; font-size:16px; padding:5px;" >
                    <option value=""  <?=$_GET['s']=='' ?'selected':''?>>TODOS</option>    
                    <option value="1" <?=$_GET['s']=='1'?'selected':''?>>ATIVO</option>
                    <option value="0" <?=$_GET['s']=='0'?'selected':''?>>INATIVO</option>
                    </select></td>

                    <td><select name="num" onchange="envia()" style="width:200px; font-size:16px; padding:5px;" >
                    <option value="4"  <?=$_GET['num']=='4' ?'selected':''?>>4</option>    
                    <option value="8"  <?=$_GET['num']=='8' ?'selected':''?>>8</option>    
                    <option value="16"  <?=$_GET['num']=='16' ?'selected':''?>>16</option>    
                    <option value="20"  <?=($_GET['num']=='20' or $_GET['num'] == '') ?'selected':''?>>20</option>    
                    <option value="32"  <?=$_GET['num']=='32' ?'selected':''?>>32</option>    
                    <option value="64"  <?=$_GET['num']=='64' ?'selected':''?>>64</option>    
                    </select></td>
                </tr>
            </table>
        </form>
   </div>     
   
    <table class="listagem" width="100%" border="0" cellpadding="3" cellspacing="0">
        <tr>
        <th width="10%" class="t_campo">#</th>
        <th width="32%" class="t_campo">PA&Iacute;S</th>
        <th width="22%" class="t_campo">CONTINENTE</th>
        <th width="10%" class="t_campo">SIGLA</th>
        <th width="5%" class="t_campo">&nbsp;</th>
        <th width="5%" class="t_campo">&nbsp;</th>
        <th width="5%" class="t_campo">&nbsp;</th>
        </tr>
        
        <?php
        // Listagem
        while($row = mysql_fetch_array($result)){
			
            $rowCon = mysql_fetch_array(mysql_query("SELECT continente FROM continente WHERE idCon='$row[idCon]'"));
            // Tratando dados
            if($row['ativo']){
				$status = 'ativo';
				$link   = 'des';
			}else{
				$status = 'inativo';
				$link   = 'ati';
			}
            echo "	<tr class=\"status\">
                    <td> $row[ordem] </td>
                    <td> $row[titulo] </td>
                    <td> $rowCon[continente] </td>
                    <td> $row[sigla_3] </td>
					<td class=\"statusInfo\" data-id=\"$row[idPai]\">".strtoupper($status)."</td>
					<td class=\"$status\" data-status=\"$status\" data-id=\"$row[idPai]\"><a href=\"javascript:void(0)\"></a></td>
                    <td><a href='pais-alt?id=$row[idPai]' class=\"alterar\"><img src='include/img/bt/bt-engrenagem.png' alt='Alterar Registro' title='Alterar Registro' border='0' /></a></td>
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
			'pais-status?id='+id, 
			function(s){}
		);
		
	}
);

</script>
