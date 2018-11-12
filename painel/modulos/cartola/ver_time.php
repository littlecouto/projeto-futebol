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

if($_GET['q'] != ''){
	if(is_numeric($_GET['q'])){
		$json = file_get_contents('http://api.cartola.globo.com/time_adv/cadun/'.$_GET['q'].'.json');
	}else{
		$json = preg_replace("/[^(]*\((.*)\)/", "$1", file_get_contents('http://api.cartola.globo.com/time/busca.jsonp?nome='.$_GET['q']));
		$json = strtr($json, array(';'=>''));

		$json = json_decode($json);
		$json = objectToArray($json);
		
		
		$id = $json['times'][0]['id'];


		$json = file_get_contents('http://api.cartola.globo.com/time/id/'.$id.'/info.json');
		
		$json = json_decode($json);
		$json = objectToArray($json);
		
		$cadun_id = $json['cadun_id'];
		$time = $json['nome'];
		
		$cartoleiro = utf8_decode($json['nome_cartola']);
		$time_carto = $json['imagens_escudo']['img_escudo_160x160'];
		
		$qCar = mysql_fetch_array(mysql_query("SELECT idCar FROM cartoleiro WHERE nome='$cartoleiro'"));
		if($qCar['idCar'] <1){
			mysql_query("INSERT INTO cartoleiro(nome)VALUE('$cartoleiro')");
			$rowCar = mysql_fetch_array(mysql_query("SELECT idCar FROM cartoleiro ORDER BY idCar DESC"));
			$idCar = $rowCar['idCar'];
		}else{
			$idCar = $qCar['idCar'];				
		}
		
		$qTim = mysql_fetch_array(mysql_query("SELECT idClu FROM cartola_time WHERE idClu='$id'"));
		if($qTim['idClu'] <1){
			mysql_query("INSERT INTO cartola_time(idClu, idCar, idCad, nome, escudo)VALUE('$id', '$idCar', '$cadun_id', '$time', '$time_carto')");
			$rowClu = mysql_fetch_array(mysql_query("SELECT idClu FROM cartola_time ORDER BY idClu DESC"));
			$idClu = $rowClu['idClu'];
		}else{
			$idClu = $qTim['idClu'];				
		}
		
		$json = file_get_contents('http://api.cartola.globo.com/time_adv/cadun/'.$cadun_id.'.json');
		
		
		
		
		$mercado = file_get_contents('http://api.cartola.globo.com/mercado/status.json');
		$mercado = json_decode($mercado);
		$mercado = objectToArray($mercado);
		$rodada = $mercado['mercado']['rodada'];
		$rodada = $rodada-1;
		$temporada = $mercado['mercado']['fechamento']['ano'];

	}
}else{
	$json = file_get_contents('http://api.cartola.globo.com/time_adv/cadun/56533856.json');
}

$json 	= json_decode($json);
$json 	= objectToArray($json);

$patrimonio = $json['time']['patrimonio'];

$media 	= 0;
$tr 	= '';
foreach($json['atleta'] as $key => $value){
	$jog = utf8_decode($value['apelido']);
	$pos = $value['posicao']['abreviacao'];
	$pon = $value['pontos'];
	$tim = strtolower($value['clube']['nome']);
	$esc = $value['clube']['escudo_pequeno'];
	$atl = $value['id'];
	
	$media = $pon + $media;
		
	$qAtl = mysql_fetch_array(mysql_query("SELECT idAtl FROM cartola_atleta WHERE idAtl='$atl'"));
	if($qAtl['idAtl'] <1){
		mysql_query("INSERT INTO cartola_atleta(idAtl, posicao, nome)VALUE('$atl', '$pos', '$jog')");
		$rowAtl = mysql_fetch_array(mysql_query("SELECT idAtl FROM cartola_atleta ORDER BY idAtl DESC"));
		$idAtl = $rowAtl['idAtl'];
	}else{
		$idAtl = $qAtl['idAtl'];
	}
	
	$qRel = mysql_num_rows(mysql_query("SELECT idRel FROM cartola_atleta_time WHERE idClu='$idClu' AND idAtl='$idAtl' AND rodada='$rodada'"));
	if($qRel <1){
		mysql_query("INSERT INTO cartola_atleta_time(idAtl, idClu, rodada)VALUE('$idAtl', '$idClu', '$rodada')");
	}

	$qATP = mysql_num_rows(mysql_query("SELECT idPon FROM cartola_atleta_pontos WHERE idAtl='$idAtl' AND rodada='$rodada' AND temporada='$temporada'"));
	if($qATP <1){
		mysql_query("INSERT INTO cartola_atleta_pontos(idAtl, pontos, rodada, temporada)VALUE('$idAtl', '$pon', '$rodada', '$temporada')");
	}
	
	
	
	
	if($pon < 0){
		$pon = "<p style='color: #FF6347'>$pon</p>";
	}elseif($pon == 0){
		$pon = "<p style='color: #696969'>$pon</p>";
	}elseif($pon > 0){
		$pon = "<p style='color: #32CD32'>$pon</p>";
	}
	
	$tr .= "
			<tr>
			<td valign=\"top\"> $pos </td>
			<td> $jog</td>
			<td> $pon </td>
			<td>&nbsp;</td>
			<td><img src='$esc' title='$tim' width='20'></td>
			</tr>
		";
}
$qATP = mysql_num_rows(mysql_query("SELECT idMed FROM cartola_time_media WHERE idClu='$idClu' AND rodada='$rodada' AND temporada='$temporada'"));
if($qATP <1){
	mysql_query("INSERT INTO cartola_time_media(idClu, media, rodada, temporada)VALUE('$idClu', '$media', '$rodada', '$temporada')");
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





<h1>PONTUAÇÃO DA <?=$rodada?>º RODADA</h1>
<br />
<img src='<?=$time_carto?>' width='120'>
<p><?=$time?></p>
<p><?=$cartoleiro?></p>
<p><?=$media?></p>
<p>C$ <?=$patrimonio?></p>


<div class="formulario"  style="width: 100%;">


	
    <table class="listagem" width="100%" border="0" cellpadding="3" cellspacing="0">
        <tr>
        <td width="20%" class="t_campo">POSIÇÃO</td>
        <td width="55%" class="t_campo">NOME</td>
        <td width="15%" class="t_campo">MÉDIA</td>
        <td width="5%" class="t_campo">&nbsp;</td>
        <td width="5%" class="t_campo">&nbsp;</td>
        </tr>
    
        <?php
        // Listagem
			echo $tr;
        ?> 	
    
    </table>


    
    
    
    
    
    
<!-- CONTEÚDO ACIMA -->
</div>
<?php include '../../include/painel/rodape.php' ?>