<?php
// Collecting the POST data
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$bdate = $_POST['bdate'];
$address = $_POST['address'];
$number = $_POST['number'];
$email = $_POST['email'];
$password = $_POST['password'];
$cpassword = $_POST['cpassword'];
$gender = $_POST['gender'];
$utype = $_POST['utype'];           

// Check if all fields are filled
if (!empty($fname) &&!empty($lname) &&!empty($bdate) &&!empty($address) &&!empty($number) &&!empty($email) &&!empty($password) &&!empty($cpassword) &&!empty($gender)  &&!empty($utype) ) {

    
    if ($password!== $cpassword) {
        echo "Password and confirm password do not match.";
        die();
    }

    // Database connection details
    $host = "localhost";
    $dbusername = "root";   
    $dbpassword = "";
    $dbname = "bh_management_system";

    // Create connection
    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: ". $conn->connect_error);
    }

    // Check if the email already exists
    $SELECT = "SELECT Email FROM registration_table WHERE Email =? LIMIT 1";
    $INSERT = "INSERT INTO registration_table (First_Name, Last_Name, Birth_Date, Add_ress, Phone_Nnumber, Email, Pass_word, Confirm_Password, Gender,User_Type) VALUES (?,?,?,?,?,?,?,?,?,?)";

    $stmt = $conn->prepare($SELECT);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $rnum = $stmt->num_rows;
    $stmt->close();

    if ($rnum == 0) { // If no email found
        $stmt->close();
    }

        

        $stmt = $conn->prepare($INSERT);
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $hashed_cpassword = password_hash($cpassword, PASSWORD_BCRYPT);
        $stmt->bind_param(
            "ssssssssss", 
            $fname, 
            $lname, 
            $bdate,
            $address, 
            $number, 
            $email, 
            $hashed_password,
            $hashed_cpassword,
            $gender,
            $utype,

      
        );
        $stmt->execute();
        echo "New record inserted successfully";

    else { // If the email already exists
    echo "Someone already registered using this email.";

}else {
echo "All fields are required.";
$die(); 
}

$conn->close(); 


?>  