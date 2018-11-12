<div class="formulario"  style="width: 100%;">


	<?php


    include 'include/scripts/converte_data.php';
    
    $status = $_GET['s'];

    $filtro = $status != ''	? $filtro = " WHERE ativo='$status'" : '';

		
	
    // PAGINAÇÃO
    $numreg = 25; // Qtde de registros por página
    $_GET['num'] != '' ? $numreg = $_GET['num']: '';
	
	if (!isset($pg)) $pg = 0;
    if (!isset($_REQUEST['pg'])) $pg = 0; else $pg = $_REQUEST['pg'];
	$inicial = $pg * $numreg;
    $sql = "
		SELECT idReg, titulo, sigla, ordem, ativo FROM pais_regiao $filtro ORDER BY ordem, titulo";
    $result = mysql_query($sql." LIMIT $inicial, $numreg") or die(mysql_error().' na linha '.__LINE__);
    $quantreg = mysql_num_rows(mysql_query($sql)); // Qtde total de registros na tabela
    // FIM PAGINAÇÃO
    
    ?>
    <div class="area">    
        <form action="" method="get" id="filtro" name="pesquisa">
            <table class="semCor" style="width: 300px">
                <tr>
                    <td class="t_campo"><strong>STATUS</strong></td>
                </tr>
                
                <tr>                    
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
        <th width="10%" class="t_campo">#</th>
        <th width="52%" class="t_campo">REGI&Atilde;O</th>
        <th width="10%" class="t_campo">SIGLA</th>
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
                    <td> $row[ordem] </td>
                    <td> $row[titulo] </td>
                    <td> $row[sigla] </td>
					<td class=\"statusInfo\" data-id=\"$row[idReg]\">".strtoupper($status)."</td>
					<td class=\"$status\" data-status=\"$status\" data-id=\"$row[idReg]\"><a href=\"javascript:void(0)\"></a></td>
                    <td><a href='regiao-alt?id=$row[idReg]' class=\"alterar\"><img src='include/img/bt/bt-engrenagem.png' alt='Alterar Registro' title='Alterar Registro' border='0' /></a></td>
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
			'regiao-status?id='+id, 
			function(s){}
		);
		
	}
);

</script>
