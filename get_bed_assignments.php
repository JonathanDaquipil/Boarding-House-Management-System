<?php
require 'config.php';

$sql = "SELECT a.assignment_id, t.user_id, t.fname, t.lname, r.room_id, r.room_no, b.bed_id, b.bed_no, a.date_start, a.due_date 
        FROM bed_assignment_table a
        JOIN registration_table t ON a.user_id = t.user_id
        JOIN room_table r ON a.room_id = r.room_id
        JOIN bed_table b ON a.bed_id = b.bed_id";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['fname'] . " " . $row['lname'] . "</td>
                <td>" . $row['room_no'] . "</td>
                <td>" . $row['bed_no'] . "</td>
                <td>" . $row['date_start'] . "</td>
                <td>" . $row['due_date'] . "</td>
                <td>
                    <button class='btn btn-warning btn-sm' data-toggle='modal' data-target='#editBedModal' 
                        data-assignment_id='" . $row['assignment_id'] . "' 
                        data-tenant_id='" . $row['user_id'] . "' 
                        data-room_id='" . $row['room_id'] . "' 
                        data-room_no='" . $row['room_no'] . "' 
                        data-boarder_name='" . $row['fname'] . " " . $row['lname'] . "' 
                        data-bed_no='" . $row['bed_no'] . "' 
                        data-bed_id='" . $row['bed_id'] . "' 
                        data-date_start='" . $row['date_start'] . "' 
                        data-due_date='" . $row['due_date'] . "'>Edit</button>
                    <button class='btn btn-danger btn-sm delete-btn' data-assignment_id='" . $row['assignment_id'] . "'>Delete</button>
                </td>
            </tr>";
    }
} else {
    echo "<tr><td colspan='6'>No bed assignments found.</td></tr>";
}

$conn->close();
?>