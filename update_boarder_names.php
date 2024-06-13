<?php
require 'config.php';


$sql = "
    UPDATE bed_assignment_table bat
    JOIN registration_table rt ON bat.user_id = rt.user_id
    SET bat.boarder_name = CONCAT(rt.fname, ' ', rt.lname)
";


if ($conn->query($sql) === TRUE) {
    echo "Boarder names updated successfully.";
} else {
    echo "Error updating boarder names: " . $conn->error;
}


$conn->close();
?>
