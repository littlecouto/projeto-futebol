<div class="formulario"  style="width: 100%;">


	<?php


    include 'include/scripts/converte_data.php';
    
    // PAGINAÇÃO
    !isset($_GET['m']) ? $mandante = 20	 : $mandante  = $_GET['m'];
    !isset($_GET['v']) ? $visitante = 28 : $visitante = $_GET['v'];
    $sql    = "SELECT 
        mandante, 
        visitante, 
        J.idJog, 
        (SELECT M.apelido FROM times M WHERE J.mandante=M.idTim) man, 
        (SELECT V.apelido FROM times V WHERE J.visitante=V.idTim) vis, 
        (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.mandante AND E.idAca=1) +
        (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.visitante AND E.idAca=5) golM, 

        (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.visitante AND E.idAca=1) +
        (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.mandante AND E.idAca=5) golV,
        (SELECT L.nome FROM estadio L WHERE J.idEst=L.idEst) estadio, 
        rodada, 
        turno, 
        (SELECT temporada FROM jogo_temporada TMP WHERE TMP.idTem=J.idTem) temporada, 
        divisao 
    FROM 
        jogo J 
    WHERE  realizado=1 AND
		((J.visitante='$mandante' AND J.visitante='$visitante') OR (J.visitante='$mandante' AND J.mandante='$visitante'))
    ORDER BY 
    temporada, J.idJog";
    $result = mysql_query($sql) or die(mysql_error().' na linha '.__LINE__);
    $jogos = mysql_num_rows(mysql_query($sql));
    ?>


    <form action="" method="get" id="filtro">
    
    
    <table class="semCor" style="width: 200px">
    <tr>
    	<td class="t_campo"><strong>&nbsp;</strong></td>
    	<td class="t_campo"><strong>&nbsp;</strong></td>
    </tr>
    <tr>
    	<td>
            <select name="m" style="width: 200px;">
				<?php 
            
                $resMan = mysql_query("SELECT idTim, apelido FROM time WHERE idPai=1 ORDER BY apelido");
                while ($rowMan = mysql_fetch_array($resMan)) {
                    echo "<option value='$rowMan[idTim]'".($mandante==$rowMan['idTim']?' selected':'').">$rowMan[apelido]</option>";
                }
            
                 ?>
		    </select>
		</td>
        <td>    
            <select name="v" style="width: 200px;">
				<?php 
                
                $resVis = mysql_query("SELECT idTim, apelido FROM time WHERE idPai=1 ORDER BY apelido");
                while ($RowVis = mysql_fetch_array($resVis)) {
					echo "<option value='$RowVis[idTim]'".($visitante==$RowVis['idTim']?' selected':'').">$RowVis[apelido]</option>";
                }
                
                ?>
            </select>
        </td>
    </tr>
</table>
</form>
    
    <table class="listagem" width="100%" border="0" cellpadding="3" cellspacing="0">
        <tr>
        <th width="5%" class="t_campo" title="TEMPORADA">TEM</th>
        <th width="5%" class="t_campo" title="DIVIS&Atilde;O">DIV</th>
        <th width="5%" class="t_campo" title="RODADA">ROD</th>
        <th width="5%" class="t_campo" title="TURNO">TUR</th>
        <th width="20%" class="t_campo">ESTÁDIO</th>
        <th width="20%" class="t_campo">MANDANTE</th>
        <th width="15%" class="t_campo">RESULTADO</th>
        <th width="20%" class="t_campo">VISITANTE</th>
        <th width="5%" class="t_campo">&nbsp;</th>
        </tr>
    
        <?php
        // Listagem
        $VitM = $VitV = $golM = $golV = 0;
        while($row = mysql_fetch_array($result)){
            if($mandante == $row['mandante']){
                $golM = $golM+$row['golM'];
                $golV = $golV+$row['golV'];
                if($row['golM']>$row['golV']){
                    $VitM++; 
                }elseif($row['golM']<$row['golV']){
                    $VitV++;
                }
            }elseif($mandante == $row['visitante']){
                $golV = $golV+$row['golV'];
                $golM = $golM+$row['golM'];
               if($row['golM']>$row['golV']){
                    $VitV++; 
                }elseif($row['golM']<$row['golV']){
                    $VitM++;
                }
			
            }
            // Tratando dados
            
            echo "	<tr>
                    <td valign=\"top\"> $row[temporada] </td>
                    <td> $row[divisao] </td>
                    <td> $row[rodada] </td>
                    <td> $row[turno]     </td>
                    <td> $row[estadio] </td>
                    <td> $row[man] </td>
                    <td> $row[golM]x$row[golV] </td>
                    <td valign=\"top\"> $row[vis] </td>
                    <td><a href='campeonato-jogos-info?j=$row[idJog]'><img src='include/img/bt/bt_alterar.gif' alt='Alterar Registro' title='Alterar Registro' border='0' /></a></td>
                    </tr>";
        }
		$empates = abs(($VitM+$VitV)-$jogos);
		$gols	 = $golM+$golV;
		
		@$medJ = round($gols/$jogos,2);
		@$medM = round($golM/$jogos,2);
		@$medV = round($golV/$jogos,2);
		
        $rowM = mysql_fetch_array(mysql_query("SELECT apelido FROM time WHERE idTim=$mandante"));
        $rowV = mysql_fetch_array(mysql_query("SELECT apelido FROM time WHERE idTim=$visitante"));
        echo "<p>$jogos jogos entre $rowM[apelido] e $rowV[apelido] ($empates empates) <br> $gols gols | $medJ gols por jogo</br>";
        echo "$VitM vitorias do $rowM[apelido] | $golM gols | $medM gols por jogo </br>";
        echo "$VitV vitorias do $rowV[apelido] | $golV gols | $medV gols por jogo</p>";

        ?> 	
        <br />
    
    </table>
<script>
$('#filtro select').change(function(e) {
    $('#filtro').submit();
});
</script>