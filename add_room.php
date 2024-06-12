<?php

require 'config.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $room_number = $_POST['room_number'];
    $description = $_POST['description'];

 
    $sql = "INSERT INTO room_table (room_no, description) VALUES ('$room_number', '$description')";
    
    if ($conn->query($sql) === TRUE) {
     
        header("location: roommanagement.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
