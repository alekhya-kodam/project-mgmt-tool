<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Include database connection file
include 'config.php'; // Your DB connection file

// Read JSON input
$data = json_decode(file_get_contents("php://input"), true);

// Extract values from JSON
$project_id = isset($data['project_id']) ? intval($data['project_id']) : null;
$status = isset($data['status']) ? $data['status'] : null;
$status_description = isset($data['status_description']) ? $data['status_description'] : null;
$status_percentage = isset($data['status_percentage']) ? $data['status_percentage'] : null;

// Validate required fields
if ($project_id === null || $status === null) {
    echo json_encode(['status' => 'error', 'message' => 'Project ID and Status are required']);
    exit();
}

$conn->begin_transaction();

try {
    // 1. Update existing records for this project to is_latest = 0
    $update_sql = "UPDATE status_table SET is_latest = 0 WHERE project_id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("i", $project_id);
    $update_stmt->execute();
    $update_stmt->close();

    // 2. Insert new record with is_latest = 1
    $insert_sql = "INSERT INTO status_table (project_id, status, status_description, status_percentage, created_at, is_latest)
                   VALUES (?, ?, ?, ?, NOW(), 1)";
    $insert_stmt = $conn->prepare($insert_sql);
    $insert_stmt->bind_param("isss", $project_id, $status, $status_description, $status_percentage);
    $insert_stmt->execute();

    $insert_stmt->close();

    $conn->commit();

    echo json_encode(['status' => 'success', 'message' => 'New status inserted and marked as latest']);

} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(['status' => 'error', 'message' => 'Query failed: ' . $e->getMessage()]);
}

$conn->close();
?>
