<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Management</title>
    <link rel="stylesheet" href="roommanagement.css">
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
            <h1>Room Management</h1>
        </div>

        <!-- Add New Button -->
        <div class="mb-3">
            <button class="btn btn-success" data-toggle="modal" data-target="#addRoomModal">Add New</button>
        </div>

        <div class="table-responsive mt-4">
            <table class="table table-bordered text-center">
                <thead>
                    <tr class="bg-primary text-white">
                        <th>Room Number</th>
                        <th>Description</th>
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
                            echo "<td>" . $row['room_no'] . "</td>";
                            echo "<td>" . $row['description'] . "</td>";
                            echo "<td>
                                    <button class='btn btn-warning btn-sm' data-toggle='modal' data-target='#editRoomModal' data-room_id='" . $row['room_id'] . "' data-room_no='" . $row['room_no'] . "' data-description='" . $row['description'] . "'>Edit</button>
                                    <button class='btn btn-danger btn-sm delete-btn' data-room_id='" . $row['room_id'] . "'>Delete</button>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No rooms found</td>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Room Modal -->
    <div class="modal fade" id="addRoomModal" tabindex="-1" aria-labelledby="addRoomModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addRoomModalLabel">Add Room</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="add_room.php" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="roomNumber">Room Number</label><br>
                            <input type="radio" id="roomNumber_RM001" name="room_number" value="RM-001" required>
                            <label for="roomNumber_RM001">RM-001</label><br>
                            <input type="radio" id="roomNumber_RM002" name="room_number" value="RM-002" required>
                            <label for="roomNumber_RM002">RM-002</label><br>
                            <input type="radio" id="roomNumber_RM003" name="room_number" value="RM-003" required>
                            <label for="roomNumber_RM003">RM-003</label><br>
                            <input type="radio" id="roomNumber_RM004" name="room_number" value="RM-004" required>
                            <label for="roomNumber_RM004">RM-004</label><br>
                        </div>
                        <div class="form-group">
                            <label for="roomDescription">Description</label>
                            <input type="text" class="form-control" id="roomDescription" name="description" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Room</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Room Modal -->
    <div class="modal fade" id="editRoomModal" tabindex="-1" aria-labelledby="editRoomModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editRoomModalLabel">Edit Room</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="edit_room.php" method="POST">
                    <div class="modal-body">
                        <input type="hidden" id="editRoomId" name="room_id">
                        <div class="form-group">
                            <label for="editRoomNumber">Room Number</label><br>
                            <input type="radio" id="editRoomNumber_RM001" name="room_number" value="RM-001" required>
                            <label for="editRoomNumber_RM001">RM-001</label><br>
                            <input type="radio" id="editRoomNumber_RM002" name="room_number" value="RM-002" required>
                            <label for="editRoomNumber_RM002">RM-002</label><br>
                            <input type="radio" id="editRoomNumber_RM003" name="room_number" value="RM-003" required>
                            <label for="editRoomNumber_RM003">RM-003</label><br>
                            <input type="radio" id="editRoomNumber_RM004" name="room_number" value="RM-004" required>
                            <label for="editRoomNumber_RM004">RM-004</label><br>
                        </div>
                        <div class="form-group">
                            <label for="editRoomDescription">Description</label>
                            <input type="text" class="form-control" id="editRoomDescription" name="description" required>
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
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $('#editRoomModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var room_id = button.data('room_id');
            var room_number = button.data('room_number');
            var description = button.data('description');

            var modal = $(this);
            modal.find('#editRoomId').val(room_id);
            modal.find('input[name="room_number"][value="' + room_number + '"]').prop('checked', true);
            modal.find('#editRoomDescription').val(description);
        });

        $(document).on('click', '.delete-btn', function () {
            if (confirm('Are you sure you want to delete this room?')) {
                var room_id = $(this).data('room_id');
                $.ajax({
                    url: 'delete_room.php',
                    type: 'POST',
                    data: { room_id: room_id },
                    success: function (response) {
                        if (response == 'success') {
                            alert('Room deleted successfully.');
                            location.reload();
                        } else {
                            alert('Error deleting room.');
                        }
                    },
                    error: function () {
                        alert('Error deleting room.');
                    }
                });
            }
        });
    </script>
</body>
</html>