<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link rel="stylesheet" href="tenant.css">
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
            <h1>Payment</h1>

         
            <div class="mb-3">
                <button class="btn btn-success" data-toggle="modal" data-target="#addPaymentModal">Add New</button>
            </div>

            <div class="table-responsive mt-4">
                <table class="table table-bordered text-center">
                    <thead>
                        <tr class="bg-primary text-white">
                            <th>Invoice Number</th>
                            <th>Payment Amount</th>
                            <th>Date</th>
                            <th>Payment Method</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require 'config.php';

                        $query = "SELECT * FROM payments";
                        $result = $conn->query($query);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr id='payment-row-".$row['payment_id']."'>";
                                echo "<td>" . $row['invoice_number'] . "</td>";
                                echo "<td>" . $row['amount_paid'] . "</td>";
                                echo "<td>" . $row['payment_date'] . "</td>";
                                echo "<td>" . $row['payment_method'] . "</td>";
                                echo "<td>" . $row['status'] . "</td>";
                                echo "<td>
                                    <button class='btn btn-warning btn-sm edit-btn' data-toggle='modal' data-target='#editPaymentModal' 
                                        data-id='" . $row['payment_id'] . "' 
                                        data-invoice_number='" . $row['invoice_number'] . "' 
                                        data-amount_paid='" . $row['amount_paid'] . "' 
                                        data-payment_date='" . $row['payment_date'] . "' 
                                        data-payment_method='" . $row['payment_method'] . "' 
                                        data-status='" . $row['status'] . "'>Edit</button>
                                    <button class='btn btn-danger btn-sm delete-btn' data-payment_id='" . $row['payment_id'] . "'>Delete</button>
                                </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No Payment found</td></tr>";
                        }

                        $conn->close();

                        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_payment'])) {
                            $paymentId = $_POST['payment_id'];
                            $status = $_POST['status'];

                     
                            $updatePaymentQuery = "UPDATE payments SET status = '$status' WHERE payment_id = $paymentId";
                            if ($conn->query($updatePaymentQuery) === TRUE) {
                                // Update status in boarder_payments_proof table
                                $updateBoarderQuery = "UPDATE boarder_payments_proof SET status = '$status' WHERE payment_id = $paymentId";
                                if ($conn->query($updateBoarderQuery) === TRUE) {
                                    echo json_encode(['success' => true]);
                                } else {
                                    echo json_encode(['success' => false]);
                                }
                            } else {
                                echo json_encode(['success' => false]);
                            }
                        }   
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Payment Modal -->
    <div class="modal fade" id="addPaymentModal" tabindex="-1" aria-labelledby="addPaymentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPaymentModalLabel">Add New Payment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addPaymentForm" action="add_payment.php" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="addInvoiceNumber">Invoice Number</label>
                            <input type="text" class="form-control" id="addInvoiceNumber" name="invoice_number" required>
                        </div>
                        <div class="form-group">
                            <label for="addPaymentAmount">Payment Amount</label>
                            <input type="number" class="form-control" id="addPaymentAmount" name="amount_paid" required>
                        </div>
                        <div class="form-group">
                            <label for="addPaymentDate">Payment Date</label>
                            <input type="date" class="form-control" id="addPaymentDate" name="payment_date" required>
                        </div>
                        <div class="form-group">
                            <label for="addPaymentMethod">Payment Method</label>
                            <select class="form-control" id="addPaymentMethod" name="payment_method" required>
                                <option value="Credit Card">Credit Card</option>
                                <option value="Cash">Cash</option>
                                <option value="Gcash">Gcash</option>
                                <option value="Bank Transfer">Bank Transfer</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="addStatus">Status</label>
                            <select class="form-control" id="addStatus" name="status" required>
                                <option value="Paid">Paid</option>
                                <option value="Pending">Pending</option>
                                <option value="Failed">Failed</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Payment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Payment Modal -->
    <div class="modal fade" id="editPaymentModal" tabindex="-1" aria-labelledby="editPaymentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPaymentModalLabel">Edit Payment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editPaymentForm" action="edit_payment.php" method="POST">
                    <div class="modal-body">
                        <input type="hidden" id="editPaymentId" name="payment_id">
                        <div class="form-group">
                            <label for="editInvoiceNumber">Invoice Number</label>
                            <input type="text" class="form-control" id="editInvoiceNumber" name="invoice_number" required>
                        </div>
                        <div class="form-group">
                            <label for="editPaymentAmount">Payment Amount</label>
                            <input type="number" class="form-control" id="editPaymentAmount" name="amount_paid" required>
                        </div>
                        <div class="form-group">
                            <label for="editPaymentDate">Payment Date</label>
                            <input type="date" class="form-control" id="editPaymentDate" name="payment_date" required>
                        </div>
                        <div class="form-group">
                            <label for="editPaymentMethod">Payment Method</label>
                            <select class="form-control" id="editPaymentMethod" name="payment_method" required>
                                <option value="Credit Card">Credit Card</option>
                                <option value="Cash">Cash</option>
                                <option value="Gcash">Gcash</option>
                                <option value="Bank Transfer">Bank Transfer</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="editStatus">Status</label>
                            <select class="form-control" id="editStatus" name="status" required>
                                <option value="Paid">Paid</option>
                                <option value="Pending">Pending</option>
                                <option value="Failed">Failed</option>
                            </select>
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

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            // Delete Payment Script
            $(document).on('click', '.delete-btn', function() {
                const paymentId = $(this).data('payment_id');
                if (confirm('Are you sure you want to delete this payment?')) {
                    $.ajax({
                        url: 'delete_payment.php',
                        type: 'POST',
                        data: JSON.stringify({ payment_id: paymentId }),
                        contentType: 'application/json',
                        success: function(data) {
                            const res = JSON.parse(data);
                            if (res.success) {
                                $('#payment-row-' + paymentId).remove();
                            } else {
                                alert('Failed to delete payment.');
                            }
                        },
                        error: function() {
                            alert('An error occurred. Please try again.');
                        }
                    });
                }
            });

            // Handle Add Payment Form Submission
            $('#addPaymentForm').on('submit', function(e) {
                e.preventDefault();

                const formData = $(this).serialize();

                $.ajax({
                    url: 'add_payment.php',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        const res = JSON.parse(response);
                        if (res.success) {
                            const newRow = `
                                <tr id="payment-row-${res.payment_id}">
                                    <td>${res.invoice_number}</td>
                                    <td>${res.amount_paid}</td>
                                    <td>${res.payment_date}</td>
                                    <td>${res.payment_method}</td>
                                    <td>${res.status}</td>
                                    <td>
                                        <button class='btn btn-warning btn-sm edit-btn' data-toggle='modal' data-target='#editPaymentModal' 
                                            data-id='${res.payment_id}' 
                                            data-invoice_number='${res.invoice_number}' 
                                            data-amount_paid='${res.amount_paid}' 
                                            data-payment_date='${res.payment_date}' 
                                            data-payment_method='${res.payment_method}' 
                                            data-status='${res.status}'>Edit</button>
                                        <button class='btn btn-danger btn-sm delete-btn' data-payment_id='${res.payment_id}'>Delete</button>
                                    </td>
                                </tr>`;
                            $('table tbody').append(newRow);
                            $('#addPaymentModal').modal('hide');
                            $('#addPaymentForm')[0].reset();
                        } else {
                            alert('Failed to add payment.');
                        }
                    },
                    error: function() {
                        alert('An error occurred. Please try again.');
                    }
                });
            });

            // Fill the Edit Modal with Data
            $(document).on('click', '.edit-btn', function() {
                const paymentId = $(this).data('id');
                const invoiceNumber = $(this).data('invoice_number');
                const amountPaid = $(this).data('amount_paid');
                const paymentDate = $(this).data('payment_date');
                const paymentMethod = $(this).data('payment_method');
                const status = $(this).data('status');

                $('#editPaymentId').val(paymentId);
                $('#editInvoiceNumber').val(invoiceNumber);
                $('#editPaymentAmount').val(amountPaid);
                $('#editPaymentDate').val(paymentDate);
                $('#editPaymentMethod').val(paymentMethod);
                $('#editStatus').val(status);
            });

            // Handle Edit Payment Form Submission
            $('#editPaymentForm').on('submit', function(e) {
                e.preventDefault();

                const formData = $(this).serialize();

                $.ajax({
                    url: 'edit_payment.php',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        const res = JSON.parse(response);
                        if (res.success) {
                            // Update table row with edited data
                            const paymentId = $('#editPaymentId').val();
                            const invoiceNumber = $('#editInvoiceNumber').val();
                            const amountPaid = $('#editPaymentAmount').val();
                            const paymentDate = $('#editPaymentDate').val();
                            const paymentMethod = $('#editPaymentMethod').val();
                            const status = $('#editStatus').val();

                            const row = $('#payment-row-' + paymentId);
                            row.find('td:nth-child(1)').text(invoiceNumber);
                            row.find('td:nth-child(2)').text(amountPaid);
                            row.find('td:nth-child(3)').text(paymentDate);
                            row.find('td:nth-child(4)').text(paymentMethod);
                            row.find('td:nth-child(5)').text(status);

                            $('#editPaymentModal').modal('hide');
                        } else {
                            alert('Failed to update payment.');
                        }
                    },
                    error: function() {
                        alert('An error occurred. Please try again.');
                    }
                });
            });
        });
    </script>
</body>
</html>
