<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $message = $_POST['message'] ?? '';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<div class="alert alert-danger">Correo inválido.</div>';
        exit;
    }

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'mailer.wit@gmail.com'; // Reemplaza con tu email
        $mail->Password = 'qzyuwykitiekjsku'; // Usa una contraseña segura o App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('mailer.wit@gmail.com', 'FinConsul');
        $mail->addAddress('dgonzalez@wit.la');
        $mail->addReplyTo($email, $name);

        $mail->isHTML(true);
        $mail->Subject = 'Nuevo mensaje de contacto';
        $mail->Body = "<strong>Nombre:</strong> $name<br><strong>Correo:</strong> $email<br><strong>Mensaje:</strong><br>$message";

        $mail->send();
        
        // Respuesta de agradecimiento
        $mail->clearAddresses();
        $mail->addAddress($email);
        $mail->Subject = 'Gracias por contactarnos';
        $mail->Body = "Gracias $name por tu mensaje. Nos pondremos en contacto contigo pronto.";
        $mail->send();

        echo '<div class="alert alert-success">Mensaje enviado correctamente.</div>';
    } catch (Exception $e) {
        echo '<div class="alert alert-danger">Error: ' . $mail->ErrorInfo . '</div>';

    }
}
