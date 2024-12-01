<?php
session_start();

include '../../includes/connection.php';
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

// Check if action is provided
if (isset($data['action'])) {
    if ($data['action'] === "create") {
        $res = [
            "status" => 200,
            "message" => "Order created successfully",
        ];

        try {
            // Start a transaction
            $pdo->beginTransaction();

            // Create contact_info
            $stmt = $pdo->prepare("
                INSERT INTO contact_info (first_name, last_name, email, phone, address_1, town_or_city, state, country) VALUES (:first_name, :last_name, :email, :phone, :address_1, :town_or_city, :state, :country);
            ");

            // Bind contact parameters
            $stmt->bindParam(':first_name', $data['first_name']);
            $stmt->bindParam(':last_name', $data['last_name']);
            $stmt->bindParam(':email', $data['email']);
            $stmt->bindParam(':phone', $data['phone']);
            $stmt->bindParam(':address_1', $data['address_1']);
            $stmt->bindParam(':town_or_city', $data['town_or_city']);
            $stmt->bindParam(':state', $data['state']);
            $stmt->bindParam(':country', $data['country']);
            $stmt->execute();

            // Get the last inserted order ID
            $contact_id = $pdo->lastInsertId();

            // Create order
            $stmt = $pdo->prepare("
                INSERT INTO orders (contact_id, message, total_amount, current_status)
                VALUES (:contact_id, :message, :total_amount, :current_status)
            ");

            // Bind order parameters
            $stmt->bindParam(':contact_id', $contact_id);
            $stmt->bindParam(':message', $data['message']);
            $stmt->bindParam(':total_amount', $data['total_amount']);
            $stmt->bindValue(':current_status', "pending");
            $stmt->execute();

            // Get the last inserted order ID
            $order_id = $pdo->lastInsertId();

            // Create order items
            if (!empty($data['order_items']) && is_array($data['order_items'])) {
                $stmt = $pdo->prepare("
                    INSERT INTO order_items (order_id, item_type, sconce_id, cutout_id, ceramic_id, finish_option_id, cover_option_id, quantity, price, description)
                    VALUES (:order_id, :item_type, :sconce_id, :cutout_id, :ceramic_id, :finish_option_id, :cover_option_id, :quantity, :price, description)
                ");

                foreach ($data['order_items'] as $item) {
                    // Bind order item parameters
                    $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
                    $stmt->bindParam(':item_type', $item['item_type']);
                    $stmt->bindParam(':sconce_id', $item['sconce_id'], PDO::PARAM_INT);
                    $stmt->bindParam(':cutout_id', $item['cutout_id'], PDO::PARAM_INT);
                    $stmt->bindParam(':ceramic_id', $item['ceramic_id'], PDO::PARAM_INT);
                    $stmt->bindParam(':finish_option_id', $item['finish_option_id'], PDO::PARAM_INT);
                    $stmt->bindParam(':cover_option_id', $item['cover_option_id'], PDO::PARAM_INT);
                    $stmt->bindParam(':quantity', $item['quantity'], PDO::PARAM_INT);
                    $stmt->bindParam(':price', $item['price']);
                    $stmt->bindParam(':description', $item['description']);
                    $stmt->execute();
                }
            }

            // Commit transaction
            $pdo->commit();
        } catch (Exception $e) {
            // Roll back the transaction on error
            $pdo->rollBack();
            $res['status'] = 500;
            $res['message'] = $e->getMessage();
        }
    }
} else {
    $res = ['error' => 'No action provided'];
}

// header('Content-Type: application/json');
echo json_encode(isset($res) ? $res : [
    "status" => 400,
    "message" => "An unexpected error occured",
    "data" => $data
]);
