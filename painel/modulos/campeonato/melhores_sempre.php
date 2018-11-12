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

$row = mysql_fetch_array(mysql_query("SELECT * FROM jogo WHERE divisao='$_GET[d]'"));
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



<?php 
    if($divisao>0){
        $h1 = $divisao."ª divisão/ temporada ".$temporada;
    }else{
        $h1 = "MELHORES DE SEMPRE";
    }
?>
<h1><?=$h1?></h1>
<br />
<a href="ad_time.php">ADICIONAR TIME</a>
<div class="formulario"  style="width: 100%;">
    <form action="" method="get">
    <select name="d">
        <option value="1"<?= $divisao==1?' selected':'' ?>>A</option>
        <option value="2"<?= $divisao==2?' selected':'' ?>>B</option>
    </select>
   <button type="submit">IR</button>

    </form>


	<?php


    include '../../include/scripts/converte_data.php';
    
    // PAGINAÇÃO
    $pos = 1;

    $filtro = $divisao >0 ? "WHERE divisao='$divisao'":'';


    $desc   = $_GET['r'] == 1  ? 'DESC'     : '';
    $order  = $_GET['o'] != '' ? $_GET['o'] : 'P DESC, V DESC, SG DESC, GP DESC';
    if($order!=''){
        $ORDERBY = "$order $desc";
    }
	
    $result = mysql_query("SELECT
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
    (
        (
            (count(case when golM > golV then 1 end)*3) +
            (count(case when golM = golV then 1 end))
         )
         /
        ((COUNT(*))*3)*100
    ) AS 'AP',
	(SUM(golM)/count(*)) AS MG
FROM (
    SELECT idMan equipe,
        (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idMan AND E.idAca=1) +
        (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idVis AND E.idAca=5) golM, 

        (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idVis AND E.idAca=1) +
        (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idMan AND E.idAca=5) golV 
    FROM jogo J
    $filtro
  union all
    SELECT idVis, 
        (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idVis AND E.idAca=1) + 
        (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idMan AND E.idAca=5) golV, 

        (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idMan AND E.idAca=1) +
        (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idVis AND E.idAca=5) golM 
    FROM jogo J
     $filtro
) a 
group by time
order by $ORDERBY") or die(mysql_error().' na linha '.__LINE__);
    $quantreg = mysql_num_rows(mysql_query("SELECT * FROM times")); // Qtde total de registros na tabela
    // FIM PAGINAÇÃO
    
    echo "<div>Foram encontrados <strong>$quantreg registro(s) </strong></div>";
    ?>

    
    <table class="listagem" width="100%" border="0" cellpadding="3" cellspacing="0">
        <tr>
        <tr>
            <td width='25%' class="t_campo"><a href="melhores_sempre.php?<?=$_GET['d']>0?'d='.$_GET['d'].'&':'';?><?= ($_GET['o']=='time' and $_GET['r'] == 0) ? 'o=time&r=1':'o=time&r=0';?>">TIME</a></td>
            <td width='10%' class="t_campo"><a href="melhores_sempre.php?<?=$_GET['d']>0?'d='.$_GET['d'].'&':'';?><?= ($_GET['o']=='p' and $_GET['r'] == 1) ? 'o=p&r=0':'o=p&r=1';?>">P</a></td>
            <td width='10%' class="t_campo"><a href="melhores_sempre.php?<?=$_GET['d']>0?'d='.$_GET['d'].'&':'';?><?= ($_GET['o']=='j' and $_GET['r'] == 1) ? 'o=j&r=0':'o=j&r=1';?>">J</a></td>
            <td width='10%' class="t_campo"><a href="melhores_sempre.php?<?=$_GET['d']>0?'d='.$_GET['d'].'&':'';?><?= ($_GET['o']=='v' and $_GET['r'] == 1) ? 'o=v&r=0':'o=v&r=1';?>">V</a></td>
            <td width='10%' class="t_campo"><a href="melhores_sempre.php?<?=$_GET['d']>0?'d='.$_GET['d'].'&':'';?><?= ($_GET['o']=='e' and $_GET['r'] == 1) ? 'o=e&r=0':'o=e&r=1';?>">E</a></td>
            <td width='10%' class="t_campo"><a href="melhores_sempre.php?<?=$_GET['d']>0?'d='.$_GET['d'].'&':'';?><?= ($_GET['o']=='d' and $_GET['r'] == 1) ? 'o=d&r=0':'o=d&r=1';?>">D</a></td>
            <td width='10%' class="t_campo"><a href="melhores_sempre.php?<?=$_GET['d']>0?'d='.$_GET['d'].'&':'';?><?= ($_GET['o']=='gp' and $_GET['r'] == 1) ? 'o=gp&r=0':'o=gp&r=1';?>">GP</a>:<a href="melhores_sempre.php?<?=$_GET['d']>0?'d='.$_GET['d'].'&':'';?><?= ($_GET['o']=='gc' and $_GET['r'] == 0) ? 'o=gc&r=1':'o=gc&r=0';?>">GC</a></td>
            <td width='5%' class="t_campo"><a href="melhores_sempre.php?<?=$_GET['d']>0?'d='.$_GET['d'].'&':'';?><?= ($_GET['o']=='sg' and $_GET['r'] == 1) ? 'o=sg&r=0':'o=sg&r=1';?>">SG</a></td>
            <td width='5%' class="t_campo"><a href="melhores_sempre.php?<?=$_GET['d']>0?'d='.$_GET['d'].'&':'';?><?= ($_GET['o']=='ap' and $_GET['r'] == 1) ? 'o=ap&r=0':'o=ap&r=1';?>">%</a></td>
            <td width='5%' class="t_campo"><a href="melhores_sempre.php?<?=$_GET['d']>0?'d='.$_GET['d'].'&':'';?><?= ($_GET['o']=='mg' and $_GET['r'] == 1) ? 'o=mg&r=0':'o=mg&r=1';?>">GM</a></td>
        </tr>

        </tr>
    
        <?php
        // Listagem
        while($row = mysql_fetch_array($result)){
			
            $row['AP'] = round($row['AP'], 1);
			$row['MG'] = round($row['MG'], 2);
            // Tratando dados
		    echo "        
		        <tr>
		            <td>$row[time]</td>
		            <td>$row[P]</td>
		            <td>$row[J]</td>
		            <td>$row[V]</td>
		            <td>$row[E]</td>
		            <td>$row[D]</td>
		            <td>$row[GP] : $row[GC]</td>
                    <td>$row[SG]</td>
                    <td>$row[AP]</td>
                    <td>$row[MG]</td>
		        </tr>";
        }


        ?> 	
    
    </table>


    
    
    
    
    
    
<!-- CONTEÚDO ACIMA -->
</div>
<?php include '../../include/painel/rodape.php' ?>