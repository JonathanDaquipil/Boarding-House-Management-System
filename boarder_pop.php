<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boarder Payment</title>
    <link rel="stylesheet" href="boarder_pop.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    
    <div class="list" id="adminpage">
        <img src="logo1.png" class="pic">
        <ul>
            <pre>
                <li><a href="boarder_page.php"><i class="fa-solid fa-house"></i>  DashBoard</a></li>   
                <li><a href="boarder_notice.php"><i class="fa-solid fa-people-line"></i>  Notice</a></li>
                <li><a href="boarder_pop.php"><i class="fa-solid fa-house-lock"></i>  Proof of Payment</a></li>
                <li><a href="boarder_ph.php"><i class="fa-solid fa-bed"></i>  Payment History</a></li>
               
            </pre>
        </ul>
    </div>

    <div class="formtitle" id="adminpage">
        <h1> Payment</h1>

      
        <div class="table-responsive mt-4">
            <table class="table table-bordered text-center">
                <thead>
                    <tr class="bg-primary text-white">
                        <th>Payment Amount</th>
                        <th>Date</th>
                        <th>Payment Method</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include 'config.php';
                  
                    $sql = "SELECT * FROM payments";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['amount_paid'] . "</td>";
                            echo "<td>" . $row['payment_date'] . "</td>";
                            echo "<td>" . $row['payment_method'] . "</td>";
                            echo "<td>" . $row['status'] . "</td>";
                            echo "<td>";
                            echo "<button class='btn btn-danger btn-sm' onclick='deletePayment(" . $row['payment_id'] . ")'>Delete</button>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No records found</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
           
            window.deletePayment = function(payment_id) {
                if (confirm('Are you sure you want to delete this record?')) {
                    $.ajax({
                        url: 'delete_payment_proof.php',
                        type: 'POST',
                        data: { payment_id: payment_id },
                        success: function(response) {
                            if (response === 'success') {
                                location.reload();
                            } else {
                                alert('Failed to delete the record.');
                            }
                        }
                    });
                }
            }
        });
    </script>

</body>
</html>
