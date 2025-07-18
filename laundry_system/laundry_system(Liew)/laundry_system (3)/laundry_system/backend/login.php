<?php

header("Access-Control-Allow-Origin: *");  
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type"); 
header('Content-Type: application/json');

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $data = json_decode(file_get_contents("php://input"));

    if (isset($data->username) && isset($data->password) && isset($data->user_type)) {
        $username = $data->username;
        $password = $data->password;
        $user_type = $data->user_type;

        // Choose table based on user type
        $table = ($user_type === 'customer') ? 'customers' : 'couriers';
        $id_column = ($user_type === 'customer') ? 'customer_id' : 'courier_id';

        $sql = "SELECT * FROM $table WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Check password
            if ($password === $user['password']) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Login successful',
                    'username' => $user['username'],
                    'phone' => $user['phone'],
                    'user_type' => $user_type,
                    'customer_id' => ($user_type === 'customer') ? $user['customer_id'] : null,
                    'courier_id' => ($user_type === 'courier') ? $user['courier_id'] : null
                ]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Invalid credentials']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'User not found']);
        }

        $stmt->close();
        $conn->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Missing credentials']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
