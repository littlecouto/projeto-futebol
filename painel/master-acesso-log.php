<div class="formulario" style="width: 100%;">



        
	<?php
    $resultUsu = mysql_query("SELECT idAce, datalogin, datalogout, ip, so, browser FROM painel_acesso WHERE idUsu=$_SESSION[USUARIO] ORDER BY idAce DESC");
    $numero = mysql_num_rows($resultUsu);
    echo "<div>Foram encontrados <strong>$numero registro(s)</strong></div>";
    ?>
        
    <table width="100%" border="0" cellpadding="3" cellspacing="0">
        <tr>
        <th width="20%" class="t_campo"> Sessão iniciada </th>
        <th width="20%" class="t_campo"> Sessão encerrada </th>
        <th width="20%" class="t_campo"> IP </th>
        <th width="20%" class="t_campo"> Sistema Op. </th>
        <th width="20%" class="t_campo"> Navegador </th>
        </tr>
    
        <?php
        include 'include/scripts/converte_data.php';
        
        while($row = mysql_fetch_array($resultUsu)){
			
			$datalogin = datetime($row['datalogin']);
			$datalogout = datetime($row['datalogout']);
            
            echo "	<tr onMouseOver=\"bgr_color(this, '#E0E0E0')\" onMouseOut=\"bgr_color(this, '#FFFFFF')\">";
            echo "	<td>$datalogin</td>";
			echo "	<td>$datalogout</td>";
			echo "	<td>$row[ip]</td>";
			echo "	<td>$row[so]</td>";
			echo "	<td>$row[browser]</td>";
            echo "	</tr>";
        }
        ?> 	
    
    </table>


</div>