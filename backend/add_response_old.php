<?php

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Allow requests from frontend
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Include database connection settings
include "config.php"; // Make sure this file has the correct connection details

// Assuming you're using PDO to connect to your database
$data = json_decode(file_get_contents("php://input"), true);  // Decode the received JSON

// Make sure required fields exist
if (isset($data['comment_id'], $data['response_text'], $data['responded_by'], $data['project_id'], $data['user_id'])) {
    // Get the response values
    $comment_id = $data['comment_id'];
    $response_text = $data['response_text'];
    $responded_by = $data['responded_by'];
    $project_id = $data['project_id'];
    $user_id = $data['user_id'];

    try {
        // Prepare an SQL statement for insertion
        $stmt = $pdo->prepare("INSERT INTO responses (comment_id, response_text, responded_by, project_id, user_id, response_date) VALUES (?, ?, ?, ?, ?, NOW())");
        $stmt->execute([$comment_id, $response_text, $responded_by, $project_id, $user_id]);

        // If everything is okay, send a success response
        echo json_encode(['status' => 'success', 'message' => 'Response saved successfully.']);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Missing required fields.']);
}
?>
