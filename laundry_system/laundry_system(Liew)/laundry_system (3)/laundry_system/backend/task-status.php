<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

// Handle preflight request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include 'db.php';

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['order_id']) && isset($data['new_status']) && isset($data['courier_id'])) {
    $order_id = intval($data['order_id']);
    $new_status = mysqli_real_escape_string($conn, $data['new_status']);
    $courier_id = intval($data['courier_id']);

    $sql = "UPDATE orders SET status = '$new_status', courier_id = $courier_id WHERE order_id = $order_id";

    if (mysqli_query($conn, $sql)) {
        http_response_code(200);
        echo json_encode(["success" => true, "message" => "Order status updated and courier assigned."]);
    } else {
        http_response_code(500);
        echo json_encode(["success" => false, "message" => "DB error: " . mysqli_error($conn)]);
    }
} else {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Missing required data."]);
}
?>
