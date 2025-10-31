<?php 
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Allow requests from frontend
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Include the database connection file
include 'config.php'; // Ensure this file contains the correct database connection

// Read JSON input from frontend
$inputData = json_decode(file_get_contents("php://input"), true);

// Retrieve user_id and name from the POST request body
$user_id = $inputData['user_id'] ?? '';  // user_id should be passed from the frontend
$name = $inputData['name'] ?? '';        // name should be passed from the frontend

// Initialize the response array
$response = [];

// Query to count the total number of projects
$query_project_count = "SELECT COUNT(*) AS project_count FROM project_table WHERE user_id = ?";

// Prepare the query and bind parameters
$stmt_project_count = $conn->prepare($query_project_count);
$stmt_project_count->bind_param("i", $user_id); // "i" means integer

// Execute the query and fetch result
$stmt_project_count->execute();
$result_project_count = $stmt_project_count->get_result();
$row_project_count = $result_project_count->fetch_assoc();

// Query to count the number of projects where the client_end_date is less than the current date
$query_exceed_count = "SELECT COUNT(*) AS exceed_count FROM project_table WHERE client_end_date < CURDATE() AND user_id = ?";

// Prepare the query and bind parameters
$stmt_exceed_count = $conn->prepare($query_exceed_count);
$stmt_exceed_count->bind_param("i", $user_id); // "i" means integer

// Execute the query and fetch result
$stmt_exceed_count->execute();
$result_exceed_count = $stmt_exceed_count->get_result();
$row_exceed_count = $result_exceed_count->fetch_assoc();

// Prepare the response with the fetched data
$response['project_count'] = $row_project_count['project_count'] ?? 0;
$response['exceed_count'] = $row_exceed_count['exceed_count'] ?? 0;

// Output the JSON response
echo json_encode($response);

// Close the database connection
$conn->close();
?>
