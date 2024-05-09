

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
    <form action="login.php">
      <h1>Login</h1>
      <div class="input-box">
        <input type="text" name="email"  placeholder="Email" required>
        <i class='bx bxs-user'></i>
      </div>
      <div class="input-box">
        <input type="password" name="password" placeholder="Password"  required>
        <img src="eye-close.png" id="eyeicon">
        <i class='bx bxs-lock-alt' ></i>
      </div>
      <script>
         let eyeicon = document.getElementById("eyeicon");
         let password = document.getElementById("password");

         eyeicon.onclick = function(){
          if(password.type == "password"){
            password.type = "text";
            eyeicon.src = "eye-open.png";
          }else{
            password.type = "password";
            eyeicon.src = "eye-close.png";
          }
         }
      </script>

      <div class="radio">
        <label for="usertype">User Type:</label>
        <select id="usertype">
          <option value="1">Select</option>
          <option value="2">Admin</option>
          <option value="3">Boarder</option>
        </select>
      </div>
     
      <div class="remember-forgot">
        <label><input type="checkbox">Remember Me</label>
        <a href="#">Forgot Password</a>
      </div>


      <button type="submit" class="btn">Login</button>
      
      <div class="register-link">
        <p>Dont have an account? <a href="index.html">Register</a></p>
      </div>
    </form>
  </div>
</body>
</html>