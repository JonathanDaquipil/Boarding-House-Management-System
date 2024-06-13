<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment History</title>
    <link rel="stylesheet" href="ph.css">
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
                <li><a href="suggestions.php"><i class="fa-regular fa-lightbulb"></i>  Suggestions</a></li>
            </pre>
    </ul>
</div>

<div class="formtitle" id="adminpage">
    <h1>Payment History</h1>

<div class="table-responsive mt-4">
    <table class="table table-bordered text-center">
        <thead>
            <tr class="bg-primary text-white">
                <th>Invoice Number</th>
                <th>Amount Paid</th>
                <th>Date of Payment</th>                                       
                <th>Remarks</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="payment-history-table">
    <?php

    require 'config.php';

    $query = "SELECT * FROM payment_history"; 
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr id='payment-row-" . $row['ph_id'] . "'>"; 
            echo "<td>" . $row['invoice_number'] . "</td>";
            echo "<td>" . $row['amount_paid'] . "</td>";
            echo "<td>" . $row['payment_date'] . "</td>";
            echo "<td>" . $row['remarks'] . "</td>";
            echo "<td>";
           
        
       
            echo "<button class='btn btn-danger delete-btn' data-ph-id='" . $row['ph_id'] . "'>Delete</button>";
            echo "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='5'>No Payment found</td></tr>";
    }

    $conn->close();
    ?>
</tbody>
    </table>
</div>


<div class="modal fade" id="editPaymentModal" tabindex="-1" aria-labelledby="editPaymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPaymentModalLabel">Edit Payment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editPaymentForm">
                    <input type="hidden" id="editPhId" name="ph_id">
                    <div class="form-group">
                        <label for="editInvoiceNumber">Invoice Number</label>
                        <input type="text" class="form-control" id="editInvoiceNumber" name="invoice_number" required>
                    </div>
                    <div class="form-group">
                        <label for="editAmountPaid">Amount Paid</label>
                        <input type="number" step="0.01" class="form-control" id="editAmountPaid" name="amount_paid" required>
                    </div>
                    <div class="form-group">
                        <label for="editPaymentDate">Date of Payment</label>
                        <input type="date" class="form-control" id="editPaymentDate" name="payment_date" required>
                    </div>
                    <div class="form-group">
                        <label for="editRemarks">Remarks</label>
                        <input type="text" class="form-control" id="editRemarks" name="remarks" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


<script>

    // Handle Delete Button Click
    $(document).on('click', '.delete-btn', function() {
        const paymentId = $(this).data('ph-id');
        if (confirm('Are you sure you want to delete this payment?')) {
            $.ajax({
                url: 'deleteph_payment.php',
                type: 'POST',
                data: { ph_id: paymentId }, // Corrected parameter name
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

</script>
</body>
</html>
