<?php
header('Content-Type: text/html; charset=ISO-8859-1',true);


$db['server']   = 'mysql.ewebtecnologia.com.br';
$db['user']     = 'ewebtecnologia02';
$db['password'] = 'sql2585';
$db['dbname']   = 'ewebtecnologia02';

$db['server']   = 'localhost';
$db['user']     = 'root';
$db['password'] = '';
$db['dbname']   = 'brasfoot';

$conn = mysql_connect($db['server'],$db['user'],$db['password']);
mysql_select_db($db['dbname'],$conn);

if($_REQUEST['ACAO'] == 'TABELA'){
$temporada = $_REQUEST['temp'];
$divisao   = $_REQUEST['divi'];
	echo "    <table>

        <tr>
            <td width='15%'>TIME</td>
            <td width='5%'>#</td>
            <td width='10%'>P</td>
            <td width='10%'>J</td>
            <td width='10%'>V</td>
            <td width='10%'>E</td>
            <td width='10%'>D</td>
            <td width='10%'>GP:GC</td>
            <td width='10%'>SG</td>
        </tr>

";
$rowRod = mysql_fetch_array(mysql_query("SELECT rodada FROM jogo WHERE temporada=$_REQUEST[temp] AND divisao=$_REQUEST[divi] ORDER BY rodada DESC LIMIT 1"));

if($_GET['rodada']!=''){
    $rodada = $_GET['rodada'];
}else{
    $rodada = $rowRod['rodada'];
}


$resTab = mysql_query("SELECT
    equipe,
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
    SELECT idMan equipe,  
            (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idMan AND E.idAca=1) +
            (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idVis AND E.idAca=5) golM, 

            (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idVis AND E.idAca=1) +
            (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idMan AND E.idAca=5) golV 

        FROM jogo J

    WHERE temporada = '$temporada' AND divisao='$divisao' AND rodada<=$rodada
  union all
    SELECT idVis,  
            (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idVis AND E.idAca=1) +
            (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idMan AND E.idAca=5) golM, 

            (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idMan AND E.idAca=1) +
            (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idVIs AND E.idAca=5) golV 

        FROM jogo J

    WHERE temporada = '$temporada' AND divisao='$divisao' AND rodada<=$rodada
) a 
group by time
order by P DESC, V DESC, SG DESC, GP DESC");


mysql_query("CREATE TEMPORARY TABLE tabAtu(
    idTim int(11), pos int(2), time VARCHAR(100), p INT(2), j INT(2), v INT(2), e INT(2), d INT(2), gp INT(3),  gc INT(3), sg  INT(4)
)") or die(mysql_error());
$pos = 0;

while($rowTab = mysql_fetch_array($resTab)){
    $pos++;

    mysql_query("INSERT INTO tabAtu(
            idTim, 
            pos, 
            time, 
            p, 
            j, 
            v, 
            e, 
            d, 
            gp, 
            gc, 
            sg
        )VALUES(
            '$rowTab[equipe]', 
            '$pos', 
            '$rowTab[time]', 
            '$rowTab[P]', 
            '$rowTab[J]', 
            '$rowTab[V]', 
            '$rowTab[E]', 
            '$rowTab[D]', 
            '$rowTab[GP]', 
            '$rowTab[GC]', 
            '$rowTab[SG]'
        )
    ") or die(mysql_error());

}


if($rodada>1){
    $resTabA = mysql_query("SELECT
        equipe,
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
        SELECT idMan equipe, 
            (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idMan AND E.idAca=1) +
            (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idVis AND E.idAca=5) golM, 

            (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idVis AND E.idAca=1) +
            (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idMan AND E.idAca=5) golV 

        FROM jogo J
        WHERE temporada = '$temporada' AND divisao='$divisao' AND rodada<$rodada
      union all
        SELECT idVis,  
            (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idVis AND E.idAca=1) +
            (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idMan AND E.idAca=5) golM, 

            (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idMan AND E.idAca=1) +
            (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idVIs AND E.idAca=5) golV 

        FROM jogo J

        WHERE temporada = '$temporada' AND divisao='$divisao' AND rodada<$rodada
    ) a 
    group by time
    order by P DESC, V DESC, SG DESC, GP DESC");


    mysql_query("CREATE TEMPORARY TABLE variacoes(
        idTim int(11), pos int(2)
    )") or die(mysql_error());
    $pos = 0;
    while($rowTabA = mysql_fetch_array($resTabA)){
        $pos++;

        mysql_query("INSERT INTO variacoes(idTim, pos)VALUES('$rowTabA[equipe]', '$pos')") or die(mysql_error());

    }
}


$resTim = mysql_query("SELECT * FROM tabAtu") or die(mysql_error());
while ($rowTim = mysql_fetch_array($resTim)) {
    if($rodada>1){
        $rowVar = mysql_fetch_array(mysql_query("SELECT pos FROM variacoes WHERE idTim=$rowTim[idTim]"));
    }else{
        $rowVar['pos'] = 10;
    }
    $pos = $rowVar['pos'] - $rowTim['pos'];

    if($pos < 0){
        $pos = strtr($pos, array('+'=>'', '-'=>''));
        $span = "<span class='pos pior'>$pos</span>";
    }elseif($pos > 0){
        $pos = strtr($pos, array('+'=>'', '-'=>''));
        $span = "<span class='pos melhor'>$pos</span>";
    }else{
        $span = ''; 
    }
    echo "        
        <tr>
            <td>$rowTim[time]</td>
            <td>$span</td>
            <td>$rowTim[p]</td>
            <td>$rowTim[j]</td>
            <td>$rowTim[v]</td>
            <td>$rowTim[e]</td>
            <td>$rowTim[d]</td>
            <td>$rowTim[gp] : $rowTim[gc]</td>
            <td>$rowTim[sg]</td>
        </tr>";
}


echo "
</table>";
}

exit;



?>		