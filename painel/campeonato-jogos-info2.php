<link rel="stylesheet" href="include/css/evento.css">
    <?php


    
    // PAGINAÇÃO
    
    $result = mysql_query("SELECT 
            J.idMan, 
            J.idVis, 
            E.idTim, 
            E.idAca,
            E.idEve,
            tempo, 
            (SELECT Jgd.apelido FROM jogador Jgd WHERE E.idJgd=Jgd.idJgd) jogador, 
            (SELECT M.apelido FROM times M WHERE J.idMan=M.idTim) man, 
            (SELECT V.apelido FROM times V WHERE J.idVis=V.idTim) vis, 
            (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idMan AND E.idAca=1 AND E.idJgd>0) +
            (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idVis AND E.idAca=5 AND E.idJgd>0) golM, 

            (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idVis AND E.idAca=1 AND E.idJgd>0) +
            (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idMan AND E.idAca=5 AND E.idJgd>0) golV
        FROM 
            evento E 
        INNER JOIN 
            jogo J 
        ON 
            E.idJog=J.idJog 
        WHERE 
            E.idJog=$_GET[j] AND E.idJgd>0
    ") or die(mysql_error().' na linha '.__LINE__);
    $resultJog = mysql_query("SELECT 
            J.idJog, 
            (SELECT M.apelido FROM times M WHERE J.idMan=M.idTim) man, 
            (SELECT V.apelido FROM times V WHERE J.idVis=V.idTim) vis,
            (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idMan AND E.idAca=1 AND E.idJgd>0) +
            (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idVis AND E.idAca=5 AND E.idJgd>0) golM, 

            (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idVis AND E.idAca=1 AND E.idJgd>0) +
            (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idMan AND E.idAca=5 AND E.idJgd>0) golV,
            (SELECT L.nome FROM estadio L WHERE J.idEst=L.idEst) estadio, 
            rodada, 
            turno, 
            temporada, 
            divisao 
        FROM 
            jogo J 
        WHERE 
            J.idJog=$_GET[j] 
        ORDER BY 
            temporada
    ") 
    or die(mysql_error().' na linha '.__LINE__);


        $rowJog = mysql_fetch_array($resultJog);
		$rowCou = mysql_fetch_array(mysql_query("SELECT COUNT(*) as jogo FROM `jogo` WHERE idJog<=$rowJog[idJog]"));
		// AND temporada=$rowJog[temporada] AND divisao=$rowJog[divisao]
		$rowCTt = mysql_fetch_array(mysql_query("SELECT COUNT(*) as jogo FROM `jogo` ORDER BY idJog DESC"));
    ?>
<h1>
<?php 
	$jogo = str_pad($rowCou['jogo'],strlen($rowCTt['jogo']),'0', STR_PAD_LEFT);
    echo "
    $rowJog[divisao]ª DIVISÃO / 
    TEMPORADA $rowJog[temporada]<br>
    $rowJog[estadio]<br>
    $rowJog[rodada]ª rodada do $rowJog[turno]º turno<br>
	JOGO $jogo
    ";
?>

</h1>
<br />
<div class="jogo">
	<div class="placar">
    	<div class="mandante"><p class="time">São Paulo</p><p class="gol">1</p></div>
    	<div class="visitante"><p class="gol">0</p><p class="time">Liverpool</p></div>
    </div>
    <div class="resumo">
    	<div class="gols">
        	<div class="mandante"><p>(25') Mineiro</p></div>
            <div class="rotulo">GOLS</div>
        	<div class="visitante"></div>
        </div>

    	<div class="cartoes">
        	<div class="mandante"><p>(60') Lugano</p></div>
            <div class="rotulo">CARTÕES</div>
        	<div class="visitante"><p>Gerrard (75')</p></div>
        </div>

    	<div class="substituicoes">
        	<div class="mandante"><p>&nbsp;</p></div>
            <div class="rotulo">SUBSTITUIÇÕES</div>
        	<div class="visitante"><p>&nbsp;</p></div>
        </div>
    </div>

      
</div>