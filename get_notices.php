<?php
// Include your database connection file
require_once 'config.php';

// Fetch notices from the database
$sql = "SELECT * FROM notices ORDER BY created_at DESC"; // Assuming 'notices' is the table name
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output each notice as a list item
    while ($row = $result->fetch_assoc()) {
        echo "<div class='notice'>";
        echo "<p>" . $row['message'] . "</p>";
        echo "<p class='timestamp'>" . $row['created_at'] . "</p>";
        echo "</div>";
    }
} else {
    echo "<p>No notices found</p>";
}

// Close the database connection
$conn->close();
?>