<?php
if(isset($_POST['ACAO']) and $_POST['ACAO'] == 'ADICIONAR'){
	
	if($_POST['nome'] == ""){
		$aviso = "Informe o nome";
		echo "<script> alert('$aviso'); window.history.go(-1); </script>";
	
	}elseif($_POST['email'] == ""){
		$aviso = "Informe o e-mail";
		echo "<script> alert('$aviso'); window.history.go(-1); </script>";
		
	}elseif($_POST['usuario'] == ""){
		$aviso = "Informe o nome de usuário";
		echo "<script> alert('$aviso'); window.history.go(-1); </script>";
	
	}elseif($_POST['senha'] == ""){
		$aviso = "Informe A senha";
		echo "<script> alert('$aviso'); window.history.go(-1); </script>";
	
	}elseif($_POST['conf'] == ""){
		$aviso = "Confirmação da senha é obrigatória";
		echo "<script> alert('$aviso'); window.history.go(-1); </script>";
	
	}elseif($_POST['senha'] != $_POST['conf']){
		$aviso = "A senha informada não é igual a confirmação!";
		echo "<script> alert('$aviso'); window.history.go(-1); </script>";
	
	}elseif($_POST['master'] == 0 and $_POST['permissao_cliente'] == 0 and $_POST['permissao_hospedagem'] == 0 and $_POST['permissao_fornecedor'] == 0 and $_POST['permissao_financeiro'] == 0){
		$aviso = 'Defina ao menos uma permissão ao usuário';
		echo "<script> alert('$aviso'); window.history.go(-1); </script>";
	
	
	// Validações para aprovador
	}elseif($_POST['timesheet'] and $_POST['aprovador1'] == ''){
		$aviso = 'Informe os aprovadores de Timesheet';
		echo "<script> alert('$aviso'); window.history.go(-1); </script>";
	
	}elseif($_POST['timesheet'] and $_POST['aprovador2'] == ''){
		$aviso = 'Informe os aprovadores de Timesheet';
		echo "<script> alert('$aviso'); window.history.go(-1); </script>";
		
	}elseif($_POST['timesheet'] and ($_POST['aprovador1'] == $_POST['aprovador2'])){
		$aviso = 'Em Timesheet, informe aprovadores diferentes';
		echo "<script> alert('$aviso'); window.history.go(-1); </script>";
		
		
	}else{
		// Tratando os dados
		$nome 					= addslashes($_POST['nome']);
		$fone 					= addslashes($_POST['fone']);
		$email 					= addslashes($_POST['email']);
		$usuario				= addslashes($_POST['usuario']);
		$senha 					= addslashes($_POST['senha']);
		$obs 					= addslashes($_POST['obs']);
		$master					= addslashes($_POST['master']);
		$permissao_cliente		= addslashes($_POST['permissao_cliente']);
		$permissao_hospedagem	= addslashes($_POST['permissao_hospedagem']);
		$permissao_fornecedor	= addslashes($_POST['permissao_fornecedor']);
		$permissao_financeiro	= addslashes($_POST['permissao_financeiro']);
		$permissao_campanha		= addslashes($_POST['permissao_campanha']);
		$ativo 					= addslashes($_POST['ativo']);
		
		$email = strtolower($email);
		$senha = md5($senha);
		
		// Gravando os dados
		$query = "INSERT INTO painel_usuario(nome, fone, email, usuario, senha, obs, master, permissao_cliente, permissao_hospedagem, permissao_fornecedor, permissao_financeiro, permissao_campanha, ativo)VALUES('$nome', '$fone', '$email', '$usuario', '$senha', '$obs', '$master', '$permissao_cliente', '$permissao_hospedagem', '$permissao_fornecedor', '$permissao_financeiro', '$permissao_campanha', $ativo)";
		$gravou = mysql_query($query) or die(mysql_error());
		
		
		// PAINEL HISTÓRICO
		$query = addslashes($query);
		mysql_query("INSERT INTO painel_historico(idUsu, acao, query) VALUE($_SESSION[USUARIO], 'INSERT', '$query')") or die (mysql_error());
		//
		
		// Verificando a gravação
		if($gravou==false){
			$aviso = 'HOUVE UM ERRO AO REALIZAR O CADASTRO';
			echo "<script> alert('$aviso'); window.history.go(-1); </script>";
			
		}else{
			
			// ADICIONANDO PERMISSÕES DE ACESSO
			$rowUsu = mysql_fetch_array(mysql_query("SELECT idUsu FROM painel_usuario ORDER BY idUsu DESC LIMIT 1")); // Resgatando código do usuário
			$COD_USU = $rowUsu['idUsu'];
			include_once 'permissoes.php';
			//
				
			
			$aviso = 'CADASTRO REALIZADO COM SUCESSO';
			echo "<script> alert('$aviso'); location.href='ger_usuarios.php'; </script>";
		}
		
					
		
	}
}
?>



<div class="formulario">



<form method="post" action="<?php echo $_SERVER['REQUEST_URI'] ?>">
<input type="hidden" name="ACAO" value="ADICIONAR" />
	<div class="area">
        <h2>INFORMA&Ccedil;&Otilde;ES DO USU&Aacute;RIO</h2>

        <div class="linha">
        <div class="t_campo">NOME<span class="obrigatorio"> (obrigat&oacute;rio)</span></div>
        <div class="campo"><label><input name="nome" type="text" id="nome" size="75" maxlength="50" onkeyup="this.value=this.value.toUpperCase()" /></label></div>
        </div>

        <div class="linha">
        <div class="t_campo">TELEFONE</div>
        <div class="campo"><label><input name="fone" type="text" id="fone" size="30" maxlength="30" /></label></div>
        </div>
        
        <div class="linha">
        <div class="t_campo">E-MAIL<span class="obrigatorio"> (obrigat&oacute;rio)</span></div>
        <div class="campo"><label><input name="email" type="text" id="email" size="75" maxlength="70" /></label></div>
        </div>
	
    </div>


	<div class="area">
    
    	<h2>DADOS DE ACESSO</h2>
        
        <div class="linha">
        <div class="t_campo">USUÁRIO<span class="obrigatorio"> (obrigat&oacute;rio)</span></div>
        <div class="campo"><label><input name="usuario" type="text" id="usuario" size="32" maxlength="32" /></label></div>
        </div>
        
        <div class="linha">
        <div class="t_campo">SENHA<span class="obrigatorio"> (obrigat&oacute;rio)</span></div>
        <div class="campo"><label><input name="senha" type="password" id="senha" size="32" maxlength="12" /></label></div>
        </div>
        
        <div class="linha">
        <div class="t_campo">CONFIRMA&Ccedil;&Atilde;O<span class="obrigatorio"> (obrigat&oacute;rio)</span></div>
        <div class="campo"><label><input name="conf" type="password" id="conf" size="32" maxlength="12" /></label></div>
        </div>

    </div>
    
    
    <!--<div class="area">
    
    	<h2>PERMISS&Otilde;ES</h2>
    	<div id="verArea"></div>
        


        <div class="linha">
        <div class="t_campo"> CLIENTES </div>
        <div class="campo">
        	<input name="permissao_cliente" type="radio" value="2" /> Adicionar/Atualizar
            &nbsp; &nbsp; 
            <input name="permissao_cliente" type="radio" value="1" /> Visualizar
            &nbsp; &nbsp; 
            <input name="permissao_cliente" type="radio" value="0" checked="checked" /> 
            Nenhuma Permiss&atilde;o
        </div>
        </div>
        
        
        <div class="linha">
        <div class="t_campo"> FORNECEDORES </div>
        <div class="campo">
        	<input name="permissao_fornecedor" type="radio" value="2" /> Adicionar/Atualizar
            &nbsp; &nbsp; 
            <input name="permissao_fornecedor" type="radio" value="1" /> Visualizar
            &nbsp; &nbsp; 
            <input name="permissao_fornecedor" type="radio" value="0" checked="checked" /> 
            Nenhuma Permiss&atilde;o
        </div>
        </div>
        
        
        <div class="linha">
        <div class="t_campo"> HOSPEDAGEM </div>
        <div class="campo">
        	<input name="permissao_hospedagem" type="radio" value="2" /> Adicionar/Atualizar
            &nbsp; &nbsp; 
            <input name="permissao_hospedagem" type="radio" value="1" /> Visualizar
            &nbsp; &nbsp; 
            <input name="permissao_hospedagem" type="radio" value="0" checked="checked" /> 
            Nenhuma Permiss&atilde;o
        </div>
        </div>
        
        
        
        <div class="linha">
        <div class="t_campo"> FINANCEIRO </div>
        <div class="campo">
        	<input name="permissao_financeiro" type="radio" value="2" /> Adicionar/Atualizar
            &nbsp; &nbsp; 
            <input name="permissao_financeiro" type="radio" value="1" /> Visualizar
            &nbsp; &nbsp; 
            <input name="permissao_financeiro" type="radio" value="0" checked="checked" /> 
            Nenhuma Permiss&atilde;o
        </div>
        </div>
        
        
        <div class="linha">
        <div class="t_campo"> RELATÓRIO </div>
        <div class="campo">
        	<input name="permissao_campanha" type="radio" value="2" /> Adicionar/Atualizar
            &nbsp; &nbsp; 
            <input name="permissao_campanha" type="radio" value="1" /> Visualizar
            &nbsp; &nbsp; 
            <input name="permissao_campanha" type="radio" value="0" checked="checked" /> 
            Nenhuma Permiss&atilde;o
        </div>
        </div>
        
        
        
        
    </div>-->
    
    
    
    
    <div class="area">
      
      <h2>OUTRAS INFORMA&Ccedil;&Otilde;ES </h2>
    
    	<div class="linha">
        <div class="t_campo">OBSERVA&Ccedil;&Otilde;ES</div>
        <div class="campo"><label><textarea name="obs" id="obs" cols="75" rows="3"></textarea></label></div>
        </div>
        
        
        <div class="linha">
        <div class="t_campo">ADMINISTRADOR MASTER</div>
        <div class="campo"> 
        	<input type="radio" name="master" value="1"  /> Sim
            &nbsp; &nbsp; 
            <input type="radio" name="master" value="0" checked="checked" /> N&atilde;o
        </div>
        </div>
        
        <div class="linha">
        <div class="t_campo">ATIVO</div>
        <div class="campo"> 
        	<input type="radio" name="ativo" value="1" checked="checked" /> Sim
            &nbsp; &nbsp; 
            <input type="radio" name="ativo" value="0" /> N&atilde;o
        </div>
        </div>
    
  </div>
    
    
    <button type="submit">Cadastrar</button>
        
	</form>




	</div>








