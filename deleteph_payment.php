<?php
// Check if payment_id is set in the POST request
if (isset($_POST['ph_id'])) {
    // Include your database connection file
    require 'config.php';

    // Prepare the DELETE query
    $paymentId = $_POST['ph_id'];
    $deleteQuery = "DELETE FROM payment_history WHERE ph_id = $paymentId";

    // Execute the DELETE query
    if ($conn->query($deleteQuery) === TRUE) {
        // If deletion is successful, return a success message
        echo json_encode(['success' => true]);
    } else {
        // If there's an error, return an error message
        echo json_encode(['success' => false]);
    }

    // Close the database connection
    $conn->close();
} else {
    // If payment_id is not set, return an error message
    echo json_encode(['success' => false]);
}
?>