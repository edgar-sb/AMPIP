<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$email = $_GET['email'];
$name = $_GET['name'];
$link = $_GET['link'];


require 'vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'moontsapp@gmail.com';                     //SMTP username
    $mail->Password   = 'GMEDVM2020';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $mail->setFrom('ampip@administracion.com', 'Ampip');
    $mail->addAddress($email, $name);     //Add a recipient
    $mail->addReplyTo('edgar.edgarroman@gmail.com', 'NUevo registro');


    //Attachments


    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Seguridad ampip';
    $mail->Body    = "Por favor ingresa a la siguiente liga para asignar una contraseña a $email <a href='http://localhost:8080/#/password?id=$link'> Aqui</a>";
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {   echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"; }

?>