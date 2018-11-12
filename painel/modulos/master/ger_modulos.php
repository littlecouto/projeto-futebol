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
// CADASTRO DE MÓDULOS
if(isset($_POST['ACAO']) and $_POST['ACAO'] == 'AD_MODULO'){
	
	//validando campos
	if(empty($_POST['nome_mod'])){
		echo "<script> alert('Preencha o campo NOME'); history.go(-1); </script>";
	}else{
		
		//tratando dados
		$_POST['nome_mod'] = strtoupper($_POST['nome_mod']);
		
		// VERIFICANDO SE JÁ EXISTE ALGUM MÓDULO COM ESTE NOME
		$existeMod = mysql_query("SELECT idMod FROM painel_modulo WHERE nome='$_POST[nome_mod]'");
		if(mysql_num_rows($existeMod) >= 1){
			echo "<script> alert('Já existe um módulo com este nome'); location.href='$_SERVER[REQUEST_URI]'; </script>";
		}
		else{
		
			// Tratando os dados
			$nome_mod	= addslashes($_POST['nome_mod']);
			$ativo 		= addslashes($_POST['ativo']);
			
			$nome_mod	= strtoupper($nome_mod);
		
			$query = "INSERT INTO painel_modulo(nome, ativo) VALUES('$nome_mod', '$ativo')";
			$gravou = mysql_query($query);
			
			// PAINEL HISTÓRICO
			$query = addslashes($query);
			mysql_query("INSERT INTO painel_historico(idUsu, acao, query) VALUE($_SESSION[USUARIO], 'INSERT', '$query')") or die (mysql_error());
			//
		
			if($gravou == true){
				echo "<script> alert('Módulo cadastrado com sucesso!'); history.go(-1); </script>";
			}elseif($gravou == false){
				echo "<script> alert('Houve um erro ao cadastrar.'); history.go(-1); </script>";
			}	
		}// FIM VERIFICAÇÃO
	}
}




//CADASTRO DE ITENS
elseif(isset($_POST['ACAO']) && $_POST['ACAO'] == 'AD_ITEM'){
	
	//validando campos
	if($_POST['sel_mod'] == null){
		echo "<script>alert('Selecione um MÓDULO!'); history.go(padrao);;</script>";
	}elseif(empty($_POST['item'])){
		echo "<script>alert('Preencha o campo ITEM!'); history.go(padrao);;</script>";
	}elseif(empty($_POST['url'])){
		echo "<script>alert('Preencha o campo URL!'); history.go(padrao);;</script>";
	}else{
		
		// Tratando os dados
		$sel_mod 	= addslashes($_POST['sel_mod']);
		$item 		= addslashes($_POST['item']);
		$url 		= addslashes($_POST['url']);
		$ativo		= addslashes($_POST['ativo']);
		$pagina 	= addslashes($_POST['pagina']);
		$item		= strtoupper($item);
		
		$query = "INSERT INTO painel_modulo_item(idMod, nome, url, ativo, pagina) VALUES('$sel_mod', '$item', '$url', '$ativo', '$pagina')";
		$gravou = mysql_query($query) or die (mysql_error());	
		
		// PAINEL HISTÓRICO
		$query = addslashes($query);
		mysql_query("INSERT INTO painel_historico(idUsu, acao, query) VALUE($_SESSION[USUARIO], 'INSERT', '$query')") or die (mysql_error());
		//
		
		if($gravou == true){
			echo "<script>alert('Item cadastrado com sucesso!'); history.go(padrao);;</script>";
		}elseif($gravou == false){
			echo "<script>alert('Houve um erro ao cadastrar!'); history.go(padrao);;</script>";
		}
	}
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859padrao" />
<title><?php echo $rowPainel['nome'] ?> - Sistema Eweb de Gestão</title>

<link href="../../include/css/layout.css" rel="stylesheet" type="text/css" />
<link href="../../include/css/form1.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="<?php echo $SISTEMA['JS']?>/jquery.min.js"></script>

<script type="text/javascript" src="../../scripts/funcoes.js"></script>



<script type="text/javascript">

// DEL ´MÓDULO
function DelMod(id){
	decisao = confirm("Deseja mesmo excluir este registro?");
	
	if(decisao){
		location.href='del_modulo.php?id='+id;
	}
}


// DEL ITEM
function DelItem(id){
	decisao = confirm("Deseja mesmo excluir este registro?");
	
	if(decisao){
		location.href='del_item.php?id='+id;
	}
}


</script>



</head>

<body>

<?php include '../../include/painel/topo.php' ?>

<div id="conteudo">

<!-- CONTEÚDO ABAIXO -->







<h1>Gerenciamento de M&oacute;dulos</h1>

<div class="formulario">

    <!-- Cadastro de módulos -->
    <form method="post" action="<?php echo $_SERVER['REQUEST_URI'] ?>">
    <input type="hidden" name="ACAO" value="AD_MODULO" />
        <div class="area">
            <h2>Cadastro de M&oacute;dulo</h2>
            
            <div class="linha">
                <div class="t_campo">M&oacute;dulo:</div>
                <div class="campo"><label><input type="text" id="nome_mod" name="nome_mod" size="30" maxlength="50" /></label></div>
            </div>
            
            
            <div class="linha">
                <div class="t_campo">Ativo:</div>
                <div class="campo">
                    <input type="radio" name="ativo" id="ativo" value="1" checked="checked" /> Sim
                    <br />
                    <input type="radio" name="ativo" id="ativo" value="0" /> N&atilde;o
                </div>
            </div>
            
                
                
            <button type="submit">Cadastrar M&oacute;dulo</button> 
        
        </div>

    </form>
	<!-- Fim cadastro de módulos -->                
	


	<!-- Cadastro de Item -->
    <form method="post" action="<?php echo $_SERVER['REQUEST_URI'] ?>">
    <input type="hidden" name="ACAO" value="AD_ITEM" />
        <div class="area">
                <h2>Cadastro de Item</h2>
                
                <div class="linha">
                    <div class="t_campo">M&oacute;dulo:</div>
                    
                        <div class="campo">
                        
                        
                            <label><select name="sel_mod" size="1" id="sel_mod">
                            
                          
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
                    <div class="t_campo">Item:</div>
                    <div class="campo"><label><input type="text" id="item" name="item" size="38" maxlength="50" /></label></div>
                </div>
                
                <div class="linha">
                    <div class="t_campo">URL:</div>
                    <div class="campo"><label><input type="text" id="url" name="url" size="38" maxlength="300" /></label></div>
                </div>
                
                <div class="linha">
                    <div class="t_campo">Ativo:</div>
                    <div class="campo">
                        <input type="radio" name="ativo" id="ativo" value="1" checked="checked" />Sim
                        <br />
                        <input type="radio" name="ativo" id="ativo" value="0" />N&atilde;o
                    </div>
                </div>
                
                <div class="linha">
                    <div class="t_campo">Abertura da Pág.:</div>
                    <div class="campo">
                      <input type="radio" name="pagina" id="pagina" value="1" checked="checked" /> Mesma P&aacute;gina 
                      <br />
                      <input type="radio" name="pagina" id="pagina" value="0" /> Nova P&aacute;gina
                    </div>
                </div>
                
       
	            <button type="submit">Cadastrar Item</button> 
            
            </div>
        </form>
		<!-- Fim cadastro de Item -->
        
        
        
        
</div>



<div class="col-dir">
        <!-- Listagem de módulos e itens cadastrados -->
        <h2>M&oacute;dulos e itens cadastrados</h2>
       <table width="100%" border="0" cellpadding="3" cellspacing="0">
        	<tr class="t_campo">
            	<td width="90%" class="t_campo"><strong> M&oacute;dulos </strong> <br /> Item</td>
            	<td width="5%" class="t_campo">&nbsp;</td>
            	<td width="5%" class="t_campo">&nbsp;</td>
            </tr>
            
            
            
            <?php 
			//listando os módulos
			$rowModu = mysql_query("SELECT * FROM painel_modulo ORDER BY nome ASC") or die (mysql_error());
			
			while($resultModu = mysql_fetch_array($rowModu)){
				
				echo "	<tr onMouseOver=\"bgr_color(this, '#FFFFFF')\" onMouseOut=\"bgr_color(this, '#E0E0E0')\">
						<td><strong>$resultModu[nome]</strong></td>
						<td><a href=\"alt_modulo.php?idMod=$resultModu[idMod]\" target='_self'><img src='../../include/img/bt/bt_alterar.gif' title='Alterar' alt='Alterar' border='0' /></a></td>
						<td><a href=\"#\" target='_self'><img src='../../include/img/bt/bt_excluir.gif' title='Excluir' alt='Excluir' border='0'  onclick=\"DelMod($resultModu[idMod]);\" /></a></td>							
						</tr>";
					
					//listando itens do módulo
					$rowItem = mysql_query("SELECT * FROM painel_modulo_item WHERE idMod='$resultModu[idMod]' ORDER BY nome") or die (mysql_error());
					while($resultItem = mysql_fetch_array($rowItem)){
						echo "	<tr onMouseOver=\"bgr_color(this, '#FFFFFF')\" onMouseOut=\"bgr_color(this, '#E0E0E0')\">
								<td> <font size=\"1\">&nbsp; &nbsp; &nbsp; $resultItem[nome]</font> </td>
								<td><a href=\"alt_item.php?idItem=$resultItem[idIte]\" target='_self'><img src='../../include/img/bt/bt_alterar.gif' border='0' alt='Alterar' title='Alterar'   border='0'/></a></td>
								<td><a href='#' target='_self'><img src='../../include/img/bt/bt_excluir.gif' border='0' alt='Excluir' title='Excluir' border='0' onclick=\"DelItem($resultItem[idIte]);\" /></a></td>
								</tr>";
					}
			}
			?>
            
            
        </table>

        <!-- Fim listagem de módulos e itens cadastrados -->
    
      

</div>




















<!-- CONTEÚDO ACIMA -->

</div>
<?php include '../../include/painel/rodape.php' ?>