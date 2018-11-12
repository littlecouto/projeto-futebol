<?php




include_once 'include/scripts/converte_data.php';



if(!isset($_REQUEST['ACAO']) or $_REQUEST['ACAO'] != 'ATUALIZAR'){

	//Selecionando dados do usuário a ser atualizado
	$query = "SELECT * FROM painel_usuario WHERE idUsu='$_REQUEST[cod]'";
	
	//$query = addslashes($query); // Proteção SQL Injection
	$selUsu = mysql_fetch_array(mysql_query($query)) or die (mysql_error());
	
	


}elseif($_POST['ACAO'] == 'ATUALIZAR'){
	
	
	
	if($_POST['nome'] == ""){
		$aviso = "Informe o nome!";
		echo "<script> alert('$aviso'); </script>";
	
	}elseif($_POST['email'] == ""){
		$aviso = "Informe o e-mail!";
		echo "<script> alert('$aviso'); </script>";
	
	}elseif($_POST['senha'] != $_POST['conf']){
		$aviso = "A senha informada não é igual a confirmação!";
		echo "<script> alert('$aviso'); </script>";
	
	}elseif($_POST['master'] == 0 and $_POST['permissao_cliente'] == 0 and $_POST['permissao_hospedagem'] == 0 and $_POST['permissao_os'] == 0  and $_POST['permissao_financeiro'] == 0){
		$aviso = 'Defina ao menos uma permissão ao usuário';
		echo "<script> alert('$aviso'); window.history.go(-1); </script>";
			
	}else{
		
		// Tratando os dados
		$nome 					= addslashes($_POST['nome']);
		$fone 					= addslashes($_POST['fone']);
		$email 					= addslashes($_POST['email']);
		$usuario				= addslashes($_POST['usuario']);
		$conf					= addslashes($_POST['conf']);
		$senha 					= addslashes($_POST['senha']);
		$obs 					= addslashes($_POST['obs']);
		$master 				= addslashes($_POST['master']);
		$permissao_cliente		= addslashes($_POST['permissao_cliente']);
		$permissao_hospedagem	= addslashes($_POST['permissao_hospedagem']);
		$permissao_fornecedor	= addslashes($_POST['permissao_fornecedor']);
		$permissao_financeiro	= addslashes($_POST['permissao_financeiro']);
		$permissao_campanha		= addslashes($_POST['permissao_campanha']);
		$ativo 					= addslashes($_POST['ativo']);
		
		$nome = strtoupper($nome);
		$email = strtolower($email);
		$senha = md5($senha);
		
		// Definindo se a senha será atualizada
		$altsenha = '';
		if($_POST['senha'] != '')  $altsenha = " senha='$senha',";
		

		//GRAVANDO OS DADOS		
		$query = "UPDATE painel_usuario SET nome='$nome', fone='$fone', email='$email', $altsenha obs='$obs', master='$master', ativo='$ativo' WHERE idUsu='$_REQUEST[cod]' LIMIT 1";
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
			echo "<script> alert('$aviso'); location.href='ger_usuarios.php'; </script>";
		}
	}

}
?>
<div class="formulario">

<form method="post" action="<?php echo $_SERVER['REQUEST_URI']?>">
<input type="hidden" name="ACAO" value="ATUALIZAR" />
<input type="hidden" name="cod" value="<?php echo $_REQUEST['cod']?>" />
<input type="hidden" name="chave" value="<?php echo $_REQUEST['chave']?>" />

	<div class="area">
    
        <div class="linha">
        <div class="t_campo">NOME</div>
        <div class="campo"><label><input name="nome" type="text" id="nome" class="obrigatorio" size="75" maxlength="50" value="<?php echo $selUsu['nome']; ?>"  onkeyup="this.value=this.value.toUpperCase()" /></label></div>
        </div>
      
        <div class="linha">
        <div class="t_campo">TELEFONE</div>
        <div class="campo"><label><input name="fone" type="text" id="fone" value="<?php echo $selUsu['fone']; ?>" size="30" maxlength="30" /></label></div>
        </div>
        <div class="linha">
          <div class="t_campo">E-MAIL</div>
        <div class="campo"><label><input name="email" class="obrigatorio" type="text" id="email" value="<?php echo $selUsu['email']; ?>" size="70" maxlength="70" /></label></div>
      </div>
        
    
            
        <div class="linha">
        <div class="t_campo">USUÁRIO</div>
        <div class="campo"><label><input name="usuario" class="obrigatorio" type="text" id="usuario" value="<?php echo $selUsu['usuario']; ?>" size="32" maxlength="32" readonly="readonly" /></label></div>
        </div>
        
        <div class="linha">
        <div class="t_campo">SENHA <p style="color: #FF0000; font-size: 10px;">(Caso queira alterar)</p></div>
        <div class="campo"><label><input name="senha" type="password" class="obrigatorio"id="senha" value="" size="32" maxlength="12" /></label></div>
        
        </div>
        
        <div class="linha">
        <div class="t_campo">CONFIRMA&Ccedil;&Atilde;O </div>
        <div class="campo"><label><input name="conf" type="password" class="obrigatorio" id="conf" size="32" maxlength="12" /></label></div>
        </div>

     </div>
     
     

    
    
    
    
     <div class="area">
       <h2> OUTRAS INFORMA&Ccedil;&Otilde;ES</h2>
     	
         <div class="linha">
        <div class="t_campo">OBSERVA&Ccedil;&Otilde;ES</div>
        <div class="campo"><label><textarea name="obs" id="obs" cols="75" rows="3"><?php echo $selUsu['obs']; ?></textarea></label></div>
        </div>
      
        <div class="linha">
        <div class="t_campo">ADMINISTRADOR MASTER</div>
        <div class="campo">
        	<input type="radio" name="master" value="1" <?php if($selUsu['master']==1) echo'checked="checked"';?> /> Sim
         	&nbsp; &nbsp; 
            <input type="radio" name="master" value="0" <?php if($selUsu['master']==0) echo'checked="checked"';?> /> N&atilde;o
        </div>
        </div>
        
        <div class="linha">
        <div class="t_campo">ATIVO</div>
        <div class="campo">
        	<input type="radio" name="ativo" value="1" <?php if($selUsu['ativo']==1) echo'checked="checked"';?> /> Sim
         	&nbsp; &nbsp; 
            <input type="radio" name="ativo" value="0" <?php if($selUsu['ativo']==0) echo'checked="checked"';?> /> N&atilde;o
        </div>
        </div>
        
	</div>
     
     
     
     <button type="submit"> ATUALIZAR INFORMAÇÕES </button>
     <button type="button" onclick="javascript:history.go(-1);"> VOLTAR </button>
    
	</form>

</div>



















