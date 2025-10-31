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

// Get the raw POST data
$data = json_decode(file_get_contents("php://input"));

// Log received data for debugging (for error diagnosis)
file_put_contents('php://stderr', print_r($data, TRUE)); // Log the incoming data

// Check if the required fields are present in the POST request
if (isset($data->comment_id) && isset($data->response_text) && isset($data->responded_by) && isset($data->user_id) && isset($data->project_id)) {
    // Sanitize the input data
    $comment_id = $conn->real_escape_string($data->comment_id);
    $response_text = $conn->real_escape_string($data->response_text);
    $responded_by = $conn->real_escape_string($data->responded_by);
    $user_id = $conn->real_escape_string($data->user_id); // Added user_id
    $project_id = $conn->real_escape_string($data->project_id); // Added project_id
    $response_date = date('Y-m-d H:i:s'); // Current date and time

    // Log the sanitized data for debugging
    file_put_contents('php://stderr', "Sanitized Data: comment_id=$comment_id, response_text=$response_text, responded_by=$responded_by, user_id=$user_id, project_id=$project_id\n");

    // Prepare the SQL query to insert the response with user_id and project_id
    $sql = "INSERT INTO responses (comment_id, response_text, responded_by, response_date, user_id, project_id)
            VALUES ('$comment_id', '$response_text', '$responded_by', '$response_date', '$user_id', '$project_id')";

    // Log the SQL query for debugging
    file_put_contents('php://stderr', "SQL Query: $sql\n");

    // Execute the query and check if it was successful
    if ($conn->query($sql) === TRUE) {
        // Return a success message
        echo json_encode(['status' => 'success', 'message' => 'Response saved successfully']);
    } else {
        // Log the error to check what went wrong
        file_put_contents('php://stderr', "Error: " . $conn->error . "\n");

        // Return an error message
        echo json_encode(['status' => 'error', 'message' => 'Error saving response: ' . $conn->error]);
    }
} else {
    // Log if the required fields are missing
    file_put_contents('php://stderr', "Missing required fields.\n");

    // Return an error message if the required data is not provided
    echo json_encode(['status' => 'error', 'message' => 'Missing required fields']);
}

// Close the database connection
$conn->close();
?>
