<?php
session_start();

// Hardcoded admin credentials
$admin_username = "kasagga";
$admin_password = "ronald";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Check if credentials match
    if ($username === $admin_username && $password === $admin_password) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;
        header("Location: Admin_dashboard.php"); // Redirect to admin dashboard
        exit();
    } else { 
  
        $error = "Invalid username or password";
        
    }
}
?>
  <!-- index.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin_Login Page</title>
     
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <div class="image-container">
            <img src="image/log1.jpg" alt="Image" class="image">
        </div>
        <div class="form-container">
            <h2>Login</h2>
           
            <form action="admin_login.php " method="post">
             

                <input type="text" name="username" placeholder="username" required><br>
                <input type="password" name="password" placeholder="User Password" required><br>
 
                <?php if (!empty($error)) echo "<p class='error-message'>$error</p>"; ?>
                <button type="submit" name="submit">Login</button>

  
            </form>
        </div>
    </div>
</body>

</html>