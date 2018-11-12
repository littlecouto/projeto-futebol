<?php 
session_start(); 

// CONEXÃO
include_once 'include/classes/conexao.class.php';
$con = new Conexao();
$conexao = $con->Conecta();

include_once 'include/config.php';
include_once 'include/php/funcoes.php';
// VER LOGIN
include_once 'include/classes/login.class.php';
$lgn = new Login();
$lgn->VerLogin();

$rowCor = mysql_fetch_array(mysql_query("SELECT cor_pri, cor_seg FROM painel_config"));
$cor_pri = $rowCor['cor_pri'];
$cor_seg = $rowCor['cor_seg'];


?>


<!doctype html>
<html>
<head>
<meta charset="iso-8859-1">
<title><?php echo $rowPainel['sistema_nome'] ?></title>
<base href="<?=$URLSEG?>">
<link href="include/css/layout.css" rel="stylesheet" type="text/css">
<link rel="shortcut icon" type="image/png" href="<?=$UrlFavicon?>/favicon-seg.png">

<?php
echo "
<style>
#conteudo h2{
	color: $cor_pri;
}
#menu {
	background-color: $cor_pri;
}
.formulario table tr th,
button , input[type=button], input[type=submit],
#login form button {
	background-color: $cor_seg;
}
#conteudo h1{
	color: $cor_seg;
}
#paginacao #paginacao-links a:hover.pg,
#paginacao #paginacao-links a.pg_off{
	background-color: $cor_pri;
	color: #FFF;
}

</style>
";
?>

<script src="include/scripts/funcoes.js"></script>
<script src="include/js/jquery-2.1.4.js"></script>
<!-- AJAX -->
<script type="text/javascript" src="ajax/busca_cep.js"> </script>


<script type="text/javascript">
// DEL IMAGEM
function DelImg(id){
	decisao = confirm("Deseja mesmo excluir esta imagem?");
	
	if(decisao){
		location.href='del_noticia_img.php?id='+id;
	}
}
</script>





</head>

<body>
<div id="conteudo">

<!-- CONTEÚDO ABAIXO -->



<?php

$url_ign = array('index', 'painel-login', 'painel-logout');
$urlAtu = $_GET['url'];
$rowPer = mysql_fetch_array(mysql_query("SELECT a.idIte, b.nome FROM painel_permissao a JOIN painel_modulo_item b ON (a.idIte = b.idIte) WHERE a.idUsu='$_SESSION[USUARIOSEG]' AND a.tipo='ITEM' AND b.url='$urlAtu'"));

if($urlAtu != 'painel-login'){
    include 'painel-topo.php';
    include 'painel-menu.php';
    include 'painel-menusub.php';
}
?>
<div id="conteudosub">
<h1><?=$rowPer['nome']?></h1>
<br>
<div class="formulario"  style="width: 100%;">

<?php
if($rowPer['idIte']<1 and $urlAtu != 'index'){
	echo "<h1>SEM PERMISSÃO!</h1>";
}else{
	(@include_once "$urlAtu.php") or die("<h2>Página não existe</h2>");
}
?>
    
    
    
<!-- CONTEÚDO ACIMA -->
</div>
</div>
<?php include 'include/painel/rodape.php' ?>
