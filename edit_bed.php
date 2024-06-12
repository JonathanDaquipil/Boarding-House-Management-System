<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $room_id = $_POST['room_id'];
    $bed_no = $_POST['bed_no'];
    $room_no = $_POST['room_no'];
    $daily_rate = $_POST['daily_rate'];
    $monthly_rate = $_POST['monthly_rate'];
    $status = $_POST['status'];

    $query = "UPDATE room_table SET bed_no = ?, room_no = ?, daily_rate = ?, monthly_rate = ?, status = ? WHERE room_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssddsi", $bed_no, $room_no, $daily_rate, $monthly_rate, $status, $room_id);

    if ($stmt->execute()) {
        echo "Bed updated successfully.";
    } else {
        echo "Error updating bed: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
    header("Location: bedmanagement.php");
    exit;
} else {
    echo "Invalid request.";
}
?>