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



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859padrao" />
<title><?php echo $rowPainel['nome'] ?> - Sistema Eweb de Gestão </title>

<link href="../../include/css/layout.css" rel="stylesheet" type="text/css" />
<link href="../../include/css/form1.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="<?php echo $SISTEMA['JS']?>/jquery.min.js"></script>
<script type="text/javascript" src="../../include/scripts/funcoes.js"></script>

<!-- CALENDÁRIO -->
<script type="text/javascript" src="../../lib/calendario/calendario.js"></script>
<link href="../../lib/calendario/calendario.css" rel="stylesheet" type="text/css" />
<!-- FIM CALENDÁRIO -->

</head>



<body>

<?php include '../../include/painel/topo.php' ?>

<div id="conteudo">

<!-- CONTEÚDO ABAIXO -->






<h1>LOG DE ACESSOS</h1>






<?php if(!isset($_POST['ACAO']) or $_POST['ACAO']==false){ ?>


    <div class="formulario">

    <form action="<?php echo $_SERVER['REQUEST_URI']?>" method="post">
    <input type="hidden" name="ACAO" value="FILTRAR" />
    
        <div class="area">
        
            <h2> FILTRO </h2>
        
            <div class="linha">
            <div class="t_campo">*USUÁRIO</div>
            <div class="campo"><label>
                <select name="usuario">
                <option value="" selected="selected">&nbsp;</option>
                <?php
                // USUÁRIOS
                $resultUsu = mysql_query("SELECT idUsu, nome FROM painel_usuario WHERE ativo=1");
                while($rowUsu = mysql_fetch_array($resultUsu)){
                    echo "<option value='$rowUsu[idUsu]'>$rowUsu[nome]</option>";
                }
                ?>
                </select>
            </label></div>
            </div>
            
            <div class="linha">
            <div class="t_campo">*PERÍODO ENTRE</div>
            <div class="campo"><label>
            <input name="dataini" type="text" id="dataini" value="<?php echo date("d/m/Y")?>" maxlength="10" style="display:block; float:left; width:75px;" />
            <img src="../../lib/calendario/calendario.png" border="0" onclick="displayCalendar(document.forms[0].dataini,'dd/mm/yyyy',this)" style="float:left; cursor:pointer; margin-right:15px" />
    
            <input name="datafim" type="text" id="datafim" value="<?php echo date("d/m/Y")?>" maxlength="10" style="display:block; float:left; width:75px;" />
            <img src="../../lib/calendario/calendario.png" border="0" onclick="displayCalendar(document.forms[0].datafim,'dd/mm/yyyy',this)" style="float:left; cursor:pointer;" />
            </label></div>
            </div>
            
        
            <button type="submit"> FILTRAR </button>
            
        </div>
        
        
    </form>

	</div>





        
<?php
}elseif(isset($_POST['ACAO']) and $_POST['ACAO'] == 'FILTRAR'){

	include '../../include/scripts/converte_data.php';

	$ini = dataaaaammdd($_POST['dataini']).' 00:00:00';
	$fim = dataaaaammdd($_POST['datafim']).' 23:59:59';

	$result = mysql_query("SELECT idAce, datalogin, datalogout, ip, so, browser FROM painel_acesso WHERE idUsu=$_POST[usuario] AND datalogin BETWEEN '$ini' AND '$fim' ORDER BY idAce DESC") or die(mysql_error());
	
	// CONTROLE DE REGISTROS
	$numero = mysql_num_rows($result);
	if($numero == 0) 
		echo '<script> alert("Nenhum registro encontrado!"); history.go(-1); </script>';
	elseif($numero > 300)
		echo '<script> alert("O filtro atual supera a 300 registros, por favor diminua o intervalo do período!"); history.go(-1); </script>';
	//
	
	echo "<div>Foram encontrados <strong>$numero registro(s)</strong></div>";
?>
	
    
    <div class="formulario" style="width: 100%;">

    <table width="100%" border="0" cellpadding="3" cellspacing="0">
        <tr>
        <td width="20%" class="t_campo"> Sessão iniciada </td>
        <td width="20%" class="t_campo"> Sessão encerrada </td>
        <td width="20%" class="t_campo"> IP </td>
        <td width="20%" class="t_campo"> Sistema Op. </td>
        <td width="20%" class="t_campo"> Navegador </td>
        </tr>
    
        <?php
        while($row = mysql_fetch_array($result)){
			
			$datalogin = datetime($row['datalogin']);
			$datalogout = datetime($row['datalogout']);
            
            echo "	<tr onMouseOver=\"bgr_color(this, '#FFFFFF')\" onMouseOut=\"bgr_color(this, '#E0E0E0')\">";
            echo "	<td>$datalogin</td>";
			echo "	<td>$datalogout</td>";
			echo "	<td>$row[ip]</td>";
			echo "	<td>$row[so]</td>";
			echo "	<td>$row[browser]</td>";
            echo "	</tr>";
        }
        ?> 	
    
    </table>
    
    <button type="buttno" onclick="javascript:history.go(-1);"> VOLTAR </button>


</div>

<?php } ?>






<!-- CONTEÚDO ACIMA -->

</div>
<?php include '../../include/painel/rodape.php' ?>