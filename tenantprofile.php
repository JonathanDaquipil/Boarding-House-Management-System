<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tenant Profile</title>
    <link rel="stylesheet" href="tenant.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="list" id="adminpage">
        <img src="logo1.png" class="pic">
        <ul>
            <li><a href="admin_page.php"><i class="fa-solid fa-house"></i> Dashboard</a></li>   
            <li><a href="tenantprofile.php"><i class="fa-solid fa-people-line"></i> Tenant Profile</a></li>
            <li><a href="roommanagement.php"><i class="fa-solid fa-house-lock"></i> Room Management</a></li>
            <li><a href="bedmanagement.php"><i class="fa-solid fa-bed"></i> Bed Management</a></li>
            <li><a href="bedassignment.php"><i class="fa-solid fa-cart-flatbed-suitcase"></i> Bed Assignment</a></li>
            <li><a href="utilitybills.php"><i class="fa-solid fa-money-bill"></i> Utility Bills</a></li>
            <li><a href="invoice.php"><i class="fa-solid fa-file-invoice"></i> Invoice</a></li>
            <li><a href="paymenthistory.php"><i class="fa-solid fa-clock-rotate-left"></i> Payment History</a></li>
            <li><a href="payment.php"><i class="fa-solid fa-credit-card"></i> Payment</a></li>
            <li><a href="noticeboard.php"><i class="fa-solid fa-triangle-exclamation"></i> Notice Board</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="formtitle" id="adminpage">
            <h1>Tenant Profile</h1>

            <div class="mb-3">
                <a href="index.php" class="btn btn-success">Add New</a>
            </div>
            <div class="table-responsive mt-4">
                <table class="table table-bordered text-center">
                    <thead>
                        <tr class="bg-primary text-white">
                            <th>Profile</th>
                            <th>Boarder Info</th>
                            <th>Address</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require 'config.php';
                        $query = "SELECT * FROM registration_table WHERE utype = 'Boarder'";
                        $result = $conn->query($query);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $profile_image_path = isset($row['profile_image_path']) ? $row['profile_image_path'] : 'default_image.jpg';
                                echo "<tr>";
                                echo "<td><img src='" . $profile_image_path . "' alt='Profile Image' class='img-thumbnail' width='50'></td>";
                                echo "<td style='text-align: left;'>" . "Name: " . $row['fname'] . " " . $row['lname'] . "<br>Contact: " . $row['number'] . "<br>Email: " . $row['email'] . "</td>";
                                echo "<td>" . $row['address'] . "</td>";
                                echo "<td>
                                        <button class='btn btn-info btn-sm' data-toggle='modal' data-target='#viewModal' data-user_id='" . $row['user_id'] . "' data-fname='" . $row['fname'] . "' data-lname='" . $row['lname'] . "' data-number='" . $row['number'] . "' data-email='" . $row['email'] . "' data-address='" . $row['address'] . "' data-profile_image_path='" . $profile_image_path . "'>View</button>
                                        <button class='btn btn-warning btn-sm' data-toggle='modal' data-target='#editModal' data-user_id='" . $row['user_id'] . "' data-fname='" . $row['fname'] . "' data-lname='" . $row['lname'] . "' data-number='" . $row['number'] . "' data-email='" . $row['email'] . "' data-address='" . $row['address'] . "' data-profile_image_path='" . $profile_image_path . "'>Edit</button>
                                        <button class='btn btn-danger btn-sm delete-btn' data-user_id='" . $row['user_id'] . "'>Delete</button>
                                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>No tenants found</td></tr>";
                        }
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- View Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewModalLabel">View Tenant</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="viewProfileImage">Profile Image</label>
                        <div id="viewProfileImageContainer">
                            <img src="" id="viewProfileImage" class="img-thumbnail" width="100">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="viewFname">First Name</label>
                        <input type="text" class="form-control" id="viewFname" readonly>
                    </div>
                    <div class="form-group">
                        <label for="viewLname">Last Name</label>
                        <input type="text" class="form-control" id="viewLname" readonly>
                    </div>
                    <div class="form-group">
                        <label for="viewNumber">Contact Number</label>
                        <input type="text" class="form-control" id="viewNumber" readonly>
                    </div>
                    <div class="form-group">
                        <label for="viewEmail">Email</label>
                        <input type="text" class="form-control" id="viewEmail" readonly>
                    </div>
                    <div class="form-group">
                        <label for="viewAddress">Address</label>
                        <input type="text" class="form-control" id="viewAddress" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Tenant</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="edit_tenant.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" id="editUserId" name="user_id">
                        <div class="form-group">
                            <label for="editProfileImage">Profile Image</label>
                            <div id="editProfileImageContainer">
                                <img src="" id="editProfileImage" class="img-thumbnail" width="100">
                            </div>
                            <input type="file" class="form-control-file" id="profile_image" name="profile_image">
                        </div>
                        <div class="form-group">
                            <label for="editFname">First Name</label>
                            <input type="text" class="form-control" id="editFname" name="fname" required>
                        </div>
                        <div class="form-group">
                            <label for="editLname">Last Name</label>
                            <input type="text" class="form-control" id="editLname" name="lname" required>
                        </div>
                        <div class="form-group">
                            <label for="editNumber">Contact Number</label>
                            <input type="text" class="form-control" id="editNumber" name="number" required>
                        </div>
                        <div class="form-group">
                            <label for="editEmail">Email</label>
                            <input type="text" class="form-control" id="editEmail" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="editAddress">Address</label>
                            <input type="text" class="form-control" id="editAddress" name="address" required>
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
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#viewModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var user_id = button.data('user_id');
                var fname = button.data('fname');
                var lname = button.data('lname');
                var number = button.data('number');
                var email = button.data('email');
                var address = button.data('address');
                var profile_image_path = button.data('profile_image_path');

                var modal = $(this);
                modal.find('#viewFname').val(fname);
                modal.find('#viewLname').val(lname);
                modal.find('#viewNumber').val(number);
                modal.find('#viewEmail').val(email);
                modal.find('#viewAddress').val(address);
                modal.find('#viewProfileImage').attr('src', profile_image_path);
            });

            $('#editModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var user_id = button.data('user_id');
                var fname = button.data('fname');
                var lname = button.data('lname');
                var number = button.data('number');
                var email = button.data('email');
                var address = button.data('address');
                var profile_image_path = button.data('profile_image_path');

                var modal = $(this);
                modal.find('#editUserId').val(user_id);
                modal.find('#editFname').val(fname);
                modal.find('#editLname').val(lname);
                modal.find('#editNumber').val(number);
                modal.find('#editEmail').val(email);
                modal.find('#editAddress').val(address);
                modal.find('#editProfileImage').attr('src', profile_image_path);
            });

            $('.delete-btn').click(function() {
                var user_id = $(this).data('user_id');
                if (confirm('Are you sure you want to delete this tenant?')) {
                    $.ajax({
                        url: 'delete_tenant.php',
                        type: 'POST',
                        data: { user_id: user_id },
                        success: function(response) {
                            alert(response);
                            location.reload();
                        },
                        error: function(xhr, status, error) {
                            alert('An error occurred: ' + error);
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>