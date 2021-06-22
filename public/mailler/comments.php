<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$email = $_GET['email'];
$name = $_GET['name'];
$comments = $_GET['comments'];


require 'vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'ampipmailofficial@gmail.com';                     //SMTP username
    $mail->Password   = 'ekggocpkpvlgpnkz';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 465;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $mail->setFrom('ampipmailofficial@gmail.com', 'AMPIP');
    $mail->addAddress($email, $name);     //Add a recipient


    //Attachments


    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'AMPIP';
    $mail->Body    = $comments;
    $mail->AltBody = 'No reply';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {   echo "------------------------------------------------->: {$mail->ErrorInfo}<-----------------------------------------------------------"; }

?>
