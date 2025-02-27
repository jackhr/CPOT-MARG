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
    if ($data['action'] === "get_all_sconces") {
        $res = [
            "status" => 200,
            "message" => "Successfully fetched sconces",
            "data" => [],
        ];

        try {
            // Fetch data
            $stmt = $pdo->prepare(
                "SELECT sconces.*, sconce_images.image_url
                    FROM sconces
                    LEFT JOIN sconce_images ON sconces.primary_image_id = sconce_images.image_id
                WHERE status = :status
                ORDER BY
                    SUBSTRING(sconces.name, 1, 1) ASC,  -- Order by the first letter (e.g., J, P)
                    CAST(SUBSTRING(sconces.name, 2) AS UNSIGNED) ASC;  -- Then order numerically by the rest of the name"
            );
            $stmt->bindValue(':status', 'active', PDO::PARAM_STR);
            $stmt->execute();
            $res['data'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $res['status'] = 500;
            $res['message'] = $e->getMessage();
        }
    } else if ($data['action'] === "get_more_sconces") {
        $page = isset($data['page']) ? (int)$data['page'] : 0;
        $itemsPerPage = 6;
        $offset = $page * $itemsPerPage;

        $res = [
            "status" => 200,
            "message" => "Successfully fetched sconces",
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
                "SELECT sconces.*, sconce_images.image_url
                    FROM sconces
                    LEFT JOIN sconce_images ON sconces.primary_image_id = sconce_images.image_id
                WHERE status = :status
                ORDER BY
                    SUBSTRING(sconces.name, 1, 1) ASC,  -- Order by the first letter (e.g., J, P)
                    CAST(SUBSTRING(sconces.name, 2) AS UNSIGNED) ASC  -- Then order numerically by the rest of the name
                LIMIT :limit
                OFFSET :offset"
            );
            $stmt->bindValue(':status', 'active', PDO::PARAM_STR);
            $stmt->bindValue(':limit', (int) $itemsPerPage, PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
            $stmt->execute();
            $sconces = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $stmt = $pdo->prepare("SELECT cutout_id, sconce_id FROM rel_sconces_cutouts");
            $stmt->execute();
            $cutoutRelations = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Initialize each sconce with an empty array of cutouts
            foreach ($sconces as &$sconce) $sconce['cutout_ids'] = [];

            foreach ($cutoutRelations as $relation) {
                // Find the index of the sconce in the sconces array
                $index = array_search($relation['sconce_id'], array_column($sconces, 'sconce_id'));

                if ($index !== false) {
                    $sconces[$index]['cutout_ids'][] = $relation['cutout_id'];
                }
            }

            $res['data'] = $sconces;

            // Fetch total items count
            $count_query = "SELECT COUNT(*) FROM sconces WHERE status = :status";
            $count_stmt = $pdo->prepare($count_query);
            $count_stmt->execute(['status' => 'active']);
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
