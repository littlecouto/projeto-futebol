<?php



if(isset($_POST['ACAO']) && $_POST['ACAO'] == 'ATUALIZAR_PERMISSOES'){
	
	// LIMPANDO TODAS AS PERMISSÕES DO USUÁRIO
	mysql_query("DELETE FROM painel_permissao WHERE idUsu=$_POST[usuario]") or die(mysql_error());

	if(isset($_POST['item'])){ // EFETUA A ATUALIZAÇÃO CASO ITENS SEJAM ESCOLHIDOS
		foreach($_POST['item'] as $item){
					
			// SELECIONANDO O MÓDULO AO QUAL O ITEM PERTENCE
			$rowMod = mysql_fetch_array(mysql_query("SELECT idMod FROM painel_modulo_item WHERE idIte=$item"));
			
			// VERIFICANDO SE O USUÁRIO JÁ POSSUI PERMISSÃO AO MÓDULO ATUAL
			$resultModAtu = mysql_query("SELECT idPer FROM painel_permissao WHERE idUsu=$_POST[usuario] AND idMod=$rowMod[idMod] AND tipo='MOD'");
			// ADICIONANDO A PERMISSÃO ATUAL - MÓDULO
			if(mysql_num_rows($resultModAtu) == 0){
				$query = "INSERT INTO painel_permissao(idUsu, idMod, tipo) VALUES($_POST[usuario], $rowMod[idMod], 'MOD')";
				mysql_query($query);
				
				// PAINEL HISTÓRICO
				$query = addslashes($query);
				mysql_query("INSERT INTO painel_historico(idUsu, acao, query) VALUE($_SESSION[USUARIO], 'INSERT', '$query')") or die (mysql_error());
				//
			}
				
			// GRAVANDO A PERMISSÃO ATUAL - ITEM
			$query = "INSERT INTO painel_permissao(idUsu, idMod, idIte, tipo) VALUES($_POST[usuario], $rowMod[idMod], $item, 'ITEM')";
			mysql_query($query);
			
			// PAINEL HISTÓRICO
			$query = addslashes($query);
			mysql_query("INSERT INTO painel_historico(idUsu, acao, query) VALUE($_SESSION[USUARIO], 'INSERT', '$query')") or die (mysql_error());
			//
		}
	}
	
	echo "<script> alert('Permissões atualizadas com sucesso!'); location.href='$_SERVER[REQUEST_URI]'; </script>";
		
}
?>

<!-- FORMULARIO -->

<div class="formulario">



    <form method="get" action="<?php echo $_SERVER['REQUEST_URI'] ?>">

    <h2>USU&Aacute;RIO</h2>
	<div class="area">
                
      	 <div class="linha">
            
            <div class="campo">
            <?php
			$resultUsu = mysql_query("SELECT idUsu, nome FROM painel_usuario WHERE ativo='1' ORDER BY nome ASC");
			$qtde = mysql_num_rows($resultUsu);
			?>
            
            <select name="usuario" onchange="document.forms[0].submit();">
            <option value="">&nbsp;</option>
            <?php
            // USUÁRIOS
            while($rowUsu = mysql_fetch_array($resultUsu)){
                echo "<option value='$rowUsu[idUsu]' ".($rowUsu['idUsu']==$_GET['usuario']?'selected':'').">$rowUsu[nome]</option>";
            }
            ?>
            </select>
            </div>
            
         </div>
         
    </div>
    </form>
    
    
    
    
    
    
<?php if(($_GET['usuario'] > 0) && ($_GET['modulo'] == 0)){ ?>
    
     
    <!-- SELEÇÃO DE MÓDULOS -->
	<form method="post" action="<?php echo $_SERVER['REQUEST_URI'] ?>">
    <input type="hidden" name="ACAO" value="ATUALIZAR_PERMISSOES" />
    <input type="hidden" name="usuario" value="<?php echo $_GET['usuario'] ?>" />
    
    <h2> PERMISSÕES </h2>
      <div class="area">
      
                
        <table width="100%" border="0" cellpadding="3" cellspacing="0">
        	<tr>
            <th width="90%" class="t_campo">MÓDULO</th>
            <th width="10%" class="t_campo"><label> <input type="checkbox" class="sel tudo" /> </label>PERMISSÃO</th>
            </tr>
            
            <?php
			// SELECIONANDO TODOS OS MÓDULOS ATIVOS
			$resultMod = mysql_query("SELECT idMod, nome FROM painel_modulo WHERE ativo=1 ORDER BY ordem");
			while($rowMod = mysql_fetch_array($resultMod)){
				
				echo "	<tr class=\"modulo\">
						<td> <strong> $rowMod[nome] </strong> </td>
						<td> <label> <input type=\"checkbox\" class=\"sel mod\" data-mod=\"$rowMod[idMod]\" /> </label> </td>
						</tr>";
				
				// SELECIONANDO OS ITENS ATIVOS DO MÓDULO ATUAL
				$resultIte = mysql_query("SELECT idIte, nome FROM painel_modulo_item WHERE ativo=1 AND idMod=$rowMod[idMod] ORDER BY ordem");
				while($rowIte = mysql_fetch_array($resultIte)){
					
					// VERIFICANDO SE O USUÁRIO SELECIONADO POSSUI PERMISSÃO AO ITEM ATUAL
					$resultPerIte = mysql_query("SELECT idPer FROM painel_permissao	WHERE idIte=$rowIte[idIte] AND idUsu=$_GET[usuario]");
					if(mysql_num_rows($resultPerIte) > 0) $chkIte='checked=\"checked\"'; else $chkIte='';
					
					echo "	<tr>
							<td> &nbsp; &nbsp; &nbsp; $rowIte[nome] </td>
							<td> <label> <input type=\"checkbox\" name=\"item[]\" data-mod=\"$rowMod[idMod]\" value=\"$rowIte[idIte]\" $chkIte /> </label> </td>
							</tr>";
				}
				
			}
			?>
            
            </table>
    
    	
        
    </div>
    
    <button type="submit"> ATUALIZAR PERMISSÕES </button>
    
    </form>
    
<?php } ?>


	</div>

    
<script>

$(document).ready(function(e) {
	$('.sel.mod').each(function(i, e) {
		var mod = $(this).attr('data-mod');
		if($('input[type=checkbox]:checked[data-mod='+mod+']:not(.sel)').size()==$('input[type=checkbox][data-mod='+mod+']:not(.sel)').size()){
			$(this).prop('checked', true);
		}else{
			$(this).prop('checked', false);
		}
	});
	
 	if($('input[type=checkbox]:checked:not(.sel)').size()==$('input[type=checkbox]:not(.sel)').size()){
		$('input.sel.tudo').prop('checked', true);
	}else{
		$('input.sel.tudo').prop('checked', false);
	}
   
});


$('.sel.tudo').click(function(){

	if($('input[type=checkbox]:checked:not(.sel)').size()==$('input[type=checkbox]:not(.sel)').size()){
		$('input').prop('checked', false);
	}else{
		$('input').prop('checked', true);
	}
});

$('.sel.mod').click(function(){
	var mod = $(this).attr('data-mod');
	if($('input[type=checkbox]:checked[data-mod='+mod+']:not(.sel)').size()==$('input[type=checkbox][data-mod='+mod+']:not(.sel)').size()){
		$('input[data-mod='+mod+']').prop('checked', false);
	}else{
		$('input[data-mod='+mod+']').prop('checked', true);
	}
});
</script>
</div>
