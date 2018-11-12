<div class="formulario"  style="width: 100%;">


	<?php


    include 'include/scripts/converte_data.php';

		
	


    $sql = "
		SELECT idCar, titulo, sigla, ativo FROM jogador_caracteristica ORDER BY ordem";
    $result = mysql_query($sql) or die(mysql_error().' na linha '.__LINE__);
    $quantreg = mysql_num_rows(mysql_query($sql)); // Qtde total de registros na tabela
    // FIM PAGINAÇÃO
    
    ?>
  
    <table class="listagem" width="100%" border="0" cellpadding="3" cellspacing="0">
        <tr>
        <th width="45%" class="t_campo">CARACTER&Iacute;STICA</th>
        <th width="40%" class="t_campo">SIGLA</th>
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
                    <td> $row[sigla] </td>
					<td class=\"statusInfo\" data-id=\"$row[idCar]\">".strtoupper($status)."</td>
					<td class=\"$status\" data-status=\"$status\" data-id=\"$row[idCar]\"><a href=\"javascript:void(0)\"></a></td>
                    <td><a href='jogador-caracteristica-alt?id=$row[idCar]' class=\"alterar\"><img src='include/img/bt/bt-engrenagem.png' alt='Alterar Registro' title='Alterar Registro' border='0' /></a></td>
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
