<?php
require 'config.php'; // Include the file that establishes the database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $billId = $_POST['bill_id'];

    $query = "DELETE FROM bills WHERE bill_id='$billId'";

    if (mysqli_query($conn, $query)) {
        header("Location: utilitybills.php");
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>