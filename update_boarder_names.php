<?php
require 'config.php'; // Ensure this points to your database configuration file

// SQL query to update boarder_name in bed_assignment_table
$sql = "
    UPDATE bed_assignment_table bat
    JOIN registration_table rt ON bat.user_id = rt.user_id
    SET bat.boarder_name = CONCAT(rt.fname, ' ', rt.lname)
";

// Execute the query
if ($conn->query($sql) === TRUE) {
    echo "Boarder names updated successfully.";
} else {
    echo "Error updating boarder names: " . $conn->error;
}

// Close the connection
$conn->close();
?>