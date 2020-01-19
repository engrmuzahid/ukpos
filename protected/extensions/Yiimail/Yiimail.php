<?php

require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'PHPMailerAutoload.php';
function Yiimail() {

    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->SMTPDebug = 3;
    $mail->Debugoutput = 'html';
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 465;
    $mail->SMTPSecure = 'ssl';
    $mail->SMTPAuth = true;
    $mail->Username = "sylhetpos@gmail.com";
    $mail->Password = "Think140";
    $mail->setFrom("sylhetpos@gmail.com", Yii::app()->params['adminName']);
    //$mail->addReplyTo("do-not-reply@sylhetshop.com", Yii::app()->params['adminName']);

    return $mail;
}
