<?php
session_start();
include_once 'include/classes/funcoes.php';
include_once 'include/php/config.php';

$admin = new admin;
if($_POST['ACAO']=='CADASTRAR'){
	$debug = new debug;
	//$debug->pre($_POST, 2);
	
	
	if($_POST['nome'] == ''){
		echo alert('Informe seu nome completo', '', '-1');
		exit;
	}elseif($_POST['pais'] <1){
		echo alert('Informe sua nacionalidade', '', '-1');
		exit;
	}elseif($_POST['email'] == '' or !email($_POST['email'])){
		echo alert('Informe um e-mail válido', '', '-1');
		exit;
	}elseif($_POST['usuario'] == ''){
		echo alert('Informe seu usuário', '', '-1');
		exit;
	}elseif($_POST['senha'] == '' or strlen($_POST['senha'])<6){
		echo alert('Informe sua senha. Ela precisa ter ao menos 6 caracteres', '', '-1');
		exit;
	}elseif($_POST['senha'] != $_POST['c_senha']){
		echo alert('As senhas não conferem', '', '-1');
		exit;
	}else{
		
		$nome 		= addslashes($_POST['nome']);
		$pais 		= addslashes($_POST['pais']);
		$email 		= addslashes($_POST['email']);
		$usuario 	= addslashes($_POST['usuario']);
		$senha 		= addslashes($_POST['senha']);
		
		$l_senha	= $senha;
		$chave 		= md5($email);
		$senha 		= md5($senha);
		
		$rowUsu = mysql_fetch_array(mysql_query("SELECT idUsu FROM jogo_usuario WHERE email='$email' OR usuario='$usuario'"));
		if($rowUsu['idUsu']>0){
			echo alert('Este email/usuário já está cadastrado', '', '-1');
			exit;
		}else{
			
			$filtro = array(' ' => '-' , '(' => '', ')' => '', '.' => '', ',' => '', '/' => '', ':' => '', '^' => '', '~' => '', ' - ' => '', '!' => '', '@' => '', '#' => '', '$' => '', '%' => '', '¨' => '', '&' => 'e', '*' => '', '_' => '-', '+' => '', '=' => '', '[' => '', '{' => '', '}' => '', ']' => '', 'ª' => 'a', 'º' => 'o', '¹' => '1', '²' => '2', '³' => '3', ';' => '', '"' => '', "'" => '', '¬' => '');
			$url 		= strtr($_POST['usuario'], $filtro);		// retirando os espaços
			$url 		= strtolower(limpa_string($url));
			
			$gravou = mysql_query("INSERT INTO jogo_usuario(idPai, nome, email, usuario, senha, url, chave)VALUES('$pais', '$nome', '$email', '$usuario', '$senha', '$url', '$chave')") or die(mysql_query());
			if($gravou){
				
				require 'include/classes/phpmailer/class.phpmailer.php';
				
				
				//CONFIGURAÇÕES PARA ENVIO
				
				$mail = new PHPMailer();
				
				$mail->IsSMTP(); // Define que a mensagem será SMTP
				
				$mail->Host = $SMTP; // Endereço do servidor SMTP (caso queira utilizar a autenticação, utilize o host smtp.seudomínio.com.br)
				$mail->SMTPAuth = true; // Usar autenticação SMTP (obrigatório para smtp.seudomínio.com.br)
				$mail->Username = $EMAIL; // Usuário do servidor SMTP (endereço de email)
				$mail->Password = $SENHA; // Senha do servidor SMTP (senha do email usado)
				$mail->Port     = $PORTA;
				$mail->IsHTML(true); // Define que o e-mail será enviado como HTML
				$mail->CharSet = 'iso-8859-1'; // Charset da mensagem (opcional)
				
				$rowUsu = mysql_fetch_array(mysql_query("SELECT idUsu FROM jogo_usuario ORDER BY idUsu DESC"));
				$idUsu = $rowUsu['idUsu'];
				
				$link = "$URLSITE/email-confirmacao?idUsu=$idUsu&amp;chave=$chave";
				$corpo = "
				<html>
				<body>
				
				<a href='$URLSITE'><img src='$URLSITE/include/contato/headeremails.jpg' alt='' border='0' /></a>
				
				<br />
				
				<table width='680' border='0' cellspacing='8'>
				
				<tr> <td colspan=\"2\"> Ol&aacute;, $nome. Seu cadastro no site P&ocirc;fexo Manager est&aacute; quase completo. Utilize o link abaixo para confirmar seu e-mail.</td> </tr>
				<tr> <td colspan=\"2\"><a href=\"$link\">$link</a> </td> </tr>
											
				</table>
				
				</body>
				</html>"; 

				// ENVIO BOLETO
				$mail->From 		= $EMAIL; // Remetente
				$mail->FromName 	= $EMPRESA; // Remetente nome
				$mail->AddAddress($email, $nome);	// Destinatário principal
				$mail->Subject = $EMPRESA.": $nome, confirme seu e-mail"; // Assunto da mensagem
				$mail->Body = $corpo; // corpo da mensagem
				$envioEmp = $mail->Send(); // Enviando o e-mail
				$mail->ClearAllRecipients();
				$mail->ClearAttachments();
				if(!$envioEmp){ echo $mail->ErrorInfo; exit;}

				//$admin->login($usuario, $l_senha);
			}
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
<link rel="stylesheet" href="include/css/cores.php">
<link rel="stylesheet" href="include/js/chosen/chosen.css">
<link rel="shortcut icon" type="image/png" href="<?=$URLSEG.$UrlFavicon?>/favicon-seg.png">
</head>

<body>

<div id="tudo">
<form action="" method="post">
	<h1>CADASTRO</h1>
	<p><input type="text" name="nome" data-placeholder="NOME" class="crescer" data-dica="SEU NOME COMPLETO"></p>
	<p>
        <select data-placeholder="NACIONALIDADE" name="pais" class="chosen-select">
        <option value="" selected disabled></option>
        	<?php
				$resCon = mysql_query("SELECT idCon, continente FROM continente WHERE ativo=1 ORDER BY continente") or die(mysql_error());
            	while($rowCon = mysql_fetch_array($resCon)){
					echo "<optgroup label=\"$rowCon[continente]\">";
					$resPais = mysql_query("SELECT idPai, titulo FROM pais WHERE ativo=1 AND idCon='$rowCon[idCon]' ORDER BY titulo") or die(mysql_error());
					while($rowPais = mysql_fetch_array($resPais)){
						echo "<option value=\"$rowPais[idPai]\">$rowPais[titulo]</option>";
					}
					echo "</optgroup>";
				}
			
			?>
	    </select>
    </p>

	<p><input type="email" name="email" data-placeholder="E-MAIL" class="crescer" data-dica="E-MAIL PARA CONFIRMA&Ccedil;&Atilde;O" data-regra="email@dominio.com"></p>
	<p><input type="text" name="usuario" data-placeholder="USU&Aacute;RIO" data-dica="USUÁRIO PARA LOGIN NO SITE"></p>
	<p><input type="password" name="senha" data-placeholder="SENHA" data-dica="SENHA PARA LOGIN NO SITE" data-regra="Ao menos 6 caracteres"></p>
	<p><input type="password" name="c_senha" data-placeholder="" data-dica="CONFIRME SUA SENHA"></p>
	<p><input type="submit" name="ACAO" value="CADASTRAR"></p>
</form>

</div>
<script src="include/js/jquery-2.1.4.js"></script>
<script src="include/js/chosen/chosen.jquery.js"></script>
<script>
	$(function(){
		input = $('input[data-placeholder]');
		input.each(function() {
			$(this).attr('placeholder', $(this).attr('data-placeholder'));
        });

		input = $('input[data-regra');
		input.each(function() {
			$(this).parent().append('<span data-regra="'+$(this).attr('data-regra')+'"></span>');
        });
	})
	$('input[data-dica]').on('focus',function(){
		$(this).css({'width':'400px', 'margin-left': '-100px'});
		$(this).attr('placeholder', $(this).attr('data-dica'));
	}).blur(function(){
		$(this).css({'width':'200px', 'margin-left': '0px'});
		$(this).attr('placeholder', $(this).attr('data-placeholder'));
	}).mouseout(function(e) {
		if($(this).is(':focus') == false){
			$(this).css({'width':'200px', 'margin-left': '0px'});        
			$(this).attr('placeholder', $(this).attr('data-placeholder'));
		}
    });;
	
	$("select").chosen({no_results_text: "Não encontramos", search_contains: true});
</script>
</body>
</html>
