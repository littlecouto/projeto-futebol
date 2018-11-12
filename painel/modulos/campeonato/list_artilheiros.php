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




<h1>MELHORES DE SEMPRE</h1>
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
        <option value="1"<?= $divisao==1?' selected':'' ?>>A</option>
        <option value="2"<?= $divisao==2?' selected':'' ?>>B</option>
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
   <button type="submit">IR</button>
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
    include '../../include/scripts/converte_data.php';

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
        <tr>
            <td width='5%' class="t_campo">#</td>
            <td width='25%' class="t_campo">NOME</td>
            <td width='5%' class="t_campo">GOLS</td>
            <td width='20%' class="t_campo">TIME</td>
            <td width='45%' class="t_campo">JOGO</td>
        </tr>

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
                <td><a href=\"jogos_campeonato_info.php?j=$row[idJog]\">$rowJog[mandante] $rowJog[golM] x $rowJog[golV] $rowJog[visitante]</a></td>
                <td></td>";
            echo"</tr>";
        }


        ?> 	
    
    </table>


    <?php include '../../include/php/paginacao.php'; ?>
  
    
    
    
    
    
<!-- CONTEÚDO ACIMA -->
</div>
<?php include '../../include/painel/rodape.php' ?>