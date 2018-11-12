<?php


// CADASTRO DE MÓDULOS
if(isset($_POST['ACAO']) and $_POST['ACAO'] == 'AD_MODULO'){
	
	//validando campos
	if(empty($_POST['nome_mod'])){
		echo "<script> alert('Informe o nome do módulo'); history.go(-1); </script>";
	}else{
		
		//tratando dados
		$nome_mod	= addslashes(strtoupper($_POST['nome_mod']));
		$ordem_mod	= addslashes($_POST['ordem_mod']);
		$ativo 		= addslashes($_POST['ativo']);
		
		$nome_mod	= mb_convert_case($nome_mod, MB_CASE_UPPER, 'ISO-8859-1');
	
		
		// VERIFICANDO SE JÁ EXISTE ALGUM MÓDULO COM ESTE NOME
		$existeMod = mysql_query("SELECT idMod FROM painel_modulo WHERE nome='$nome'");
		if(mysql_num_rows($existeMod) > 0){
			echo "<script> alert('Já existe um módulo com este nome'); location.href='$_SERVER[REQUEST_URI]'; </script>";
		}
		else{
		
			// Tratando os dados
			$query = "INSERT INTO painel_modulo(nome, ordem, ativo) VALUES('$nome_mod', '$ordem_mod', '$ativo')";
			$gravou = mysql_query($query);
			
			// PAINEL HISTÓRICO
			$query = addslashes($query);
			mysql_query("INSERT INTO painel_historico(idUsu, acao, query) VALUE($_SESSION[USUARIO], 'INSERT', '$query')") or die (mysql_error());
			//
		
			if($gravou == true){
				echo "<script> alert('Módulo cadastrado com sucesso!'); location.href='master-modulo-ger'; </script>";
			}elseif($gravou == false){
				echo "<script> alert('Houve um erro ao cadastrar.'); history.go(-1); </script>";
			}	
		}// FIM VERIFICAÇÃO
	}
}




//CADASTRO DE ITENS
elseif(isset($_POST['ACAO']) && $_POST['ACAO'] == 'AD_ITEM'){
	
	//validando campos
	if($_POST['sel_mod'] == ''){
		echo "<script>alert('Selecione um MÓDULO!'); history.go(padrao);;</script>";
		exit;
	}elseif(empty($_POST['item'])){
		echo "<script>alert('Preencha o campo ITEM!'); history.go(padrao);;</script>";
		exit;
	}elseif(empty($_POST['url'])){
		echo "<script>alert('Preencha o campo URL!'); history.go(padrao);;</script>";
		exit;
	}else{
		
		// Tratando os dados
		$sel_mod 	= addslashes($_POST['sel_mod']);
		$sel_ite 	= addslashes($_POST['sel_ite']);
		$item 		= addslashes($_POST['item']);
		$url 		= addslashes($_POST['url']);
		$ativo		= addslashes($_POST['ativo']);
		$item_ordem = addslashes($_POST['item_ordem']);
		$pagina 	= addslashes($_POST['pagina']);
		$tipo	 	= addslashes($_POST['tipo']);
		$item		= strtoupper($item);
		
		$query = "INSERT INTO painel_modulo_item(idMod, idPri, nome, url, ordem, ativo, pagina, tipo) VALUES('$sel_mod', '$sel_ite', '$item', '$url', '$item_ordem', '$ativo', '$pagina', '$tipo')";
		$gravou = mysql_query($query) or die (mysql_error());	
		
		// PAINEL HISTÓRICO
		$query = addslashes($query);
		mysql_query("INSERT INTO painel_historico(idUsu, acao, query) VALUE($_SESSION[USUARIO], 'INSERT', '$query')") or die (mysql_error());
		//
		
		if($gravou == true){
			echo "<script>alert('Item cadastrado com sucesso!'); location.href='master-modulo-ger'; </script>";
		}elseif($gravou == false){
			echo "<script>alert('Houve um erro ao cadastrar!'); history.go(padrao);;</script>";
		}
	}
}
?>
<script type="text/javascript">

// DEL ´MÓDULO
function DelMod(id){
	decisao = confirm("Deseja mesmo excluir este registro?");
	
	if(decisao){
		location.href='master-modulo-del?id='+id;
	}
}


// DEL ITEM
function DelItem(id){
	decisao = confirm("Deseja mesmo excluir este registro?");
	
	if(decisao){
		location.href='master-item-del?id='+id;
	}
}


</script>
<link rel="stylesheet" href="include/js/chosen/chosen.min.css">
<link rel="stylesheet" type="text/css" href="lib/checkbox/checkbox.css">
<div class="formulario">

    <!-- Cadastro de módulos -->
    <form method="post" action="<?php echo $_SERVER['REQUEST_URI'] ?>">
    <input type="hidden" name="ACAO" value="AD_MODULO" />
        <div class="area">
          <div class="linha">
              <div class="t_campo">M&Oacute;DULO</div>
                <div class="campo"><label><input class="obrigatorio" type="text" id="nome_mod" name="nome_mod" onblur="this.value=this.value.toUpperCase()" size="50" maxlength="50" /></label></div>
            </div>
            

            <div class="linha">
                <div class="t_campo">ORDEM</div>
                <div class="campo"><label><input class="obrigatorio" type="text" id="ordem_mod" name="ordem_mod" size="38" maxlength="4" /></label></div>
            </div>
            
            <div class="linha">
                <div class="t_campo">ATIVO</div>
                <div class="campo">
                    <label><input type="radio" name="ativo" id="ativo" value="1" checked="checked" /> Sim</label>
                    &nbsp; &nbsp;  
                    <label><input type="radio" name="ativo" id="ativo" value="0" /> N&atilde;o</label>
                </div>
            </div>
            
        
        </div>
        
        <button type="submit">Cadastrar M&oacute;dulo</button> 

    </form>
	<!-- Fim cadastro de módulos -->                
	


	<!-- Cadastro de Item -->
    <form method="post" action="<?php echo $_SERVER['REQUEST_URI'] ?>">
    <input type="hidden" name="ACAO" value="AD_ITEM" />
        <div class="area">
          <div class="linha">
              <div class="t_campo">M&Oacute;DULO</div>
                        <div class="campo">
                            <label><select data-placeholder="Escolha um m&oacute;dulo" class="obrigatorio" name="sel_mod" size="1" id="sel_mod">
                                <option value=""></option>
                                <?php
                                    $rowModulo = mysql_query("SELECT * FROM painel_modulo ORDER BY nome ASC");
                                    
                                    while($resultModulo = mysql_fetch_array($rowModulo)){
                                     echo " <option value=\"$resultModulo[idMod]\">$resultModulo[nome]</option>";
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
                                    $resultModulo= mysql_query("SELECT * FROM painel_modulo_item WHERE ativo=1 AND tipo=1 ORDER BY nome ASC");
                                    
                                    while($rowModulo  = mysql_fetch_array($resultModulo)){
                                     echo " <option value=\"$rowModulo[idIte]\" data-id=\"$rowModulo[idMod]\">$rowModulo[nome]</option>";
                                    }
                                ?>
                          </select></label>
                      </div>
                </div>
                
                <div class="linha">
                    <div class="t_campo">ITEM</div>
                    <div class="campo"><label><input class="obrigatorio" type="text" id="item" name="item" size="50" onkeyup="this.value=this.value.toUpperCase()" maxlength="50" /></label></div>
                </div>
                
                <div class="linha">
                    <div class="t_campo">URL</div>
                    <div class="campo"><label><input class="obrigatorio" type="text" id="url" name="url" size="38" maxlength="300" /></label></div>
                </div>

                <div class="linha">
                    <div class="t_campo">ORDEM</div>
                    <div class="campo"><label><input class="obrigatorio" type="text" id="item_ordem" name="item_ordem" size="38" maxlength="2" /></label></div>
                </div>
                
                <div class="linha">
                    <div class="t_campo">ATIVO</div>
                    <div class="campo">
                        <label><input type="radio" name="ativo" id="ativo" value="1" checked="checked" /> SIM</label>
                        &nbsp; &nbsp; 
                       <label><input type="radio" name="ativo" id="ativo" value="0" /> N&Atilde;O</label>
                    </div>
                </div>
                
                <div class="linha">
                    <div class="t_campo">ABERTURA DA P&Aacute;GINA</div>
                    <div class="campo">
                      <label><input type="radio" name="pagina" id="pagina" value="1" checked="checked" /> MESMA P&Aacute;GINA</label>
                      &nbsp; &nbsp; 
                      <label><input type="radio" name="pagina" id="pagina" value="0" /> NOVA P&Aacute;GINA</label>
                    </div>
                </div>
                
                <div class="linha">
                    <div class="t_campo">TIPO DA P&Aacute;GINA</div>
                    <div class="campo">
                      <label><input type="radio" name="tipo" id="tipo" value="1" checked="checked" /> MENU</label>
                      &nbsp; &nbsp; 
                      <label><input type="radio" name="tipo" id="tipo" value="2" /> SUB P&Aacute;GINA</label>
                    </div>
                </div>
                
            </div>
            
            
            <button type="submit">Cadastrar Item</button> 
            
        </form>
		<!-- Fim cadastro de Item -->
        
        
    <div class="area" style="margin-top:75px">       

        <!-- Listagem de módulos e itens cadastrados -->
        <table width="100%" border="0" cellpadding="3" cellspacing="0">
        <tr class="t_campo">
        <th width="30%" class="t_campo">M&Oacute;DULO</th>
        <th width="30%" class="t_campo">&nbsp;</th>
        <th width="30%" class="t_campo">&nbsp;</th>
        <th width="5%" class="t_campo">&nbsp;</th>
        <th width="5%" class="t_campo">&nbsp;</th>
        </tr>
            
            
            
		<?php 
        //listando os módulos
        $rowModu = mysql_query("SELECT * FROM painel_modulo ORDER BY ordem ") or die (mysql_error());
        
        while($resultModu = mysql_fetch_array($rowModu)){
            
			
			$sqlNumIte 		= "SELECT * FROM painel_modulo_item WHERE idMod='$resultModu[idMod]'";
			$rowNumIte 		= mysql_fetch_array(mysql_query($sqlNumIte." AND idPri=0"));
			$numIte 		= mysql_num_rows(mysql_query($sqlNumIte));
			
			$rowSpanIte 	= $numIte+1;
			
            echo "	<tr class=\"modulo\">
                    <td rowspan=\"$rowSpanIte\" align=\"center\" valign=\"middle\">
						<span class=\"nome\">$resultModu[nome]</span>
						<span class=\"imagens\"><a href=\"master-modulo-alt?idMod=$resultModu[idMod]\" target='_self'><img src='include/img/bt/Wrench.png' height='20' title='Alterar' alt='Alterar' border='0' /></a><a href=\"javascript:void(0)\" target='_self'><img src='include/img/bt/Xion.png' height='20' title='Excluir' alt='Excluir' border='0'  onclick=\"DelMod($resultModu[idMod]);\" /></a></span>
						</td>							
                    </tr>";
                
                //listando itens do módulo
                $resultItem = mysql_query("SELECT * FROM painel_modulo_item WHERE idMod='$resultModu[idMod]' AND idPri=0 ORDER BY ordem") or die (mysql_error());
                while($rowItem = mysql_fetch_array($resultItem)){
					$sqlNumSub 		= "SELECT * FROM painel_modulo_item A INNER JOIN painel_modulo_item B ON A.idPri=B.idIte WHERE B.idIte='$rowItem[idIte]'";
					$numSub 		= mysql_num_rows(mysql_query($sqlNumSub));
					$rowSpanSub 	= $numSub+1;
                    echo "	<tr class=\"principal\">
                            <td rowspan=\"$rowSpanSub\" align=\"center\" valign=\"middle\">
								<span class=\"nome\">$rowItem[nome]</span> 
							
								<span class=\"imagens\"><a href=\"master-item-alt?idItem=$rowItem[idIte]\" target='_self'><img src='include/img/bt/Wrench.png' height='20' border='0' alt='Alterar' title='Alterar'   border='0'/></a><a href=\"javascript:void(0)\" target='_self'><img src='include/img/bt/Xion.png' height='20' border='0' alt='Excluir' title='Excluir' border='0' onclick=\"DelItem($rowItem[idIte]);\" /></a></span>
							</td>
		                    
							
                            </tr>";
							
						//listando itens do módulo
						$resSub = mysql_query("SELECT A.idIte, A.nome FROM painel_modulo_item A INNER JOIN painel_modulo_item B ON A.idPri=B.idIte WHERE A.idPri='$rowItem[idIte]' AND A.principal=0 ORDER BY A.ordem ") or die (mysql_error());
						while($rowIte = mysql_fetch_array($resSub)){
							echo "	<tr class=\"item\">
									<td> $rowIte[nome] </td>
									<td><a href=\"master-item-alt?idItem=$rowIte[idIte]\" target='_self'><img src='include/img/bt/Wrench.png' height='20' border='0' alt='Alterar' title='Alterar'   border='0'/></a></td>
									<td><a href=\"javascript:void(0)\" target='_self'><img src='include/img/bt/Xion.png' height='20' border='0' alt='Excluir' title='Excluir' border='0' onclick=\"DelItem($rowIte[idIte]);\" /></a></td>
									</tr>";
						}
                }
				echo "<tr><td colspan=\"8\"></td></tr>";
        }
        ?>
            
            
    </table>

    <!-- Fim listagem de módulos e itens cadastrados -->
    
      

    </div>



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


