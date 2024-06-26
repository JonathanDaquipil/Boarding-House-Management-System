<?php
require 'config.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $invoice_number = $_POST['invoice_number'];
    $boarder_name = $_POST['boarder_name'];
    $discount = $_POST['discount'];
    $penalty = $_POST['penalty'];
    $total_rate = $_POST['total_rate'];
    $due_date = $_POST['due_date'];


 

  
    if (!$invoice_number || !$boarder_name || !$discount || !$penalty || !$total_rate || !$due_date) {
        echo "All fields are required.";
        exit;
    }


    $boarderNameQuery = "SELECT CONCAT(fname, ' ', lname) AS full_name FROM registration_table WHERE user_id = ?";
    $stmt = $conn->prepare($boarderNameQuery);
    $stmt->bind_param("i", $boarder_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $boarderFullName = $row['full_name'];
    } else {
   
        echo "Error: Boarder name not found.";
        exit;
    }


    $insertQuery = "INSERT INTO invoice_table (invoice_number, boarder_name, discount, penalty, total_rate, due_date, status) VALUES (?, ?, ?, ?, ?, ?, NULL)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("ssssss", $invoice_number, $boarderFullName, $discount, $penalty, $total_rate, $due_date);

    if ($stmt->execute()) {
       
        $message = "Invoice added successfully!";
        echo "<script>
                alert('$message');
                setTimeout(function(){
                    window.location.href = 'invoice.php';
                }, 1000); // Redirect after 1 second
              </script>";
    } else {
   
        echo "Error adding invoice: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
