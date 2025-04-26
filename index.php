<!-- index.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <div class="image-container">
            <img src="image/log1.jpg" alt="Image" class="image">
        </div>
        <div class="form-container">
            <h2>Login</h2>

            <form action="login.php" method="post">

                <!-- Dropdown to select the role -->
                <select name="role" id="sel" required>
                    <option value="student">Student</option>
                   
                    <option value="supervisor">Supervisor</option>
                    <option value="coordinator">Coordinator</option>
                </select><br>

                <input type="text" name="user_number" placeholder="User Number/ username" required><br>
                <input type="password" name="password" placeholder="User Password" required><br>

                <a href="forgot_password.html">Forgot password?</a>

                <button type="submit" name="submit">Login</button>

                <?php if (isset($_GET['error'])) { ?>
                    <p class="error-message"><?php echo $_GET['error']; ?></p>
                <?php } ?>
            </form>
        </div>
    </div>
</body>

</html>