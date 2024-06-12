<?php
// Include your database connection file
require 'config.php';

// Check if user_id is provided
if (isset($_GET['user_id'])) {
    // Retrieve user_id from the request
    $userId = $_GET['user_id'];

    // Perform a query to fetch first name and last name based on user_id
    $query = "SELECT fname, lname FROM registration_table WHERE user_id = $userId";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // Fetch user data
        $userData = $result->fetch_assoc();

        // Return user data as JSON
        echo json_encode($userData);
    } else {
        // No user found with the given user_id
        echo json_encode(array('error' => 'User not found'));
    }
} else {
    // No user_id provided in the request
    echo json_encode(array('error' => 'No user_id provided'));
}

// Close database connection
$conn->close();
?>