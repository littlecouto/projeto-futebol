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
if(isset($_POST['ACAO']) && $_POST['ACAO'] == 'ATUALIZAR_PERMISSOES'){
	
	// LIMPANDO TODAS AS PERMISSÕES DO USUÁRIO
	mysql_query("DELETE FROM painel_permissao WHERE idUsu=$_POST[usuario]") or die(mysql_error());

	if(isset($_POST['item'])){ // EFETUA A ATUALIZAÇÃO CASO ITENS SEJAM ESCOLHIDOS
		foreach($_POST['item'] as $item){
					
			// SELECIONANDO O MÓDULO AO QUAL O ITEM PERTENCE
			$rowMod = mysql_fetch_array(mysql_query("SELECT idMod FROM painel_modulo_item WHERE idIte=$item"));
			
			// Tratando os dados
			$datacad = date("Y-m-d G:i:s");
			
			// VERIFICANDO SE O USUÁRIO JÁ POSSUI PERMISSÃO AO MÓDULO ATUAL
			$resultModAtu = mysql_query("SELECT idPer FROM painel_permissao WHERE idUsu=$_POST[usuario] AND idMod=$rowMod[idMod] AND tipo='MOD'");
			// ADICIONANDO A PERMISSÃO ATUAL - MÓDULO
			if(mysql_num_rows($resultModAtu) == 0){
				$query = "INSERT INTO painel_permissao(idUsu, idMod, datacad, tipo) VALUES($_POST[usuario], $rowMod[idMod], '$datacad', 'MOD')";
				mysql_query($query);
				
				// PAINEL HISTÓRICO
				$query = addslashes($query);
				mysql_query("INSERT INTO painel_historico(idUsu, acao, query) VALUE($_SESSION[USUARIO], 'INSERT', '$query')") or die (mysql_error());
				//
			}
				
			// GRAVANDO A PERMISSÃO ATUAL - ITEM
			$query = "INSERT INTO painel_permissao(idUsu, idMod, idIte, datacad, tipo) VALUES($_POST[usuario], $rowMod[idMod], $item, '$datacad', 'ITEM')";
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


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859padrao" />
<title><?php echo $rowPainel['nome'] ?> - Sistema Eweb de Gestão</title>

<link href="../../include/css/layout.css" rel="stylesheet" type="text/css" />
<link href="../../include/css/form1.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="<?php echo $SISTEMA['JS']?>/jquery.min.js"></script>

<script type="text/javascript" src="../../include/scripts/funcoes.js"></script>

</head>

<body>

<?php include '../../include/painel/topo.php' ?>

<div id="conteudo">

<!-- CONTEÚDO ABAIXO -->




<h1>Gerenciamento de Permiss&otilde;es</h1>



<!-- FORMULARIO -->

<div class="formulario">



<?php if($_GET['usuario'] == 0){ ?>
    <form method="post" action="<?php echo $_SERVER['REQUEST_URI'] ?>">

	<div class="area">
                
      	 <div class="linha">
            
            <div class="campo">
            <h2>Usu&aacute;rio</h2>
            <?php
			$resultUsu = mysql_query("SELECT idUsu, nome FROM painel_usuario WHERE ativo='1' ORDER BY idUsu ASC");
			$qtde = mysql_num_rows($resultUsu);
			?>
            
            <select name="usu" onchange="window.open(this.value,'_self');">
            <option value="">&nbsp;</option>
            <?php
            // USUÁRIOS
            while($rowUsu = mysql_fetch_array($resultUsu)){
                echo "<option value='ger_permissoes.php?usuario=$rowUsu[idUsu]'>$rowUsu[nome]</option>";
            }
            ?>
            </select>
            </div>
            
         </div>
         
    </div>
    </form>

<?php }else{ ?>

		<!-- SELEÇÃO DE USUÁRIO -->
		<form method="post" action="<?php echo $_SERVER['REQUEST_URI'] ?>">
		 <div class="area">
                
      	 <div class="linha">
            
            <div class="campo">
            <h2>Usu&aacute;rio</h2>
            <?php
			$resultUsu = mysql_query("SELECT idUsu, nome FROM painel_usuario WHERE idUsu<>$_GET[usuario] AND ativo='1' ORDER BY idUsu ASC");
			$qtde = mysql_num_rows($resultUsu);
			?>
            
            <?php
			//pegando dados para mostra o usuario selecionado
			$row_Usu = mysql_fetch_array(mysql_query("SELECT idUsu, nome FROM painel_usuario WHERE idUsu='$_GET[usuario]'")) or die (mysql_error());
			?>
            
            <select name="usu" onchange="window.open(this.value,'_self');">
            <option value="<?php echo $row_Usu['idUsu']; ?>" selected="selected"><?php echo $row_Usu['nome']; ?></option>
            <?php
            // USUÁRIOS
            while($rowUsu = mysql_fetch_array($resultUsu)){
                echo "<option value='ger_permissoes.php?usuario=$rowUsu[idUsu]'>$rowUsu[nome]</option>";
            }
            ?>
            </select>
            </div>
         </div>
         
    </div>
    </form>    
    <!-- FIM SELEÇÃO DE USUÁRIO -->
    
 <?php } ?>   
    
    
    
    
    
    
<?php if(($_GET['usuario'] > 0) && ($_GET['modulo'] == 0)){ ?>
    
     
    <!-- SELEÇÃO DE MÓDULOS -->
	<form method="post" action="<?php echo $_SERVER['REQUEST_URI'] ?>">
    <input type="hidden" name="ACAO" value="ATUALIZAR_PERMISSOES" />
    <input type="hidden" name="usuario" value="<?php echo $_GET['usuario'] ?>" />
    
      <div class="area">
      
      	<h2> PERMISSÕES DO USUÁRIO </h2>
                
        <table width="100%" border="0" cellpadding="3" cellspacing="0">
        	<tr>
            <td width="90%" class="t_campo">MÓDULO</td>
            <td width="10%" class="t_campo">PERMISSÃO</td>
            </tr>
            
            <?php
			// SELECIONANDO TODOS OS MÓDULOS ATIVOS
			$resultMod = mysql_query("SELECT idMod, nome FROM painel_modulo WHERE ativo=1");
			while($rowMod = mysql_fetch_array($resultMod)){
				
				echo "	<tr onMouseOver=\"bgr_color(this, '#FFFFFF')\" onMouseOut=\"bgr_color(this, '#E0E0E0')\">
						<td> <strong> $rowMod[nome] </strong> </td>
						<td> <!--<label> <input type=\"checkbox\" id=\"$rowMod[idMod]\" /> </label>--> </td>
						</tr>";
				
				// SELECIONANDO OS ITENS ATIVOS DO MÓDULO ATUAL
				$resultIte = mysql_query("SELECT idIte, nome FROM painel_modulo_item WHERE ativo=1 AND idMod=$rowMod[idMod]");
				while($rowIte = mysql_fetch_array($resultIte)){
					
					// VERIFICANDO SE O USUÁRIO SELECIONADO POSSUI PERMISSÃO AO ITEM ATUAL
					$resultPerIte = mysql_query("SELECT idPer FROM painel_permissao	WHERE idIte=$rowIte[idIte] AND idUsu=$_GET[usuario]");
					if(mysql_num_rows($resultPerIte) > 0) $chkIte='checked=\"checked\"'; else $chkIte='';
					
					echo "	<tr onMouseOver=\"bgr_color(this, '#FFFFFF')\" onMouseOut=\"bgr_color(this, '#E0E0E0')\">
							<td> &nbsp; &nbsp; &nbsp; $rowIte[nome] </td>
							<td> <label> <input type=\"checkbox\" name=\"item[]\" value=\"$rowIte[idIte]\" $chkIte /> </label> </td>
							</tr>";
				}
				
			}
			?>
            
            </table>
    
    	<button type="submit"> ATUALIZAR PERMISSÕES </button>
        
    </div>
    </form>
    
<?php } ?>


	</div>

    

</div>
<?php include '../../include/painel/rodape.php' ?>