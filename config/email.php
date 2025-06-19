<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../includes/phpmailer/Exception.php';
require_once __DIR__ . '/../includes/phpmailer/PHPMailer.php';
require_once __DIR__ . '/../includes/phpmailer/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $emailCliente = $_POST['email'] ?? '';  

    // Validar email básico
    if (filter_var($emailCliente, FILTER_VALIDATE_EMAIL)) {
        try {
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
            $mail->addAddress($emailCliente);  // acá va el email recibido del formulario

            // Asunto y cuerpo
            $mail->Subject = 'Confirmación de tu reserva';
            $mail->Body = '<h1>Gracias por reservar con nosotros</h1><p>Tu reserva ha sido confirmada. ¡Te esperamos!</p>';

            $mail->send();
            echo "Correo de confirmación enviado a $emailCliente";
        } catch (Exception $e) {
            echo "Error al enviar el correo: {$mail->ErrorInfo}";
        }
    } else {
        echo "Email inválido";
    }
} else {
    echo "Acceso no permitido";
}
