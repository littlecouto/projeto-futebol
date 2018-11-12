<?php 
$sql = "SELECT A.divisao, B.temporada, B.idTem FROM jogo A INNER JOIN jogo_temporada B ON A.idTem=B.idTem WHERE B.idTem='$_GET[t]' AND A.divisao='$_GET[d]' GROUP BY A.idTem";
$query = mysql_query($sql) or die(mysql_error());
$row = mysql_fetch_array($query);
$divisao 	= $row['divisao'];
$temporada 	= $row['temporada'];
$idTem 		= $row['idTem'];
?>









<h2><?=$divisao?>ª divisão/ temporada <?=$temporada?></h2>
<br />
<div class="formulario"  style="width: 100%;">


	<?php


    include 'include/scripts/converte_data.php';
    
    // PAGINAÇÃO
    $pos = 1;
    $sql = "SELECT
    (SELECT t.apelido FROM time t WHERE t.idTim=equipe) as time,
    count(*) J, 
    SUM(
          case when golM > golV then 3 else 0 end 
        + case when golM = golV then 1 else 0 end
    ) P, 
    count(case when golM > golV then 1 end) V, 
    count(case when golM = golV then 1 end) E, 
    count(case when golV> golM then 1 end) D, 
    SUM(golM) GP, 
    SUM(golV) GC, 
    SUM(golM) - SUM(golV) SG
FROM (
    SELECT mandante equipe, 
        (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.mandante AND E.idAca=1) +
        (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.visitante AND E.idAca=5) golM, 

        (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.visitante AND E.idAca=1) +
        (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.mandante AND E.idAca=5) golV 
    FROM jogo J
    WHERE idTem = '$idTem' AND divisao='$divisao'
    
  union all
    SELECT visitante, 
        (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.visitante AND E.idAca=1) + 
        (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.mandante AND E.idAca=5) golV, 

        (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.mandante AND E.idAca=1) +
        (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.visitante AND E.idAca=5) golM 
    FROM jogo J
    WHERE idTem = '$idTem' AND divisao='$divisao'
    
) a 
group by time
order by P DESC, V DESC, SG DESC, GP DESC";
    $result = mysql_query($sql) or die(mysql_error().' na linha '.__LINE__);
    $quantreg = mysql_num_rows(mysql_query($sql)); // Qtde total de registros na tabela
    // FIM PAGINAÇÃO
    
    echo "<div>$quantreg times disputaram a competição</div>";
    ?>

    
    <table class="listagem" width="100%" border="0" cellpadding="3" cellspacing="0">
        <tr>
        <tr>
            <td width='30%' class="t_campo">TIME</td>
            <td width='10%' class="t_campo">P</td>
            <td width='10%' class="t_campo">J</td>
            <td width='10%' class="t_campo">V</td>
            <td width='10%' class="t_campo">E</td>
            <td width='10%' class="t_campo">D</td>
            <td width='10%' class="t_campo">GP:GC</td>
            <td width='10%' class="t_campo">SG</td>
        </tr>

        </tr>
    
        <?php
        // Listagem
        while($row = mysql_fetch_array($result)){
			
            $cor = '';
            // Tratando dados
            if($pos ==1){
            	$cor = "style='color: #077347; font-weight: bold;'";
            }elseif($pos>8){
            	$cor = "style='color: #DC143C;'";
            }
		    echo "        
		        <tr>
		            <td $cor>$row[time]</td>
		            <td>$row[P]</td>
		            <td>$row[J]</td>
		            <td>$row[V]</td>
		            <td>$row[E]</td>
		            <td>$row[D]</td>
		            <td>$row[GP] : $row[GC]</td>
		            <td>$row[SG]</td>
		        </tr>";
		        $pos++;
        }


        ?> 	
    
    </table>


    
    
    
    
    
    
