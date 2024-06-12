<?php
require 'config.php';

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['usertype'] != 'Admin') {
    header('Location: login_form.php');
    exit();
}

// Fetch total number of boarders
$query_boarders = "SELECT COUNT(*) AS total_boarders FROM registration_table WHERE utype = 'Boarder'";
$result_boarders = mysqli_query($conn, $query_boarders);
$total_boarders = mysqli_fetch_assoc($result_boarders)['total_boarders'];

// Fetch total number of rooms
$query_rooms = "SELECT COUNT(*) AS total_rooms FROM room_table";
$result_rooms = mysqli_query($conn, $query_rooms);
$total_rooms = mysqli_fetch_assoc($result_rooms)['total_rooms'];

// Fetch total number of beds
$query_beds = "SELECT COUNT(*) AS total_beds FROM bed_table";
$result_beds = mysqli_query($conn, $query_beds);
$total_beds = mysqli_fetch_assoc($result_beds)['total_beds'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="adminpage.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
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
        <h1>Dashboard</h1>
        <div class="dashboard">
        <div class="card boarders-card">
                <span>Total Boarders: <?php echo $total_boarders; ?></span>
            </div>
            <div class="card rooms-card">
                <span>Total Rooms: <?php echo $total_rooms; ?></span>
            </div>
            <div class="card beds-card">
                <span>Total Beds: <?php echo $total_beds; ?></span>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</body>
</html>