<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $billName = $_POST['bill_name'];
    $billRate = $_POST['bill_rate'];

    $query = "INSERT INTO bills (bills, rate) VALUES ('$billName', '$billRate')";

    if (mysqli_query($conn, $query)) {
        header("Location: utilitybills.php");
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
