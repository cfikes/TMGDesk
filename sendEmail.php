<?php
function sendEmail($to,$subject,$body,$altBody){
    include 'globalSettings.php';
    require_once 'PHPMailerAutoload.php';
    
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->Host = $setting['SMTPServer'];
    $mail->SMTPAuth = true;
    $mail->Username = $setting['SMTPUsername'];
    $mail->Password = $setting['SMTPPassword'];
    $mail->SMTPSecure = $setting['SMTPSecurity'];
    $mail->Port = $setting['SMTPPort'];

    $mail->From = $setting['SMTPUsername'];
    $mail->FromName = 'Technicial Support';
    $mail->addAddress($to);

    $mail->isHTML(true);

    $mail->Subject = $subject;
    $mail->Body    = $body;
    $mail->AltBody = $altBody;

    if(!$mail->send()) {
       $message = "Not Sent";
       return($message);
    } else {
       $message = "Sent";
       return($message);
    }
}