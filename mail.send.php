<?php

// CONFIG

$EMPRESA 	= 'DIVERNET';
$EMAIL 		= 'contato@divernet.com.br';
$SENHA 		= 'diver2015';
$SMTP 		= 'smtp.divernet.com.br';
$PORTA 		= '587';


// Classe
require("include/contato/phpmailer/class.phpmailer.php");

	
//CONFIGURAÇÕES PARA ENVIO
$mail = new PHPMailer();
$mail->IsSMTP(); // Define que a mensagem será SMTP
$mail->Host 	= $SMTP; // Endereço do servidor SMTP
$mail->Port     = $PORTA;
$mail->SMTPAuth = true; // Usa autenticação SMTP? (opcional)
$mail->Username = $EMAIL; // Usuário do servidor SMTP
$mail->Password = $SENHA; // Senha do servidor SMTP
$mail->IsHTML(true); // Define que o e-mail será enviado como HTML
$mail->IsMail(true); // Para hotmail
$mail->CharSet = 'iso-8859-1'; // Charset da mensagem (opcional)

?>