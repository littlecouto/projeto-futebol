<?php 
$divisao = $_GET['d'] !=''?$_GET['d']:'1';
?>









<h2><?=$divisao?>ª DIVIS&Atilde;O</h2>
<div class="formulario"  style="width: 100%;">


	<?php


    include 'include/scripts/converte_data.php';
    
    // PAGINAÇÃO
    $resultTem = mysql_query("SELECT idTem FROM jogo WHERE realizado=1 ORDER BY idTem DESC") or die(mysql_error()); // Qtde total de registros na tabela
    // FIM PAGINAÇÃO
    
    ?>

    
    <table class="listagem" width="100%" border="0" cellpadding="3" cellspacing="0">
        <tr>
        <tr>
            <th width='4%' class="t_campo" title="TEMPORADA">T</th>
            <th width='20%' class="t_campo">CAMPEÃO</th>
            <th width='20%' class="t_campo">VICE</th>
            <th width='20%' class="t_campo">TERCEIRO</th>
            <th width='30%' class="t_campo">ARTILHEIRO</th>
            <th width='3%' class="t_campo">&nbsp;</th>
            <th width='3%' class="t_campo">&nbsp;</th>
        </tr>

        </tr>
    
        <?php
        // Listagem
        while($rowTem = mysql_fetch_array($resultTem)){
            $temporada = $rowTem['idTem'];
			$res = mysql_query("SELECT
    (SELECT t.apelido FROM times t WHERE t.idTim=equipe) as time,
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
        WHERE idTem = '$idTem' AND divisao='$divisao' AND realizado=1
  union all
    SELECT visitante,
        (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.visitante AND E.idAca=1) +
        (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.mandante AND E.idAca=5) golM, 

        (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.mandante AND E.idAca=1) +
        (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.visitante AND E.idAca=5) golV 
     FROM jogo J
        WHERE idTem = '$idTem' AND divisao='$divisao' AND realizado=1
) a 
group by time
order by P DESC, V DESC, SG DESC, GP DESC LIMIT 3") or die(mysql_error());
            // Tratando dados
		    echo "<tr onclick=\"javascript:location.href='campeonato-info?t=$temporada&amp;d=$divisao'\">
                <td>$temporada</td>";
                while ($row = mysql_fetch_array($res)) {
                    echo"<td>$row[time] - $row[P]</td>";
                }
			$resArt = mysql_query("SELECT COUNT(E.idAca) gols, J.apelido, T.apelido time FROM evento E INNER JOIN jogador J ON E.idJgd=J.idJgd INNER JOIN jogo G ON E.idJog=G.idJog INNER JOIN time T ON E.idTim=T.idTim WHERE G.divisao=$divisao AND E.idAca=1 AND E.idTem='$temporada' GROUP BY E.idJgd ORDER BY gols DESC ") or die(mysql_error());
            $rowArt = mysql_fetch_array($resArt);
                echo "
					<td>$rowArt[apelido], $rowArt[gols] ($rowArt[time])</td>
					<td> <a href='campeonato-jogos?t=$temporada&amp;d=$divisao'>Jogos</a> </td>
					<td><a href='campeonato-info?t=$temporada&amp;d=$divisao'><img src='include/img/bt/bt_alterar.gif' alt='Alterar Registro' title='Alterar Registro' border='0' /></a></td>
				";
				
            echo"</tr>";
        }


        ?> 	
    
    </table>


    
    
    
    
    
    
