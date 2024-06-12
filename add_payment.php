<?php
require 'config.php';

// Assuming the fields are coming from $_POST
$invoice_number = $_POST['invoice_number'];
$amount_paid = $_POST['amount_paid'];
$payment_date = $_POST['payment_date'];
$payment_method = $_POST['payment_method'];
$status = $_POST['status'];

// Insert into payments table
$query = "INSERT INTO payments (invoice_number, amount_paid, payment_date, payment_method, status) 
          VALUES ('$invoice_number', '$amount_paid', '$payment_date', '$payment_method', '$status')";
if ($conn->query($query) === TRUE) {
    // Get the last inserted ID
    $payment_id = $conn->insert_id;

    // If the status is "Paid", insert into payment_history
    if ($status === "Paid") {
        $history_query = "INSERT INTO payment_history (invoice_number, amount_paid, payment_date, remarks) 
                          VALUES ('$invoice_number', '$amount_paid', '$payment_date', 'Payment added')";
        $conn->query($history_query);
    }

    // Redirect back to the form
    header("Location: payment.php");
    exit(); // Make sure nothing else is executed after redirection
} else {
    echo json_encode(['success' => false]);
}

$conn->close();
?>