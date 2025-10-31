<?php

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Allow requests from frontend
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include "config.php";

// Read JSON input from frontend
$inputData = json_decode(file_get_contents("php://input"), true);

// Encryption Key (should match the key used for encryption)
$encryption_key = "your-encryption-key";

// Prepare the query to include the password
$query = "SELECT id, name, email, role, created_at, password FROM users WHERE role = 'teamlead'";

// Execute the query
$result = $conn->query($query);

// Check if there are results
if ($result->num_rows > 0) {
    // Create an array to hold the data
    $teamleadData = array();

    // Fetch each row and decrypt the password
    while ($row = $result->fetch_assoc()) {
        // Decrypt the password
        $decrypted_password = openssl_decrypt($row['password'], "AES-128-ECB", $encryption_key);
        
        // Add the decrypted password to the array
        $row['password'] = $decrypted_password;
        
        $teamleadData[] = $row;
    }

    // Return the data as a JSON response
    echo json_encode($teamleadData);
} else {
    // If no team leads found, return an empty array
    echo json_encode([]);
}

// Close the database connection
$conn->close();
?>
