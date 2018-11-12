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

$divisao = $_GET['d'];
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




<h1><?=$divisao?>ª divisão</h1>
<br />
<a href="ad_time.php">ADICIONAR TIME</a>
<div class="formulario"  style="width: 100%;">


	<?php


    include '../../include/scripts/converte_data.php';
    
    // PAGINAÇÃO
    $resultTem = mysql_query("SELECT temporada FROM jogo WHERE divisao=$divisao AND rodada=18 GROUP BY temporada"); // Qtde total de registros na tabela
    // FIM PAGINAÇÃO
    
    ?>

    
    <table class="listagem" width="100%" border="0" cellpadding="3" cellspacing="0">
        <tr>
        <tr>
            <td width='10%' class="t_campo">TEMPORADA</td>
            <td width='20%' class="t_campo">CAMPEÃO</td>
            <td width='20%' class="t_campo">VICE</td>
            <td width='20%' class="t_campo">TERCEIRO</td>
            <td width='30%' class="t_campo">ARTILHEIRO</td>
        </tr>

        </tr>
    
        <?php
        // Listagem
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
    SUM(golM) - SUM(golV) SG
FROM (
    SELECT idMan equipe,
        (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idMan AND E.idAca=1) +
        (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idVis AND E.idAca=5) golM, 

        (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idVis AND E.idAca=1) +
        (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idMan AND E.idAca=5) golV 
    FROM jogo J
    WHERE temporada = '$temporada' AND divisao='$divisao'
  union all
    SELECT idVis,
        (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idVis AND E.idAca=1) +
        (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idMan AND E.idAca=5) golM, 

        (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idMan AND E.idAca=1) +
        (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idVIs AND E.idAca=5) golV 
     FROM jogo J
    WHERE temporada = '$temporada' AND divisao='$divisao'
) a 
group by time
order by P DESC, V DESC, SG DESC, GP DESC LIMIT 3") or die(mysql_error());
            // Tratando dados
		    echo "<tr onclick=\"javascript:location.href='info_campeonato.php?t=$temporada&amp;d=$divisao'\">
                <td>$temporada</td>";
                while ($row = mysql_fetch_array($res)) {
                    echo"<td>$row[time] - $row[P]</td>";
                }

            $rowArt = mysql_fetch_array(mysql_query("SELECT COUNT(E.idAca) gols, J.apelido, T.apelido time FROM evento E INNER JOIN jogador J ON E.idJgd=J.idJgd INNER JOIN jogo G ON E.idJog=G.idJog INNER JOIN times T ON E.idTim=T.idTim WHERE G.divisao=$divisao AND E.idAca=1 AND E.temporada=$temporada GROUP BY E.idJgd ORDER BY gols DESC "));
                echo "<td>$rowArt[apelido], $rowArt[gols] ($rowArt[time])</td>";
            echo"</tr>";
        }


        ?> 	
    
    </table>


    
    
    
    
    
    
<!-- CONTEÚDO ACIMA -->
</div>
<?php include '../../include/painel/rodape.php' ?>