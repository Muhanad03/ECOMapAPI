<?php
$to = "mohandhatem011@gmail.com";
$subject = "Activate your account";
$message = "Click the link below to activate your account:\r\n";
$message .= "hello";
$headers = "From: yourname@example.com\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

// Send email
if (mail($to, $subject, $message, $headers)) {
    echo "Activation email sent successfully.";
} else {
    echo "Failed to send activation email.";
}
?>