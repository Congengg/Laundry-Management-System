<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require 'db.php';

$data = json_decode(file_get_contents("php://input"), true);
$customer_id = $data['customer_id'] ?? null;
$search = $data['search'] ?? '';

if (!$customer_id) {
    echo json_encode([]);
    exit;
}

$sql = "SELECT o.order_id, o.pickup_time, o.pickup_address, o.status, 
               o.customer_phone, p.package_name, p.price
        FROM orders o
        JOIN packages p ON o.package_id = p.package_id
        WHERE o.customer_id = ?";

if (!empty($search)) {
    $sql .= " AND (o.order_id LIKE ? OR o.customer_phone LIKE ?)";
}

$sql .= " ORDER BY o.order_id DESC";

$stmt = $conn->prepare($sql);

if (!empty($search)) {
    $like = "%$search%";
    $stmt->bind_param("iss", $customer_id, $like, $like);
} else {
    $stmt->bind_param("i", $customer_id);
}

$stmt->execute();
$result = $stmt->get_result();

$orders = [];
while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
}

echo json_encode($orders);
?>
