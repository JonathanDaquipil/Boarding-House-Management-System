<?php
require 'config.php';

$sql = "SELECT DISTINCT boarder_name FROM bed_assignment"; // Adjust table and column names as needed
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<option value='" . $row['boarder_name'] . "'>" . $row['boarder_name'] . "</option>";
    }
} else {
    echo "<option value=''>No boarders found</option>";
}

$conn->close();
?>