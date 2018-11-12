<link rel="stylesheet" href="include/css/evento.css">
    <?php


    
    // PAGINAÇÃO
    
    $result = mysql_query("SELECT 
            J.mandante, 
            J.visitante, 
            E.idTim, 
            E.idAca,
            E.idEve,
            tempo, 
            (SELECT Jgd.apelido FROM jogador Jgd WHERE E.idJgd=Jgd.idJgd) jogador, 
            (SELECT M.apelido FROM times M WHERE J.mandante=M.idTim) man, 
            (SELECT V.apelido FROM times V WHERE J.visitante=V.idTim) vis, 
            (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.mandante AND E.idAca=1 AND E.idJgd>0) +
            (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.visitante AND E.idAca=5 AND E.idJgd>0) golM, 

            (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.visitante AND E.idAca=1 AND E.idJgd>0) +
            (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.mandante AND E.idAca=5 AND E.idJgd>0) golV
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
            (SELECT M.apelido FROM times M WHERE J.mandante=M.idTim) man, 
            (SELECT V.apelido FROM times V WHERE J.visitante=V.idTim) vis,
            (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.mandante AND E.idAca=1 AND E.idJgd>0) +
            (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.visitante AND E.idAca=5 AND E.idJgd>0) golM, 

            (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.visitante AND E.idAca=1 AND E.idJgd>0) +
            (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.mandante AND E.idAca=5 AND E.idJgd>0) golV,
            (SELECT L.nome FROM estadio L WHERE J.idEst=L.idEst) estadio, 
            rodada, 
            turno, 
			(SELECT temporada FROM jogo_temporada TMP WHERE TMP.idTem=J.idTem) temporada, 
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
<br />
<div class="jogo">    
        <?php
        // Listagem
			
			
			echo "
			
			<div class=\"info\">
				<p>$rowJog[divisao]ª divis&atilde;o </p>
			    <p>$rowJog[temporada]º temporada</p>
				<p>$rowJog[estadio]</p>
				<p>$rowJog[rodada]ª rodada</p>
				<p>$rowJog[turno]º turno</p>

			</div>
			<div class=\"placar\">
				<div class=\"mandante\"><p class=\"time\">$rowJog[man]</p><p class=\"gol\">$rowJog[golM]</p></div>
				<div class=\"visitante\"><p class=\"gol\">$rowJog[golV]</p><p class=\"time\">$rowJog[vis]</p></div>
			</div>
			
";
			$golM = $golV = $amareloM = $amareloV = $vermelhoM = $vermelhoV = $contusaoM = $contusaoV = "&nbsp;";
        while($row = mysql_fetch_array($result)){
			

            // Tratando dados
            if($row['idTim']==$row['mandante']){
				switch ($row['idAca']) {
					case 1:
						$golM .= "<p><span>($row[tempo]') $row[jogador]</span></p>";
						break;
					case 2:
						$cartaoM .= "<p class=\"amarelo\"><span>($row[tempo]') $row[jogador]</span></p>";
						break;
					case 3:
						$cartaoM .= "<p class=\"vermelho\"><span>($row[tempo]') $row[jogador]</span></p>";
						break;
					case 4:
						$contusaoM .= "<p><span>($row[tempo]') $row[jogador]</span></p>";
						break;
					case 5:
	
						$golV .= "<p class=\"contra\"><span>$row[jogador] ($row[tempo]')</span></p>";
						break;
				}
            }elseif($row['idTim']==$row['visitante']){
				switch ($row['idAca']) {
					case 1:
						$golV .= "<p><span>$row[jogador] ($row[tempo]')</span></p>";
						break;
					case 2:
						$cartaoV .= "<p class=\"amarelo\"><span>$row[jogador] ($row[tempo]')</span></p>";
						break;
					case 3:
						$cartaoV .= "<p class=\"vermelho\"><span>$row[jogador] ($row[tempo]')</span></p>";
						break;
					case 4:
						$contusaoV .= "<p><span>$row[jogador] ($row[tempo]')</span></p>";
						break;
					case 5:
	
						$golM .= "<p class=\"contra\"><span>($row[tempo]') $row[jogador]</span></p>";
						break;
				}
            }
        }
echo "    <div class=\"resumo\">
    	<div class=\"gols\">
        	<div class=\"mandante\">$golM</div>
            <div class=\"rotulo\">GOLS</div>
        	<div class=\"visitante\">$golV</div>
        </div>

    	<div class=\"cartoes\">
        	<div class=\"mandante\">$cartaoM</div>
            <div class=\"rotulo\">CARTÕES</div>
        	<div class=\"visitante\">$cartaoV</div>
        </div>

    	<div class=\"substituicoes\">
        	<div class=\"mandante\"><p>&nbsp;</p></div>
            <div class=\"rotulo\">SUBSTITUIÇÕES</div>
        	<div class=\"visitante\"><p>&nbsp;</p></div>
        </div>
    </div>";
        ?> 	
    
    </table>
