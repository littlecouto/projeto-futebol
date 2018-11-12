<div class="formulario"  style="width: 100%;">


	<?php


    include 'include/scripts/converte_data.php';
    
    $pais 		= $_GET['p'];
    $distrito 	= $_GET['d'];
    $status 	= $_GET['s'];

	$filtro  =
	$pais < 1
		?''
		:" WHERE T.idPai='$pais'"
	;
	
	$filtro  .=
	$distrito < 1
		?''
		:($filtro != ''
				?' AND'
				:'WHERE'
		  	)." T.idDis='$distrito'"
	;
	
	$filtro  .=
	$status != ''
		? 	($filtro != ''
				?' AND'
				:'WHERE'
		  	)." ativo='$status'"
		:''
	;
	
	
    // PAGINAÇÃO
    $numreg = 25; // Qtde de registros por página
    if (!isset($pg)) $pg = 0;
    if (!isset($_REQUEST['pg'])) $pg = 0; else $pg = $_REQUEST['pg'];
	$inicial = $pg * $numreg;
    $sql = "
		SELECT 
			T.idTim,
			T.nome, 
			T.apelido, 
			(SELECT ROUND(AVG(J.forca)) FROM jogador J, jogador_time C WHERE J.ativo=1 AND T.idTim=C.idTim AND C.idJgd=J.idJgd) as FORCAS,
			T.ativo 
		FROM time T 
		$filtro 
		ORDER BY FORCAS DESC, apelido";
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
                    <td class="t_campo"><strong>STATUS</strong></td>
                </tr>
                
                <tr>
                    <td><select name="p" onchange="envia()" style="width:200px; font-size:16px; padding:5px;" >
                    <?php 
                    $resPai = mysql_query("SELECT P.idPai, P.titulo FROM pais P INNER JOIN time T ON P.idPai=T.idPai GROUP BY P.titulo ORDER BY P.titulo") or die(mysql_error());
                    echo "<option value=\"0\">TODOS</option>";
                    while ($rowPai = mysql_fetch_array($resPai)) {
                        echo "<option value='$rowPai[idPai]'".($pais==$rowPai['idPai']?' selected':'').">$rowPai[titulo]</option>";
                    }
                
                     ?>
                    </select></td>

                    <td><select name="d" onchange="envia()" style="width:200px; font-size:16px; padding:5px;" >
                    <?php 
					
					$filDis = $pais >0? "AND A.idPai='$pais'": '';
                    $resDis = mysql_query("SELECT A.idDis, A.distrito FROM pais_regiao_distrito A INNER JOIN time B ON A.idDis=B.idDis WHERE A.ativo=1 AND B.ativo=1 $filDis GROUP BY A.idDis ORDER BY A.distrito") or die(mysql_error());
                    echo "<option value=\"0\">TODOS</option>";
                    while ($rowDis = mysql_fetch_array($resDis)) {
                        echo "<option value='$rowDis[idDis]'".($distrito==$rowDis['idDis']?' selected':'').">$rowDis[distrito]</option>";
                    }
                
                     ?>
                    </select></td>

                    <td><select name="s" onchange="envia()" style="width:200px; font-size:16px; padding:5px;" >
                    <option value=""  <?=$_GET['s']=='' ?'selected':''?>>TODOS</option>    
                    <option value="1" <?=$_GET['s']=='1'?'selected':''?>>ATIVO</option>
                    <option value="0" <?=$_GET['s']=='0'?'selected':''?>>INATIVO</option>
                    </select></td>
                </tr>
            </table>
        </form>
   </div>     
   
    <table class="listagem" width="100%" border="0" cellpadding="3" cellspacing="0">
        <tr>
        <th width="10%" class="t_campo">FORÇA</th>
        <th width="32.5%" class="t_campo">NOME</th>
        <th width="32.5%" class="t_campo">APELIDO</th>
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
            echo "	<tr class=\"status\">
                    <td> $row[FORCAS] </td>
                    <td> $row[nome] </td>
                    <td> $row[apelido] </td>
					<td class=\"statusInfo\" data-id=\"$row[idTim]\">".strtoupper($status)."</td>
					<td class=\"$status\" data-status=\"$status\" data-id=\"$row[idTim]\"><a href=\"javascript:void(0)\"></a></td>
                    <td><a href='time-alt?id=$row[idTim]' class=\"alterar\"><img src='include/img/bt/bt-engrenagem.png' alt='Alterar Registro' title='Alterar Registro' border='0' /></a></td>
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
			'time-status?id='+id, 
			function(s){}
		);
		
	}
);

</script>
