<?php
require 'config.php'; 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $billId = $_POST['bill_id'];
    $billName = $_POST['bill_name'];
    $billRate = $_POST['bill_rate'];

    $query = "UPDATE bills SET bills='$billName', rate='$billRate' WHERE bill_id='$billId'";

    if (mysqli_query($conn, $query)) {
        header("Location: utilitybills.php");
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
