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

// Query to count the total number of projects
$query_project_count = "SELECT COUNT(*) AS project_count FROM project_table";

// Query to count the number of projects where the client_end_date is less than the current date
$query_exceed_count = "SELECT COUNT(*) AS exceed_count FROM project_table WHERE client_end_date < CURDATE()";

$query_inprogress_count = "SELECT COUNT(*) AS inprogress_count FROM status_table WHERE status = 'In Progress'";

$query_completed_count = "SELECT COUNT(*) AS completed_count FROM status_table WHERE status = 'Completed'";

// Execute the queries
$result_project_count = $conn->query($query_project_count);
$result_exceed_count = $conn->query($query_exceed_count);
$result_inprogress_count = $conn->query($query_inprogress_count);
$result_completed_count = $conn->query($query_completed_count);

// Prepare the response
$response = [];

if ($result_project_count && $result_exceed_count) {
    $row_project_count = $result_project_count->fetch_assoc();
    $row_exceed_count = $result_exceed_count->fetch_assoc();
    $row_inprogress_count = $result_inprogress_count->fetch_assoc();
    $row_completed_count = $result_completed_count->fetch_assoc();

    $response['project_count'] = $row_project_count['project_count'];
    $response['exceed_count'] = $row_exceed_count['exceed_count'];
    $response['inprogress_count'] = $row_inprogress_count['inprogress_count'];
    $response['completed_count'] = $row_completed_count['completed_count'];


    echo json_encode($response);
} else {
    echo json_encode(['error' => 'Error fetching project count']);
}

// Close the database connection
$conn->close();
?>
