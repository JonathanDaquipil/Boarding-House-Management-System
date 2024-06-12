<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['room_id'])) {
    $room_id = intval($_POST['room_id']);

    $sql = "DELETE FROM room_table WHERE room_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $room_id);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "Error deleting room: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Room ID not provided.";
}
?>