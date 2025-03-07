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
    if ($data['action'] === "get_all") {
        $res = [
            "status" => 200,
            "message" => "Successfully fetched items",
            "data" => [],
        ];

        try {
            // Fetch data
            $stmt = $pdo->prepare(
                "SELECT shop_items.*, shop_item_images.image_url
                    FROM shop_items
                    LEFT JOIN shop_item_images ON shop_items.primary_image_id = shop_item_images.image_id
                ORDER BY shop_items.name;"
            );
            $stmt->execute();
            $res['data'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $res['status'] = 500;
            $res['message'] = $e->getMessage();
        }
    } else if ($data['action'] === "get_more") {
        $page = isset($data['page']) ? (int)$data['page'] : 0;
        $itemsPerPage = 6;
        $offset = $page * $itemsPerPage;

        $res = [
            "status" => 200,
            "message" => "Successfully fetched items",
            "data" => [],
            "pagination" => [
                "current_page" => $page + 1,
                "per_page" => $itemsPerPage,
                "total_items" => null,
                "total_pages" => null
            ]
        ];

        try {
            // Fetch data
            $stmt = $pdo->prepare(
                "SELECT shop_items.*, shop_item_images.image_url
                    FROM shop_items
                    LEFT JOIN shop_item_images ON shop_items.primary_image_id = shop_item_images.image_id
                ORDER BY shop_items.name
                LIMIT :limit
                OFFSET :offset;"
            );
            $stmt->bindValue(':limit', (int) $itemsPerPage, PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
            $stmt->execute();
            $res['data'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Fetch total items count
            $count_query = "SELECT COUNT(*) FROM shop_items WHERE status <> :status";
            $count_stmt = $pdo->prepare($count_query);
            $count_stmt->execute(['status' => 'archived']);
            $total_items = $count_stmt->fetchColumn();

            // Add pagination metadata
            $res['pagination']['total_items'] = (int)$total_items;
            $res['pagination']['total_pages'] = (int)ceil($total_items / $itemsPerPage);
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
