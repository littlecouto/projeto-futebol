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

$row = mysql_fetch_array(mysql_query("SELECT * FROM jogo WHERE temporada='$_GET[t]' AND divisao='$_GET[d]'"));
$divisao = $row['divisao'];
$temporada = $row['temporada'];
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




<h1><?=$divisao?>ª divisão/ temporada <?=$temporada?></h1>
<br />
<a href="ad_time.php">ADICIONAR TIME</a>
<div class="formulario"  style="width: 100%;">


	<?php


    include '../../include/scripts/converte_data.php';
    
    // PAGINAÇÃO
    $pos = 1;
    $sql = "SELECT
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
        (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idMan AND E.idAca=5) golV, 

        (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idMan AND E.idAca=1) +
        (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idVis AND E.idAca=5) golM 
    FROM jogo J
    WHERE temporada = '$temporada' AND divisao='$divisao'
    
) a 
group by time
order by P DESC, V DESC, SG DESC, GP DESC";
    $result = mysql_query($sql) or die(mysql_error().' na linha '.__LINE__);
    $quantreg = mysql_num_rows(mysql_query($sql)); // Qtde total de registros na tabela
    // FIM PAGINAÇÃO
    
    echo "<div>$quantreg times disputaram a competição</div>";
    ?>

    
    <table class="listagem" width="100%" border="0" cellpadding="3" cellspacing="0">
        <tr>
        <tr>
            <td width='30%' class="t_campo">TIME</td>
            <td width='10%' class="t_campo">P</td>
            <td width='10%' class="t_campo">J</td>
            <td width='10%' class="t_campo">V</td>
            <td width='10%' class="t_campo">E</td>
            <td width='10%' class="t_campo">D</td>
            <td width='10%' class="t_campo">GP:GC</td>
            <td width='10%' class="t_campo">SG</td>
        </tr>

        </tr>
    
        <?php
        // Listagem
        while($row = mysql_fetch_array($result)){
			
            $cor = '';
            // Tratando dados
            if($pos ==1){
            	$cor = "style='color: #077347; font-weight: bold;'";
            }elseif($pos>8){
            	$cor = "style='color: #DC143C;'";
            }
		    echo "        
		        <tr>
		            <td $cor>$row[time]</td>
		            <td>$row[P]</td>
		            <td>$row[J]</td>
		            <td>$row[V]</td>
		            <td>$row[E]</td>
		            <td>$row[D]</td>
		            <td>$row[GP] : $row[GC]</td>
		            <td>$row[SG]</td>
		        </tr>";
		        $pos++;
        }


        ?> 	
    
    </table>


    
    
    
    
    
    
<!-- CONTEÚDO ACIMA -->
</div>
<?php include '../../include/painel/rodape.php' ?>