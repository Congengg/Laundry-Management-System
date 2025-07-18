<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include 'db.php';

$sql = "SELECT o.order_id, o.package_id, o.customer_name, o.pickup_address, o.pickup_time,
               o.status, o.created_at, p.package_name, p.price
        FROM orders o
        JOIN packages p ON o.package_id = p.package_id
        ORDER BY o.created_at DESC";

$result = mysqli_query($conn, $sql);

$orders = [];

while ($row = mysqli_fetch_assoc($result)) {
    $orders[] = $row;
}

echo json_encode($orders);
?>
