<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    require 'config.php';

    $assignmentId = $_POST['assignment_id'];
    $roomNo = $_POST['room_no'];
    $bedNo = $_POST['bed_no'];
    $dateStart = $_POST['date_start'];
    $dueDate = $_POST['due_date'];

    $query = "UPDATE bed_assignment_table 
              SET room_no = '$roomNo', bed_no = '$bedNo', date_start = '$dateStart', due_date = '$dueDate'
              WHERE assignment_id = '$assignmentId'";

    if ($conn->query($query) === TRUE) {
        // Redirect to bed management page or any other desired page after successful update
        header("Location: bedassignment.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }

    // Close database connection
    $conn->close();
}
?>
