<?php
require 'config.php';


$invoice_number = $_POST['invoice_number'];
$amount_paid = $_POST['amount_paid'];
$payment_date = $_POST['payment_date'];
$payment_method = $_POST['payment_method'];
$status = $_POST['status'];


$query = "INSERT INTO payments (invoice_number, amount_paid, payment_date, payment_method, status) 
          VALUES ('$invoice_number', '$amount_paid', '$payment_date', '$payment_method', '$status')";
if ($conn->query($query) === TRUE) {
 
    $payment_id = $conn->insert_id;


    if ($status === "Paid") {
        $history_query = "INSERT INTO payment_history (invoice_number, amount_paid, payment_date, remarks) 
                          VALUES ('$invoice_number', '$amount_paid', '$payment_date', 'Payment added')";
        $conn->query($history_query);
    }

   
    header("Location: payment.php");
    exit();
} else {
    echo json_encode(['success' => false]);
}

$conn->close();
?>
