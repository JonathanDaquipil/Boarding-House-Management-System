<?php
require 'config.php'; 

$success_message = "";
$error_message = "";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  
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
            $success_message = "User registered successfully!!! ";
        } else {
            $error_message = "User registered, but error updating boarder names: " . $conn->error;
        }
    } else {
        $error_message = "Error registering user: " . $conn->error;
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
    <title>Register An Account!</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        .message {
            display: none;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="atan" id="signup">
        <h1 class="form-title">Registration </h1>

        <?php if (!empty($success_message)) : ?>
            <div class="message success"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <?php if (!empty($error_message)) : ?>
            <div class="message error"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <form method="POST" action="index.php" autocomplete="off">
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="fname" placeholder="First Name" required>
            </div>
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="lname" placeholder="Last Name" required>
            </div>
            <div class="input-group">
            <label for ="bdate">Birth Date</label>
                <input type="date" name="bdate" placeholder="Date of Birth" required>
            </div>
            <div class="input-group">
                <i class="fa-solid fa-location-dot"></i>
                <input type="text" name="address" placeholder="Address" required>
            </div>
            <div class="input-pnumber">
                <i class="fa-solid fa-mobile"></i>
                <input type="number" name="number" placeholder="Phone Number" required>
            </div>
            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="cpassword" placeholder="Confirm Password" required>
            </div>
            <div class="input-group">
                <label for="gender"> Gender</label>
                <select id="gender" name="gender" required>
                    <option value="">Select</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Prefer not to say</option>
                </select>
            </div>
            <div class="input-group">
                <label for="utype"> Types of User</label>
                <select id="utype" name="utype" required>
                    <option value="">Select</option>
                    <option value="Admin">Admin</option>
                    <option value="Boarder">Boarder</option>
                </select>
            </div>
            <button type="submit" name="submit" class="btn2">Register</button>
            <div class="login-link">
                <p>Do you have an account? <a href="login_form.php">Login</a></p>
            </div>
        </form>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            if ($('.message').length) {
                $('.message').show().delay(5000).fadeOut('slow');
            }
        });
    </script>
</body>
</html>
