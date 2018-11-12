<?php 
session_start(); 

include_once '../../include/config.php';

// CONEXÃO
include_once '../../include/classes/conexao.class.php';
$con = new Conexao();
$conexao = $con->Conecta();

// VER LOGIN
include_once '../../include/classes/login.class.php';
$lgn = new Login();
$lgn->VerLogin();

// TITULO PAINEL
$resultPainel 	= mysql_query("SELECT nome FROM painel_empresa LIMIT 1");
$rowPainel		= mysql_fetch_array($resultPainel);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $rowPainel['nome'] ?> - Sistema Eweb de Gestão </title>

<link href="../../include/css/layout.css" rel="stylesheet" type="text/css" />
<link href="../../include/css/form1.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="../../include/scripts/funcoes.js"></script>

<script type="text/javascript">
// DEL EQUIPE
function DelNoticia(id){
	decisao = confirm("Deseja mesmo excluir este registro?");
	
	if(decisao){
		location.href='del_noticia.php?id='+id;
	}
}
</script>



</head>

<body>

<?php include '../../include/painel/topo.php' ?>

<div id="conteudo">
<!-- CONTEÚDO ABAIXO -->




<h1>LISTAGEM DE TIMES</h1>
<br />
<a href="ad_time.php">ADICIONAR TIME</a>
<div class="formulario"  style="width: 100%;">


	<?php


    include '../../include/scripts/converte_data.php';
    
    // PAGINAÇÃO
    !isset($_GET['m']) ? $mandante = 20 : $mandante = $_GET['m'];
    !isset($_GET['v']) ? $visitante = 28 : $visitante = $_GET['v'];
    $sql    = "SELECT 
        idMan, 
        idVis, 
        J.idJog, 
        (SELECT M.apelido FROM times M WHERE J.idMan=M.idTim) man, 
        (SELECT V.apelido FROM times V WHERE J.idVis=V.idTim) vis, 
        (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idMan AND E.idAca=1) +
        (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idVis AND E.idAca=5) golM, 

        (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idVis AND E.idAca=1) +
        (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idMan AND E.idAca=5) golV,
        (SELECT L.nome FROM estadio L WHERE J.idEst=L.idEst) estadio, 
        rodada, 
        turno, 
        temporada, 
        divisao 
    FROM 
        jogo J 
    WHERE 
        (J.idMan=$mandante AND J.idVis=$visitante) 
    OR 
        (J.idVis=$mandante AND J.idMan=$visitante) 
    ORDER BY 
    temporada, J.idJog";
    $result = mysql_query($sql) or die(mysql_error().' na linha '.__LINE__);
    $jogos = mysql_num_rows(mysql_query($sql));
    ?>
    <form action="" method="get">
    <select name="m">
    <?php 

    $resMan = mysql_query("SELECT idTim, apelido FROM times WHERE idPai=1 ORDER BY apelido");
    while ($rowMan = mysql_fetch_array($resMan)) {
        echo "<option value='$rowMan[idTim]'".($mandante==$rowMan['idTim']?' selected':'').">$rowMan[apelido]</option>";
    }

     ?>
    </select>
    <select name="v">
    <?php 

    $resVis = mysql_query("SELECT idTim, apelido FROM times WHERE idPai=1 ORDER BY apelido");
    while ($RowVis = mysql_fetch_array($resVis)) {
        echo "<option value='$RowVis[idTim]'".($visitante==$RowVis['idTim']?' selected':'').">$RowVis[apelido]</option>";
    }

     ?>
    </select>
   <button type="submit">IR</button>
    </form>
    
    <table class="listagem" width="100%" border="0" cellpadding="3" cellspacing="0">
        <tr>
        <td width="5%" class="t_campo">TEMPORADA</td>
        <td width="5%" class="t_campo">DIVISAO</td>
        <td width="5%" class="t_campo">RODADA</td>
        <td width="5%" class="t_campo">TURNO</td>
        <td width="20%" class="t_campo">ESTÁDIO</td>
        <td width="20%" class="t_campo">MANDANTE</td>
        <td width="15%" class="t_campo">RESULTADO</td>
        <td width="20%" class="t_campo">VISITANTE</td>
        <td width="5%" class="t_campo">&nbsp;</td>
        </tr>
    
        <?php
        // Listagem
        $VitM = $VitV = $golM = $golV = 0;
        while($row = mysql_fetch_array($result)){
            if($mandante == $row['idMan']){
                $golM = $golM+$row['golM'];
                $golV = $golV+$row['golV'];
                if($row['golM']>$row['golV']){
                    $VitM++; 
                }elseif($row['golM']<$row['golV']){
                    $VitV++;
                }
            }elseif($mandante == $row['idVis']){
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
                    <td><a href='jogos_campeonato_info.php?j=$row[idJog]'><img src='../../include/img/bt/bt_alterar.gif' alt='Alterar Registro' title='Alterar Registro' border='0' /></a></td>
                    </tr>";
        }
		$empates = abs(($VitM+$VitV)-$jogos);
		$gols	 = $golM+$golV;
		
		$medJ = round($gols/$jogos,2);
		$medM = round($golM/$jogos,2);
		$medV = round($golV/$jogos,2);
		
        $rowM = mysql_fetch_array(mysql_query("SELECT apelido FROM times WHERE idTim=$mandante"));
        $rowV = mysql_fetch_array(mysql_query("SELECT apelido FROM times WHERE idTim=$visitante"));
        echo "$jogos jogos entre $rowM[apelido] e $rowV[apelido] | $gols gols | $medJ gols por jogo</br>";
        echo "$VitM vitorias do $rowM[apelido] | $golM gols | $medM gols por jogo </br>";
        echo "$VitV vitorias do $rowV[apelido] | $golV gols | $medV gols por jogo</br>";
        echo "E $empates empates</br>";

        ?> 	
    
    </table>


    
    
    
    
    
    
<!-- CONTEÚDO ACIMA -->
</div>
<?php include '../../include/painel/rodape.php' ?>