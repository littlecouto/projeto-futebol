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
if($_POST['ACAO'] == 'ADICIONAR'){
	if($_POST['nome'] == ""){
		$aviso = "Informe o nome!";
		echo "<script> alert('$aviso'); </script>";
	}else{
		
		
		
				
		// Gravando os dados
		$gravou = mysql_query("INSERT INTO cat_curso(nome, ativo)VALUES('$_POST[nome]', '$_POST[ativo]')") or die(mysql_error());
		
		// Verificando a gravação
		if($gravou==false) $aviso='Houve um erro no cadastro!';
		if($gravou==true){
			$aviso='Cadastro efetuado com sucesso!';
		}
		
		echo "<script> alert('$aviso'); location.href='list_categorias.php'; </script>";
		
	}
}
?>








<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $rowPainel['nome'] ?>  - Sistema Eweb de Gestão </title>

<link href="../../include/css/layout.css" rel="stylesheet" type="text/css" />
<link href="../../include/css/form1.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="../../include/scripts/funcoes.js"></script>


<!-- AJAX -->
<script type="text/javascript" src="ajax/busca_cep.js"> </script>


</head>

<body>

<?php include '../../include/painel/topo.php' ?>
<div id="conteudo">
<!-- CONTEÚDO ABAIXO -->


<h1>CADASTRO DE CATEGORIAS</h1>



<div class="formulario">

    <form method="post" action="<?php echo $_SERVER['REQUEST_URI']?>">
    <input type="hidden" name="ACAO" value="ADICIONAR" />
	<div class="area">
    
        <h2>Dados Gerais</h2>
        
        <div class="linha">
        <div class="t_campo">Nome:</div>
        <div class="campo"><label><input name="nome" type="text" id="nome" size="100" maxlength="100" onkeyup="this.value=this.value.toUpperCase()" /></label></div>
        </div>
       

        <div class="linha">
        <div class="t_campo">Ativo: </div>
        <div class="campo">
        	<input name="ativo" type="radio" id="ativo" value="1" checked="checked" /> Sim <br />
         	<input type="radio" name="ativo" id="ativo" value="0" /> N&atilde;o
        </div>
        </div>
        
    
    </div>
         
            
    <button type="submit">Cadastrar</button>
     
        
    </form>
    
    
    

</div>





<!-- CONTEÚDO ACIMA -->
</div>
<?php include '../../include/painel/rodape.php' ?>