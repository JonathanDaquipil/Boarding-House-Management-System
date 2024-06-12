<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    require 'config.php';

  
    $userId = $_POST['user_id'];
    $roomNo = $_POST['room_no'];
    $bedNo = $_POST['bed_no'];
    $dateStart = $_POST['date_start'];
    $dueDate = $_POST['due_date'];

    
    $roomQuery = "SELECT room_id FROM room_table WHERE room_no = ?";
    $roomStmt = $conn->prepare($roomQuery);
    $roomStmt->bind_param("s", $roomNo);
    $roomStmt->execute();
    $roomResult = $roomStmt->get_result();
    if ($roomResult->num_rows == 0) {
        die("Error: No room found with the number $roomNo");
    }
    $roomId = $roomResult->fetch_assoc()['room_id'];
    $roomStmt->close();

   
    $bedQuery = "SELECT bed_id FROM bed_table WHERE bed_no = ?";
    $bedStmt = $conn->prepare($bedQuery);
    $bedStmt->bind_param("s", $bedNo);
    $bedStmt->execute();
    $bedResult = $bedStmt->get_result();
    if ($bedResult->num_rows == 0) {
        die("Error: No bed found with the number $bedNo");
    }
    $bedId = $bedResult->fetch_assoc()['bed_id'];
    $bedStmt->close();

  
    $query = "INSERT INTO bed_assignment_table (user_id, room_id, bed_id, date_start, due_date) 
              VALUES (?, ?, ?, ?, ?)";


    $stmt = $conn->prepare($query);
    $stmt->bind_param("iiiss", $userId, $roomId, $bedId, $dateStart, $dueDate);


    if ($stmt->execute()) {
     
        header("Location: bedassignment.php");
        exit();
    } else {
  
        echo "Error: " . $stmt->error;
    }


    $stmt->close();


    $conn->close();
}
?>
