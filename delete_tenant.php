<?php
require 'config.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $conn->real_escape_string($_POST['user_id']);
    
   
    error_log("User ID received: " . $user_id);

    // Delete the user from the registration_table
    $sql = "DELETE FROM registration_table WHERE user_id = '$user_id'";

    if ($conn->query($sql) === TRUE) {
        echo "Tenant deleted successfully.";
    } else {
        echo "Error deleting tenant: " . $conn->error;
    }

    // Close the connection
    $conn->close();
}
?>
