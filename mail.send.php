<?php

// CONFIG

$EMPRESA 	= 'DIVERNET';
$EMAIL 		= 'contato@divernet.com.br';
$SENHA 		= 'diver2015';
$SMTP 		= 'smtp.divernet.com.br';
$PORTA 		= '587';


// Classe
require("include/contato/phpmailer/class.phpmailer.php");

	
//CONFIGURA��ES PARA ENVIO
$mail = new PHPMailer();
$mail->IsSMTP(); // Define que a mensagem ser� SMTP
$mail->Host 	= $SMTP; // Endere�o do servidor SMTP
$mail->Port     = $PORTA;
$mail->SMTPAuth = true; // Usa autentica��o SMTP? (opcional)
$mail->Username = $EMAIL; // Usu�rio do servidor SMTP
$mail->Password = $SENHA; // Senha do servidor SMTP
$mail->IsHTML(true); // Define que o e-mail ser� enviado como HTML
$mail->IsMail(true); // Para hotmail
$mail->CharSet = 'iso-8859-1'; // Charset da mensagem (opcional)

?>