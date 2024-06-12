<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $payment_id = $data['payment_id'];

    $query = "DELETE FROM payments WHERE payment_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $payment_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }

    $stmt->close();
    $conn->close();
}
?>