<?php 

namespace Lib;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class PHPMail{

    public function enviarCorreo(string $correo, string $asunto, string $mensaje, string $archivoPDF): void
    {
        // Variables requeridas para enviar un correo
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->SMTPDebug = SMTP::DEBUG_OFF;
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 465;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['EMAIL_DIR'];
        $mail->Password = $_ENV['EMAIL_PASS'];
        $mail->setFrom($_ENV['EMAIL_DIR'], 'All&Locker');
        $mail->addAddress($correo);
        $mail->Subject = $asunto;
        $mail->msgHTML($mensaje);

        $mail->addStringAttachment($archivoPDF, 'facturaPedido.pdf', 'base64', 'application/pdf');

        // Verificar que el correo se envíe correctamente
        if (!$mail->send()) {
            error_log('Error al enviar correo: ' . $mail->ErrorInfo);
        }
    }
}