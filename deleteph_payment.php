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

    // Close the database connection
    $conn->close();
} else {
    // If payment_id is not set, return an error message
    echo json_encode(['success' => false]);
}
?>
