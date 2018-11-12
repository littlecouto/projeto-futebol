<?php
header('Content-Type: text/html; charset=iso-utf-8',true);
?>
<!doctype html>
<html>
<head>
<meta charset="iso-8859-1">
<title>Brasfoot</title>

<script src="jquery-3.0.0-alpha1.js"></script>
<link href="jogo.css" rel="stylesheet" type="text/css">

<script src="include/js/jquery.bpopup.min.js" type="text/javascript"></script>
<script>
$(function(){
    $('p.placar').click(function() {
        var classe = '.'+$(this).attr('data-class');
        $('.resumo'+classe).bPopup();
    });
});
</script>

</head>

<body>

<?php

error_reporting(0);
$db['server']     = 'mysql.ewebtecnologia.com.br';
$db['user']         = 'ewebtecnologia02';
$db['password']     = 'sql2585';
$db['dbname']     = 'ewebtecnologia02';

$db['server']       = 'localhost';
$db['user']         = 'root';
$db['password']     = '';
$db['dbname']       = 'futebol';

$conn = mysql_connect($db['server'],$db['user'],$db['password']);
mysql_select_db($db['dbname'],$conn);


//error_reporting(0);

/*echo "<pre>";
print_r($_POST);
echo "</pre>";

*/
include 'fazer_jogos.php';



$rodada = array(
    array(
        array(
            'm'=>'Juventus',
            'v'=>'Palmeiras',
        ),
    )
);

$rodada = array(
    array(
        array(
            'm'=>'Palmeiras',
            'v'=>'Milan',
        ),
    )
);
$rodada = array(
    array(
        array(
            'm'=>'Juventus',
            'v'=>'Real Madrid',
        ),
    )
);

$rodada = array(
    array(
        array(
            'v'=>'Avai',
            'm'=>'Coritiba',
        ),
    ),

);
// mysql_query("TRUNCATE evento") or die(mysql_error());
// mysql_query("TRUNCATE jogo") or die(mysql_error());

for ($divisao=1; $divisao <=2; $divisao++) {

$rowTem = mysql_fetch_array(mysql_query("SELECT temporada FROM jogo WHERE rodada=18 AND realizado=1 AND divisao=$divisao ORDER BY temporada DESC LIMIT 1"));
$temAnt = $rowTem['temporada'];
$qtdT1 = 8;
$qtdT2 = 2;
$filtro1 = "DESC";
$filtro2 = "DESC";

$divisao == 1 ? $times = '>0' : $times = '=0';
if($divisao >= 2){
    $qtdT1 = 2;
    $qtdT2 = '2,6';
    $qtdT3 = 2;
    $filtro1 = "ASC";
    $filtro2 = "DESC";
}
if($temAnt<1){
    if($divisao == 1){
        $sql = "SELECT LOWER(T.apelido) AS time, (SELECT SUM(J.forca) FROM jogador J, jogador_time C WHERE T.idTim=C.idTim AND C.idJgd=J.idJgd) as FORCAS FROM times T WHERE T.ativo=1 AND T.idPai='1' AND FIELD(apelido, 'CRUZEIRO',  'CORINTHIANS',  'GR�MIO', 'ATL�TICO-PR', 'JOINVILLE', 'ATL�TICO-MG', 'CHAPECOENSE', 'CORITIBA', 'INTERNACIONAL', 'S�O PAULO') $times  ORDER BY FORCAS DESC, apelido LIMIT 10";
    }else{

    }
}else{
    if($divisao == 1){
        $sql = "
			(select
                (select LOWER(t.apelido) FROM times t where t.idTim=time) as time,
                count(*) J,
                sum(
                      case when golM > golV then 3 else 0 end
                    + case when golM = golV then 1 else 0 end
                ) P,
                count(case when golM > golV then 1 end) V,
                count(case when golM = golV then 1 end) E,
                count(case when golV> golM then 1 end) D,
                sum(golM) GP,
                sum(golV) GC,
                sum(golM) - sum(golV) SG
            from (
                select idMan time, golM, golV, temporada from jogo
                WHERE temporada='$temAnt' AND divisao=1
              union all
                select idVis, golV, golM, temporada from jogo
                WHERE temporada='$temAnt' AND divisao=1
            ) a
            group by time
            order by temporada $filtro1, P $filtro1, V $filtro1, SG $filtro1, GP $filtro1 LIMIT $qtdT1)
        UNION

        (select
            (select LOWER(t.apelido) FROM times t where t.idTim=time) as time,
            count(*) J,
            sum(
                  case when golM > golV then 3 else 0 end
                + case when golM = golV then 1 else 0 end
            ) P,
            count(case when golM > golV then 1 end) V,
            count(case when golM = golV then 1 end) E,
            count(case when golV> golM then 1 end) D,
            sum(golM) GP,
            sum(golV) GC,
            sum(golM) - sum(golV) SG
        from (
            select idMan time, golM, golV, temporada from jogo
            WHERE temporada='$temAnt' AND divisao=2
          union all
            select idVis, golV, golM, temporada from jogo
            WHERE temporada='$temAnt' AND divisao=2
        ) b
        group by time
        order by temporada $filtro2, P $filtro2, V $filtro2, SG $filtro2, GP $filtro2 LIMIT $qtdT2)


        ";
    }else {
        $sql = "(select
                (select LOWER(t.apelido) FROM times t where t.idTim=time) as time,
                count(*) J,
                sum(
                      case when golM > golV then 3 else 0 end
                    + case when golM = golV then 1 else 0 end
                ) P,
                count(case when golM > golV then 1 end) V,
                count(case when golM = golV then 1 end) E,
                count(case when golV> golM then 1 end) D,
                sum(golM) GP,
                sum(golV) GC,
                sum(golM) - sum(golV) SG
            from (
                select idMan time, golM, golV, temporada from jogo
                WHERE temporada='$temAnt' AND divisao=1
              union all
                select idVis, golV, golM, temporada from jogo
                WHERE temporada='$temAnt' AND divisao=1
            ) a
            group by time
            order by temporada $filtro1, P $filtro1, V $filtro1, SG $filtro1, GP $filtro1 LIMIT $qtdT1)
        UNION
        (
        (select
            (select LOWER(t.apelido) FROM times t where t.idTim=time) as time,
            count(*) J,
            sum(
                  case when golM > golV then 3 else 0 end
                + case when golM = golV then 1 else 0 end
            ) P,
            count(case when golM > golV then 1 end) V,
            count(case when golM = golV then 1 end) E,
            count(case when golV> golM then 1 end) D,
            sum(golM) GP,
            sum(golV) GC,
            sum(golM) - sum(golV) SG
        from (
            select idMan time, golM, golV, temporada from jogo
            WHERE temporada='$temAnt' AND divisao=2
          union all
            select idVis, golV, golM, temporada from jogo
            WHERE temporada='$temAnt' AND divisao=2
        ) b
        group by time
        order by temporada $filtro2, P $filtro2, V $filtro2, SG $filtro2, GP $filtro2 LIMIT $qtdT2)
        )
            UNION
        (SELECT
            LOWER(ter.apelido),
            '0',
            '0',
            '0',
            '0',
            '0',
            '0',
            '0',
            '0'
        FROM
            times ter
        WHERE
            ter.idPai=1 AND ter.ativo=1
        ORDER BY (SELECT COUNT(*) FROM jogo P WHERE (P.idMan=ter.idTim OR P.idVis=ter.idTim)), ter.idTim
        LIMIT 2
        )

        ";

    }
}
    $res = mysql_query($sql) or die(mysql_error());

$times = array();

while($row = mysql_fetch_array($res)){
    $times[] = ucwords($row['time']);
}
//shuffle($times);

echo "<pre>";
print_r($times);
echo "</pre>";


$rowRod = mysql_fetch_array(mysql_query("SELECT rodada, temporada FROM jogo WHERE divisao=$divisao AND realizado=1 ORDER BY temporada DESC, rodada DESC"));
$temporada = $rowRod['temporada'];

$qtdRod = ((count($times)-1)*2);

if ($rowRod['rodada']<1) {
    $rowRod['rodada'] = 0;
}

$rodada = $rowRod['rodada']+1;
$turno = 1;

if($temporada<1){
    $temporada = 1;
}

if($rodada>=count($times) and $rodada <=$qtdRod){
    $turno = 2;
    $rodada = $rodada-count($times)+1;
}
if($rodada > $qtdRod){
    $rowRod['rodada'] = 0;
    $rodada = 1;
    $turno = 1;
    $temporada = $temporada+1;
}

// if($rodada >= count($times)){
//     $temporada = $temporada+1;
//     $rodada = $rodada-count($times)+1;
//     $turno = 2;
// }else{
//     $temporada = $temporada;
// }

$rodada = jogo($times,$rodada, $turno);



echo "<script>
$(document).ready(function(){
";
 $divisao == 1 ? $inc = 0 : $inc = 10;
   foreach ($rodada as $c => $v) {
        $jgd_usados = array();
        foreach ($v as $i) {
            $inc++;
            $rowEst = mysql_fetch_array(mysql_query("SELECT (SELECT e.nome FROM estadio e WHERE e.idEst=t.idEst) AS nome, t.idEst, t.idTim FROM times t WHERE t.apelido LIKE '%$i[m]%'"));


            $rowVis = mysql_fetch_array(mysql_query("SELECT idTim FROM times WHERE apelido LIKE '%$i[v]%'"));
            $idMan = $rowEst['idTim'];
            $idVis = $rowVis['idTim'];
            $idEst = $rowEst['idEst'];

            if($rowEst['nome'] == ''){
                $rowEst = mysql_fetch_array(mysql_query("SELECT nome FROM estadio ORDER BY rand()"));
            }

            $JogInc = $JG = $PS = 1;
            $filtro = '';

           $time1 = $time2 = '';
           for($Jgd1 = 1; $Jgd1<=5; $Jgd1++){
                if($Jgd1==1){
                    $idPos = 1;
                    $QtdJ1 = 1;
                }elseif ($Jgd1 == 2) {
                    $idPos = 2;
                    $QtdJ1 = 2;
                }elseif ($Jgd1 == 3) {
                    $idPos = 3;
                    $QtdJ1 = 2;
                }elseif ($Jgd1 == 4) {
                    $idPos = 4;
                    $QtdJ1 = 4;
                }elseif ($Jgd1 == 5) {
                    $idPos = 5;
                    $QtdJ1 = 2;
                }
                $resTim1 = mysql_query("SELECT LOWER(j.apelido) AS apelido, j.idJgd, j.forca, j.idPos FROM jogador j INNER JOIN jogador_time c ON j.idJgd=c.idJgd INNER JOIN times t ON c.idTim=t.idTim WHERE t.idTim=$idMan AND j.idPos='$idPos' ORDER BY forca DESC LIMIT $QtdJ1") or die(mysql_error());

                while($rowTim1 = mysql_fetch_array($resTim1)){
                    $rowTim1['apelido'] =  ucwords($rowTim1['apelido']);

                    $rowTim1['apelido'] = strtr($rowTim1['apelido'], array('��'=>'�'));


                    if($JogInc < 11){
                        $time1 .= "'$rowTim1[apelido]',
                ";
                    }elseif($JogInc == 11){
                        $time1 .= "'$rowTim1[apelido]'";
                    }
                    $JogInc++;

                }
            }
            $JogInc = 1;

           for($Jgd2 = 1; $Jgd2<=5; $Jgd2++){
                if($Jgd2==1){
                    $idPos = 1;
                    $QtdJ2 = 1;
                }elseif ($Jgd2 == 2) {
                    $idPos = 2;
                    $QtdJ2 = 2;
                }elseif ($Jgd2 == 3) {
                    $idPos = 3;
                    $QtdJ2 = 2;
                }elseif ($Jgd2 == 4) {
                    $idPos = 4;
                    $QtdJ2 = 4;
                }elseif ($Jgd2 == 5) {
                    $idPos = 5;
                    $QtdJ2 = 2;
                }
                $resTim2 = mysql_query("SELECT LOWER(j.apelido) AS apelido, j.idJgd, j.forca, j.idPos FROM jogador j INNER JOIN jogador_time c ON j.idJgd=c.idJgd INNER JOIN times t ON c.idTim=t.idTim WHERE t.idTim=$idVis AND j.idPos='$idPos' ORDER BY forca DESC LIMIT $QtdJ2") or die(mysql_error());

                while($rowTim2 = mysql_fetch_array($resTim2)){
                    $rowTim2['apelido'] =  ucwords($rowTim2['apelido']);

                    $rowTim2['apelido'] = strtr($rowTim2['apelido'], array('��'=>'�'));


                    if($JogInc < 11){
                        $time2 .= "'$rowTim2[apelido]',
                ";
                    }elseif($JogInc == 11){
                        $time2 .= "'$rowTim2[apelido]'";
                    }
                    $JogInc++;

                }
            }

            $rodAtu  = $rowRod['rodada']+1;
            $turno = 1;
            if($rodAtu>=count($times)){
                $turno = 2;
            }



/*            $rowJog = mysql_fetch_array(mysql_query("SELECT idJog FROM jogo WHERE idMan='$idMan' AND idVis='$idVis' AND rodada='$rodAtu' AND turno='$turno' AND temporada='$temporada'"));
            if($rowJog['idJog']<1){
                mysql_query("INSERT INTO jogo(
                    idCom, idMan, idVis, idEst, rodada, turno, temporada, divisao
                )VALUE(
                    '1', '$idMan', '$idVis', '$idEst', '$rodAtu', '$turno', '$temporada', '$divisao'
                )") or die(mysql_error());
                $rowJog = mysql_fetch_array(mysql_query("SELECT idJog FROM jogo WHERE idMan='$idMan' AND idVis='$idVis' AND rodada='$rodAtu' AND turno='$turno' AND temporada='$temporada'"));
            }elseif($rowJog['idJog']>0){
                mysql_query("DELETE FROM evento WHERE idJog='$rowJog[idJog]'") or die(mysql_error());
            }*/

            $idJog = $rowJog['idJog'];

            $rowFor1 = mysql_fetch_array(mysql_query("SELECT (SELECT ROUND(AVG(J.forca)) FROM jogador J, jogador_time C WHERE T.idTim=C.idTim AND C.idJgd=J.idJgd) as FORCAS FROM times T WHERE T.idTim=$idMan"));
            $rowFor2 = mysql_fetch_array(mysql_query("SELECT (SELECT ROUND(AVG(J.forca)) FROM jogador J, jogador_time C WHERE T.idTim=C.idTim AND C.idJgd=J.idJgd) as FORCAS FROM times T WHERE T.idTim=$idVis"));
            $forca1 = $rowFor1['FORCAS']+15;
            $forca2 = $rowFor2['FORCAS']-5;
            echo "
            Jogar('jogo$inc', '$i[m]', '$i[v]', '$rowEst[nome]',
            [
                [
                $time1
                ],
                [
                $time2
                ]
            ],'$idJog', '$idMan', '$idVis', '$forca1', '$forca2');
";
        }
    }
echo "});

</script>


<div class=\"rodada\">";

$divisao == 1 ? $inc = 0 : $inc = 10;
foreach ($rodada as $c => $v) {
    if($divisao==1){
        echo"
        <h1>$temporada � TEMPORADA</h1>
        <h2>RODADA ".($rodAtu)."</h2>";
   }
   foreach ($v as $i) {
    $inc++;
    $base = 'C:\xampp\htdocs\brasfoot\img\time';
    $Man = mysql_fetch_array(mysql_query("SELECT escudo FROM times WHERE apelido='$i[m]'")) or die(mysql_error());
    $Vis = mysql_fetch_array(mysql_query("SELECT escudo FROM times WHERE apelido='$i[v]'")) or die(mysql_error());
    $IMGM = "$base\\$Man[escudo].png";
    $IMGV = "$base\\$Vis[escudo].png";
   echo "

    <div class=\"jogo$inc\">
        <div style=\"display: none;\">
            <p class=\"abr1\"></p>
            <p class=\"abr2\"></p>
        </div>
        <div class=\"jogadores\">
            <div class=\"man\"></div>
            <div class=\"vis\"></div>
        </div>

        <!--<p class=\"posse\">Posse de bola: <span class=\"man\">50</span>% - <span class=\"vis\">50</span>%</p>-->
        <p class=\"tempo\">0</p>
        <img src='imagem.php?img=$IMGM&amp;w=45&amp;h=45' class='escudo' alt='$i[m]' title='$i[m]'>
        <p class=\"placar\" data-class=\"jogo$inc\"> 0x0 </p>
        <img src='imagem.php?img=$IMGV&amp;w=45&amp;h=45' class='escudo' alt='$i[v]' title='$i[v]'>
        <p class=\"eventos\"></p>

        <p style=\"display: none;\" class=\"narrar\">V�o come�ar as cobran�as</p>
        <p style=\"display: none;\" class=\"timeM\"><span>0</span> - </p>
        <p style=\"display: none;\" class=\"timeV\"><span>0</span> - </p>

        <div class=\"jogo$inc resumo\">
            <div class=\"man\">
                <img src='imagem.php?img=$IMGM&amp;w=75&amp;h=75' class='escudo' alt='$i[m]' title='$i[m]'>
                <h2>$i[m]</h2>
                <ul class=\"jogadores\">

                </ul>
            </div>
            <div class=\"evento\">
                <div>
                <div class=\"aviso\">1�</div>
                </div>
            </div>
            <div class=\"vis\">
                <img src='imagem.php?img=$IMGV&amp;w=75&amp;h=75' class='escudo' alt='$i[v]' title='$i[v]'>
                <h2>$i[v]</h2>
                <ul class=\"jogadores\"></ul>
            </div>
            <div class=\"posse\">
                <p class='man'>50%</p>
                <p class='vis'>50%</p>
            </div>
            <div class=\"infos\">
                <p class='estadio'></p>
            </div>

        </div>

        <div class=\"penaltis\">
            <div class=\"man\"></div>
            <div class=\"vis\"></div>
        </div>
        <button class=\"jogar\" style='display: none;'>JOGAR</button>
        <button class=\"pausar\" style='display: none;'>PAUSAR</button>
    </div>
";
    }
}
echo
"</div>



<div class=\"tabela tabela$divisao\">
    <table>

        <tr>
            <td width='15%'>TIME</td>
            <td width='5%'>#</td>
            <td width='10%'>P</td>
            <td width='10%'>J</td>
            <td width='10%'>V</td>
            <td width='10%'>E</td>
            <td width='10%'>D</td>
            <td width='10%'>GP</td>
            <td width='10%'>GC</td>
            <td width='10%'>SG</td>
        </tr>


";

 $sqlTim = "SELECT
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
    SELECT idMan equipe, golM, golV FROM jogo
    WHERE temporada = '$temporada' AND divisao='$divisao'
  union all
    SELECT idVis, golV, golM FROM jogo
    WHERE temporada = '$temporada' AND divisao='$divisao'
) a
group by time
order by P DESC, V DESC, SG DESC, GP DESC";
$resTim = mysql_query($sqlTim) or die(mysql_error());

while($rowTim = mysql_fetch_array($resTim)){
    echo "
        <tr>
            <td>$rowTim[time]</td>
            <td></td>
            <td>$rowTim[P]</td>
            <td>$rowTim[J]</td>
            <td>$rowTim[V]</td>
            <td>$rowTim[E]</td>
            <td>$rowTim[D]</td>
            <td>$rowTim[GP] </td>
            <td>$rowTim[GC]</td>
            <td>$rowTim[SG]</td>
        </tr>";
}


echo "
</table>
</div>";
}


// if($rodAtu>1 and $rodAtu<= count($times) * 2-2){
//     echo "<a href='jogo.php?rodada=".($rodAtu - 1)."'>Rodada Anterior</a>";
// }
// echo "&nbsp;&nbsp;";
// if($rodAtu>0 and $rodAtu< count($times) * 2-2){
//     echo "<a href='jogo.php?rodada=".($rodAtu + 1)."'>Pr�xima Rodada</a>";
// }
?>
<script src="jogo.js"></script>

<?php
// exit;
?>
<script>
    $(function(){
        var a = 0;
        var busTab = setInterval(function(){
            var dados = {
                'ACAO' : 'TABELA',
                'temp' : '<?= $temporada ?>',
                'divi' : '1'
            }
            data = $(this).serialize() + "&" + $.param(dados);
            $.post('atu_tabela.php',data,function(retorna){
                $('.tabela1').html(retorna);
            });
            var dados = {
                'ACAO' : 'TABELA',
                'temp' : '<?= $temporada ?>',
                'divi' : '2'
            }
            data = $(this).serialize() + "&" + $.param(dados);
            $.post('atu_tabela.php',data,function(retorna){
                $('.tabela2').html(retorna);
            });
            if(a >= 25){
                var dados = {
                    'ACAO' : 'FIMRODADA',
                    'temp' : '<?= $temporada ?>',
                    'rodA' : '<?= $rodAtu ?>'
                }
                data = $(this).serialize() + "&" + $.param(dados);
                $.post('    .php',data,function(retorna){
                    var rodada = <?=$rodAtu?>;
                    if(retorna === 'SIM'){
                        clearInterval(busTab);
                        if(rodada<18){
                            location.reload();
                        }
                    }
                });
            }

            a++;
        }, 2500);
    });
</script>
</body>
</html>
