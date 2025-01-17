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
function validateEmails($email_str)
{
    // Split the string by commas
    $emails = array_map('trim', explode(',', $email_str));

    // Validate each email
    foreach ($emails as $email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false; // Return false if any email is invalid
        }
    }
    return true; // Return true if all emails are valid
}

function handleSendEmail($from, $email_str = "", $template_path = "", $data = [], $subject = "", $reply_to = "")
{
    // Validate 'from' email
    if (isset($from) && gettype($from) === "string") {
        $from .= "@margriehunt.com";
    } else {
        throw new Error("Invalid 'from' email address domain provided");
    }

    // Validate 'from' email
    if (!validateEmails($from)) {
        throw new Error("Invalid 'from' email address");
    }

    // Validate recipient email
    $emails = array_map('trim', explode(',', $email_str));
    foreach ($emails as $email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Error("Invalid recipient email address: $email");
        }
    }

    // Validate 'reply-to' email if provided
    if ($reply_to && !filter_var($reply_to, FILTER_VALIDATE_EMAIL)) {
        throw new Error("Invalid 'reply-to' email address");
    }

    // Load and prepare email template
    $template_path = __DIR__ . "/emails/" . $template_path;
    if (!file_exists($template_path)) {
        throw new Error("Email template file not found: $template_path");
    }

    $email_body = file_get_contents($template_path);

    // Replace placeholders with actual data
    foreach ($data as $key => $value) {
        $email_body = str_replace("{{{$key}}}", htmlspecialchars($value, ENT_QUOTES, 'UTF-8'), $email_body);
    }

    // Prepare headers
    $headers  = "From: {$from}\r\n";
    if (strlen($reply_to) > 0) {
        $headers .= "Reply-To: $reply_to\r\n";
    }
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";

    // Send email to each recipient
    foreach ($emails as $email) {
        if (!mail($email, $subject, $email_body, $headers)) {
            error_log("Failed to send email to $email");
        }
    }

    return true; // Return true if all emails are processed
}
