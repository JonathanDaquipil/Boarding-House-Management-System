
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register An Account!</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
   
</head>
<body>
    <div class="atan" id="signup">
        <h1 class="form-title">Boarder Registration </h1>    
        <form method="POST" action="connection.php">

            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="fname" placeholder="First Name" required>
           
            </div>

           <div class="input-group">
            <i class="fas fa-user"></i>
            <input type="text" name="lname" placeholder="Last Name" required>
           
           </div> 
           
          <div class="input-group">
            <i class="fa-regular fa-calendar"></i>         
            <input type="date" name="bdate" placeholder="Date of Birth" required>
           
           </div> 
          
           
           <div class="input-group">
            <i class="fa-solid fa-location-dot"></i>
            <input type="text" name="address" placeholder="Address" required>
            
        </div>

        <div class="input-pnumber">
            <i class="fa-solid fa-location-dot"></i>
            <input type="number" name="number"  placeholder="Phone Number" required>
            
        </div>

        <div class="input-group">
            <i class="fas fa-envelope"></i>
            <input type="text" name="email"  placeholder="Email" required>
            
        </div>

        <div class="input-group">
            <i class="fas fa-lock"></i>
            <input type="password" name="password"  placeholder="Password" required>
           
        </div>

        <div class="input-group">
            <i class="fas fa-lock"></i>
            <input type="password" name="cpassword"  placeholder="Confirm Password" required>  
           
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

        <button type="submit" class="btn2">Register</button>
          
      <div class="login-link">
        <p>Do you have an account? <a href="login_form.php">Login</a></p>
      </div>

        </form>
    </div>
</body>
</html>