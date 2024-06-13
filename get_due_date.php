<?php
require 'config.php'; 

if (isset($_GET['boarder'])) {
    $boarderId = $_GET['boarder'];
    
    
    $sql = "SELECT due_date FROM invoice_table WHERE boarder_id = ? ORDER BY invoice_id DESC LIMIT 1";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bind_param("i", $boarderId);

    // Execute the query
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Check if there are any rows returned
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo $row['due_date']; // Return the due date
    } else {
        echo 'No due date found';
    }

    // Close statement
    $stmt->close();
} else {
    echo 'Invalid request';
}

// Close connection
$conn->close();
?>
