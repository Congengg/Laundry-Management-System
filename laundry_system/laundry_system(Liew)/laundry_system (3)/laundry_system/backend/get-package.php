<?php

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header('HTTP/1.1 200 OK');
    exit;
}

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type"); 
header('Content-Type: application/json');

include 'db.php';

// Prepare SQL to fetch packages
$sql = "SELECT * FROM packages";
$result = $conn->query($sql);

$packages = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $packages[] = $row;
    }
    // Return packages as JSON
    echo json_encode($packages);
} else {
    echo json_encode(["message" => "No packages found"]);
}

// Close the connection
$conn->close();
?>
