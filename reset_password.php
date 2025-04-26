<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>reset password</title>
    <link rel="stylesheet" href="forgetpass.css">
</head>

<body>
    <div class="container">
        <h1>Reset your Password</h1>
        <form action="reset_password_processing.php" method="post">

            <select name="role" id="sel" required>
                <option value="student">Student</option>
                <option value="admin">Admin</option>
                <option value="supervisor">Supervisor</option>
                <option value="coordinator">Coordinator</option>
            </select><br>
            
            <label for="password">New Password</label>
            <input type="password" name="password" required>

            <label for="confirm_password">Confirm Password</label>
            <input type="password" name="confirm_password" required>

            <button type="submit">Reset Password</button>

            <?php
            if (isset($_SESSION["error"])) {
                echo $_SESSION["error"];
                unset($_SESSION["error"]);
            }
            ?>
        </form>
    </div>

</body>

</html>