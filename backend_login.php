<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    $email = $_POST['email'];
    $password = $_POST['password'];

 
    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "bh_management_system";

 
    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the email exists
    $SELECT = "SELECT Email, Pass_word, User_Type FROM registration_table WHERE Email = ?";
    $stmt = $conn->prepare($SELECT);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows == 0) { // If no such email
        echo "Invalid credentials.";
        $stmt->close();
        $conn->close();
        exit;
    }

    // Get the data from the database
    $stmt->bind_result($Email, $Pass_word, $User_Type);
    $stmt->fetch();

    // Verify the password
    if (password_verify($password, $Pass_word)) {
        // Password matches
        $_SESSION['email'] = $Email;
        $_SESSION['usertype'] = $User_Type;

        if ($usertype === "Admin") {
            // Redirect to admin page if user is an admin
            header("Location: admin_page.html");
        } else {
            // Redirect to a different page or dashboard for other user types
            header("Location: boarder_page.html");
        }

        exit;
    } else {
        // Password does not match
        echo "Invalid credentials.";
    }

    $stmt->close();
    $conn->close();
}
?>
