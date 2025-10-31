<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");


include "config.php";

$sql = "SELECT * FROM project_table ORDER BY id DESC where user_id= ?";
$result = $conn->query($sql);

$projects = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $projects[] = $row;
    }
    echo json_encode(["status" => "success", "data" => $projects]);
} else {
    echo json_encode(["status" => "success", "data" => []]);
}

$conn->close();
?>
