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
    
    $pais = $_GET['p'];


    $filtro = $pais < 1 ? '' : "WHERE T.idPai=$pais";
    // PAGINAÇÃO
    $numreg = 25; // Qtde de registros por página
    if (!isset($pg)) $pg = 0;
    if (!isset($_REQUEST['pg'])) $pg = 0; else $pg = $_REQUEST['pg'];
	$inicial = $pg * $numreg;
    $sql = "SELECT T.idTim, T.apelido, (SELECT ROUND(AVG(J.forca)) FROM jogador J, jogador_time C WHERE T.idTIm=C.idTim AND C.idJgd=J.idJgd) as FORCAS FROM times T $filtro ORDER BY FORCAS DESC, apelido";
    $result = mysql_query($sql." LIMIT $inicial, $numreg") or die(mysql_error().' na linha '.__LINE__);
    $quantreg = mysql_num_rows(mysql_query($sql)); // Qtde total de registros na tabela
    // FIM PAGINAÇÃO
    
    echo "<div>Foram encontrados <strong>$quantreg registro(s) </strong></div>";
    ?>

     <form action="" method="get">
    <select name="p">
    <?php 
    $resPai = mysql_query("SELECT P.idPai, P.pais FROM pais P INNER JOIN times T ON P.idPai=T.idPai GROUP BY P.pais ORDER BY P.pais") or die(mysql_error());
    echo "<option value=\"0\">TODOS</option>";
    while ($rowPai = mysql_fetch_array($resPai)) {
        echo "<option value='$rowPai[idPai]'".($pais==$rowPai['idPai']?' selected':'').">$rowPai[pais]</option>}
        option";
    }

     ?>
    </select>
   <button type="submit">IR</button>
    </form>
    
   
    <table class="listagem" width="100%" border="0" cellpadding="3" cellspacing="0">
        <tr>
        <td width="20%" class="t_campo">FORÇA</td>
        <td width="55%" class="t_campo">TIME</td>
        <td width="5%" class="t_campo">&nbsp;</td>
        <td width="5%" class="t_campo">&nbsp;</td>
        </tr>
    
        <?php
        // Listagem
        while($row = mysql_fetch_array($result)){
			
            
            // Tratando dados
            
            echo "	<tr>
                    <td valign=\"top\"> $row[FORCAS] </td>
                    <td> $row[apelido] </td>
                    <td><a href='alt_time.php?id=$row[idTim]'><img src='../../include/img/bt/bt_alterar.gif' alt='Alterar Registro' title='Alterar Registro' border='0' /></a></td>
					<td><a href='#'><img src='../../include/img/bt/bt_excluir.gif' alt='Excluir Registro' title='Excluir Registro' border='0' onclick=\"DelNoticia($row[idTim]);\" /></a></td>
                    </tr>";
        }


        ?> 	
    
    </table>


    <?php include '../../include/php/paginacao.php'; ?>
    
    
    
    
    
    
<!-- CONTEÚDO ACIMA -->
</div>
<?php include '../../include/painel/rodape.php' ?>