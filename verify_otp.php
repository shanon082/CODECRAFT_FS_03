<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entered_otp = $_POST['otp'];

    if ($entered_otp == $_SESSION['otp']) {
        header("Location: reset_password.php");
    } else {
        echo "Invalid OTP. Please try again.";
    }
}
?>
