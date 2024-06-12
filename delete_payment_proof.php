<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['payment_id'];

    
    $sql = "DELETE FROM payments WHERE payment_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $payment_id);
    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }

  
  
    // $stmt2->bind_param("i", $id);
    // $stmt2->execute();
}
?>
