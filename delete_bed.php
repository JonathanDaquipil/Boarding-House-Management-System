<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $room_id = $_POST['room_id'];

    // Prepare and execute the delete statement
    $stmt = $conn->prepare("DELETE FROM room_table WHERE room_id = ?");
    $stmt->bind_param("i", $room_id);

    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }

    $stmt->close();
    $conn->close();
} else {
    echo 'error';
}
?>