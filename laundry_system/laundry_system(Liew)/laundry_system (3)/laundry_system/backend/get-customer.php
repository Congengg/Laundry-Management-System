<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Enable CORS for the frontend to make requests to this API
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

session_start();
header('Content-Type: application/json');

// Ensure customer is logged in
if (!isset($_SESSION['customer_id'])) {
    echo json_encode(['error' => 'Customer is not logged in']);
    exit();
}

// Return the customer_id if the customer is logged in
echo json_encode(['customer_id' => $_SESSION['customer_id']]);
?>