
<br />
<div class="formulario"  style="width: 100%;">


	<?php


    include 'include/scripts/converte_data.php';
    
    // PAGINAÇÃO
    !isset($_GET['d']) ? $divisao = ''      : $divisao      = $_GET['d'];
    $_GET['r']<1       ? $rodada = ''       : $rodada       = $_GET['r'];
    !isset($_GET['t']) ? $temporada = ''    : $temporada    = $_GET['t'];
    !isset($_GET['e']) ? $equipe = ''       : $equipe       = $_GET['e'];
    !isset($_GET['l']) ? $listar = 'j'      : $listar       = $_GET['l'];
    !isset($_GET['s']) ? $status = 't'      : $status       = $_GET['s'];

     

    $numreg = 45; // Qtde de registros por página
    if (!isset($pg)) $pg = 0;
    if (!isset($_REQUEST['pg'])) $pg = 0; else $pg = $_REQUEST['pg'];
    $inicial = $pg * $numreg;

    $WHERE = 'WHERE';

    if($divisao>0){
        $WHERE .= ' divisao='.$_GET['d'];
    }
    if($rodada>0 and $WHERE != 'WHERE'){
        $WHERE .= ' AND J.rodada='.$_GET['r'];        
    }elseif($rodada>0 and $WHERE== 'WHERE'){
        $WHERE .= ' J.rodada='.$_GET['r'];        
    }
    if($status != '' and $WHERE != 'WHERE'){
        if($status == 't'){
            $WHERE .= ' AND J.realizado<3';        
        }elseif($status == 'r'){
            $WHERE .= ' AND J.realizado=1';        
        }elseif($status == 'a'){
            $WHERE .= ' AND J.realizado=2';    
        }elseif($status == 'd'){
            $WHERE .= ' AND J.realizado=0';        
        }
    }elseif($status != '' and $WHERE== 'WHERE'){
        if($status == 't'){
            $WHERE .= ' J.realizado<3';        
        }elseif($status == 'r'){
            $WHERE .= ' J.realizado=1';        
        }elseif($status == 'a'){
            $WHERE .= ' J.realizado=2';        
        }elseif($status == 'd'){
            $WHERE .= ' J.realizado=0';        
        }
    }
    if($temporada>0 and $WHERE != 'WHERE'){
        $WHERE .= ' AND J.idTem='.$_GET['t'];        
    }elseif($temporada>0 and $WHERE== 'WHERE'){
        $WHERE .= ' J.idTem='.$_GET['t'];        
    }
    if($equipe>0 and $WHERE != 'WHERE'){
        $WHERE .= ' AND (J.mandante='.$_GET['e'].' OR J.visitante='.$_GET['e'].')';        
    }elseif($equipe>0 and $WHERE== 'WHERE'){
        $WHERE .= ' (J.mandante='.$_GET['e'].' OR J.visitante='.$_GET['e'].')';        
    }

    if($WHERE == 'WHERE'){
        $WHERE = '';
    }
    $ORDERBY = 'idTem DESC, turno DESC, rodada DESC, divisao DESC';
    if($listar=='g'){
        $ORDERBY = "(case when golMan>=golVis then golMan-golVis else golVis-golMan end) DESC,
        (case when golMan>=golVis then golMan else golVis end) DESC";
    }
    $PAR = $_SERVER['QUERY_STRING'];

    $sql = "SELECT 
        J.idJog, 
        (SELECT M.apelido FROM time M WHERE J.mandante=M.idTim) man, 
        (SELECT V.apelido FROM time V WHERE J.visitante=V.idTim) vis, 
        (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.mandante AND E.idAca=1 AND E.idJgd>0) +
        (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.visitante AND E.idAca=5 AND E.idJgd>0) golMan, 

        (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.visitante AND E.idAca=1 AND E.idJgd>0) +
        (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.mandante AND E.idAca=5 AND E.idJgd>0) golVis,
        (SELECT L.nome FROM estadio L WHERE J.idEst=L.idEst) estadio, 
        rodada, 
        (SELECT temporada FROM jogo_temporada TMP WHERE TMP.idTem=J.idTem) temporada, 
        divisao,
        realizado
    FROM jogo J 
    $WHERE
    ORDER BY 
        $ORDERBY
        ";
   $quantreg = mysql_num_rows(mysql_query($sql)); // Qtde total de registros na tabela
   $result = mysql_query($sql." LIMIT $inicial, $numreg") or die(mysql_error());
    ?>
    
    <form action="" method="get" id="filtro">
    
    
    <table class="semCor" style="width: 600px">
    <tr>
    	<td class="t_campo"><strong>TEMPORADA</strong></td>
    	<td class="t_campo"><strong>S&Eacute;RIE</strong></td>
    	<td class="t_campo"><strong>CLASSIFICAR</strong></td>
    	<td class="t_campo"><strong>SITUA&Ccedil;&Atilde;O</strong></td>
    	<td class="t_campo"><strong>RODADA</strong></td>
    	<td class="t_campo"><strong>TIME</strong></td>
    </tr>
<tr>
    <td><select name="t">
    <?php 

    $resTem = mysql_query("SELECT idTem, temporada FROM jogo_temporada GROUP BY temporada");
    echo "<option value=\"0\">TODAS</option>";
    while ($rowTem = mysql_fetch_array($resTem)) {
        echo "<option value='$rowTem[idTem]'".($temporada==$rowTem['idTem']?' selected':'').">$rowTem[temporada]</option>}
        option";
    }

     ?>
    </select>
    </td>
    <td><select name="d">
        <option value="0"<?= $divisao==0?' selected':'' ?>>TODOS</option>
        <option value="1"<?= $divisao==1?' selected':'' ?>>A</option>
        <option value="2"<?= $divisao==2?' selected':'' ?>>B</option>
    </select>
    </td>
    <td><select name="l">
        <option value="g"<?= $listar=='g'?' selected':'' ?>>GOLS</option>
        <option value="j"<?= $listar=='j'?' selected':'' ?>>JOGOS</option>
    </select>
    </td>
    <td><select name="s">
        <option value="t"<?= $status=='t'?' selected':'' ?>>TODOS</option>
        <option value="r"<?= $status=='r'?' selected':'' ?>>REALIZADOS</option>
        <option value="a"<?= $status=='a'?' selected':'' ?>>EM ANDAMENTO</option>
        <option value="d"<?= $status=='d'?' selected':'' ?>>PRÓXIMOS</option>
    </select>
    <td><select name="r">
    <?php 

    $resRod = mysql_query("SELECT rodada FROM jogo GROUP BY rodada");
    echo "<option value=\"0\">TODAS</option>";
    while ($rowRod = mysql_fetch_array($resRod)) {
        echo "<option value='$rowRod[rodada]'".($rodada==$rowRod['rodada']?' selected':'').">$rowRod[rodada]</option>}
        option";
    }

     ?>
    </select></td>
    <td><select name="e">
    <?php 

    $resEqu = mysql_query("SELECT idTim, apelido FROM times WHERE idPai=1 ORDER BY apelido");
    echo "<option value=\"0\">TODOS</option>";
    while ($rowEqu = mysql_fetch_array($resEqu)) {
        echo "<option value='$rowEqu[idTim]'".($_GET['e']==$rowEqu['idTim']?' selected':'').">$rowEqu[apelido]</option>}
        option";
    }

     ?>
    </select></td>
    </tr>
</table>
    </form>
    
    <table class="listagem" width="100%" border="0" cellpadding="3" cellspacing="0">
        <tr>
        <th width="5%" class="t_campo">TEMPORADA</th>
        <th width="5%" class="t_campo">DIVISAO</th>
        <th width="5%" class="t_campo">RODADA</th>
        <th width="20%" class="t_campo">ESTÁDIO</th>
        <th width="20%" class="t_campo">MANDANTE</th>
        <th width="15%" class="t_campo">RESULTADO</th>
        <th width="20%" class="t_campo">VISITANTE</th>
        <th width="5%" class="t_campo">REALIZADO</th>
        <th width="5%" class="t_campo">&nbsp;</th>
        </tr>
    
        <?php
        // Listagem
        while($row = mysql_fetch_array($result)){
			
            $row['realizado'] == 1 ? $realizado = "SIM" : $realizado = "NÃO";
            // Tratando dados
            
            echo "	<tr>
                    <td valign=\"top\"> $row[temporada] </td>
                    <td> $row[divisao] </td>
                    <td> $row[rodada] </td>
                    <td> $row[estadio] </td>
                    <td> $row[man] </td>
                    <td> $row[golMan]x$row[golVis] </td>
                    <td valign=\"top\"> $row[vis] </td>
                    <td> $realizado</td>
                    <td><a href='campeonato-jogos-info?j=$row[idJog]'><img src='include/img/bt/bt_alterar.gif' alt='Alterar Registro' title='Alterar Registro' border='0' /></a></td>
                    </tr>";
        }


        ?> 	
    
    </table>

    <?php include 'include/php/paginacao.php'; ?>
<script>
$('#filtro select').change(function(e) {
    $('#filtro').submit();
});
</script>	