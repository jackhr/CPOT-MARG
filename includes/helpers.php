<?php


function generateRandomKey($length = 24)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $key = '';
    for ($i = 0; $i < $length; $i++) {
        $key .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $key;
}

function handleSendEmail($from, $email_str = "", $body = "", $subject="", $reply_to = "")
{
    if (!isset($from)) {
        throw new Error("No from has been applied");
    }
    $headers  = "From: {$from}@margriehunt.com\r\n";
    if (strlen($reply_to) > 0) $headers .= "Reply-To: $reply_to\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";

    return mail($email_str, $subject, $body, $headers);
}