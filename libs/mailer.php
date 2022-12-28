<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once('PHPMailer/PHPMailer.php');
require_once('PHPMailer/Exception.php');
require_once('PHPMailer/SMTP.php');

function SendEmail($to, $nameTo, $subject, $message, $altBody)
{

    $from  = "re.connect0927@gmail.com";
    $nameFrom = "Re-Connect";

    $mail = new PHPMailer(true);
    $mail->CharSet = 'UTF-8';

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = $from;
    $mail->Password = '0513Klover!';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->setFrom($from,  $nameFrom);
    $mail->addAddress($to, $nameTo);
    $mail->Subject  = $subject;
    $mail->AltBody  = $altBody;
    $mail->Body = $message;
    $mail->isHTML();

    try {
        $mail->send();
        return ['1', 'Message has been sent'];
    } catch (Exception $e) {
        return ['0', $mail->ErrorInfo];
    }
}

function SendEmailMany($address, $subject, $message, $altBody)
{

    $from  = "re.connect0927@gmail.com";
    $nameFrom = "Re-Connect";

    $mail = new PHPMailer(true);
    $mail->CharSet = 'UTF-8';

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = $from;
    $mail->Password = '0513Klover!';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->setFrom($from,  $nameFrom);

    foreach ($address as $to) {
        $mail->addAddress($to);
    }

    $mail->Subject  = $subject;
    $mail->AltBody  = $altBody;
    $mail->Body = $message;
    $mail->isHTML();

    try {
        $mail->send();
        return ['1', 'Message has been sent'];
    } catch (Exception $e) {
        return ['0', $mail->ErrorInfo];
    }
    
}