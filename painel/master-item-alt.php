

<?php




if(isset($_POST['ACAO']) && $_POST['ACAO'] == 'ATUALIZAR'){
	

	if($_POST['sel_mod'] == ''){
		echo "<script>alert('Selecione um MÓDULO!'); history.go(-1);;</script>";
		exit;
	}elseif(empty($_POST['item'])){
		echo "<script>alert('Preencha o campo ITEM!'); history.go(-1);;</script>";
		exit;
	}elseif(empty($_POST['url'])){
		echo "<script>alert('Preencha o campo URL!'); history.go(-1);;</script>";
		exit;
	}else{
	
		// Tratando os dados
		
		// Tratando os dados
		$modulo 	= addslashes($_POST['sel_mod']);
		$item_pri 	= addslashes($_POST['sel_ite']);
		$item 		= addslashes($_POST['item']);
		$url 		= addslashes($_POST['url']);
		$ordem		= addslashes($_POST['ordem']);
		$ativo		= addslashes($_POST['ativo']);
		$pagina 	= addslashes($_POST['pagina']);
		$tipo	 	= addslashes($_POST['tipo']);
		$item		= strtoupper($item);
		
		$query = "UPDATE painel_modulo_item SET idMod='$modulo', idPri='$item_pri', nome='$item', url='$url', ordem='$ordem', ativo='$ativo', pagina='$pagina', tipo='$tipo' WHERE idIte='$_POST[idItem]' LIMIT 1";
		$gravou = mysql_query($query) or die (mysql_error());
		
		// PAINEL HISTÓRICO
		$query = addslashes($query);
		mysql_query("INSERT INTO painel_historico(idUsu, acao, query) VALUE($_SESSION[USUARIO], 'UPDATE', '$query')") or die (mysql_error());
		//
		
		if($gravou == true){
			echo "<script>alert('Atualização efetuada com sucesso!'); location.href='master-modulo-ger';</script>";
		}elseif($gravou == false){
			echo "<script>alert('Houve um erro ao atualizar!'); history.go(padrao);</script>";
		}
	}
}

?>
<link rel="stylesheet" href="include/js/chosen/chosen.min.css">
<link rel="stylesheet" type="text/css" href="lib/checkbox/checkbox.css">
<div class="formulario">

	<!-- Cadastro de Item -->
    <form method="post" action="<?=$_SERVER['REQUEST_URI']?>">
    <input type="hidden" name="ACAO" value="ATUALIZAR" />
    <input type="hidden" name="idItem" value="<?=$_GET['idItem'] ?>" />
    
    <div class="area">
      <?php
         //pegando os dados do item a ser alterado
         $rowItem = mysql_fetch_array(mysql_query("SELECT * FROM painel_modulo_item WHERE idIte='$_GET[idItem]'")) or die (mysql_error());
         
        //pegando o módulo que o item está cadastrado
        $rowModulo = mysql_fetch_array(mysql_query("SELECT * FROM painel_modulo WHERE idMod='$rowItem[idMod]'")) or die (mysql_error());
        ?>
        
          <div class="linha">
              <div class="t_campo">M&Oacute;DULO</div>
                        <div class="campo">
                            <label><select data-placeholder="Escolha um m&oacute;dulo" class="obrigatorio" name="sel_mod" size="1" id="sel_mod">
                                <option value=""></option>
                                <?php
                                    $resMod = mysql_query("SELECT * FROM painel_modulo ORDER BY nome");
                                    
                                    while($rowMod = mysql_fetch_array($resMod)){
                                     echo " <option value=\"$rowMod[idMod]\" ".($rowItem['idMod'] == $rowMod['idMod']? 'selected': '').">$rowMod[nome]</option>";
                                    }
                                ?>
                          </select></label>
                      </div>
                </div>
                
          <div class="linha">
              <div class="t_campo">ITEM PRINCIPAL</div>
                        <div class="campo">
                            <label><select data-placeholder="Escolha um item" name="sel_ite" size="1" id="sel_ite">
                                <option value=""></option>
                                <?php
                                    $resIte = mysql_query("SELECT * FROM painel_modulo_item WHERE ativo=1 AND idIte!='$rowItem[idIte]' AND idPri!='$rowItem[idIte]' AND tipo=1 ORDER BY nome");
                                    
                                    while($rowIte  = mysql_fetch_array($resIte)){
                                     echo " <option value=\"$rowIte[idIte]\" data-id=\"$rowIte[idMod]\" ".($rowIte['idMod'] != $rowItem['idMod']? 'disabled': '')." ".($rowItem['idPri'] == $rowIte['idIte']? 'selected': '').">$rowIte[nome]</option>";
                                    }
                                ?>
                          </select></label>
                      </div>
                </div>
                
        
        <div class="linha">
            <div class="t_campo">Item</div>
            <div class="campo"><label><input type="text" id="item" name="item" size="38" maxlength="50" value="<?=$rowItem['nome']; ?>" onkeyup="this.value=this.value.toUpperCase()"  /></label></div>
        </div>
        
        <div class="linha">
            <div class="t_campo">URL</div>
            <div class="campo"><label><input type="text" id="url" name="url" size="38" maxlength="300" value="<?=$rowItem['url']; ?>" /></label></div>
        </div>
        
        <div class="linha">
            <div class="t_campo">ORDEM</div>
            <div class="campo"><label><input type="text" id="ordem" name="ordem" size="5" maxlength="2" value="<?=$rowItem['ordem']; ?>" /></label></div>
        </div>
        
        <div class="linha">
            <div class="t_campo">Ativo</div>
            <div class="campo">
                <label><input type="radio" name="ativo" id="ativo" value="1" <?php if($rowItem['ativo']==1) echo'checked=checked'?> /> Sim</label>
                &nbsp; &nbsp; 
                <label><input type="radio" name="ativo" id="ativo" value="0" <?php if($rowItem['ativo']==0) echo'checked=checked'?> /> N&atilde;o</label>
            </div>
        </div>
        
        <div class="linha">
            <div class="t_campo">Abertura da P&Aacute;gINA</div>
            <div class="campo">
              <label><input type="radio" name="pagina" id="pagina" value="1"  <?php if($rowItem['pagina']==1) echo'checked=checked'?> /> Mesma P&aacute;gina</label>
              &nbsp; &nbsp; 
              <label><input type="radio" name="pagina" id="pagina" value="0"  <?php if($rowItem['pagina']==0) echo'checked=checked'?> /> Nova P&aacute;gina</label>
            </div>
        </div>
        
        
        <div class="linha">
            <div class="t_campo">Tipo da P&Aacute;gINA</div>
            <div class="campo">
              <label><input type="radio" name="tipo" id="tipo" value="1"  <?= $rowItem['tipo']==1? 'checked': '';?> /> Menu</label>
              &nbsp; &nbsp; 
              <label><input type="radio" name="tipo" id="tipo" value="2" <?= $rowItem['tipo']==2? 'checked': '';?> /> Sub P&aacute;gina</label>
            </div>
        </div>
        
        
        
        
    </div>
    
    <button type="submit">Alterar Item</button>
    <button type="button" onclick="javascript:history.go(-1);"> VOLTAR </button>
    
</form>
<!-- Fim cadastro de Item -->



</div>
<script src="include/js/chosen/chosen.jquery.js"></script>
<script src="lib/checkbox/checkbox.js"></script>
<script>
	$("select").chosen({no_results_text: "Não encontramos", search_contains: true, width: "510px"});
	$('select#sel_mod').change(function(e) {
		var $this 	= $(this),
			id 	= $this.val(),
			option 	= $('select#sel_ite option'),
			opt;
		
		
		option.each(function() {
			opt = $(this);
			if(opt.attr('data-id') == id){
				opt.prop('disabled', false);
			}else{
				opt.prop('disabled', true);
			}
        });
		$('select#sel_ite').val('').trigger("chosen:updated");
		
		
    });
    $('input[type=checkbox], input[type=radio]').customRadioCheck();
</script>


