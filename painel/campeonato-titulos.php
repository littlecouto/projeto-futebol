<?php 
$divisao = $_GET['d'] > 0 ? $_GET['d'] : '1';
$posicao = $_GET['p'] > 0 ? $_GET['p'] : '1';

?>

<h2><?=$divisao?>ª DIVIS&Atilde;O</h2>
<div class="formulario"  style="width: 100%;">

    <form action="" method="get">
    
    
    <table class="semCor" style="width: 200px">
    <tr>
    	<td class="t_campo"><strong>DIVIS&Atilde;O</strong></td>
    	<td class="t_campo"><strong>&nbsp;</strong></td>
    </tr>
    <tr>
        <td>    
            <select name="d">
                <option value="1"<?= $divisao==1?' selected':'' ?>>1ª</option>
                <option value="2"<?= $divisao==2?' selected':'' ?>>2ª</option>
            </select>
        </td>
    	<td>
		    <select name="p">
			<?php
            for ($p= 1; $p <=10; $p++) {
                $selected = $posicao==$p ? ' selected' :'';
                echo " <option value='$p' $selected>$p</option>";
            }
            ?>
		    </select>
		</td>
    </tr>
</table>
</form>


	<?php


    include 'include/scripts/converte_data.php';
    
    // PAGINAÇÃO

    $resultTem = mysql_query("SELECT temporada FROM jogo WHERE divisao=$divisao AND rodada=18 AND realizado=1 GROUP BY temporada"); // Qtde total de registros na tabela
    // FIM PAGINAÇÃO
    
    ?>

    
    <table class="listagem" width="100%" border="0" cellpadding="3" cellspacing="0">
        <tr>
        <tr>
            <th width='10%' class="t_campo">#</th>
            <th width='40%' class="t_campo">TIME</th>
            <th width='50%' class="t_campo">ÚLTIMA VEZ</th>
        </tr>

        </tr>
    
        <?php
        $campeoes = array();
        // Listagem
        $LIMIT = '1';
        if($_GET['p']){
            $exp = explode(',', $_GET['p'].",");
            $LIMIT = $exp[0];
            if(count($exp)>2){
                $LIMIT = $exp[0]-1;
                $LIMIT .= ", $exp[1]";
            }elseif(count($exp)<=2 and $LIMIT>1){
                $LIMIT = $exp[0]-1;
                $LIMIT .= ", 1";
            }
        }
        while($rowTem = mysql_fetch_array($resultTem)){
            $temporada = $rowTem['temporada'];
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
    SUM(golM) - SUM(golV) SG,
    temporada
FROM (
    SELECT idMan equipe, temporada,
        (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idMan AND E.idAca=1) +
        (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idVis AND E.idAca=5) golM, 

        (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idVis AND E.idAca=1) +
        (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idMan AND E.idAca=5) golV 
    FROM jogo J
     WHERE temporada = '$temporada' AND divisao='$divisao'
   
  union all
    SELECT idVis, temporada,
        (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idVis AND E.idAca=1) + 
        (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idMan AND E.idAca=5) golV, 

        (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idMan AND E.idAca=1) +
        (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idVis AND E.idAca=5) golM 
    FROM jogo J
     WHERE temporada = '$temporada' AND divisao='$divisao'
   
) a 
group by time
order by P DESC, V DESC, SG DESC, GP DESC LIMIT $LIMIT") or die("ESTÁ MORTO O MENINO SQL: ".mysql_error());
            // Tratando dados
            while ($row = mysql_fetch_array($res)) {
                if(!$campeoes[$row['time']]){
                    $campeoes[$row['time']] = array();
                    $campeoes[$row['time']]['t'] = 1;
                }else{
                    $campeoes[$row['time']]['t']++;                
                }
                $campeoes[$row['time']]['a'] = $row['temporada'];
            }

        }



        mysql_query("CREATE TEMPORARY TABLE campeoes(
                time VARCHAR(100), titulos INT(2), temporada INT(4)
            )") ;
        foreach ($campeoes as $time => $t) {
            mysql_query("INSERT INTO campeoes(time, titulos, temporada)VALUES('$time', '$t[t]', '$t[a]')");
        }
        $resTit = mysql_query("SELECT * FROM campeoes ORDER BY titulos DESC, temporada");
        while ($rowTit = mysql_fetch_array($resTit)) {
            echo "<tr>
                <td>$rowTit[titulos]</td>
                <td>$rowTit[time]</td>
                <td>$rowTit[temporada]</td>
            </tr>";
        }

        ?> 	
    
    </table>


    <script>
    	$('.semCor select').change(function(e) {
            $('.semCor').submit();
        });
    </script>
    
    
    
    
    
