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

<style>
.evento {
        width: 15px;
    height: auto;
    float: left;
    min-height: 15px;
    background-size: contain;
    background-position: center center;
    margin: 0px 10px 0px 5px;

}
.gol {
    background-image: url(../../../img/gol.png);
    background-repeat: no-repeat;
}
.contra {
    background-image: url(../../../img/contra.png);
    background-repeat: no-repeat;
}
.amarelo {
    background-image: url(../../../img/amarelo.png);
    background-repeat: no-repeat;
}
.seg-amarelo {
    background-image: url(../../../img/seg-amarelo.png);
    background-repeat: no-repeat;
}
.substituto {
    background-image: url(../../../img/substituto.png);
    background-repeat: no-repeat;
}
.entra {
    background-image: url(../../../img/entra.png);
    background-repeat: no-repeat;
}
.sai {
    background-image: url(../../../img/sai.png);
    background-repeat: no-repeat;
}
.vermelho {
    background-image: url(../../../img/vermelho.png);
    background-repeat: no-repeat;
}
.contusao {
    background-image: url(../../../img/contusao.png);
    background-repeat: no-repeat;
}
</style>

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



    <?php


    
    // PAGINAÇÃO
    
    $result = mysql_query("SELECT 
            J.idMan, 
            J.idVis, 
            E.idTim, 
            E.idAca,
            E.idEve,
            tempo, 
            (SELECT Jgd.apelido FROM jogador Jgd WHERE E.idJgd=Jgd.idJgd) jogador, 
            (SELECT M.apelido FROM times M WHERE J.idMan=M.idTim) man, 
            (SELECT V.apelido FROM times V WHERE J.idVis=V.idTim) vis, 
            (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idMan AND E.idAca=1 AND E.idJgd>0) +
            (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idVis AND E.idAca=5 AND E.idJgd>0) golM, 

            (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idVis AND E.idAca=1 AND E.idJgd>0) +
            (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idMan AND E.idAca=5 AND E.idJgd>0) golV
        FROM 
            evento E 
        INNER JOIN 
            jogo J 
        ON 
            E.idJog=J.idJog 
        WHERE 
            E.idJog=$_GET[j] AND E.idJgd>0
    ") or die(mysql_error().' na linha '.__LINE__);
    $resultJog = mysql_query("SELECT 
            J.idJog, 
            (SELECT M.apelido FROM times M WHERE J.idMan=M.idTim) man, 
            (SELECT V.apelido FROM times V WHERE J.idVis=V.idTim) vis,
            (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idMan AND E.idAca=1 AND E.idJgd>0) +
            (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idVis AND E.idAca=5 AND E.idJgd>0) golM, 

            (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idVis AND E.idAca=1 AND E.idJgd>0) +
            (SELECT COUNT(E.idAca) FROM evento E WHERE E.idJog=J.idJog AND E.idTim=J.idMan AND E.idAca=5 AND E.idJgd>0) golV,
            (SELECT L.nome FROM estadio L WHERE J.idEst=L.idEst) estadio, 
            rodada, 
            turno, 
            temporada, 
            divisao 
        FROM 
            jogo J 
        WHERE 
            J.idJog=$_GET[j] 
        ORDER BY 
            temporada
    ") 
    or die(mysql_error().' na linha '.__LINE__);


        $rowJog = mysql_fetch_array($resultJog);
		$rowCou = mysql_fetch_array(mysql_query("SELECT COUNT(*) as jogo FROM `jogo` WHERE idJog<=$rowJog[idJog]"));
		// AND temporada=$rowJog[temporada] AND divisao=$rowJog[divisao]
		$rowCTt = mysql_fetch_array(mysql_query("SELECT COUNT(*) as jogo FROM `jogo` ORDER BY idJog DESC"));
    ?>
<h1>
<?php 
	$jogo = str_pad($rowCou['jogo'],strlen($rowCTt['jogo']),'0', STR_PAD_LEFT);
    echo "
    $rowJog[divisao]ª DIVISÃO / 
    TEMPORADA $rowJog[temporada]<br>
    $rowJog[estadio]<br>
    $rowJog[rodada]ª rodada do $rowJog[turno]º turno<br>
	JOGO $jogo
    ";
?>

</h1>
<br />
<a href="ad_time.php">ADICIONAR TIME</a>
<div class="formulario"  style="width: 100%;">


      
    <table class="listagem" width="100%" border="0" cellpadding="3" cellspacing="0">
        <tr>
        <td width="5%" class="t_campo">TEMPO</td>
        <td width="20%" class="t_campo">MANDANTE</td>
        <td width="15%" class="t_campo">RESULTADO</td>
        <td width="20%" class="t_campo">VISITANTE</td>
        </tr>
    
        <?php
        // Listagem
        echo "    <tr>
            <td> &nbsp; </td>
            <td> $rowJog[man] </td>
            <td> $rowJog[golM]x$rowJog[golV] </td>
            <td valign=\"top\"> $rowJog[vis] </td>
            </tr>
            <tr><td><br></td></tr>";
        while($row = mysql_fetch_array($result)){
			
            switch ($row['idAca']) {
                case 1:
                    $classe = 'gol';
                    break;
                case 2:
                    $classe = 'amarelo';
                    break;
                case 3:
                    $classe = 'vermelho';
                    break;
                case 4:
                    $classe = 'contusao';
                    break;
                case 5:

                    $classe = 'contra';
                    break;
            }
            if ($row['idAca'] == 5) {
                if($row['idTim']==$row['idMan']){
                    $row['idTim'] = $row['idVis'];
                }elseif($row['idTim']==$row['idVis']){
                    $row['idTim'] = $row['idMan'];
                }
            }

            // Tratando dados
            if($row['idTim']==$row['idMan']){
                echo "    <tr>
                        <td> $row[tempo] </td>
                        <td>  $row[jogador] <p class='evento $classe'></p></td>
                        <td> &nbsp; </td>
                        <td> &nbsp; </td>
                        </tr>";
            }elseif($row['idTim']==$row['idVis']){
                echo "    <tr>
                        <td> $row[tempo] </td>
                        <td> &nbsp; </td>
                        <td> &nbsp; </td>
                        <td> <p class='evento $classe'></p>  $row[jogador] </td>
                        </tr>";
            }
        }

        ?> 	
    
    </table>


    
    
    
    
    
    
<!-- CONTEÚDO ACIMA -->
</div>
<?php include '../../include/painel/rodape.php' ?>