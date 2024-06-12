<?php
require 'config.php';
$response = array('success' => false, 'error' => '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $invoice_id = isset($_POST['invoice_id']) ? $_POST['invoice_id'] : '';

    if (!empty($invoice_id)) {
        
        $sql = "DELETE FROM invoice_table WHERE invoice_number = ?";
        $stmt = $conn->prepare($sql);
        
        if ($stmt === false) {
            $response['error'] = 'Failed to prepare the statement.';
        } else {
            $stmt->bind_param('s', $invoice_id);
            if ($stmt->execute()) {
                $response['success'] = true;
            } else {
                $response['error'] = 'Failed to delete invoice.';
            }
            $stmt->close();
        }
    } else {
        $response['error'] = 'Invalid invoice ID.';
    }
} else {
    $response['error'] = 'Invalid request method.';
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($response);
?>
