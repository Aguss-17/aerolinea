<?php
// config/email.php
require './vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

// Configuración SMTP
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'aeroluxindustry@gmail.com';
$mail->Password = 'hsbrfscjtotffpqo';
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = 587;

// Configuración general
$mail->CharSet = 'UTF-8';
$mail->isHTML(true);
$mail->setFrom('no-reply@tuaerolinea.com', 'Tu Aerolínea');