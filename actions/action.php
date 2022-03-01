<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

$mail = new PHPMailer(true);

if($_POST["name"] and $_POST["email"] and $_POST["tel"] and $_POST["textmessage"]) {
    $content_name = $_POST["name"];
    $content_email = $_POST["email"];
    $content_tel = $_POST["tel"];
    $content_textmessage = $_POST["textmessage"];
}
if($_POST["city"]) {
    $content_city = $_POST["city"];
}
if($_POST["zip"]) {
    $content_zip = $_POST["zip"];
}

$content_body = '<b>Přišla nová zpráva:</b><br>
                Poptávající: ' .$content_name.'<br>
                Telefon: '.$content_tel.'<br>
                Text zprávy:<br><br>'.$content_textmessage.'<br>
                <img src="https://raw.githubusercontent.com/MarvelousMartin/bachelor-thesis/master/assets/images/logo.png">';

try {
    $mail->CharSet = 'UTF-8';
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'yda44277@gmail.com'; /** dočasný e-mail */
    $mail->Password = 'm3extM3HNbTB3mT9qnyMVR4FstBs4orTRjBvxCw6';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    $mail->setFrom('yda44277@gmail.com', 'Poptávka z webu jirfa.cz');
    $mail->addAddress($content_email);
    $mail->addReplyTo($content_email);


    $mail->isHTML(true);
    $mail->Subject = 'JIRFA s.r.o. - Poptávka';
    $mail->Body = $content_body;

    $mail->send();
    echo 'Zpráva poslána!';
}

catch (Exception $e) {
    echo 'Nepodařilo se poslat e-mail. Chyba: ', $mail->ErrorInfo;
}
