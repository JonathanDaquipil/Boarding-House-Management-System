<?php

require 'config.php';


if (isset($_POST["submit"])) {
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = $_POST["password"]; 
    $usertype = $_POST["utype"];

    if ($usertype == "Select") {
        echo "<script>alert('Please select a user type.');</script>";
    } else {
        $result = mysqli_query($conn, "SELECT * FROM registration_table WHERE email = '$email'");
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $hashedPassword = $row["password"];

          
            if ($row["utype"] !== $usertype) {
                echo "<script>alert('This user is not valid.');</script>";
            } else {
                // Compare the entered password with the hashed password from the database
                if (password_verify($password, $hashedPassword)) {
                    // Password is correct, proceed with login
                    $_SESSION["submit"] = true;
                    $_SESSION["user_id"] = $row["user_id"];
                    $_SESSION["usertype"] = $row["utype"];
                    $_SESSION["email"] = $row["email"];

                    if ($usertype == "Admin") {
                        header("Location: admin_page.php");
                    } else {
                        // Redirect to another page for non-admin users, if applicable
                        header("Location: boarder_page.php");
                    }
                    exit();
                } else {
                   echo "<script>alert('Wrong Password!');</script>";
                }
            }
        } else {
            echo "<script>alert('User Not Registered');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="styles.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="wrapper">
        <form action="login_form.php" method="POST">
            <h1>Login</h1>
            <div class="input-box">
                <input type="text" name="email" id="email" placeholder="Email" required>
                <i class='bx bxs-user'></i>
            </div>
            <div class="input-box">
                <input type="password" name="password" id="password" placeholder="Password" required>
                <img src="eye-close.png" id="eyeicon">
                <i class='bx bxs-lock-alt'></i>
            </div>
            <script>
                let eyeicon = document.getElementById("eyeicon");
                let password = document.getElementById("password");

                eyeicon.onclick = function() {
                    if (password.type == "password") {
                        password.type = "text";
                        eyeicon.src = "eye-open.png";
                    } else {
                        password.type = "password";
                        eyeicon.src = "eye-close.png";
                    }
                }
            </script>

            <div class="radio">
                <label for="usertype">User Type:</label>
                <select id="usertype" name="utype">
                    <option value="Select">Select</option>
                    <option value="Admin">Admin</option>
                    <option value="Boarder">Boarder</option>
                </select>
            </div>

            <div class="remember-forgot">
                <label><input type="checkbox">Remember Me</label>
                <a href="#">Forgot Password</a>
            </div>

            <button type="submit" name="submit" class="btn">Login</button>

            <div class="register-link">
                <p>Don't have an account? <a href="index.php">Register</a></p>
            </div>

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        </form>
    </div>
</body>
</html>
