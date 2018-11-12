<?php
session_start();
include_once 'include/classes/funcoes.php';
include_once 'include/php/config.php';
$admin = new admin;
$admin->verLogin();


if($_POST['ACAO']=='CONTINUAR'){
	
	$debug = new debug;
	//$debug->pre($_POST, 3);
	
	if($_POST['plano'] <0){
		echo alert('Escolha um plano', '', '-1');
		exit;
	}else{
		
		$plano = addslashes($_POST['plano']);
		$idUsu = $_SESSION['USUARIO_JOGO_LOGADO']['ID'];
		
		$rowPla = mysql_fetch_array(mysql_query("SELECT qtd_dia, valor FROM jogo_plano WHERE idPla='$plano'"));
		$qtd_dia = $rowPla['qtd_dia'];
		$valor	 = $rowPla['valor'];
		
		$vigini = date("Y-m-d H:i:s");
		$vigfim = date("Y-m-d H:i:s", strtotime($vigini." +$qtd_dia days"));
		
		$gravou = mysql_query("INSERT INTO jogo_plano_usuario(idPla, idUsu, vigencia_ini, vigencia_fim, valor)VALUES('$plano', '$idUsu', '$vigini', '$vigfim', '$valor')") or die(mysql_query());
		if($gravou){
			mysql_query("UPDATE jogo_usuario SET primeiro_acesso='0' WHERE idUsu='$idUsu'") or die(mysql_query());
	
			header("Location: cadastro-time");
		}
		
		
		
	}
	
}

?>

<!doctype html>
<html>
<head>
<meta charset="iso-8859-1">
<title><?=$title?></title>
<link rel="stylesheet" href="include/css/cadastro.css">
<link href="include/css/cadastro-planos.css" rel="stylesheet">
<link rel="stylesheet" href="include/css/cores.php">
<link rel="stylesheet" href="include/js/chosen/chosen.css">
<link rel="shortcut icon" type="image/png" href="<?=$URLSEG.$UrlFavicon?>/favicon-seg.png">
</head>

<body>

<div id="tudo">
<form action="" method="post">
        <div class="planos">
        	<h1>PLANOS</h1>
        	<?php
				$resPla = mysql_query("SELECT idPla, titulo, limite_campeonato, qtd_campeonato, inicio_campeonato, limite_divisao, qtd_divisao, inicio_divisao, limite_tecnico, limite_time, qtd_time, qtd_tecnico, valor, qtd_dia, desconto_mensal FROM jogo_plano WHERE disponivel=1 AND ativo=1 ORDER BY valor DESC") or die(mysql_error());

				$planoAtu = 0;
            	while($rowPla = mysql_fetch_array($resPla)){
					$planoAtu++;
					$idPla 		= $rowPla['idPla'];
					$titulo 	= $rowPla['titulo'];

					$camp_lmt 	= $rowPla['limite_campeonato'];
					$camp_qtd 	= $rowPla['qtd_campeonato'];
					$camp_ini 	= $rowPla['inicio_campeonato'];

					$divi_lmt 	= $rowPla['limite_divisao'];
					$divi_qtd 	= $rowPla['qtd_divisao'];
					$divi_ini 	= $rowPla['inicio_divisao'];

					$tecn_lmt 	= $rowPla['limite_tecnico'];
					$tecn_qtd 	= $rowPla['qtd_tecnico'];

					$time_lmt 	= $rowPla['limite_time'];
					$time_qtd 	= $rowPla['qtd_time'];

					$valor 		= $rowPla['valor'];
					$qtd_dia 	= $rowPla['qtd_dia'];
					$desconto 	= $rowPla['desconto_mensal'];
					
					if((int)$valor == 0){
						$valor_final = "<span class=\"preco\">Gr&aacute;tis</span>";
					}else{
						$valor = number_format($valor, 2, ',', '.');
						
						$qtd_dias = round($qtd_dia/30);
						$valor_desc = '';
						if($qtd_dias >1){
							$valor_sdesc = $valor;
							$desconto /= 100;
							
							
							
							$valor 		= $valor_sdesc-($valor_sdesc*$desconto);
							$valor_desc = "$desconto&permil; de desconto";
							
						}
						
						switch($qtd_dias){
							case 1 : $duracao = 'mensal'; break;
							case 2 : $duracao = 'bimestral'; break;
							case 3 : $duracao = 'trimestral'; break;
							case 6 : $duracao = 'semestral'; break;
							case 6 : $duracao = 'semestral'; break;
							case 12 : $duracao = 'anual'; break;
						}
						
						$valor_final = "<span class=\"preco\">R$ $valor </span>para contrata&ccedil;&atilde;o $duracao. <span class=\"desconto\">$valor_desc</span>";
						
						
					}
					
					$info = '';
					if($camp_lmt){
						$palavra = $camp_qtd >1 ?'campeonatos':'campeonato';

						$rowPai = mysql_fetch_array(mysql_query("SELECT titulo FROM pais WHERE idPai='$camp_ini'"));
						$pais   = $rowPai['titulo'];
						if($camp_ini){
							$inicio = "Come&ccedil;ando no $pais.";
						}else{
							$inicio = "Come&ccedil;ando no pa&iacute;s de sua prefer&ecirc;ncia.";
						}
						$info .= "<li class=\"value\">Podendo jogar apenas em $camp_qtd $palavra. $inicio</li>";
					}else{
						$info .= "<li class=\"value\">Sem limites de campeonatos. $inicio</li>";
					}
					if($divi_lmt){
						$palavra = $divi_qtd >1 ?'divis&otilde;es':'divis&atilde;o';
						$info .= "<li class=\"value\">Podendo jogar apenas em $divi_qtd $palavra. Come&ccedil;ando na $divi_ini&ordf; divis&atilde;o.</li>";
					}else{
						$info .= "<li class=\"value\">Sem limites de divis&otilde;es. Come&ccedil;ando na divis&atilde;o de sua prefer&ecirc;ncia.</li>";
					}

					if($tecn_lmt){
						$palavra = $tecn_qtd >1 ?'t&eacute;cnicos':'t&eacute;cnico';
						$info .= "<li class=\"value\">Podendo jogar apenas com $tecn_qtd $palavra.</li>";
					}else{
						$info .= "<li class=\"value\">Sem limites de t&eacute;cnicos.</li>";
					}

					if($time_lmt){
						$palavra = $time_qtd >1 ?'novos times':'novo time';
						
						if($time_qtd==0){
							$info .= "<li class=\"value\">Sem possibilidades de criar $palavra.</li>";
						}else{
							$info .= "<li class=\"value\">Podendo criar at&eacute; $time_qtd $palavra.</li>";
						}
						
					}else{
						$info .= "<li class=\"value\">Pode criar quantos times quiser.</li>";
					}
					
					echo "
					<input type=\"radio\" id=\"plano$idPla\" ".($planoAtu==1?'checked':'')." name=\"plano\" value=\"$idPla\" style=\"display: none;\">
					<label for=\"plano$idPla\">
					<div class=\"plano\">
						<p class=\"h1\">$titulo</p>
						<ul class=\"info\">
							$info
						</ul>
						<p class=\"valor\"> $valor_final</p>
					</div>
					</label>";
				}
			
			?>
	    </div>
        <input type="submit" name="ACAO" value="CONTINUAR">
</form>

</div>
<script src="include/js/jquery-2.1.4.js"></script>
<script src="include/js/chosen/chosen.jquery.js"></script>
<script>
	
	$(document).ready(function(){
		tudo = $('#tudo');
		
		width = tudo.outerWidth();
		marginL = Math.ceil(width/2);

		height = tudo.outerHeight();
		marginT = Math.ceil(height/2);
		
		tudo.css({'margin-left': '-'+marginL+'px', 'margin-top': '-'+marginT+'px'});
	})
	$(window).resize(function(){
		tudo = $('#tudo');
		
		width = tudo.outerWidth();
		marginL = Math.ceil(width/2);

		height = tudo.outerHeight();
		marginT = Math.ceil(height/2);
		
		tudo.css({'margin-left': '-'+marginL+'px', 'margin-top': '-'+marginT+'px'});
	})
</script>
</body>
</html>
