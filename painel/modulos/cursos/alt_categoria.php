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



<?php
if($_REQUEST['idCat'] == 0){
	$aviso = "Registro não encontrado!";
	echo "<script> alert('$aviso'); window.history.go(-1); </script>";	
	
}elseif($_REQUEST['idCat'] > 0 && $_POST['ACAO'] == ''){
	$row = mysql_fetch_array(mysql_query("SELECT * FROM cat_curso WHERE idCat='$_REQUEST[idCat]'"));
	
}elseif($_REQUEST['idCat'] > 0 && $_POST['ACAO'] == 'ATUALIZAR'){
	if($_POST['nome'] == ""){
		$aviso = "Informe o nome!";
		echo "<script> alert('$aviso'); </script>";

		
	}else{
		
		// Gravando os dados
		$gravou = mysql_query("UPDATE cat_curso SET nome='$_POST[nome]', ativo='$_POST[ativo]' WHERE idCat='$_POST[idCat]' LIMIT 1");
		
		// Verificando a gravação
		if($gravou==false){$aviso="Houve um erro no cadastro!";}
		if($gravou==true){$aviso="Dados atualizados com sucesso!";}
					
		echo "<script> alert('$aviso'); location.href='list_categorias.php'; </script>";
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

<script type="text/javascript" src="../../include/scripts/funcoes.js"></script>


<script type="text/javascript">
// DEL ÁLBUM
function Delcat_curso(id){
	decisao = confirm("Deseja mesmo excluir este registro?");
	
	if(decisao){
		location.href='del_categoria.php?id='+id;
	}
}
</script>

</head>

<body>

<?php include '../../include/painel/topo.php' ?>

<div id="conteudo">
<!-- CONTEÚDO ABAIXO -->





<h1>Atualizar &Aacute;lbum</h1>


<div class="formulario">

    <form action="" method="post">
    <input type="hidden" name="ACAO" value="ATUALIZAR" />
    <input type="hidden" name="idCat" value="<?php echo $_REQUEST['idCat']?>" />

	<div class="area">
    
    	<h2> Dados Gerais </h2>

        <div class="linha">
        <div class="t_campo">Nome:</div>
        <div class="campo"><label><input name="nome" type="text" value="<?php echo $row['nome']?>" size="100" maxlength="100" /></label></div>
        </div>
        
        
        <div class="linha">
        <div class="t_campo">Ativo: </div>
        <div class="campo">
        	<input name="ativo" type="radio" id="ativo" value="1" <?php if($row['ativo']==1) echo 'checked="checked"'; ?> /> Sim
        	<input type="radio" name="ativo" id="ativo" value="0" <?php if($row['ativo']==0) echo 'checked="checked"'; ?> /> N&atilde;o
        </div>
        </div>
    
    </div>
    
    
    <button type="submit">Atualizar Dados</button>
    


	</form>
    





<!-- CONTEÚDO ACIMA -->
</div>
<?php include '../../include/painel/rodape.php' ?>