<?php
// Classe
require 'lib/phpmailer/class.phpmailer.php';


//CONFIGURA��ES PARA ENVIO

$mail = new PHPMailer();

$mail->IsSMTP(); // Define que a mensagem ser� SMTP

$mail->Host = $SMTP; // Endere�o do servidor SMTP (caso queira utilizar a autentica��o, utilize o host smtp.seudom�nio.com.br)
$mail->SMTPAuth = true; // Usar autentica��o SMTP (obrigat�rio para smtp.seudom�nio.com.br)
$mail->Username = $EMAIL; // Usu�rio do servidor SMTP (endere�o de email)
$mail->Password = $SENHA; // Senha do servidor SMTP (senha do email usado)
$mail->Port     = $PORTA;
$mail->IsHTML(true); // Define que o e-mail ser� enviado como HTML
$mail->CharSet = 'iso-8859-1'; // Charset da mensagem (opcional)
//$mail->Port     = $PORTA;
//$mail->IsMail(true); // Para hotmail

?>