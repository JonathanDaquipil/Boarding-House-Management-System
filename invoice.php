<?php
require 'config.php'; 

// Handle AJAX request for boarder details
if (isset($_GET['boarderId'])) {
    $boarderId = intval($_GET['boarderId']);
    $sql = "SELECT fname, lname FROM registration_table WHERE user_id = $boarderId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $boarder = $result->fetch_assoc();
        echo json_encode($boarder);
    } else {
        echo json_encode(['error' => 'Boarder not found']);
    }
    exit;
}


$boarderNames = [];
$sql = "SELECT user_id, CONCAT(fname, ' ', lname) AS full_name FROM registration_table";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $boarderNames[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <link rel="stylesheet" href="invoice.css">
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

    <div class="formtitle" id="adminpage">
        <h1>Invoice</h1>

        <button class="btn btn-success mb-3" id="addInvoiceModalButton" data-toggle="modal" data-target="#addInvoiceModal">Add New</button>
        
       
        <div class="table-responsive mt-4">
            <table class="table table-bordered text-center">
                <thead>
                    <tr class="bg-primary text-white">
                        <th>Invoice Number</th>
                        <th>Boarder Name</th>
                        <th>Discount</th>
                        <th>Penalty</th>
                        <th>Total Rate</th>
                        <th>Due Date</th>
                        <th>Status</th>
                       
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM invoice_table";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['invoice_number'] . "</td>";
                            echo "<td>" . $row['boarder_name'] . "</td>";
                            echo "<td>" . $row['discount'] . "</td>";
                            echo "<td>" . $row['penalty'] . "</td>";
                            echo "<td>" . $row['total_rate'] . "</td>";
                            echo "<td>" . $row['due_date'] . "</td>";
                           
                            echo "<td>
                                <button class='btn btn-warning btn-sm edit-btn' data-toggle='modal' data-target='#editInvoiceModal' data-invoice='" . json_encode($row) . "'>Edit</button>
                                <button class='btn btn-danger btn-sm delete-btn' data-invoice-id='" . $row['invoice_number'] . "'>Delete</button>
                            </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>No invoices found</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>


     <div class="modal fade" id="addInvoiceModal" tabindex="-1" aria-labelledby="addInvoiceModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addInvoiceModalLabel">Add New Invoice</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="add_invoice.php" method="POST" id="addInvoiceForm">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="invoiceNumber">Invoice Number</label>
                            <input type="text" class="form-control" id="nvoice_number" name="invoice_number" required>
                        </div>
                        <div class="form-group">
                            <label for="boarderName">Boarder Name</label>
                            <select class="form-control" id="boarder_name" name="boarder_name" required>
                                <option value="" disabled selected>Select Boarder</option>
                                <?php
                                foreach ($boarderNames as $boarder) {
                                    echo "<option value='" . htmlspecialchars($boarder['user_id']) . "'>" . htmlspecialchars($boarder['full_name']) . "</option>";
                                }
                                ?>
                            </select>
                    
                            <input type="hidden" id="boarder_fname" name="boarder_fname">
                            <input type="hidden" id="boarder_lname" name="boarder_lname">
                        </div>
                        <div class="form-group">
                            <label for="discount">Discount</label>
                            <input type="text" class="form-control" id="discount" name="discount" required>
                        </div>
                        <div class="form-group">
                            <label for="penalty">Penalty</label>
                            <input type="text" class="form-control" id="penalty" name="penalty" required>
                        </div>
                        <div class="form-group">
                            <label for="totalRate">Total Rate</label>
                            <input type="text" class="form-control" id="totalRate" name="total_rate" required>
                        </div>
                        <div class="form-group">
                            <label for="dueDate">Due Date</label>
                            <input type="date" class="form-control" id="due_date" name="due_date" required>
                        </div>
                       
                            </select>
                        </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
$(document).ready(function(){
    $('#boarder_name').change(function() {
        var selectedBoarder = $(this).val();
        $.ajax({
            url: 'get_due_date.php', // File to handle AJAX request for due date
            type: 'GET',
            data: { boarder: selectedBoarder },
            success: function(response) {
                $('#due_date').val(response); // Update the due date input field with the fetched value
            },
            error: function(xhr, status, error) {
                console.error('Error fetching due date:', error);
            }
        });
    });

    $('#addInvoiceModal').on('hidden.bs.modal', function () {
        $(this).find('form')[0].reset();
    });
});
</script>
    <!-- Edit Invoice Modal -->
    <div class="modal fade" id="editInvoiceModal" tabindex="-1" aria-labelledby="editInvoiceModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editInvoiceModalLabel">Edit Invoice</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="edit_invoice.php" method="POST" id="editInvoiceForm">
                    <div class="modal-body">
                        <input type="hidden" id="editInvoiceId" name="invoice_id">
                        <div class="form-group">
                            <label for="editInvoiceNumber">Invoice Number</label>
                            <input type="text" class="form-control" id="editInvoiceNumber" name="invoice_number" required>
                        </div>
                        <div class="form-group">
                            <label for="editBoarderName">Boarder Name</label>
                            <select class="form-control" id="editBoarderName" name="boarder_name" required>
                                <option value="" disabled selected>Select Boarder</option>
                                <?php
                                foreach ($boarderNames as $boarder) {
                                    echo "<option value='" . htmlspecialchars($boarder['user_id']) . "'>" . htmlspecialchars($boarder['full_name']) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="editDiscount">Discount</label>
                            <input type="text" class="form-control" id="editDiscount" name="discount" required>
                        </div>
                        <div class="form-group">
                            <label for="editPenalty">Penalty</label>
                            <input type="text" class="form-control" id="editPenalty" name="penalty" required>
                        </div>
                        <div class="form-group">
                            <label for="editTotalRate">Total Rate</label>
                            <input type="text" class="form-control" id="editTotalRate" name="total_rate" required>
                        </div>
                        <div class="form-group">
                            <label for="editDueDate">Due Date</label>
                            <input type="date" class="form-control" id="editDueDate" name="due_date" required>
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

    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    


    <script>
        $(document).ready(function(){
            $('#boarderName').change(function() {
                var selectedBoarder = $(this).val();
                $.ajax({
                    url: 'get_boarder_names.php',
                    type: 'GET',
                    data: { boarderId: selectedBoarder },
                    success: function(response) {
                        var data = JSON.parse(response);
                        $('#boarderFirstName').val(data.fname);
                        $('#boarderLastName').val(data.lname);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching boarder names:', error);
                    }
                });
            });
        });
    </script>


    <!-- Custom JavaScript -->
    <script>
    $(document).ready(function(){
        // Function to delete an invoice
        $(document).on('click', '.delete-btn', function() {
            if (confirm('Are you sure you want to delete this invoice?')) {
                var invoiceId = $(this).data('invoice-id');
                // AJAX call to delete_invoice.php
                $.ajax({
                    url: 'delete_invoice.php',
                    type: 'POST',
                    data: { invoice_id: invoiceId },
                    dataType: 'json',
                    success: function(response) {
                        if(response.success) {
                            // If deletion is successful, remove the row from the table
                            alert('Invoice deleted successfully.');
                            location.reload(); // Reload the page to reflect the changes
                        } else {
                            // If there's an error, display the error message
                            alert('Error deleting invoice: ' + response.error);
                        }
                    },
                    error: function(xhr, status, error) {
                        // If AJAX request fails, display an error message
                        console.error('Error deleting invoice:', error);
                        alert('Error deleting invoice. Please try again.');
                    }
                });
            }
        });
    });
    </script>

            <script>
            $(document).on('click', '.edit-btn', function() {
                var invoice = $(this).data('invoice');
                $('#editInvoiceId').val(invoice.invoice_number);
                $('#editInvoiceNumber').val(invoice.invoice_number);
                $('#editBoarderName').val(invoice.boarder_name);
                $('#editDiscount').val(invoice.discount);
                $('#editPenalty').val(invoice.penalty);
                $('#editTotalRate').val(invoice.total_rate);
                $('#editDueDate').val(invoice.due_date);
               
            });

            $('#boarderName').change(function() {
                var selectedBoarder = $(this).val();
                $.ajax({
                    url: 'get_due_date.php',
                    type: 'GET',
                    data: { boarder: selectedBoarder },
                    success: function(response) {
                        $('#dueDate').val(response);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching due date:', error);
                    }
                });
            });

            $('#addInvoiceModal').on('hidden.bs.modal', function () {
                $(this).find('form')[0].reset();
            });
       
    </script>
</body>
</html>
