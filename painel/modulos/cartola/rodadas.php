<?php 
session_start(); 

include_once '../../include/config.php';

// CONEXÃO
include_once '../../include/classes/conexao.class.php';
$con = new Conexao();
$conexao = $con->Conecta();

if($_GET['auth'] != md5('ledbetter')){
	// VER LOGIN
	include_once '../../include/classes/login.class.php';
	$lgn = new Login();
	$lgn->VerLogin();
}

// TITULO PAINEL
$resultPainel 	= mysql_query("SELECT nome FROM painel_empresa LIMIT 1");
$rowPainel		= mysql_fetch_array($resultPainel);
function objectToArray($d) {
	if (is_object($d)) {
		// Gets the properties of the given object
		// with get_object_vars function
		$d = get_object_vars($d);
	}
	
	if (is_array($d)) {
		/*
		* Return array converted to object
		* Using __FUNCTION__ (Magic constant)
		* for recursive call
		*/
		return array_map(__FUNCTION__, $d);
	}
	else {
		// Return array
		return $d;
	}
}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $rowPainel['nome'] ?> - Sistema Eweb de Gestão </title>

<link href="../../include/css/layout.css" rel="stylesheet" type="text/css" />
<link href="../../include/css/form1.css" rel="stylesheet" type="text/css" />
<style>
div#conteudo>img {
    float: left;
    margin-top: -30px;
    margin-right: -20px;
}

div#conteudo>p {
    margin-top: 10px;
    margin-bottom: -10px;
    font-size: 15px;
}
</style>
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





<h1>PONTUAÇÃO DA ÚLTIMA RODADA</h1>
<br />
<img src='<?=$time_carto?>' width='120'>
<p><?=$time?></p>
<p><?=$cartoleiro?></p>
<p><?=$media?></p>


<div class="formulario"  style="width: 100%;">


	
    <table class="listagem" width="100%" border="0" cellpadding="3" cellspacing="0">
        <tr>
        <td width="5%" class="t_campo">&nbsp;</td>
        <td width="20%" class="t_campo">NOME</td>
        <td width="55%" class="t_campo">M&Eacute;DIA</td>
        <td width="15%" class="t_campo">RODADA</td>
        <td width="5%" class="t_campo">&nbsp;</td>
        </tr>
    
        <?php
        // Listagem

        $resCar = mysql_query("SELECT T.idClu, T.nome time, T.escudo, M.idMed, M.media, M.rodada, M.temporada FROM cartola_time T, cartola_time_media M WHERE T.idClu=M.idClu AND rodada>0 ORDER BY media DESC");
        while ($rowCar = mysql_fetch_array($resCar)) {
			echo "
				<tr>
				<td><img src='$rowCar[escudo]' title='$rowCar[time]' width='30'></td>
				<td valign=\"top\"> $rowCar[time] </td>
				<td> $rowCar[media] </td>
				<td> $rowCar[rodada] </td>
				<td>&nbsp;</td>
				</tr>
			";
	        }
        ?> 	
    
    </table>


    
    
    
    
    
    
<!-- CONTEÚDO ACIMA -->
</div>
<?php include '../../include/painel/rodape.php' ?>