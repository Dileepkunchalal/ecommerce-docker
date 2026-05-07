<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function sendVerificationEmail($email, $token) {

    $mail = new PHPMailer(true);

    try {

        $mail->isSMTP();

        $mail->Host = 'smtp.gmail.com';

        $mail->SMTPAuth = true;

        // YOUR GMAIL
        $mail->Username = 'YOUR_GMAIL@gmail.com';

        // YOUR APP PASSWORD
        $mail->Password = 'YOUR_APP_PASSWORD';

        $mail->SMTPSecure = 'tls';

        $mail->Port = 587;

        $mail->setFrom(
            'YOUR_GMAIL@gmail.com',
            'My Store'
        );

        $mail->addAddress($email);

        $verify_link = "
        http://localhost:8080/verify.php?token=$token
        ";

        $mail->isHTML(true);

        $mail->Subject = 'Verify Your Email';

        $mail->Body = "
            <h2>Email Verification</h2>

            <p>
                Click below to verify your account:
            </p>

            <a href='$verify_link'>
                Verify Email
            </a>
        ";

        $mail->send();

        return true;

    } catch (Exception $e) {

        return false;
    }
}
?>