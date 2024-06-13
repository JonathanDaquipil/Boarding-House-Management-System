<?php

require 'config.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $room_id = $_POST['room_id'];
    $room_number = $_POST['room_number'];
    $description = $_POST['description'];

    
    $sql = "UPDATE room_table SET room_no='$room_number', description='$description' WHERE room_id='$room_id'";
    
    if ($conn->query($sql) === TRUE) {
        // Redirect back to roommanagement.php after successful update
        header("location: roommanagement.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $conn->close();
}
?>
