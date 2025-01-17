<?php
session_start();

include '../../includes/env.php';
include '../../includes/helpers.php';

$debugging = isset($debugging_email_string);

if ($debugging) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

// Get the JSON data
$json = file_get_contents('php://input');
$data = json_decode($json, true);

// Check if JSON was properly decoded
if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['error' => 'Invalid JSON input']);
    exit;
}

// Sanitize input function
function sanitize_input($input)
{
    if (is_array($input)) {
        return array_map('sanitize_input', $input);
    } else {
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }
}

// Sanitize all input data
$data = sanitize_input($data);

// Validate required fields
if (empty($data['action']) || $data['action'] !== "submit_enquiry") {
    echo json_encode(['error' => 'Invalid action or action not provided']);
    exit;
}

if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['error' => 'Invalid email address']);
    exit;
}

if (empty($data['name'])) {
    echo json_encode(['error' => 'Name is required']);
    exit;
}

if (empty($data['phone']) || !preg_match('/^[0-9\-+\s()]*$/', $data['phone'])) {
    echo json_encode(['error' => 'Invalid phone number']);
    exit;
}

$data['year'] = date("Y");

// Proceed with processing
$res = [
    "status" => 200,
    "message" => "Enquiry successfully submitted",
];

$email_subject = "Contact Form at Margrie Hunt";
$from = "contact";

try {
    // Send email to the client
    $mail_res_client = handleSendEmail(
        $from,
        $data['email'],
        "$from/client.html",
        $data,
        $email_subject
    );

    // Determine admin email string
    if ($debugging) {
        $admin_email_str = $debugging_email_string;
    } elseif (isset($testing_email_string)) {
        $admin_email_str = $testing_email_string;
    } else {
        $admin_email_str = $email_string;
    }

    // Send email to admin
    $mail_res_client = handleSendEmail(
        $from,
        $admin_email_str,
        "$from/admin.html",
        $data,
        $email_subject,
        $data['email']
    );

    // Check email results and respond accordingly
    if ($mail_res_client && $mail_res_admin) {
        $res['message'] = "Enquiry successfully submitted, and emails sent.";
    } else {
        $res['message'] = "Enquiry submitted, but there was an error sending emails.";
    }
} catch (Error $e) {
    $res = [
        "status" => 400,
        "message" => $e->getMessage()
    ];
}

echo json_encode($res);
exit;
