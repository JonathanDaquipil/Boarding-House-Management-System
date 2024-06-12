<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bed Management</title>
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
            <h1>Bed Management</h1>
        </div>

       
        <div class="mb-3">
            <button class="btn btn-success" data-toggle="modal" data-target="#addBedModal">Add New</button>
        </div>

        <div class="table-responsive mt-4">
            <table class="table table-bordered text-center">
                <thead>
                    <tr class="bg-primary text-white">
                        <th>Bed No.</th>
                        <th>Room No.</th>
                        <th>Daily Rate</th>
                        <th>Monthly Rate</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require 'config.php';

                    $query = "SELECT * FROM room_table";
                    $result = $conn->query($query);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['bed_no'] . "</td>";
                            echo "<td>" . $row['room_no'] . "</td>";
                            echo "<td>" . $row['daily_rate'] . "</td>";
                            echo "<td>" . $row['monthly_rate'] . "</td>";
                            echo "<td>" . $row['status'] . "</td>";
                            echo "<td>
                                    <button class='btn btn-info btn-sm' data-toggle='modal' data-target='#viewModal' data-id='" . $row['room_id'] . "' data-bed_no='" . $row['bed_no'] . "' data-room_no='" . $row['room_no'] . "' data-daily_rate='" . $row['daily_rate'] . "' data-monthly_rate='" . $row['monthly_rate'] . "' data-status='" . $row['status'] . "'>View</button>
                                    <button class='btn btn-warning btn-sm' data-toggle='modal' data-target='#editModal' data-id='" . $row['room_id'] . "' data-bed_no='" . $row['bed_no'] . "' data-room_no='" . $row['room_no'] . "' data-daily_rate='" . $row['daily_rate'] . "' data-monthly_rate='" . $row['monthly_rate'] . "' data-status='" . $row['status'] . "'>Edit</button>
                                    <button class='btn btn-danger btn-sm delete-btn' data-room_id='" . $row['room_id'] . "'>Delete</button>
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
                    <h5 class="modal-title" id="addBedModalLabel">Add New Bed</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="add_bed.php" method="POST">
                    <div class="modal-body">
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
                            <label for="addRoomNo">Room No.</label><br>
                            <div>
                                <label class="radio-inline"><input type="radio" name="room_no" value="RM-001" required> RM-001</label>
                                <label class="radio-inline"><input type="radio" name="room_no" value="RM-002"> RM-002</label>
                                <label class="radio-inline"><input type="radio" name="room_no" value="RM-003"> RM-003</label>
                                <label class="radio-inline"><input type="radio" name="room_no" value="RM-004"> RM-004</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="addDailyRate">Daily Rate</label>
                            <input type="number" class="form-control" id="addDailyRate" name="daily_rate" required>
                        </div>
                        <div class="form-group">
                            <label for="addMonthlyRate">Monthly Rate</label>
                            <input type="number" class="form-control" id="addMonthlyRate" name="monthly_rate" required>
                        </div>
                        <div class="form-group">
                            <label for="addStatus">Status</label><br>
                            <div>
                                <label class="radio-inline"><input type="radio" name="status" value="Available" required> Available</label>
                                <label class="radio-inline"><input type="radio" name="status" value="Occupied"> Occupied</label>
                            </div>
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

    <!-- View Bed Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewModalLabel">View Bed</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="viewBedNo">Bed No.</label>
                        <p id="viewBedNo"></p>
                    </div>
                    <div class="form-group">
                        <label for="viewRoomNo">Room No.</label>
                        <p id="viewRoomNo"></p>
                    </div>
                    <div class="form-group">
                        <label for="viewDailyRate">Daily Rate</label>
                        <p id="viewDailyRate"></p>
                    </div>
                    <div class="form-group">
                        <label for="viewMonthlyRate">Monthly Rate</label>
                        <p id="viewMonthlyRate"></p>
                    </div>
                    <div class="form-group">
                        <label for="viewStatus">Status</label>
                        <p id="viewStatus"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Bed Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Bed</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="edit_bed.php" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="room_id" id="editRoomId">
                        <div class="form-group">
                            <label for="editBedNo">Bed No.</label>
                            <div>
                                <label class="radio-inline"><input type="radio" name="bed_no" value="BD-001" required> BD-001</label>
                                <label class="radio-inline"><input type="radio" name="bed_no" value="BD-002"> BD-002</label>
                                <label class="radio-inline"><input type="radio" name="bed_no" value="BD-003"> BD-003</label>
                                <label class="radio-inline"><input type="radio" name="bed_no" value="BD-004"> BD-004</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="editRoomNo">Room No.</label>
                            <div>
                                <label class="radio-inline"><input type="radio" name="room_no" value="RM-001" required> RM-001</label>
                                <label class="radio-inline"><input type="radio" name="room_no" value="RM-002"> RM-002</label>
                                <label class="radio-inline"><input type="radio" name="room_no" value="RM-003"> RM-003</label>
                                <label class="radio-inline"><input type="radio" name="room_no" value="RM-004"> RM-004</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="editDailyRate">Daily Rate</label>
                            <input type="number" class="form-control" id="editDailyRate" name="daily_rate" required>
                        </div>
                        <div class="form-group">
                            <label for="editMonthlyRate">Monthly Rate</label>
                            <input type="number" class="form-control" id="editMonthlyRate" name="monthly_rate" required>
                        </div>
                        <div class="form-group">
                            <label for="editStatus">Status</label><br>
                            <div>
                                <label class="radio-inline"><input type="radio" name="status" value="Available" required> Available</label>
                                <label class="radio-inline"><input type="radio" name="status" value="Occupied"> Occupied</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#viewModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var bed_no = button.data('bed_no');
                var room_no = button.data('room_no');
                var daily_rate = button.data('daily_rate');
                var monthly_rate = button.data('monthly_rate');
                var status = button.data('status');

                var modal = $(this);
                modal.find('#viewBedNo').text(bed_no);
                modal.find('#viewRoomNo').text(room_no);
                modal.find('#viewDailyRate').text(daily_rate);
                modal.find('#viewMonthlyRate').text(monthly_rate);
                modal.find('#viewStatus').text(status);
            });

            $('#editModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var room_id = button.data('id');
                var bed_no = button.data('bed_no');
                var room_no = button.data('room_no');
                var daily_rate = button.data('daily_rate');
                var monthly_rate = button.data('monthly_rate');
                var status = button.data('status');

                var modal = $(this);
                modal.find('#editRoomId').val(room_id);
                modal.find('input[name="bed_no"][value="' + bed_no + '"]').prop('checked', true);
                modal.find('input[name="room_no"][value="' + room_no + '"]').prop('checked', true);
                modal.find('#editDailyRate').val(daily_rate);
                modal.find('#editMonthlyRate').val(monthly_rate);
                modal.find('input[name="status"][value="' + status + '"]').prop('checked', true);
            });

            $('.delete-btn').on('click', function() {
                var room_id = $(this).data('room_id');
                if (confirm('Are you sure you want to delete this bed?')) {
                    $.ajax({
                        url: 'delete_bed.php',
                        type: 'POST',
                        data: { room_id: room_id },
                        success: function(response) {
                            alert(response);
                            location.reload();
                        },
                        error: function(xhr, status, error) {
                            alert('An error occurred: ' + xhr.responseText);
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
