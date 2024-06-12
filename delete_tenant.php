<?php
require 'config.php'; // Ensure this points to your database configuration file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $conn->real_escape_string($_POST['user_id']);
    
    // Check if the user_id is being received correctly
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