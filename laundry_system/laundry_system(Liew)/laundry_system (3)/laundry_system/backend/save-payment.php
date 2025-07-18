<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require 'db.php'; // Your DB connection file

$data = json_decode(file_get_contents("php://input"), true);

$customer_id = $data['customer_id'] ?? null;
$payment_method = $data['payment_method'] ?? null;

if (!$customer_id || !$payment_method) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit;
}

// Optional: get the latest order for this customer
$orderQuery = "SELECT order_id FROM orders WHERE customer_id = ? ORDER BY order_id DESC LIMIT 1";
$orderStmt = $conn->prepare($orderQuery);
$orderStmt->bind_param("i", $customer_id);
$orderStmt->execute();
$orderResult = $orderStmt->get_result();

if ($orderResult->num_rows > 0) {
    $order = $orderResult->fetch_assoc();
    $order_id = $order['order_id'];

    // Save payment (or update the order with payment info)
    $paymentQuery = "INSERT INTO payments (order_id, customer_id, method, status, payment_date) VALUES (?, ?, ?, 'Paid', NOW())";
    $paymentStmt = $conn->prepare($paymentQuery);
    $paymentStmt->bind_param("iis", $order_id, $customer_id, $payment_method);

    if ($paymentStmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database insert error']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'No recent order found for this customer']);
}
?>
