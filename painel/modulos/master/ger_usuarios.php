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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859padrao" />
<title><?php echo $rowPainel['nome'] ?> - Sistema Eweb de Gestão v5.0</title>

<link href="../../include/css/layout.css" rel="stylesheet" type="text/css" />
<link href="../../include/css/form1.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="<?php echo $SISTEMA['JS']?>/jquery.min.js"></script>

<script type="text/javascript" src="../../include/scripts/funcoes.js"></script>



</head>

<body>

<?php include '../../include/painel/topo.php' ?>

<div id="conteudo">

<!-- CONTEÚDO ABAIXO -->




<?php

if(isset($_POST['ACAO']) and $_POST['ACAO'] == 'ADICIONAR'){
	if($_POST['nome'] == ""){
		$aviso = "Informe o seu nome";
		echo "<script> alert('$aviso'); </script>";
	
	}elseif($_POST['email'] == ""){
		$aviso = "Informe o seu e-mail";
		echo "<script> alert('$aviso'); </script>";
		
	}elseif($_POST['usuario'] == ""){
		$aviso = "Informe o seu nome de usuário";
		echo "<script> alert('$aviso'); </script>";
	
	}elseif($_POST['senha'] == ""){
		$aviso = "Informe sua senha";
		echo "<script> alert('$aviso'); </script>";
	
	}elseif($_POST['conf'] == ""){
		$aviso = "Confirmação da senha é obrigatória";
		echo "<script> alert('$aviso'); </script>";
	
	}elseif($_POST['senha'] != $_POST['conf']){
		$aviso = "A senha informada não é igual a confirmação!";
		echo "<script> alert('$aviso'); </script>";
		
	}else{
		// Tratando os dados
		$nome 		= addslashes($_POST['nome']);
		$fone 		= addslashes($_POST['fone']);
		$email 		= addslashes($_POST['email']);
		$usuario	= addslashes($_POST['usuario']);
		$senha 		= addslashes($_POST['senha']);
		$obs 		= addslashes($_POST['obs']);
		$ativo 		= addslashes($_POST['ativo']);
		
		$nome = strtoupper($nome);
		$datacad = date("Y-m-d G:i:s");
		$email = strtolower($email);
		$senha = md5($senha);
		
		// Gravando os dados
		$query = "INSERT INTO painel_usuario(datacad, nome, fone, email, usuario, senha, obs, ativo)VALUES('$datacad', '$_POST[nome]', '$_POST[fone]', '$email', '$_POST[usuario]', '$senha', '$_POST[obs]', '$_POST[ativo]')";
		$gravou = mysql_query($query) or die(mysql_error());
		
		// PAINEL HISTÓRICO
		$query = addslashes($query);
		mysql_query("INSERT INTO painel_historico(idUsu, acao, query) VALUE($_SESSION[USUARIO], 'INSERT', '$query')") or die (mysql_error());
		//
		
		// Verificando a gravação
		if($gravou==false) $aviso = 'Houve um erro no cadastro!'; else $aviso = 'Cadastro efetuado com sucesso!';
		
					
		echo "<script> alert('$aviso'); location.href='ad_usuario.php'; </script>";
	}
}
?>



<h1>Gerenciamento de usu&aacute;rios</h1>



<div class="formulario">



<form method="post" action="ger_usuario.php" enctype="multipart/form-data">
<input type="hidden" name="acao" value="adicionar" />
	<div class="area">
        <h2>Cadastro de Usu&aacute;rio</h2>
        <div class="linha">
        <div class="t_campo">*NOME</div>
        <div class="campo"><label><input name="nome" type="text" id="nome" maxlength="50" /></label></div>
        </div>
        
        <div class="linha">
        <div class="t_campo">TELEFONE</div>
        <div class="campo"><label><input name="fone" type="text" id="fone" maxlength="30" /></label></div>
        </div>
        
        <div class="linha">
        <div class="t_campo">*E-MAIL</div>
        <div class="campo"><label><input name="email" type="text" id="email" maxlength="70" /></label></div>
        </div>
        
        <div class="linha">
        <div class="t_campo">*USUÁRIO</div>
        <div class="campo"><label><input name="usuario" type="text" id="usuario" maxlength="32" /></label></div>
        </div>
        
        <div class="linha">
        <div class="t_campo">*SENHA</div>
        <div class="campo"><label><input name="senha" type="password" id="senha" maxlength="12" /></label></div>
        </div>
        
        <div class="linha">
        <div class="t_campo">*CONFIRMA&Ccedil;&Atilde;O</div>
        <div class="campo"><label><input name="conf" type="password" id="conf" maxlength="12" /></label></div>
        </div>
        
        <div class="linha">
        <div class="t_campo">OBSERVA&Ccedil;&Otilde;ES</div>
        <div class="campo"><label><textarea name="obs" id="obs" cols="48" rows="3"></textarea></label></div>
        </div>
        <div class="linha">
          <div class="t_campo">Ativo: </div>
        <div class="campo"> 
        	<input name="ativo" type="radio" id="ativo" value="1" checked="checked" /> Sim
            <br />
            <input type="radio" name="ativo" id="ativo" value="0" /> N&atilde;o
        </div>
        </div>
    
    
        <button type="submit">Cadastrar</button>

    </div>
    
        
	</form>




	</div>







    <div class="col-dir">
    
    <h2> Usuários Cadastrados </h2>
    
    <?php
    $resultUsu = mysql_query("SELECT idUsu,nome,ativo FROM painel_usuario ORDER BY nome");
    $numero = mysql_num_rows($resultUsu);
    echo "<div>Foram encontrados <strong>$numero registro(s)</strong></div>";
    ?>
    
    <table width="100%" border="0" cellpadding="3" cellspacing="0">
        <tr>
        <td width='80%' class='t_campo'>Nome</td>
        <td width='10%' class='t_campo'>Ativo</td>
        <td width='10%' class='t_campo'>&nbsp;</td>
        </tr>
    
        <?php
		include '../../include/scripts/converte_data.php';
            
            while($row = mysql_fetch_array($resultUsu)){
    
                $chave = md5($row['idUsu']);
                
                echo "	<tr onclick=\"javascript:window.location='../usuarios/alt_usuario.php?idUsu=$row[idUsu]&amp;chave=$chave'\" onMouseOver=\"bgr_color(this, '#FFFFFF')\" onMouseOut=\"bgr_color(this, '#E0E0E0')\">";
                
                echo "	<td>$row[nome]</td>";
                        
                if($row['ativo'] == 1) echo '<td> Sim </td>'; else echo '<td><font color=red> N&atilde;o </font></td>';
                
                echo "	<td><a href='../usuarios/alt_usuario.php?idUsu=$row[idUsu]&amp;chave=$chave'><img src='../../include/img/bt/bt_alterar.gif' border='0' alt='Alterar Registro' border='0' /></a></td>";
                            
                echo "	</tr>";
            }
        ?> 	
    
    </table>
    
    
    </div>




















<!-- CONTEÚDO ACIMA -->
</div>
<?php include '../../include/painel/rodape.php' ?>