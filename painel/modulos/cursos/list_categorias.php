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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $rowPainel['nome'] ?>  - Sistema Eweb de Gestão </title>

<link href="../../include/css/layout.css" rel="stylesheet" type="text/css" />
<link href="../../include/css/form1.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="../../include/scripts/funcoes.js"></script>


<!-- AJAX -->
<script type="text/javascript" src="ajax/busca_cep.js"> </script>



<script type="text/javascript">
// DEL ATLETA
function Delcategoria(id){
	decisao = confirm("DESEJA MESMO EXCLUIR ESTA CATEGORIA?");
	
	if(decisao){
		location.href='del_categoria.php?id='+id;
	}
}
</script>

</head>

<body>

<?php include '../../include/painel/topo.php' ?>
<div id="conteudo">
<!-- CONTEÚDO ABAIXO -->






<h1>Listagem de Categorias</h1>

<div class="formulario">

	<div class="area">
		<?php
        $result = mysql_query("SELECT idCat,nome,ativo FROM cat_curso ORDER BY nome"); 
        $numero = mysql_num_rows($result);
        echo "<div>Foram encontrados <strong>$numero registro(s) </strong></div>";
        ?>
	</div>
    
    
    
    <div class="area">
        
        <table width="100%" border="0" cellpadding="3" cellspacing="0">
            <tr>
            <td width="70%" class="t_campo">CATEGORIA</td>
            <td width="15%" class="t_campo">ATIVO</td>
            <td width="5%" class="t_campo">&nbsp;</td>
            <td width="5%" class="t_campo">&nbsp;</td>

            </tr>
        
            <?php
			// Artigo
            while($row = mysql_fetch_array($result)){
                echo "	<tr onMouseOver=\"bgr_color(this, '#FFFFFF')\" onMouseOut=\"bgr_color(this, '#E0E0E0')\">";
                echo "	<td>$row[nome]</td>";
                if($row['ativo'] == 1) echo '<td>Sim</td>'; else echo '<td><font color="red">Não</font></td>';
                echo "	<td><a href='alt_categoria.php?idCat=$row[idCat]'><img src='../../include/img/bt/bt_alterar.gif' alt='Alterar Registro' border='0' /></a></td>";                
                echo "	<td><a href='#'><img src='../../include/img/bt/bt_excluir.gif' alt='Excluir Usu&atilde;rio' title='Excluir Usu&atilde;rio' border='0' onclick=\"Delcategoria($row[idCat]);\" /></a></td>";
                echo "	</tr>";
								
			}
            ?> 	
        
        </table>
    
    
    </div>
    
    
    
    
    
    
    
    
    
    
    
    
<!-- CONTEÚDO ACIMA -->
</div>
<?php include '../../include/painel/rodape.php' ?>