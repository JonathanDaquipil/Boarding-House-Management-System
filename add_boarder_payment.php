<?php
require 'config.php';


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $payment_id = $_POST['payment_id'];
    $status = $_POST['status'];

 
    if (empty($payment_id) || empty($status)) {
        echo json_encode(['success' => false, 'message' => 'Missing required data']);
        exit;
    }


    $update_proof_query = "UPDATE boarder_payments_proof
                           SET status='$status' 
                           WHERE payment_id='$payment_id'";
    if ($conn->query($update_proof_query) === TRUE) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating boarder_payments_proof: ' . $conn->error]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}

$conn->close();
?>
