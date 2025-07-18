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

$data = json_decode(file_get_contents("php://input"), true);
file_put_contents("debug_input.json", json_encode($data, JSON_PRETTY_PRINT));

if (
    isset($data['customer_id']) &&
    isset($data['package_id']) &&
    isset($data['customer_name']) &&
    isset($data['customer_phone']) &&
    isset($data['pickup_address']) &&
    isset($data['pickup_time'])
) {
    $customer_id = intval($data['customer_id']);
    $package_id = intval($data['package_id']);
    $customer_name = mysqli_real_escape_string($conn, $data['customer_name']);
    $customer_phone = mysqli_real_escape_string($conn, $data['customer_phone']);
    $pickup_address = mysqli_real_escape_string($conn, $data['pickup_address']);
    $pickup_time = mysqli_real_escape_string($conn, str_replace('T', ' ', $data['pickup_time']));
    $remarks = isset($data['special_instructions']) ? mysqli_real_escape_string($conn, $data['special_instructions']) : '';
    $created_at = date('Y-m-d H:i:s');
    $status = 'pending';

    // 🔍 Get price from packages
    $package_sql = "SELECT price FROM packages WHERE package_id = $package_id";
    $result = mysqli_query($conn, $package_sql);
    if ($row = mysqli_fetch_assoc($result)) {
        $price = $row['price'];
    } else {
        echo json_encode(["success" => false, "message" => "Invalid package ID."]);
        exit();
    }

    // ✅ Fixed: include price column
    $sql = "INSERT INTO orders (
        customer_id, customer_name, customer_phone, pickup_address, pickup_time,
        special_instructions, package_id, status, courier_id, created_at, price
    ) VALUES (
        $customer_id, '$customer_name', '$customer_phone', '$pickup_address', '$pickup_time',
        '$remarks', $package_id, '$status', NULL, '$created_at', $price
    )";

    file_put_contents("debug_sql.txt", $sql); // Log it

    if (mysqli_query($conn, $sql)) {
        echo json_encode([
            "success" => true,
            "message" => "Order placed successfully.",
            "order_id" => mysqli_insert_id($conn),
            "price" => $price
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Database error: " . mysqli_error($conn)
        ]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Missing required fields."]);
}
?>
