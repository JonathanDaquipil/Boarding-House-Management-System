<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bed_no = $_POST['bed_no'];
    $room_no = $_POST['room_no'];
    $daily_rate = $_POST['daily_rate'];
    $monthly_rate = $_POST['monthly_rate'];
    $status = $_POST['status'];

    $query = "INSERT INTO room_table (bed_no, room_no, daily_rate, monthly_rate, status) VALUES ('$bed_no', '$room_no', '$daily_rate', '$monthly_rate', '$status')";
    
    if ($conn->query($query) === TRUE) {
        header('Location: bedmanagement.php');
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }

    $conn->close();
}
?>