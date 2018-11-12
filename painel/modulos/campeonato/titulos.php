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

$divisao = $_GET['d'] > 0 ? $_GET['d'] : '1';
$posicao = $_GET['p'] > 0 ? $_GET['p'] : '1';

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
<div class="formulario"  style="width: 100%;">
    <form action="" method="get">
    <select name="d">
        <option value="1"<?= $divisao==1?' selected':'' ?>>A</option>
        <option value="2"<?= $divisao==2?' selected':'' ?>>B</option>
    </select>

    <select name="p">
    <?php
    for ($p= 1; $p <=10; $p++) {
        $selected = $posicao==$p ? ' selected' :'';
        echo " <option value='$p' $selected>$p</option>";
    }
    ?>
    </select>
   <button type="submit">IR</button>

    </form>


	<?php


    include '../../include/scripts/converte_data.php';
    
    // PAGINAÇÃO

    $resultTem = mysql_query("SELECT temporada FROM jogo WHERE divisao=$divisao AND rodada=18 AND realizado=1 GROUP BY temporada"); // Qtde total de registros na tabela
    // FIM PAGINAÇÃO
    
    ?>

    
    <table class="listagem" width="100%" border="0" cellpadding="3" cellspacing="0">
        <tr>
        <tr>
            <td width='10%' class="t_campo">#</td>
            <td width='40%' class="t_campo">TIME</td>
            <td width='50%' class="t_campo">ÚLTIMA VEZ</td>
        </tr>

        </tr>
    
        <?php
        $campeoes = array();
        // Listagem
        $LIMIT = '1';
        if($_GET['p']){
            $exp = explode(',', $_GET['p'].",");
            $LIMIT = $exp[0];
            if(count($exp)>2){
                $LIMIT = $exp[0]-1;
                $LIMIT .= ", $exp[1]";
            }elseif(count($exp)<=2 and $LIMIT>1){
                $LIMIT = $exp[0]-1;
                $LIMIT .= ", 1";
            }
        }
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
    SUM(golM) - SUM(golV) SG,
    temporada
FROM (
    SELECT idMan equipe, temporada,
        (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idMan AND E.idAca=1) +
        (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idVis AND E.idAca=5) golM, 

        (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idVis AND E.idAca=1) +
        (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idMan AND E.idAca=5) golV 
    FROM jogo J
     WHERE temporada = '$temporada' AND divisao='$divisao'
   
  union all
    SELECT idVis, temporada,
        (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idVis AND E.idAca=1) + 
        (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idMan AND E.idAca=5) golV, 

        (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idMan AND E.idAca=1) +
        (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idVis AND E.idAca=5) golM 
    FROM jogo J
     WHERE temporada = '$temporada' AND divisao='$divisao'
   
) a 
group by time
order by P DESC, V DESC, SG DESC, GP DESC LIMIT $LIMIT") or die("ESTÁ MORTO O MENINO SQL: ".mysql_error());
            // Tratando dados
            while ($row = mysql_fetch_array($res)) {
                if(@!$campeoes[$row['time']]){
                    $campeoes[$row['time']] = array();
                    $campeoes[$row['time']]['t'] = 1;
                }else{
                    $campeoes[$row['time']]['t']++;                
                }
                $campeoes[$row['time']]['a'] = $row['temporada'];
            }

        }



        mysql_query("CREATE TEMPORARY TABLE campeoes(
                time VARCHAR(100), titulos INT(2), temporada INT(4)
            )") ;
        foreach ($campeoes as $time => $t) {
            mysql_query("INSERT INTO campeoes(time, titulos, temporada)VALUES('$time', '$t[t]', '$t[a]')");
        }
        $resTit = mysql_query("SELECT * FROM campeoes ORDER BY titulos DESC, temporada");
        while ($rowTit = mysql_fetch_array($resTit)) {
            echo "<tr>
                <td>$rowTit[titulos]</td>
                <td>$rowTit[time]</td>
                <td>$rowTit[temporada]</td>
            </tr>";
        }

        ?> 	
    
    </table>


    
    
    
    
    
    
<!-- CONTEÚDO ACIMA -->
</div>
<?php include '../../include/painel/rodape.php' ?>