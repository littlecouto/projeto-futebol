<?php
// Classe
require 'lib/phpmailer/class.phpmailer.php';


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
//$mail->Port     = $PORTA;
//$mail->IsMail(true); // Para hotmail

?>