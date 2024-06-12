<?php
require 'config.php'; // Ensure this points to your database configuration file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $invoice_id = $_POST['invoice_id'];
    $invoice_number = $_POST['invoice_number'];
    $boarder_name = $_POST['boarder_name'];
    $discount = $_POST['discount'];
    $penalty = $_POST['penalty'];
    $total_rate = $_POST['total_rate'];
    $due_date = $_POST['due_date'];
   

    // Update the invoice in the database
    $sql = "UPDATE invoice_table 
            SET invoice_number = ?, boarder_name = ?, discount = ?, penalty = ?, total_rate = ?, due_date = ?
            WHERE invoice_number = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssssssss', $invoice_number, $boarder_name, $discount, $penalty, $total_rate, $due_date, $invoice_id);

    if ($stmt->execute()) {
        header('Location: invoice.php');
    } else {
        echo "Error updating invoice: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>