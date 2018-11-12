<?php 
session_start(); 

// CONEXÃO
include_once 'include/classes/conexao.class.php';
$con = new Conexao();
$conexao = $con->Conecta();

include_once 'include/config.php';

// VER LOGIN
include_once 'include/classes/login.class.php';
$lgn = new Login();
$lgn->VerLogin();

// TITULO PAINEL
$resultPainel 	= mysql_query("SELECT sistema_nome nome FROM painel_config LIMIT 1") or die (mysql_error());
$rowPainel		= mysql_fetch_array($resultPainel);
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859padrao" />
<title><?php echo $rowPainel['nome'] ?> </title>

<link href="include/css/layout.css" rel="stylesheet" type="text/css" />
<link href="include/css/form1.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="<?php echo $SISTEMA['JS']?>/jquery.min.js"></script>
<script type="text/javascript" src="include/scripts/funcoes.js"></script>

</head>



<body>

<?php include 'include/painel/topo.php' ?>

<div id="conteudo">

<!-- CONTEÚDO ABAIXO -->






<h1>HIST&Oacute;RICO DE ACESSOS</h1>



<div class="formulario" style="width: 100%;">



        
	<?php
    $resultUsu = mysql_query("SELECT idAce, datalogin, datalogout, ip, so, browser FROM painel_acesso WHERE idUsu=$_SESSION[USUARIO] ORDER BY idAce DESC");
    $numero = mysql_num_rows($resultUsu);
    echo "<div>Foram encontrados <strong>$numero registro(s)</strong></div>";
    ?>
        
    <table width="100%" border="0" cellpadding="3" cellspacing="0">
        <tr>
        <td width="20%" class="t_campo"> Sessão iniciada </td>
        <td width="20%" class="t_campo"> Sessão encerrada </td>
        <td width="20%" class="t_campo"> IP </td>
        <td width="20%" class="t_campo"> Sistema Op. </td>
        <td width="20%" class="t_campo"> Navegador </td>
        </tr>
    
        <?php
        include 'include/scripts/converte_data.php';
        
        while($row = mysql_fetch_array($resultUsu)){
			
			$datalogin = datetime($row['datalogin']);
			$datalogout = datetime($row['datalogout']);
            
            echo "	<tr onMouseOver=\"bgr_color(this, '#E0E0E0')\" onMouseOut=\"bgr_color(this, '#FFFFFF')\">";
            echo "	<td>$datalogin</td>";
			echo "	<td>$datalogout</td>";
			echo "	<td>$row[ip]</td>";
			echo "	<td>$row[so]</td>";
			echo "	<td>$row[browser]</td>";
            echo "	</tr>";
        }
        ?> 	
    
    </table>


</div>












<!-- CONTEÚDO ACIMA -->

</div>
<?php include 'include/painel/rodape.php' ?>