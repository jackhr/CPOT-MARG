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
            "message" => "Successfully fetched portfolio items",
            "data" => [],
        ];

        try {
            // Fetch data
            $query = "SELECT items.*, images.image_url
            FROM portfolio_items items
            LEFT JOIN portfolio_item_images images ON items.primary_image_id = images.image_id
            WHERE status = :status";

            if (isset($data['artist'])) $query .= " AND artist = :artist";

            $query .= " ORDER BY items.year_created IS NULL, items.year_created, items.name";

            $stmt = $pdo->prepare($query);
            $stmt->bindValue(':status', 'active', PDO::PARAM_STR);
            if (isset($data['artist'])) {
                $stmt->bindValue(':artist', $data['artist'], PDO::PARAM_STR);
            }
            $stmt->execute();
            $res['data'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $res['status'] = 500;
            $res['message'] = $e->getMessage();
        }
    } else if ($data['action'] === "get_more") {
        $page = isset($data['page']) ? (int)$data['page'] : 0;
        $itemsPerPage = 10;
        $offset = $page * $itemsPerPage;

        $res = [
            "status" => 200,
            "message" => "Successfully fetched portfolio items",
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
            $query = "SELECT items.*, images.image_url
            FROM portfolio_items items
            LEFT JOIN portfolio_item_images images ON items.primary_image_id = images.image_id
            WHERE status = :status";

            if (isset($data['artist'])) $query .= " AND artist = :artist";

            $query .= " ORDER BY items.year_created IS NULL, items.year_created, items.name
            LIMIT :limit
            OFFSET :offset";

            $stmt = $pdo->prepare($query);
            $stmt->bindValue(':status', 'active', PDO::PARAM_STR);
            if (isset($data['artist'])) {
                $stmt->bindValue(':artist', $data['artist'], PDO::PARAM_STR);
            }
            $stmt->bindValue(':limit', $itemsPerPage, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            $res['data'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Fetch total items count
            $count_query = "SELECT COUNT(*) FROM portfolio_items pi WHERE pi.status = :status";
            if (isset($data['artist'])) {
                $count_query .= " AND pi.artist = :artist";
            }
            $count_stmt = $pdo->prepare($count_query);
            if (isset($data['artist'])) {
                $count_stmt->bindValue(':artist', $data['artist'], PDO::PARAM_STR);
            }
            $count_stmt->bindValue(':status', 'active', PDO::PARAM_STR);
            $count_stmt->execute();
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
