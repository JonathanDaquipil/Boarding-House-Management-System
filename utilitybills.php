<?php
require 'config.php';


$query = "SELECT * FROM bills";
$result = mysqli_query($conn, $query); 

if (!$result) {
 
    die("Query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Utility Bills</title>
    <link rel="stylesheet" href="utilitybills.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
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

    <div class="formtitle" id="adminpage">
        <h1>Utility Bills</h1>
    

    <!-- Add New Button -->
    <div class="mb-3">
        <button class="btn btn-success" data-toggle="modal" data-target="#addBillModal">Add New</button>
    </div>

    <div class="table-responsive mt-4">
        <table class="table table-bordered text-center">
            <thead>
                <tr class="bg-primary text-white">
                    <th>Bill Name</th>
                    <th>Rate</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
         
                while ($row = mysqli_fetch_assoc($result)) {
                    $billId = $row['bill_id'];
                    $billName = $row['bills'];
                    $billRate = $row['rate'];

                    echo "<tr>";
                    echo "<td>$billName</td>";
                    echo "<td>$billRate</td>";
                    echo "<td>";
                    echo "<button class='btn btn-primary' data-toggle='modal' data-target='#editBillModal' data-bill_id='$billId' data-bill_name='$billName' data-bill_rate='$billRate'>Edit</button>";
                    echo "<button class='btn btn-danger' data-toggle='modal' data-target='#deleteBillModal' data-bill_id='$billId'>Delete</button>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>


    <div class="modal fade" id="addBillModal" tabindex="-1" aria-labelledby="addBillModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="add_bill.php">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addBillModalLabel">Add New Bill</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="bill_name">Bill Name</label>
                            <input type="text" class="form-control" id="bill_name" name="bill_name" required>
                        </div>
                        <div class="form-group">
                            <label for="bill_rate">Rate</label>
                            <input type="text" class="form-control" id="bill_rate" name="bill_rate" required>
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


    <div class="modal fade" id="editBillModal" tabindex="-1" aria-labelledby="editBillModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="edit_bill.php">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editBillModalLabel">Edit Bill</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="edit_bill_id" name="bill_id">
                        <div class="form-group">
                            <label for="edit_bill_name">Bill Name</label>
                            <input type="text" class="form-control" id="edit_bill_name" name="bill_name" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_bill_rate">Rate</label>
                            <input type="text" class="form-control" id="edit_bill_rate" name="bill_rate" required>
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


    <div class="modal fade" id="deleteBillModal" tabindex="-1" aria-labelledby="deleteBillModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="delete_bill.php">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteBillModalLabel">Delete Bill</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="delete_bill_id" name="bill_id">
                        <p>Are you sure you want to delete this bill?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>

        $('#editBillModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var billId = button.data('bill_id');
            var billName = button.data('bill_name');
            var billRate = button.data('bill_rate');
            
            var modal = $(this);
            modal.find('#edit_bill_id').val(billId);
            modal.find('#edit_bill_name').val(billName);
            modal.find('#edit_bill_rate').val(billRate);
        });


        $('#deleteBillModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var billId = button.data('bill_id');
            
            var modal = $(this);
            modal.find('#delete_bill_id').val(billId);
        });
    </script>
</body>
</html>

<?php

mysqli_close($conn);
?>
