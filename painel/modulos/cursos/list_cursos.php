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
<title><?php echo $rowPainel['nome'] ?> - Sistema Eweb de Gestão </title>

<link href="../../include/css/layout.css" rel="stylesheet" type="text/css" />
<link href="../../include/css/form1.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="../../include/scripts/funcoes.js"></script>

<script type="text/javascript">
// DEL EQUIPE
function DelNoticia(id){
	decisao = confirm("Deseja mesmo excluir este registro?");
	
	if(decisao){
		location.href='del_curso.php?id='+id;
	}
}
</script>



</head>

<body>

<?php include '../../include/painel/topo.php' ?>

<div id="conteudo">
<!-- CONTEÚDO ABAIXO -->





<h1>LISTAGEM DE CURSOS</h1>

<div class="formulario"  style="width: 100%;">


	<?php
    include '../../include/scripts/converte_data.php';
    
    // PAGINAÇÃO
    $numreg = 20; // Qtde de registros por página
    if (!isset($pg)) $pg = 0;
    if (!isset($_REQUEST['pg'])) $pg = 0; else $pg = $_REQUEST['pg'];
	$inicial = $pg * $numreg;
    $result = mysql_query("SELECT idCur, idCat, titulo, ativo FROM cursos ORDER BY titulo DESC LIMIT $inicial, $numreg") or die(mysql_error());
    $quantreg = mysql_num_rows(mysql_query("SELECT * FROM cursos WHERE ativo=1")); // Qtde total de registros na tabela
    // FIM PAGINAÇÃO
    
    echo "<div>Foram encontrados <strong>$quantreg registro(s) </strong></div>";
    ?>

    <table width="100%" border="0" cellpadding="3" cellspacing="0">
        <tr>
        
        <td width="60%" class="t_campo">T&Iacute;TULO</td>
        <td width="15%" class="t_campo">CATEGORIA</td>
        <td width="15%" class="t_campo">STATUS</td>
        <td width="5%" class="t_campo">&nbsp;</td>
        <td width="5%" class="t_campo">&nbsp;</td>
        </tr>
    
        <?php
        // Listagem
        while($row = mysql_fetch_array($result)){
			
			if($row['ativo']) $ativo='ATIVO'; else $ativo='<font color="red"> INVATIVO </font>';
            
            // Tratando dados
            //$datacad = datetime($row['datacad']);
            $rowCat = mysql_fetch_array(mysql_query("SELECT idCat, nome FROM cat_curso WHERE idCat=$row[idCat]"));

            echo "	<tr onMouseOver=\"bgr_color(this, '#FFFFFF')\" onMouseOut=\"bgr_color(this, '#E0E0E0')\">
                    
                    <td> $row[titulo] </td>
					<td> $rowCat[nome] </td>
					<td> $ativo </td>
                    <td><a href='alt_curso.php?id=$row[idCur]'><img src='../../include/img/bt/bt_alterar.gif' alt='Alterar Registro' title='Alterar Registro' border='0' /></a></td>
					<td><a href='#'><img src='../../include/img/bt/bt_excluir.gif' alt='Excluir Registro' title='Excluir Registro' border='0' onclick=\"DelNoticia($row[idCur]);\" /></a></td>
                    </tr>";
        }
        ?> 	
    
    </table>


    <?php include '../../include/php/paginacao.php'; ?>
    
    
    
    
    
    
<!-- CONTEÚDO ACIMA -->
</div>
<?php include '../../include/painel/rodape.php' ?>