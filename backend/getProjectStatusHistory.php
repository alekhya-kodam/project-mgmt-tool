<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Include database connection file
include 'config.php'; // Your DB connection file

// Get projectId from query params
$projectId = isset($_GET['projectId']) ? intval($_GET['projectId']) : 0;

if ($projectId <= 0) {
    echo json_encode([]);
    exit;
}

try {
    // Prepare SQL: fetch all status records for this project ordered by updated_at ASC
    $stmt = $conn->prepare("SELECT * FROM status_table WHERE project_id = ? ORDER BY updated_at ASC");
    $stmt->bind_param("i", $projectId);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            "id" => intval($row['id']),
            "project_id" => intval($row['project_id']),
            "status" => $row['status'],
            "status_description" => $row['status_description'],
            "status_percentage" => floatval($row['status_percentage']),
            "created_at" => $row['created_at'],
            "updated_at" => $row['updated_at'],
            "is_latest" => intval($row['is_latest']),
        ];
    }

    echo json_encode($data);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
}
