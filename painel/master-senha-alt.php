<?php

$idUsu = $_REQUEST['idUsu'];
$chave = $_REQUEST['chave'];

if($chave != md5($idUsu)){	echo "<script> window.history.go(-1); </script>"; }



include_once 'include/scripts/converte_data.php';




if(!$_POST['ACAO']){
	
	//Selecionando dados do usuário a ser atualizado
	$query = "SELECT * FROM painel_usuario WHERE idUsu='$idUsu'";
	//$query = addslashes($query); // Proteção SQL Injection
	$selUsu = mysql_fetch_array(mysql_query($query)) or die (mysql_error());




}if($_POST['ACAO'] == 'ATUALIZAR'){

	if($_POST['nome'] == ""){
		$aviso = "Informe o nome!";
		echo "<script> alert('$aviso'); </script>";
	
	}elseif($_POST['email'] == ""){
		$aviso = "Informe o e-mail!";
		echo "<script> alert('$aviso'); </script>";
	
	}elseif($_POST['senha'] != $_POST['conf']){
		$aviso = "A senha informada não é igual a confirmação!";
		echo "<script> alert('$aviso'); </script>";
	
		
	}else{
		// Tratando os dados
		$nome 				= addslashes($_POST['nome']);
		$fone 				= addslashes($_POST['fone']);
		$email 				= addslashes($_POST['email']);
		$usuario			= addslashes($_POST['usuario']);
		$senha 				= addslashes($_POST['senha']);
		
		$email = strtolower($email);
		$senha = md5($senha);
		
		// Definindo se a senha será atualizada
		$altsenha = '';
		if($_POST['senha'] != '')  $altsenha = ", senha='$senha' ";
		
		
		//GRAVANDO OS DADOS		
		$query = "UPDATE painel_usuario SET nome='$nome', fone='$fone', email='$email' $altsenha WHERE idUsu='$_SESSION[USUARIO]' LIMIT 1";
		$gravou = mysql_query($query) or die(mysql_error());
		
		// PAINEL HISTÓRICO
		$query = addslashes($query);
		mysql_query("INSERT INTO painel_historico(idUsu, acao, query) VALUE('$_SESSION[USUARIO]', 'UPDATE', '$query')") or die (mysql_error());
		//
					
					
		// Verificando a gravação
		if($gravou==false){
			$aviso = 'HOUVE UM ERRO AO ATUALIZAR OS DADOS';
			echo "<script> alert('$aviso'); window.history.go(-1); </script>";
			
		}else{
			$aviso = 'DADOS ATUALIZADOS COM SUCESSO';
			echo "<script> alert('$aviso'); location.href='$SISTEMA[URL]'; </script>";
		}
	}

}
?>







<div class="formulario">

<form method="post" action="<?php echo $_SERVER['REQUEST_URI']?>">
<input type="hidden" name="ACAO" value="ATUALIZAR" />
<input type="hidden" name="idUsu" value="<?php echo $_REQUEST['idUsu']?>" />
	<div class="area">
    
        <h2>INFORMA&Ccedil;&Otilde;ES B&Aacute;SICAS</h2>
        <div class="linha">
        <div class="t_campo">NOME<span class="obrigatorio"> (obrigat&oacute;rio)</span></div>
        <div class="campo"><label><input name="nome" type="text" id="nome" size="75" maxlength="50" onkeyup="this.value=this.value.toUpperCase()" value="<?php echo $selUsu['nome']; ?>" /></label></div>
        </div>
      
        <div class="linha">
        <div class="t_campo">TELEFONE</div>
        <div class="campo"><label><input name="fone" type="text" id="fone" value="<?php echo $selUsu['fone']; ?>" size="30" maxlength="30" /></label></div>
        </div>
        <div class="linha">
          <div class="t_campo">E-MAIL<span class="obrigatorio"> (obrigat&oacute;rio)</span></div>
        <div class="campo"><label><input name="email" type="text" id="email" value="<?php echo $selUsu['email']; ?>" size="70" maxlength="70" /></label></div>
      </div>
	
    </div>
    
    
    <div class="area">
    
    	<h2>DADOS DE ACESSO </h2>
        
        <div class="linha">
        <div class="t_campo">USUÁRIO<span class="obrigatorio"> (obrigat&oacute;rio )</span></div>
        <div class="campo"><label><input name="usuario" type="text" id="usuario" value="<?php echo $selUsu['usuario']; ?>" size="32" maxlength="32" readonly="readonly" /></label></div>
        </div>
        
        <div class="linha">
        <div class="t_campo">SENHA</div>
        <div class="campo"><label><input name="senha" type="password" id="senha" value="" size="32" maxlength="12" /></label></div>
        <div class="legenda"> Caso queira alterar </div>
        </div>
        
        <div class="linha">
        <div class="t_campo">CONFIRMA&Ccedil;&Atilde;O<span class="obrigatorio"> (obrigat&oacute;rio PARA ALTERA&Ccedil;&Atilde;O DE SENHA)</span></div>
        <div class="campo"><label><input name="conf" type="password" id="conf" size="32" maxlength="12" /></label></div>
        </div>

     </div>
    <button type="submit"> ATUALIZAR INFORMAÇÕES </button>
     <button type="button" onclick="javascript:history.go(-1);"> VOLTAR </button>
    
	</form>

</div>