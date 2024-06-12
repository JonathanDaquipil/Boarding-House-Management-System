<?php
if (isset($_POST['ph_id'])) {
   
    require 'config.php';

    $paymentId = $_POST['ph_id'];
    $deleteQuery = "DELETE FROM payment_history WHERE ph_id = $paymentId";

    if ($conn->query($deleteQuery) === TRUE) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }

    $conn->close();
} else {
  
    echo json_encode(['success' => false]);
}
?>
