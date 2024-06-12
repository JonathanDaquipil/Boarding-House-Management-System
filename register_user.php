<?php
require 'config.php'; // Ensure this points to your database configuration file

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $fname = $conn->real_escape_string($_POST['fname']);
    $lname = $conn->real_escape_string($_POST['lname']);
    $bdate = $conn->real_escape_string($_POST['bdate']);
    $address = $conn->real_escape_string($_POST['address']);
    $number = $conn->real_escape_string($_POST['number']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($conn->real_escape_string($_POST['password']), PASSWORD_BCRYPT); // Encrypt password
    $gender = $conn->real_escape_string($_POST['gender']);
    $utype = $conn->real_escape_string($_POST['utype']);

    // Insert user data into registration_table
    $sql = "INSERT INTO registration_table (fname, lname, bdate, address, number, email, password, gender, utype) 
            VALUES ('$fname', '$lname', '$bdate', '$address', '$number', '$email', '$password', '$gender', '$utype')";

    if ($conn->query($sql) === TRUE) {
        // Get the newly created user's ID
        $user_id = $conn->insert_id;

        // Update the boarder_name in bed_assignment_table
        $update_sql = "
            UPDATE bed_assignment_table bat
            JOIN registration_table rt ON bat.user_id = rt.user_id
            SET bat.boarder_name = CONCAT(rt.fname, ' ', rt.lname)
        ";

        if ($conn->query($update_sql) === TRUE) {
            echo "User registered successfully and boarder names updated.";
        } else {
            echo "User registered, but error updating boarder names: " . $conn->error;
        }
    } else {
        echo "Error registering user: " . $conn->error;
    }

    // Close the connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register User</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Register User</h1>
        <form action="register_user.php" method="POST">
            <div class="form-group">
                <label for="fname">First Name</label>
                <input type="text" class="form-control" id="fname" name="fname" required>
            </div>
            <div class="form-group">
                <label for="lname">Last Name</label>
                <input type="text" class="form-control" id="lname" name="lname" required>
            </div>
            <div class="form-group">
                <label for="bdate">Birth Date</label>
                <input type="date" class="form-control" id="bdate" name="bdate" required>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" class="form-control" id="address" name="address" required>
            </div>
            <div class="form-group">
                <label for="number">Phone Number</label>
                <input type="text" class="form-control" id="number" name="number" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="gender">Gender</label>
                <select class="form-control" id="gender" name="gender" required>
                    <option value="" disabled selected>Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>
            <div class="form-group">
                <label for="utype">User Type</label>
                <select class="form-control" id="utype" name="utype" required>
                    <option value="" disabled selected>Select User Type</option>
                    <option value="boarder">Boarder</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>