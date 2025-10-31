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

// Query to count the number of projects where the client_end_date is less than the current date
$query = "SELECT COUNT(*) AS exceed_count FROM project_table WHERE client_end_date < CURDATE()";

// Execute the query
$result = $conn->query($query);

// Check if query executed successfully
if ($result) {
    $row = $result->fetch_assoc();
    echo json_encode(['exceed_count' => $row['exceed_count']]);
} else {
    // In case of error, send an error message
    echo json_encode(['error' => 'Error fetching exceed project count']);
}

// Close the database connection
$conn->close();


?>