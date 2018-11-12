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
		location.href='del_noticia.php?id='+id;
	}
}
</script>



</head>

<body>

<?php include '../../include/painel/topo.php' ?>

<div id="conteudo">
<!-- CONTEÚDO ABAIXO -->





<h1>LISTAGEM DE NOT&Iacute;CIAS</h1>
<br />
<a href="ad_noticia.php">ADICIONAR NOTÍCIA</a>
<div class="formulario"  style="width: 100%;">


	<?php
    include '../../include/scripts/converte_data.php';
    
    // PAGINAÇÃO
    $numreg = 20; // Qtde de registros por página
    if (!isset($pg)) $pg = 0;
    if (!isset($_REQUEST['pg'])) $pg = 0; else $pg = $_REQUEST['pg'];
	$inicial = $pg * $numreg;
    $result = mysql_query("SELECT idNot, datacad, nome, ativo FROM noticias ORDER BY datacad DESC LIMIT $inicial, $numreg") or die(mysql_error());
    $quantreg = mysql_num_rows(mysql_query("SELECT * FROM noticias WHERE ativo=1")); // Qtde total de registros na tabela
    // FIM PAGINAÇÃO
    
    echo "<div>Foram encontrados <strong>$quantreg registro(s) </strong></div>";
    ?>

    
    <table class="listagem" width="100%" border="0" cellpadding="3" cellspacing="0">
        <tr>
        <td width="20%" class="t_campo">DATA</td>
        <td width="55%" class="t_campo">T&Iacute;TULO</td>
        <td width="15%" class="t_campo">STATUS</td>
        <td width="5%" class="t_campo">&nbsp;</td>
        <td width="5%" class="t_campo">&nbsp;</td>
        </tr>
    
        <?php
        // Listagem
        while($row = mysql_fetch_array($result)){
			
			if($row['ativo']) $ativo='ATIVO'; else $ativo='<font color="red"> INVATIVO </font>';
            
            // Tratando dados
            $datacad = datetime($row['datacad']);
            
            echo "	<tr>
                    <td valign=\"top\"> $datacad </td>
                    <td> $row[nome] </td>
					<td> $ativo </td>
                    <td><a href='alt_noticia.php?id=$row[idNot]'><img src='../../include/img/bt/bt_alterar.gif' alt='Alterar Registro' title='Alterar Registro' border='0' /></a></td>
					<td><a href='#'><img src='../../include/img/bt/bt_excluir.gif' alt='Excluir Registro' title='Excluir Registro' border='0' onclick=\"DelNoticia($row[idNot]);\" /></a></td>
                    </tr>";
        }
        ?> 	
    
    </table>


    <?php include '../../include/php/paginacao.php'; ?>
    
    
    
    
    
    
<!-- CONTEÚDO ACIMA -->
</div>
<?php include '../../include/painel/rodape.php' ?>