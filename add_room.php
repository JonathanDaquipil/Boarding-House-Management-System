<?php
// Assuming you have a database connection established in config.php
require 'config.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $room_number = $_POST['room_number'];
    $description = $_POST['description'];

    // Insert the new room into the database
    $sql = "INSERT INTO room_table (room_no, description) VALUES ('$room_number', '$description')";
    
    if ($conn->query($sql) === TRUE) {
        // Redirect back to roommanagement.php after successful insertion
        header("location: roommanagement.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>