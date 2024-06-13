
<?php
require 'config.php';

$payment_id = $_POST['payment_id'];
$invoice_number = $_POST['invoice_number'];
$amount_paid = $_POST['amount_paid'];
$payment_date = $_POST['payment_date'];
$payment_method = $_POST['payment_method'];
$status = $_POST['status'];

error_log("Received data: payment_id=$payment_id, invoice_number=$invoice_number, amount_paid=$amount_paid, payment_date=$payment_date, payment_method=$payment_method, status=$status");


$conn->begin_transaction();

try {
    
    $query = "UPDATE payments 
              SET invoice_number = ?, amount_paid = ?, payment_date = ?, payment_method = ?, status = ? 
              WHERE payment_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sssssi', $invoice_number, $amount_paid, $payment_date, $payment_method, $status, $payment_id);
    if (!$stmt->execute()) {
        throw new Exception('Error updating payments: ' . $stmt->error);
    }


    $proof_update_query = "UPDATE boarder_payments_proof 
                           SET payment_amount = ?, payment_date = ?, payment_method = ?, status = ? 
                           WHERE user_id = (SELECT user_id FROM payments WHERE payment_id = ?) AND invoice_number = ?";
    $stmt = $conn->prepare($proof_update_query);
    $stmt->bind_param('sssssi', $amount_paid, $payment_date, $payment_method, $status, $payment_id, $invoice_number);
    if (!$stmt->execute()) {
        throw new Exception('Error updating boarder_payments_proof: ' . $stmt->error);
    }

    
    if ($status === "Paid") {
        // Check if the record already exists in payment_history
        $history_check_query = "SELECT * FROM payment_history WHERE invoice_number = ?";
        $stmt = $conn->prepare($history_check_query);
        $stmt->bind_param('s', $invoice_number);
        $stmt->execute();
        $history_result = $stmt->get_result();

        if ($history_result->num_rows > 0) {
            // Update existing record in payment_history
            $history_update_query = "UPDATE payment_history 
                                     SET amount_paid = ?, payment_date = ?, remarks = 'Payment updated' 
                                     WHERE invoice_number = ?";
            $stmt = $conn->prepare($history_update_query);
            $stmt->bind_param('sss', $amount_paid, $payment_date, $invoice_number);
            if (!$stmt->execute()) {
                throw new Exception('Error updating payment_history: ' . $stmt->error);
            }
        } else {
            // Insert new record into payment_history
            $history_insert_query = "INSERT INTO payment_history (invoice_number, amount_paid, payment_date, remarks) 
                                     VALUES (?, ?, ?, 'Paid')";
            $stmt = $conn->prepare($history_insert_query);
            $stmt->bind_param('sss', $invoice_number, $amount_paid, $payment_date);
            if (!$stmt->execute()) {
                throw new Exception('Error inserting into payment_history: ' . $stmt->error);
            }
        }
    }

    // Commit transaction
    $conn->commit();
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    // Rollback transaction
    $conn->rollback();
    error_log('Transaction failed: ' . $e->getMessage());
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

// Close connection
$conn->close();
?>
