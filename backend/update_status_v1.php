<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Methods: POST");
// header("Access-Control-Allow-Headers: Content-Type");


// Include database connection file
include 'config.php'; // Your DB connection file

// Read JSON input
$data = json_decode(file_get_contents("php://input"), true);

// Extract values from JSON
$project_id = isset($data['project_id']) ? intval($data['project_id']) : null;
$status = isset($data['status']) ? $data['status'] : null;
$status_description = isset($data['status_description']) ? $data['status_description'] : null;
$status_percentage = isset($data['status_percentage']) ? $data['status_percentage'] : null;
$user_id = $data['user_id'] ?? null;
$name = $data['name'] ?? null;

// Log received data for debugging
error_log("Received: project_id=$project_id, status=$status, description=$status_description, percentage=$status_percentage");

// Validate required fields
if ($project_id === null || $status === null) {
    echo json_encode(['status' => 'error', 'message' => 'Project ID and Status are required']);
    exit();
}

$query = "SELECT id as status_id FROM status_table WHERE project_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $project_id);
$stmt->execute();
$stmt->bind_result($status_id);
$stmt->fetch();
$stmt->close();

// if ($status_id) {
//     // Update existing record
//     $sql = "UPDATE status_table 
//             SET status = ?, status_description = ?, status_percentage = ? 
//             WHERE id = ? ";
// } else {
//     // Insert new record or update if exists (duplicate key)
//     $sql = "INSERT INTO status_table (project_id, status, status_description, status_percentage, created_at)
//             VALUES (?, ?, ?, ?, NOW())
//             ON DUPLICATE KEY UPDATE
//             status = VALUES(status),
//             status_description = VALUES(status_description),
//             status_percentage = VALUES(status_percentage),
//             created_at = NOW()";
// }
if ($status_id) {
    // Status exists, update it
    $sql = "UPDATE status_table  
            SET status = ?, status_description = ?, status_percentage = ?  
            WHERE id = ?";
} else {
    // Status does not exist, insert new record
    $sql = "INSERT INTO status_table (project_id, status, status_description, status_percentage, created_at)
            VALUES (?, ?, ?, ?, NOW())";
}
// Prepare and bind
// $stmt = $conn->prepare($sql);
// if (!$stmt) {
//     error_log("SQL Prepare Error: " . $conn->error);
//     echo json_encode(['status' => 'error', 'message' => 'Failed to prepare query']);
//     exit();
// }

// Bind parameters
// For "status_percentage", it can be nullable, so we handle it accordingly.
// if ($status_percentage === null) {
// Bind parameters for update
// $stmt->bind_param("sssi", $status, $status_description, $status_percentage, $project_id);
// } else {
// Bind parameters for insert/update
// $stmt->bind_param("ssss", $project_id, $status, $status_description, $status_percentage);
// }

// Execute
// if ($stmt->execute()) {
// echo json_encode(['status' => 'success', 'message' => 'Status inserted or updated successfully']);
// } else {
// error_log("SQL Execute Error: " . $stmt->error);
// echo json_encode(['status' => 'error', 'message' => 'Failed to execute query']);
// }

$stmt = $conn->prepare($sql);

if ($status_id) {
    $stmt->bind_param("sssi", $status, $status_description, $status_percentage, $status_id);
} else {
    $stmt->bind_param("isss", $project_id,  $status, $status_description, $status_percentage);
}

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => $status_id ? 'Status updated' : 'Status inserted']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Query failed']);
}

$stmt->close();

// Close
// $stmt->close();
$conn->close();
