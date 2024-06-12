<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $assignment_id = $_POST['assignment_id'];

    $query = "DELETE FROM bed_assignment_table WHERE assignment_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $assignment_id);

    if ($stmt->execute()) {
        header("Location: bedassignment.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: bedassignment.php");
}
?>