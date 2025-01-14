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
                    VALUES (:order_id, :item_type, :sconce_id, :cutout_id, :ceramic_id, :finish_option_id, :cover_option_id, :quantity, :price, :description)
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

                    // Get the last inserted order_item_id
                    $order_item_id = $pdo->lastInsertId();

                    // Insert add-ons for this order item if they exist
                    if (!empty($item['add_on_ids']) && is_array($item['add_on_ids'])) {
                        $addOnStmt = $pdo->prepare("
                            INSERT INTO order_item_add_ons (order_item_id, add_on_id, add_on_name, add_on_price)
                            SELECT :order_item_id, ao.add_on_id, ao.name, ao.price
                            FROM add_ons ao
                            WHERE ao.add_on_id = :add_on_id;
                        ");

                        foreach ($item['add_on_ids'] as $add_on_id) {
                            $addOnStmt->bindParam(':order_item_id', $order_item_id, PDO::PARAM_INT);
                            $addOnStmt->bindParam(':add_on_id', $add_on_id, PDO::PARAM_INT);
                            $addOnStmt->execute();
                        }
                    }
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

        // Check if the transaction is active (it should not be active if commit or rollback was called)
        if ($pdo->inTransaction()) {
            // This means the transaction is still open, which could indicate an issue
            $res['status'] = 500;
            $res['message'] = "Transaction was not completed successfully.";
        } else if ($res['status'] === 200) {
            // Transaction was successful
            // Now need to generate a better formatted email body
            $mail_res_client = handleSendEmail($data['email'], "Your order has been submitted and is now pending review!");

            // determine admin email string
            if ($debugging) {
                $admin_email_str = $debugging_email_string;
            } else if (isset($testing_email_string)) {
                $admin_email_str = $testing_email_string;
            } else {
                $admin_email_str = $email_string;
            }

            // Send email to admin
            // Now need to generate a better formatted email body
            $mail_res_admin = handleSendEmail($admin_email_str, $body = "There has been an order request made by {$data['first_name']} {$data['last_name']} on the website.", $data['email']);
        }
    }

    if ($data['action'] === "create_enquiry") {
        $res = [
            "status" => 200,
            "message" => "Enquiry for \"{$data['oak_name']}\" created successfully",
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
                INSERT INTO one_of_a_kind_enquiries (contact_id, one_of_a_kind_id, message, current_status)
                VALUES (:contact_id, :one_of_a_kind_id, :message, :current_status)
            ");

            // Bind order parameters
            $stmt->bindParam(':contact_id', $contact_id);
            $stmt->bindParam(':one_of_a_kind_id', $data['one_of_a_kind_id']);
            $stmt->bindParam(':message', $data['message']);
            $stmt->bindValue(':current_status', "pending");
            $stmt->execute();

            // Commit transaction
            $pdo->commit();
        } catch (Exception $e) {
            // Roll back the transaction on error
            $pdo->rollBack();
            $res['status'] = 500;
            $res['message'] = $e->getMessage();
        }

        // Check if the transaction is active (it should not be active if commit or rollback was called)
        if ($pdo->inTransaction()) {
            // This means the transaction is still open, which could indicate an issue
            $res['status'] = 500;
            $res['message'] = "Transaction was not completed successfully.";
        } else if ($res['status'] === 200) {
            // Transaction was successful
            // Now need to generate a better formatted email body
            $mail_res_client = handleSendEmail($data['email'], "Your One of a Kind enquiry has been submitted and is now pending review!");

            // determine admin email string
            if ($debugging) {
                $admin_email_str = $debugging_email_string;
            } else if (isset($testing_email_string)) {
                $admin_email_str = $testing_email_string;
            } else {
                $admin_email_str = $email_string;
            }

            // Send email to admin
            // Now need to generate a better formatted email body
            $mail_res_admin = handleSendEmail($admin_email_str, $body = "There has been an One of a Kind enquiry made by {$data['first_name']} {$data['last_name']} on the website.", $data['email']);
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
