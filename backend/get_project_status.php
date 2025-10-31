<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include 'config.php'; // Include your DB connection

// Fetch project and status data by joining project_table and status_table based on project_id
$sql = "
    SELECT 
        p.id AS project_id,
        p.project_name,
        s.status,
        s.status_description,
        s.status_percentage
    FROM project_list p
    LEFT JOIN status_table s ON p.id = s.project_id
";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $projectStatus = [];
    while($row = $result->fetch_assoc()) {
        $projectStatus[] = $row;
    }
    echo json_encode(['status' => 'success', 'data' => $projectStatus]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'No data found']);
}

$conn->close();
?>
