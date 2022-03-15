<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT']);
$dotenv->safeLoad();

$mail = new PHPMailer(true);

if ($_POST["name"] and $_POST["email"] and $_POST["tel"] and $_POST["textmessage"]) {
    $content_name = $_POST["name"];
    $content_email = $_POST["email"];
    $content_tel = $_POST["tel"];
    $content_textMessage = $_POST["textmessage"];
}
if ($_POST["city"]) {
    $content_city = $_POST["city"];
}
if ($_POST["zip"]) {
    $content_zip = $_POST["zip"];
}

$content_body = '<b>Přišla nová zpráva:</b><br>
                Poptávající: ' . $content_name . '<br>
                Telefon: ' . $content_tel . '<br>
                Text zprávy:<br><br>' . $content_textMessage . '<br>
                <img src="https://raw.githubusercontent.com/MarvelousMartin/bachelor-thesis/master/assets/images/logo.png" alt="">';

try {
    $mail->CharSet = 'UTF-8';
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    /** dočasný e-mail */
    $mail->Username = $_ENV['EMAIL'];
    $mail->Password = $_ENV['PASSWORD'];
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    $mail->setFrom('yda44277@gmail.com', 'Poptávka z webu jirfa.cz');
    /** pro otestování funkčnosti, ve finální verzi bude přeměněno na e-mail společnosti */
    $mail->addAddress($content_email);
    $mail->addReplyTo($content_email);


    $mail->isHTML(true);
    $mail->Subject = 'JIRFA s.r.o. - Poptávka';
    $mail->Body = $content_body;

    $test = $mail->send();
    if ($test == 1) {
        var_dump(http_response_code(200));
    }
    echo 'Zpráva poslána!';
} catch (Exception $e) {
    var_dump(http_response_code(500));
    echo 'Nepodařilo se poslat e-mail. Chyba: ', $mail->ErrorInfo;
}
