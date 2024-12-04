<?php
session_start();

include '../../includes/connection.php';

// Get the JSON data
$json = file_get_contents('php://input');
$data = json_decode($json, true);

// Check if JSON was properly decoded
if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['error' => 'Invalid JSON input']);
    exit;
}

if (isset($data['action'])) {
    if ($data['action'] === "get_all_cutouts") {
        $res = [
            "status" => 200,
            "message" => "Successfully fetched cutouts",
            "data" => [],
        ];

        try {
            // Fetch data
            $stmt = $pdo->prepare("SELECT * FROM cutouts WHERE deleted_at IS NULL");
            $stmt->execute();
            $res['data'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $res['status'] = 500;
            $res['message'] = $e->getMessage();
        }
    }
} else {
    $res = ['error' => 'No action provided'];
}

// header('Content-Type: application/json');
echo json_encode($res ? $res : $_POST);
