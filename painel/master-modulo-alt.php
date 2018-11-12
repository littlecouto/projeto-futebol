<?php

//resgatando id passado pela URL
$idModu = $_REQUEST['idMod'];

//tratando dados
$_POST['nome_mod'] = strtoupper($_POST['nome_mod']);

if(isset($_POST['ACAO']) && $_POST['ACAO'] == 'ATUALIZAR'){
	
	// Tratando os dados
	$nome_mod 	= addslashes($nome_mod);
	$ordem	 	= addslashes($ordem);
	$ativo		= addslashes($ativo);
	$nome_mod	= strtoupper($nome_mod);
	
	$query = "UPDATE painel_modulo SET	nome='$_POST[nome_mod]', ordem='$_POST[ordem]', ativo='$_POST[ativo]' WHERE idMod='$idModu' LIMIT 1";
	$gravou = mysql_query($query)or die (mysql_error());
	
	// PAINEL HISTÓRICO
	$query = addslashes($query);
	mysql_query("INSERT INTO painel_historico(idUsu, acao, query) VALUE($_SESSION[USUARIO], 'UPDATE', '$query')") or die (mysql_error());
	//

	mysql_query("UPDATE painel_modulo_item SET principal='0' WHERE idMod='$idModu' LIMIT 1");
	
	$sqlIte 	= "UPDATE painel_modulo_item SET principal='1' WHERE idIte='$_POST[item]' LIMIT 1";
	$gravouIte 	= mysql_query($sqlIte)or die (mysql_error());
	
	// PAINEL HISTÓRICO
	$query = addslashes($query);
	mysql_query("INSERT INTO painel_historico(idUsu, acao, query) VALUE($_SESSION[USUARIO], 'UPDATE', '$query')") or die (mysql_error());
	//
	
	
	
	if($gravou == true){
		echo "<script> alert('Informações atualizadas com sucesso!'); location.href='master-modulo-ger'; </script>";
	}elseif($gravou == false){
		echo "<script> alert('Houve um erro ao atualizar as informações!'); hitory.go(-1); </script>"; 
	}
}




// selecionando a tabela pAra resgatar os dados do módulo a ser alterado
$resultModu = mysql_fetch_array(mysql_query("SELECT * FROM painel_modulo WHERE idMod='$idModu'"));

?>

<div class="formulario">


<!-- Cadastro de módulos -->
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']?>">
    <input type="hidden" name="ACAO" value="ATUALIZAR" />
    <input type="hidden" name="idMod" value="<?php echo $idModu; ?>" />
    
    <div class="area">
    
        <h2>INFORMA&Ccedil;&Otilde;ES DO M&Oacute;DULO</h2>
       
        <div class="linha">
            <div class="t_campo">M&Oacute;dulo</div>
            <div class="campo"><label><input type="text" id="nome_mod" name="nome_mod" size="50" maxlength="50" value="<?php echo $resultModu['nome'] ?>" onkeyup="this.value=this.value.toUpperCase()"  /></label></div>
        </div>
        
        <div class="linha">
            <div class="t_campo">ORDEM</div>
            <div class="campo"><label><input type="text" id="ordem" name="ordem" size="5" maxlength="2" value="<?php echo $resultModu['ordem'] ?>" onkeyup="this.value=this.value.toUpperCase()"  /></label></div>
        </div>

        <div class="linha">
            <div class="t_campo">LINK</div>
            <div class="campo"><label>
            	<select name="item">
                	<?php
                    $resMen = mysql_query("SELECT idIte, nome, principal FROM painel_modulo_item WHERE idMod='$_GET[idMod]' ORDER BY nome");
					while($rowMen = mysql_fetch_array($resMen)){
						echo "<option value=\"$rowMen[idIte]\" ".($rowMen['principal'] ? 'selected': '').">$rowMen[nome]</option>";
					}
					
					?>
                </select>
                </label></div>
        </div>
                                        
        <div class="linha">
            <div class="t_campo">ATIVO</div>
            <div class="campo">
                <input type="radio" name="ativo" id="ativo" value="1" <?php if($resultModu['ativo']==1) echo'checked="checked"';?> /> Sim
                <br />
                <input type="radio" name="ativo" id="ativo" value="0" <?php if($resultModu['ativo']==0) echo'checked="checked"';?> /> N&atilde;o
            </div>
        </div>
    </div>
    
    
    <button type="submit">ATUALIZAR INFORMAÇÕES</button>
    <button type="button" onclick="javascript:history.go(-1);"> VOLTAR </button>
	
    
</form>
<!-- Fim cadastro de módulos --> 
    
</div>
