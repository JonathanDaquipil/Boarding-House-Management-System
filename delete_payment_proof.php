<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['payment_id'];

    // Delete the record from boarder_payments_proof table
    $sql = "DELETE FROM payments WHERE payment_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $payment_id);
    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }

    // Optionally, you might want to delete the corresponding record from the payments table
    // Uncomment the following lines if needed
    // $sql2 = "DELETE FROM payments WHERE payment_id = ?";
    // $stmt2 = $conn->prepare($sql2);
    // $stmt2->bind_param("i", $id);
    // $stmt2->execute();
}
?>