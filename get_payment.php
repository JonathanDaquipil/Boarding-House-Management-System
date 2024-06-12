<?php
include 'config.php';

if (isset($_GET['id'])) {
    $payment_id = $_GET['id'];

    $sql = "SELECT * FROM payments WHERE payment_id='$payment_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo json_encode($result->fetch_assoc());
    } else {
        echo json_encode([]);
    }
}
$conn->close();
?>