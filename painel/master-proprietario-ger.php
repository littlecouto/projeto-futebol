


<?php 



if(isset($_POST['ACAO']) && $_POST['ACAO'] == 'ATUALIZAR'){
	
	//validando campos
	if(empty($_POST['nome'])){
		echo "<script>alert('Preencha o campo NOME!'); history.go(padrao);</script>";
	}elseif(empty($_POST['email'])){
		echo "<script>alert('Preencha o campo EMAIL!'); history.go(padrao);</script>";
	}elseif(empty($_POST['cep'])){
		echo "<script>alert('Preencha o campo CEP!'); history.go(padrao);</script>";
	}elseif(empty($_POST['fone'])){
		echo "<script>alert('Preencha o campo FONE!'); history.go(padrao);</script>";
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
		$fone 			= addslashes($_POST['fone']);
		$email 			= addslashes($_POST['email']);
		$site 			= addslashes($_POST['site']);
		$nome  			= strtoupper($nome);
		$email 			= strtolower($email);
		$site 			= strtolower($site);
		
		$query = "UPDATE painel_empresa SET idUsu='$_SESSION[USUARIO]', nome='$nome', cep='$cep', logradouro='$logradouro', num='$num', complemento='$complemento', bairro='$bairro', cidade='$cidade', uf='$uf', fone='$fone', email='$email', site='$site' WHERE idEmp='1' LIMIT 1";
		$gravou = mysql_query($query) or die (mysql_error());
		
		// PAINEL HISTÓRICO
		$query = addslashes($query);
		mysql_query("INSERT INTO painel_historico(idUsu, acao, query) VALUE($_SESSION[USUARIO], 'UPDATE', '$query')") or die (mysql_error());
		//
				
		if($gravou == false) $aviso = 'Erro ao gravar os dados!'; else $aviso = 'Dados atualizados com sucesso!';
		
					
		echo "<script> alert('$aviso'); location.href='$SISTEMA[URL]'; </script>";
			
	}
}
	
?>
<div class="formulario">

<?php 
	//pegando dados do cliente
	$rowEmp = mysql_fetch_array(mysql_query("SELECT * FROM painel_empresa WHERE idEmp='1'")) or die (mysql_error());
?>

<form method="post" action="<?php $_SERVER['REQUEST_URI'] ?>">
<input type="hidden" name="ACAO" value="ATUALIZAR" />

	<div class="area">
        <h2>INFORMA&Ccedil;&Otilde;ES GERAIS</h2>
        <div class="linha">
        <div class="t_campo">NOME</div>
        <div class="campo"><label><input name="nome" type="text" id="nome" value="<?php echo $rowEmp['nome']; ?>" size="75" maxlength="50" /></label></div>
        </div>
        
        <div class="linha">
        <div class="t_campo">E-MAIL</div>
        <div class="campo"><label><input name="email" type="text" id="email" value="<?php echo $rowEmp['email']; ?>" size="75" maxlength="70" /></label></div>
        </div>
      
        <div class="linha">
        <div class="t_campo">TELEFONE</div>
        <div class="campo"><label><input name="fone" type="text" id="fone" value="<?php echo $rowEmp['fone']; ?>" size="20" maxlength="14" /></label></div>
        </div>
        
        <div class="linha">
        <div class="t_campo">CEP</div>
        <div class="campo"><label><input name="cep" type="text" id="cep" value="<?php echo $rowEmp['cep']; ?>" size="15" maxlength="9" /></label></div>
        </div>
        
        <div class="linha">
        <div class="t_campo">LOGRADOURO</div>
        <div class="campo"><label><input name="logradouro" type="text" id="logra" value="<?php echo $rowEmp['logradouro']; ?>" size="75" maxlength="100" /></label></div>
        </div>
       
        <div class="linha">
        <div class="t_campo">NÚMERO</div>
        <div class="campo"><label><input name="num" type="text" id="num" value="<?php echo $rowEmp['num']; ?>" size="10" maxlength="6" /></label></div>
        </div>
        
        <div class="linha">
        <div class="t_campo">COMPLEMENTO</div>
        <div class="campo"><label><input name="complemento" type="text" id="complemento" value="<?php echo $rowEmp['complemento']; ?>" size="30" maxlength="30" /></label></div>
        </div>
       
    
       
        <div class="linha">
        <div class="t_campo">BAIRRO</div>
        <div class="campo"><label><input name="bairro" type="text" id="bairro" value="<?php echo $rowEmp['bairro']; ?>" size="50" maxlength="50" /></label></div>
        </div>
        
        
        <div class="linha">
        
        <div class="t_campo">CIDADE</div>
        <div class="campo"><label><input name="cidade" type="text" id="cidade" value="<?php echo $rowEmp['cidade']; ?>" size="50" maxlength="50" /></label></div>
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
    
       
        <div class="linha">
        <div class="t_campo">Site</div>
        <div class="campo"><label><input name="site" type="text" value="<?php echo $rowEmp['site']; ?>" size="75" maxlength="70" /></label></div>
        </div>
        
        
        
    
    </div>
                 
    <button type="submit">Atualizar Dados</button>      
   
    
	</form>

</div>
















