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
        $WHERE .= ' AND J.temporada='.$_GET['t'];        
    }elseif($temporada>0 and $WHERE== 'WHERE'){
        $WHERE .= ' J.temporada='.$_GET['t'];        
    }
    if($equipe>0 and $WHERE != 'WHERE'){
        $WHERE .= ' AND (J.idMan='.$_GET['e'].' OR J.idVis='.$_GET['e'].')';        
    }elseif($equipe>0 and $WHERE== 'WHERE'){
        $WHERE .= ' (J.idMan='.$_GET['e'].' OR J.idVis='.$_GET['e'].')';        
    }

    if($WHERE == 'WHERE'){
        $WHERE = '';
    }
    $ORDERBY = 'temporada DESC, turno DESC, rodada DESC, divisao DESC';
    if($listar=='g'){
        $ORDERBY = "(case when golMan>=golVis then golMan-golVis else golVis-golMan end) DESC,
        (case when golMan>=golVis then golMan else golVis end) DESC";
    }
    $PAR = $_SERVER['QUERY_STRING'];

    $sql = "SELECT 
        J.idJog, 
        (SELECT M.apelido FROM times M WHERE J.idMan=M.idTim) man, 
        (SELECT V.apelido FROM times V WHERE J.idVis=V.idTim) vis, 
        (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idMan AND E.idAca=1 AND E.idJgd>0) +
        (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idVis AND E.idAca=5 AND E.idJgd>0) golMan, 

        (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idVis AND E.idAca=1 AND E.idJgd>0) +
        (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idMan AND E.idAca=5 AND E.idJgd>0) golVis,
        (SELECT L.nome FROM estadio L WHERE J.idEst=L.idEst) estadio, 
        rodada, 
        temporada, 
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
    <form action="" method="get">
    <select name="t">
    <?php 

    $resTem = mysql_query("SELECT temporada FROM jogo GROUP BY temporada");
    echo "<option value=\"0\">TODAS</option>";
    while ($rowTem = mysql_fetch_array($resTem)) {
        echo "<option value='$rowTem[temporada]'".($temporada==$rowTem['temporada']?' selected':'').">$rowTem[temporada]</option>}
        option";
    }

     ?>
    </select>
    <select name="d">
        <option value="0"<?= $divisao==0?' selected':'' ?>>TODOS</option>
        <option value="1"<?= $divisao==1?' selected':'' ?>>A</option>
        <option value="2"<?= $divisao==2?' selected':'' ?>>B</option>
    </select>
    <select name="l">
        <option value="g"<?= $listar=='g'?' selected':'' ?>>GOLS</option>
        <option value="j"<?= $listar=='j'?' selected':'' ?>>JOGOS</option>
    </select>
    <select name="s">
        <option value="t"<?= $status=='t'?' selected':'' ?>>TODOS</option>
        <option value="r"<?= $status=='r'?' selected':'' ?>>REALIZADOS</option>
        <option value="a"<?= $status=='a'?' selected':'' ?>>EM ANDAMENTO</option>
        <option value="d"<?= $status=='d'?' selected':'' ?>>PRÓXIMOS</option>
    </select>
    <select name="r">
    <?php 

    $resRod = mysql_query("SELECT rodada FROM jogo GROUP BY rodada");
    echo "<option value=\"0\">TODAS</option>";
    while ($rowRod = mysql_fetch_array($resRod)) {
        echo "<option value='$rowRod[rodada]'".($rodada==$rowRod['rodada']?' selected':'').">$rowRod[rodada]</option>}
        option";
    }

     ?>
    </select>
    <select name="e">
    <?php 

    $resEqu = mysql_query("SELECT idTim, apelido FROM times WHERE idPai=1 ORDER BY apelido");
    echo "<option value=\"0\">TODOS</option>";
    while ($rowEqu = mysql_fetch_array($resEqu)) {
        echo "<option value='$rowEqu[idTim]'".($_GET['e']==$rowEqu['idTim']?' selected':'').">$rowEqu[apelido]</option>}
        option";
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
        <td width="20%" class="t_campo">ESTÁDIO</td>
        <td width="20%" class="t_campo">MANDANTE</td>
        <td width="15%" class="t_campo">RESULTADO</td>
        <td width="20%" class="t_campo">VISITANTE</td>
        <td width="5%" class="t_campo">REALIZADO</td>
        <td width="5%" class="t_campo">&nbsp;</td>
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
                    <td><a href='jogos_campeonato_info.php?j=$row[idJog]'><img src='../../include/img/bt/bt_alterar.gif' alt='Alterar Registro' title='Alterar Registro' border='0' /></a></td>
                    </tr>";
        }


        ?> 	
    
    </table>

    <?php include '../../include/php/paginacao.php'; ?>
    
    
    
    
    
    
<!-- CONTEÚDO ACIMA -->
</div>
<?php include '../../include/painel/rodape.php' ?>