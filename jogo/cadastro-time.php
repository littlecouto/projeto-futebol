<?php
session_start();
include_once 'include/classes/funcoes.php';
include_once 'include/php/config.php';
$admin = new admin;
$admin->verLogin();

$idUsu = $_SESSION['USUARIO_JOGO_LOGADO']['ID'];

if($_POST['ACAO']=='CONTINUAR'){
	
	$debug = new debug;
	$debug->pre($_POST);
	
	if($_POST['time'] <0){
		echo alert('Escolha um time', '', '-1');
		exit;
	}else{
		
		$time = addslashes($_POST['time']);
		
		
		$gravou = mysql_query("INSERT INTO jogo_tecnico_time(idTec, idTim)VALUES('$plano', '$idUsu', '$vigini', '$vigfim', '$valor')") or die(mysql_query());
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
<link href="include/css/cadastro-time.css" rel="stylesheet">
<link rel="stylesheet" href="include/css/cores.php">
<link rel="stylesheet" href="include/js/chosen/chosen.css">
<link rel="shortcut icon" type="image/png" href="<?=$URLSEG.$UrlFavicon?>/favicon-seg.png">
</head>

<body>

<div id="tudo">
		<?php 
			$sqlPla = mysql_query("SELECT inicio_campeonato idPai FROM jogo_plano A INNER JOIN jogo_plano_usuario B ON A.idPla=B.idPla WHERE idUsu='$idUsu' AND vigencia_fim<CURRENT_TIMESTAMP ORDER BY datacon") or die(mysql_error());
			$rowPla = mysql_fetch_array($sqlPla);
			$idPai = $rowPla['idPai'];
			$filPai = $idPai != 0? " AND A.idPai='$idPai'": '';
			$filTim = $idPai != 0? " AND idPai='$idPai'": '';
	
			$rowPaiUsu = mysql_fetch_array(mysql_query("SELECT idPai FROM jogo_usuario WHERE idUsu='$idUsu'"));
			$idPaiUsu = $rowPaiUsu['idPai'];

			$qtdTim = mysql_num_rows(mysql_query("SELECT idTim, apelido FROM time WHERE idPai='$idPaiUsu' AND ativo=1"));
			$divisoes = ceil($qtdTim/20);
	
			
		?>
    <form onSubmit="return false">
        <div class="pais">
        	<input type="search" id="pesquisa" placeholder="Pesquisar time">
        	<select name="pais">
            	<?php
				
                	$resPais = mysql_query("SELECT A.idPai, A.titulo FROM pais A INNER JOIN time B ON A.idPai=B.idPai WHERE A.ativo=1 $filPai GROUP BY A.idPai ORDER BY A.titulo") or die(mysql_error());
					while($rowPais = mysql_fetch_array($resPais)){
						$paiQtd = mysql_num_rows(mysql_query("SELECT 1 FROM time WHERE idPai='$rowPais[idPai]' AND ativo=1"));
						$paiDiv= ceil($paiQtd/20);
						
						echo "<option value=\"$rowPais[idPai],$paiDiv\"".($rowPais['idPai'] == $idPaiUsu? 'selected': '').">$rowPais[titulo]</option>";
					}
				?>
            </select>

            <select name="divisao" data-placeholder="DIVIS&Atilde;O">
                <?php 
                
                    for($divisao = 1; $divisao<=$divisoes; $divisao++){
                        echo "<option value='$divisao' ".($divisao==$_GET['divisao']? 'selected': '').">$divisao</option>";
                    }
                ?>
            </select>
            
        </div>
	</form>
    <form name="cadastro-time" action="" method="post">
        <div class="times">
        	<?php
				
				$resTim = mysql_query("SELECT idPai, idTim, apelido, divisao, escudo FROM time WHERE ativo=1 $filTim ORDER BY apelido") or die(mysql_error());
				while($rowTim = mysql_fetch_array($resTim)){
					$escudo = $rowTim['escudo'];
					
					if(file_exists("$DirTime$escudo.png")){
						$escudo = "$UrlTime$escudo.png";
					}else{
						$escudo = "include/img/padrao.png";
					}
					
					$classe = ($rowTim['idPai'] == $idPaiUsu and $rowTim['divisao'] == 1)? 'ativo': 'inativo';
					echo "<label><input type=\"radio\" name=\"time\" value=\"$rowTim[idTim]\">";
					echo "<div class=\"time $classe\" data-pais=\"$rowTim[idPai]\" data-nome=\"$rowTim[apelido]\" data-divisao=\"$rowTim[divisao]\">";
					echo "<div class=\"escudo\"><img src=\"$escudo\" width=\"120\"></div>";
					echo "<p class=\"titulo\">$rowTim[apelido]</p>";
					echo "<p class=\"subtitulo\">$rowTim[apelido]</p>";
					echo "</div>";
					echo "</label>";
				}
			?>
	    </div>
        <input type="submit" name="ACAO" value="CONTINUAR">
</form>

</div>
<script src="include/js/jquery-2.1.4.js"></script>
<script src="include/js/chosen/chosen.jquery.js"></script>
<script>
	
	function limpa_string(str){
	
		// the characters i'm looking for in a string:
		var charList = ["À","Á","Â","Ã","Ä","Å","Æ","Ç","È","É","Ê","Ë","Ì","Í","Î","Ï","Ð","Ñ","Ò","Ó","Ô","Õ","Ö","Ø","Ù","Ú","Û","Ü","Ý","Þ","ß","à","á","â","ã","ä","å","æ","ç","è","é","ê","ë","ì","í","î","ï","ð","ñ","ò","ó","ô","õ","ö","ø","ù","ú","û","ý","ý","þ","ÿ","º","ª"];
	
		// the characters i'd like to replace them with:
		var replaceList = ["a","a","a","a","a","a","a","c","e","e","e","e","i","i","i","i","d","n","o","o","o","o","o","o","u","u","u","u","y","b","s","a","a","a","a","a","a","a","c","e","e","e","e","i","i","i","i","d","n","o","o","o","o","o","o","u","u","u","y","y","b","y","o","a"];
	
		var limit = str.length;
		for (i = 0; i < limit; i++){
			for(var j in charList){
				if (str.charAt(i) === charList[j])
					str = str.replace(str.charAt(i), replaceList[j]);
			}
		}
	
		return str;
	}
	$.expr[":"].contains = $.expr.createPseudo(function(arg) {
		return function( elem ) {
			return $(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
		};
	});	
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
	$('input#pesquisa').on('keydown, keypress, keyup', function(){
		valor = $(this).val();
        idPai = $('.pais select').val();
		
		
		$('.time').removeClass('ativo').addClass('inativo');
		if(valor != ''){
			
			$(".time:contains('"+valor+"')").each(function() {
				este = $(this);
				/*este_nome = este.find('p.titulo')
				este_data_nome = este.attr('data-nome')
				este_nome_mask = este.find('.subtitulo');
				este_nome.html(este_data_nome);
				este_nome_html = este_nome.html()
				place = '';				
				for(is = 1; is<=valor.length; is++){
					place += '&nbsp;';
				}
				resto = '';
				for(ie = 1; ie<=este_nome_html.length-valor.length; ie++){
					resto += '&nbsp;';
				}

				este_nome_under = "<font>"+place+"</font>";

					
				este_nome_mask.html(este_nome_under+resto)*/
				
                este.removeClass('inativo').addClass('ativo');
            });
			
			
		}else{
			$(".time").each(function() {
				este = $(this);
				/*este_nome = este.find('p.titulo')
				este_data_nome = este_nome.attr('data-nome')
				este_nome.html(este_data_nome);*/
				
                este.removeClass('ativo').addClass('inativo');
            });
			
			$('.time[data-pais='+idPai+']').removeClass('inativo').addClass('ativo');
		}
		
	})
	$('.pais select[name=pais]').change(function(e) {
		valores = $(this).val()
		valores = valores.split(',');
		
        idPai 	= valores[0];
        qtdDiv 	= valores[1];
		
		selectOpt = '';
		
		for(q = 1; q<=qtdDiv; q++){
			selectOpt += '<option value="'+q+'">'+q+'</option>';
		}
		
		$('.pais select[name=divisao]').html(selectOpt)
		
		$('.time').removeClass('ativo').addClass('inativo');
		$('.time[data-pais='+idPai+']').removeClass('inativo').addClass('ativo');
		
    });

	$('.pais select[name=divisao]').change(function(e) {
        divisao = $(this).val();
		
		$('.time').removeClass('ativo').addClass('inativo');
		$('.time[data-divisao='+divisao+']').removeClass('inativo').addClass('ativo');
    });

</script>
</body>
</html>
