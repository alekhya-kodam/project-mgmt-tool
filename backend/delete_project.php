<?php
// Enable full error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Allow requests from frontend
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include "config.php";  // Include your database connection

// Decode JSON body
$inputData = json_decode(file_get_contents("php://input"), true);

// Retrieve the project ID to delete
$project_id = $inputData['id'] ?? '';  
$user_id = $inputData['user_id'] ?? '';
$name = $inputData['name'] ?? '';

// Basic validation for ID
if (empty($project_id)) {
    echo json_encode(["status" => "error", "message" => "Project ID is required."]);
    exit;
}

// Log the project_id for debugging
error_log("Attempting to delete project with ID: " . $project_id);

// Begin Transaction
$conn->begin_transaction();

try {
    // First, delete the associated rows from the status_table
    $sql1 = "
    DELETE st 
    FROM status_table st
    INNER JOIN project_table pt ON pt.id = st.project_id
    WHERE pt.id = ?";
    $stmt1 = $conn->prepare($sql1);
    $stmt1->bind_param("i", $project_id);
    $stmt1->execute();
    
    // Then, delete the project from the project_table
    $sql2 = "DELETE FROM project_table WHERE id = ?";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->bind_param("i", $project_id);
    $stmt2->execute();

    // Commit the transaction if both queries are successful
    $conn->commit();

    echo json_encode(["status" => "success", "message" => "Project and associated data deleted successfully."]);
} catch (Exception $e) {
    // If any error occurs, rollback the transaction
    $conn->rollback();
    echo json_encode(["status" => "error", "message" => "Error deleting data: " . $e->getMessage()]);
}

$stmt1->close();
$stmt2->close();
$conn->close();
?>
