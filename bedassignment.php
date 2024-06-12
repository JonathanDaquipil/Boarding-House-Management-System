
<?php
require 'config.php';

if (isset($_GET['boarderId'])) {
    $boarderId = $_GET['boarderId'];

    $query = "SELECT due_date, fname, lname FROM registration_table WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $boarderId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        echo json_encode($data);
    } else {
        echo json_encode(['error' => 'No data found for the selected boarder']);
    }

    $stmt->close();
    $conn->close();
    exit;
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bed Assignment</title>
    <link rel="stylesheet" href="bedmanagement.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="list" id="adminpage">
        <img src="logo1.png" class="pic">
        <ul>
        <pre>
                <li><a href="admin_page.php"><i class="fa-solid fa-house"></i>  Dashboard</a></li>   
                <li><a href="tenantprofile.php"><i class="fa-solid fa-people-line"></i>  Tenant Profile</a></li>
                <li><a href="roommanagement.php"><i class="fa-solid fa-house-lock"></i>  Room Management</a></li>
                <li><a href="bedmanagement.php"><i class="fa-solid fa-bed"></i>  Bed Management</a></li>
                <li><a href="bedassignment.php"><i class="fa-solid fa-cart-flatbed-suitcase"></i>  Bed Assignment</a></li>
                <li><a href="utilitybills.php"><i class="fa-solid fa-money-bill"></i>  Utility Bills</a></li>
                <li><a href="invoice.php"><i class="fa-solid fa-file-invoice"></i>  Invoice</a></li>
                <li><a href="paymenthistory.php"><i class="fa-solid fa-clock-rotate-left"></i>  Payment History</a></li>
                <li><a href="payment.php"><i class="fa-solid fa-credit-card"></i>  Payment</a></li>
                <li><a href="noticeboard.php"><i class="fa-solid fa-triangle-exclamation"></i>  Notice Board</a></li>
               
            </pre>
        </ul>
    </div>

    <div class="main-content">
        <div class="formtitle" id="adminpage">
            <h1>Bed Assignment</h1>
        </div>

      
        <div class="mb-3">
            <button class="btn btn-success" data-toggle="modal" data-target="#addBedModal">Add New</button>
        </div>

        <div class="table-responsive mt-4">
            <table class="table table-bordered text-center">
                <thead>
                    <tr class="bg-primary text-white">
                        <th>Boarder Name</th>
                        <th>Room No.</th>
                        <th>Bed No.</th>
                        <th>Date Start</th>
                        <th>Due Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    

                    $query = "SELECT 
                                CONCAT(r.fname, ' ', r.lname) AS boarder_name, 
                                b.room_no, 
                                b.bed_no, 
                                ba.date_start, 
                                ba.due_date,
                                ba.assignment_id
                              FROM bed_assignment_table ba
                              JOIN bed_table b ON ba.bed_id = b.bed_id
                              JOIN registration_table r ON ba.user_id = r.user_id";
                    $result = $conn->query($query);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['boarder_name'] . "</td>";
                            echo "<td>" . $row['room_no'] . "</td>";
                            echo "<td>" . $row['bed_no'] . "</td>";
                            echo "<td>" . $row['date_start'] . "</td>";
                            echo "<td>" . $row['due_date'] . "</td>";
                            echo "<td>
                                    <button class='btn btn-warning btn-sm' data-toggle='modal' data-target='#editModal' data-assignment_id='" . $row['assignment_id'] . "' data-room_no='" . $row['room_no'] . "' data-bed_no='" . $row['bed_no'] . "' data-date_start='" . $row['date_start'] . "' data-due_date='" . $row['due_date'] . "'>Edit</button>
                                    <button class='btn btn-danger btn-sm delete-btn' data-assignment_id='" . $row['assignment_id'] . "'>Delete</button>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No beds found</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    
    <div class="modal fade" id="addBedModal" tabindex="-1" aria-labelledby="addBedModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addBedModalLabel">Add New Bed Assignment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="add_bed_assignment.php" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="boarderName">Boarder Name</label>
                            <select class="form-control" id="boarderName" name="user_id" required>
                                <option value="" disabled selected>Select Boarder</option>
                                <?php
                                require 'config.php';
                                $boarderQuery = "SELECT user_id, CONCAT(fname, ' ', lname) AS full_name FROM registration_table";
                                $boarderResult = $conn->query($boarderQuery);

                                if ($boarderResult->num_rows > 0) {
                                    while ($boarderRow = $boarderResult->fetch_assoc()) {
                                        echo "<option value='" . $boarderRow['user_id'] . "'>" . $boarderRow['full_name'] . "</option>";
                                    }
                                } else {
                                    echo "<option value='' disabled>No registered boarders</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="addRoomNo">Room No.</label><br>
                            <div>
                                <label class="radio-inline"><input type="radio" name="room_no" value="RM-001" required> RM-001</label>
                                <label class="radio-inline"><input type="radio" name="room_no" value="RM-002"> RM-002</label>
                                <label class="radio-inline"><input type="radio" name="room_no" value="RM-003"> RM-003</label>
                                <label class="radio-inline"><input type="radio" name="room_no" value="RM-004"> RM-004</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="addBedNo">Bed No.</label><br>
                            <div>
                                <label class="radio-inline"><input type="radio" name="bed_no" value="BD-001" required> BD-001</label>
                                <label class="radio-inline"><input type="radio" name="bed_no" value="BD-002"> BD-002</label>
                                <label class="radio-inline"><input type="radio" name="bed_no" value="BD-003"> BD-003</label>
                                <label class="radio-inline"><input type="radio" name="bed_no" value="BD-004"> BD-004</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="addDateStart">Date Start</label>
                            <input type="date" class="form-control" id="addDateStart" name="date_start" required>
                        </div>
                        <div class="form-group">
                            <label for="addDueDate">Due Date</label>
                            <input type="date" class="form-control" id="addDueDate" name="due_date" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Bed</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Bed Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Bed Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="edit_bed_assignment.php" method="POST">
                    <div class="modal-body">
                        <input type="hidden" id="editAssignmentId" name="assignment_id">
                        <div class="form-group">
                            <label for="editRoomNo">Room No.</label>
                            <input type="text" class="form-control" id="editRoomNo" name="room_no" required>
                        </div>
                        <div class="form-group">
                            <label for="editBedNo">Bed No.</label>
                            <input type="text" class="form-control" id="editBedNo" name="bed_no" required>
                        </div>
                        <div class="form-group">
                            <label for="editDateStart">Date Start</label>
                            <input type="date" class="form-control" id="editDateStart" name="date_start" required>
                        </div>
                        <div class="form-group">
                            <label for="editDueDate">Due Date</label>
                            <input type="date" class="form-control" id="editDueDate" name="due_date" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Hidden form to handle deletions -->
    <form id="deleteForm" action="delete_bed_assignment.php" method="POST" style="display: none;">
        <input type="hidden" id="deleteAssignmentId" name="assignment_id">
    </form>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $('#editModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var assignmentId = button.data('assignment_id');
            var roomNo = button.data('room_no');
            var bedNo = button.data('bed_no');
            var dateStart = button.data('date_start');
            var dueDate = button.data('due_date');

            var modal = $(this);
            modal.find('#editAssignmentId').val(assignmentId);
            modal.find('#editRoomNo').val(roomNo);
            modal.find('#editBedNo').val(bedNo);
            modal.find('#editDateStart').val(dateStart);
            modal.find('#editDueDate').val(dueDate);
        });

        $('.delete-btn').on('click', function () {
            if (confirm('Are you sure you want to delete this bed assignment?')) {
                var assignmentId = $(this).data('assignment_id');
                $('#deleteAssignmentId').val(assignmentId);
                $('#deleteForm').submit();
            }
        });
    </script>
</body>
</html>
