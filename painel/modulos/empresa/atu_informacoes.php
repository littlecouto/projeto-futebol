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
if(isset($_POST['ACAO']) && $_POST['ACAO'] == 'ATUALIZAR'){
	
	//validando campos
	if(empty($_POST['nome'])){
		echo "<script>alert('Preencha o campo NOME!'); history.go(padrao);</script>";
	}elseif(empty($_POST['email'])){
		echo "<script>alert('Preencha o campo EMAIL!'); history.go(padrao);</script>";
	}else{
		// Tratando os dados
		$nome 			= addslashes($_POST['nome']);
		$cep 			= addslashes($_POST['cep']);
		$logradouro 	= addslashes($_POST['logradouro']);
		$num			= addslashes($_POST['num']);
		$complemento 	= addslashes($_POST['complemento']);
		$bairro 		= addslashes($_POST['bairro']);
		$cidade 		= addslashes($_POST['cidade']);
		$uf 			= addslashes($_POST['uf']);
		$fone1 			= addslashes($_POST['fone1']);
		$fone2 			= addslashes($_POST['fone2']);
		$fax			= addslashes($_POST['fax']);
		$email 			= addslashes($_POST['email']);
		$nome  			= strtoupper($nome);
		$email 			= strtolower($email);
		

		// VERIFICANDO SE A TABELA JÁ POSSUI DADOS
		if(mysql_num_rows(mysql_query("SELECT idUsu FROM empresa")) == 0){
					
			// GRAVAR DADOS
			$query = "INSERT INTO empresa(idUsu, nome, cep, logradouro, num, complemento, bairro, cidade, uf, fone1, fone2, fax, email) VALUES('$_SESSION[USUARIO]', '$nome', '$cep', '$logradouro', '$num', '$complemento', '$bairro', '$cidade', '$uf', '$fone1', '$fone2', '$fax', '$email')";
			
			$gravou = mysql_query($query) or die (mysql_error());
		
			// PAINEL HISTÓRICO
			$query = addslashes($query);
			mysql_query("INSERT INTO painel_historico(idUsu, acao, query) VALUE($_SESSION[USUARIO], 'INSERT', '$query')") or die (mysql_error());
			//
		
		}
		
		else{
			
			// ATUALIZAR DADOS
			$query = "UPDATE empresa SET idUsu='$_SESSION[USUARIO]', nome='$nome', cep='$cep', logradouro='$logradouro', num='$num', complemento='$complemento', bairro='$bairro', cidade='$cidade', uf='$uf', fone1='$fone1', fone2='$fone2', fax='$fax', email='$email' LIMIT 1";
			
			$gravou = mysql_query($query) or die (mysql_error());
		
			// PAINEL HISTÓRICO
			$query = addslashes($query);
			mysql_query("INSERT INTO painel_historico(idUsu, acao, query) VALUE($_SESSION[USUARIO], 'UPDATE', '$query')") or die (mysql_error());
			//
			
		}
			
		
				
		if($gravou == false) $aviso = 'Erro ao gravar os dados!'; else $aviso = 'Dados atualizados com sucesso!';
		
					
		echo "<script> alert('$aviso'); location.href='$SISTEMA[URL]'; </script>";
			
	}
}
	
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859padrao" />
<title><?php echo $rowPainel['nome'] ?> - Sistema Eweb de Gestão </title>

<link href="../../include/css/layout.css" rel="stylesheet" type="text/css" />
<link href="../../include/css/form1.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="<?php echo $SISTEMA['JS']?>/jquery.min.js"></script>


</head>

<body>

<?php include '../../include/painel/topo.php' ?>

<div id="conteudo">

<!-- CONTEÚDO ABAIXO -->






<h1>INFORMA&Ccedil;&Otilde;ES EXIBIDAS NO SITE</h1>

<div class="formulario">

<?php 
	//pegando dados do cliente
	$rowEmp = mysql_fetch_array(mysql_query("SELECT * FROM empresa LIMIT 1"));
?>

<form method="post" action="<?php $_SERVER['REQUEST_URI'] ?>">
<input type="hidden" name="ACAO" value="ATUALIZAR" />

	<div class="area">
        <h2>Atualizar INFORMA&Ccedil;&Otilde;ES</h2>
        <div class="linha">
        <div class="t_campo">NOME</div>
        <div class="campo"><label><input name="nome" type="text" id="nome" maxlength="50" value="<?php echo $rowEmp['nome']; ?>" /></label></div>
        </div>
        
        <div class="linha">
        <div class="t_campo">E-MAIL</div>
        <div class="campo"><label><input name="email" type="text" id="email" maxlength="70" value="<?php echo $rowEmp['email']; ?>" /></label></div>
        </div>
      
        <div class="linha">
        <div class="t_campo">TELEFONE 1</div>
        <div class="campo"><label><input name="fone1" type="text" id="fone1" maxlength="30" value="<?php echo $rowEmp['fone1']; ?>" /></label></div>
        </div>
        
        <div class="linha">
        <div class="t_campo">TELEFONE 2</div>
        <div class="campo"><label><input name="fone2" type="text" id="fone2" maxlength="30" value="<?php echo $rowEmp['fone2']; ?>" /></label></div>
        </div>
        
        <div class="linha">
        <div class="t_campo">Fax</div>
        <div class="campo"><label><input name="fax" type="text" id="fax" maxlength="30" value="<?php echo $rowEmp['fax']; ?>" /></label></div>
        </div>
        
        
        
        <div class="linha">
        <div class="t_campo">LOGRADOURO</div>
        <div class="campo"><label><input name="logradouro" type="text" id="logra" maxlength="100" value="<?php echo $rowEmp['logradouro']; ?>" /></label></div>
        </div>
       
        <div class="linha">
        <div class="t_campo">NÚMERO</div>
        <div class="campo"><label><input name="num" type="text" id="num" maxlength="6" value="<?php echo $rowEmp['num']; ?>" /></label></div>
        </div>
        
        <div class="linha">
        <div class="t_campo">COMPLEMENTO</div>
        <div class="campo"><label><input name="complemento" type="text" id="complemento" maxlength="30" value="<?php echo $rowEmp['complemento']; ?>" /></label></div>
        </div>
       
        <div class="linha">
        <div class="t_campo">CEP</div>
        <div class="campo"><label><input name="cep" type="text" id="cep" maxlength="9" value="<?php echo $rowEmp['cep']; ?>" /></label></div>
        </div>
    
       
        <div class="linha">
        <div class="t_campo">BAIRRO</div>
        <div class="campo"><label><input name="bairro" type="text" id="bairro" maxlength="50" value="<?php echo $rowEmp['bairro']; ?>" /></label></div>
        </div>
        
        
        <div class="linha">
        
        <div class="t_campo">CIDADE</div>
        <div class="campo"><label><input name="cidade" type="text" id="cidade" maxlength="50" value="<?php echo $rowEmp['cidade']; ?>" /></label></div>
        </div>
        
        <div class="linha">
        <div class="t_campo">UF</div>
        <div class="campo"><label>
            <select name="uf" size="1" id="uf">
            <option value="<?php echo $rowEmp['uf']; ?>" ><?php echo $rowEmp['uf']; ?> </option>
            <option value="AC">AC</option>
            <option value="AL">AL</option>
    
            <option value="AM">AM</option>
            <option value="AP">AP</option>
            <option value="BA">BA</option>
            <option value="CE">CE</option>
            <option value="DF">DF</option>
            <option value="ES">ES</option>
    
            <option value="GO">GO</option>
            <option value="MA">MA</option>
            <option value="MG">MG</option>
            <option value="MS">MS</option>
            <option value="MT">MT</option>
            <option value="PA">PA</option>
    
            <option value="PB">PB</option>
            <option value="PE">PE</option>
            <option value="PI">PI</option>
            <option value="PR">PR</option>
            <option value="RJ">RJ</option>
            <option value="RN">RN</option>
    
            <option value="RO">RO</option>
            <option value="RR">RR</option>
            <option value="RS">RS</option>
            <option value="SC">SC</option>
            <option value="SE">SE</option>
            <option value="SP">SP</option>
    
            <option value="TO">TO</option>
            </select>
        </label>
        </div>
        </div>
    
       
        <button type="submit">Atualizar Dados</button>
    
    </div>
                 
                
   
    
	</form>

</div>
















<!-- CONTEÚDO ACIMA -->

</div>
<?php include '../../include/painel/rodape.php' ?>