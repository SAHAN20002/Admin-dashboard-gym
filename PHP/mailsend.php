<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;



function mailsend($to, $subject, $message, $headers) {
    
    require 'C:/wamp64/www/sahan/ADMIN-MAIN/vendor/autoload.php';

    
    // Create a new instance of PHPMailer
    $mail = new PHPMailer;
 try {
    // Configure the SMTP settings
    $mail->SMTPDebug = SMTP::DEBUG_OFF;  
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // Replace with your SMTP server address
    $mail->SMTPAuth = true;
    $mail->Username = 'zonef845@gmail.com'; // Replace with your SMTP username
    $mail->Password = 'acjy yyze xare izjn';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;           // Enable implicit TLS encryption
    $mail->Port = 587;   // Replace with your SMTP password
     // Replace with the appropriate port number

    // Set the email details
    $mail->setFrom('zonef845@gmail.com', 'Fitness Zone');
    $mail->addAddress($to, 'user');
    $mail->addReplyTo('sender@example.com', 'Sender Name');
    $mail->addCC('cc@example.com');
    $mail->addBCC('bcc@example.com');
    $mail->Subject = $subject;
    $mail->Body = $message;

    // Send the email
    if ($mail->send()) {
        echo "Email sent successfully.";
        return true;
    } else {
        echo "Failed to send email. Error: " . $mail->ErrorInfo;
    }
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
}
?>