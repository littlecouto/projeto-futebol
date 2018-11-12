<br />
<div class="formulario"  style="width: 100%;">
    <form action="" method="get">
    <select name="t">
    <?php 
    !isset($_GET['d']) ? $divisao = 0 : $divisao = $_GET['d'];
    !isset($_GET['r']) ? $rodada = 0 : $rodada = $_GET['r'];
    !isset($_GET['t']) ? $temporada = 0 : $temporada = $_GET['t'];
    

    $resTem = mysql_query("SELECT temporada FROM jogo GROUP BY temporada");
    echo "<option value=\"0\" ".($temporada==0?' selected':'' ).">TODAS</option>";
    while ($rowTem = mysql_fetch_array($resTem)) {
        echo "<option value='$rowTem[temporada]'".($temporada==$rowTem['temporada']?' selected':'').">$rowTem[temporada]</option>}
        option";
    }

     ?>
    </select>
    <select name="d">
        <option value="0"<?= $divisao==0?' selected':'' ?>>TODAS</option>
        <option value="1"<?= $divisao==1?' selected':'' ?>>1ª</option>
        <option value="2"<?= $divisao==2?' selected':'' ?>>2ª</option>
    </select>
    <select name="r">
    <?php 

    $resRod = mysql_query("SELECT rodada FROM jogo GROUP BY rodada");
    echo "<option value=\"0\" ".($rodada==0?' selected':'' ).">TODAS</option>";
    while ($rowRod = mysql_fetch_array($resRod)) {
        echo "<option value='$rowRod[rodada]'".($rodada==$rowRod['rodada']?' selected':'').">$rowRod[rodada]</option>";
    }

     ?>
    </select>
    </form>


	<?php
    $temporada = $_GET['t'];
    $filtro = "WHERE E.idAca=1";
    if($divisao>0){
        $filtro .= " AND divisao='$divisao'";
    }
    if($temporada>0){
        $filtro .= " AND E.temporada='$temporada'";        
    }
    if($rodada>0){
        $filtro .= " AND G.rodada='$rodada'";        
    }
    include 'include/scripts/converte_data.php';

    $numreg = 20; // Qtde de registros por página
    if (!isset($pg)) $pg = 0;
    if (!isset($_REQUEST['pg'])) $pg = 0; else $pg = $_REQUEST['pg'];
    $inicial = $pg * $numreg;
    $sql = "SELECT 
        COUNT(E.idAca) gols,
        J.apelido nome,
        T.apelido time,
        (SELECT A.apelido FROM times A WHERE A.idTim=(case when E.idTim=G.idMan then idVis else idMan end) LIMIT 1) adversario,
        concat(G.golM,'x',G.golV) placar,
		G.idJog
    FROM
        evento E
    INNER JOIN 
        jogador J 
            ON E.idJgd=J.idJgd 
    INNER JOIN 
        jogo G 
            ON E.idJog=G.idJog 
    INNER JOIN 
        times T 
            ON E.idTim=T.idTim 
    $filtro

    GROUP BY 
        E.idJgd 
    ORDER BY 
        gols DESC
    ";
    $result = mysql_query($sql." LIMIT $inicial, $numreg") or die(mysql_error()); // Qtde total de registros na tabela
    // FIM PAGINAÇÃO
    $quantreg = mysql_num_rows(mysql_query($sql)); // Qtde total de registros na tabela
   
    // PAGINAÇÃO
    
    ?>

    
    <table class="listagem" width="100%" border="0" cellpadding="3" cellspacing="0">
        <tr>
            <th width='5%' class="t_campo">#</th>
            <th width='25%' class="t_campo">NOME</th>
            <th width='5%' class="t_campo">GOLS</th>
            <th width='20%' class="t_campo">TIME</th>
            <th width='45%' class="t_campo">JOGO</th>

        </tr>
    
        <?php
        // Listagem
        while($row = mysql_fetch_array($result)){
            $temporada = $row['temporada'];
            // Tratando dados
            $inicial++;
			$rowJog = mysql_fetch_array(mysql_query("
				SELECT G.idJog, 
					   (SELECT M.apelido FROM times M WHERE M.idTim=G.idMan LIMIT 1) mandante,
					   (SELECT V.apelido FROM times V WHERE V.idTim=G.idVis LIMIT 1) visitante,
					   G.golM,
					   G.golV
				FROM   jogo G
				WHERE  G.idJog='$row[idJog]'
			"));
		    echo "<tr>
                <td>$inicial</td>
                <td>$row[nome]</td>
                <td>$row[gols]</td>
                <td>$row[time]</td>
                <td><a href=\"campeonato-jogos-info.php?j=$row[idJog]\">$rowJog[mandante] $rowJog[golM] x $rowJog[golV] $rowJog[visitante]</a></td>
                <td></td>";
            echo"</tr>";
        }


        ?> 	
    
    </table>


    <?php include 'include/php/paginacao.php'; ?>
  
    
    
    
    
    
