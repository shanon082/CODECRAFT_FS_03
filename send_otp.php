<?php
require 'db.php';
require 'PHPMailer/PHPMailer/PHPMailer.php';
require 'PHPMailer/PHPMailer/SMTP.php';
require 'PHPMailer/PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $role = $_POST['role'];

    switch ($role) {
        case 'student':
            $table = 'students';
            $column = 'student_number';
            $password_column = 'password';
            break;
       
        case 'supervisor':
            $table = 'supervisors';
            $column = 'supervisor_username';
            $password_column = 'password';
            break;
        case 'coordinator':
            $table = 'coordinators';
            $column = 'coordinator_username';
            $password_column = 'password';
            break;
        default:
            header('Location: index.php?error=' . urlencode('Invalid role selected.'));
            exit;
    }

    $stmt = $conn->prepare("SELECT * FROM $table WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $otp = rand(100000, 999999); 
        session_start();
        $_SESSION['otp'] = $otp;
        $_SESSION['email'] = $email;

        
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';  
            $mail->SMTPAuth = true;
            $mail->Username = 'kasaggaronald516@gmail.com';  
            $mail->Password = 'uvji iaje jsmq sorz';  
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('kasaggaronald516@gmail.com', 'final year project');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Your OTP for Password Recovery with FINAL YEAR PROJECT';
            $mail->Body = "Your OTP is: <strong>$otp</strong>";

            $mail->send();
            echo "OTP sent to your email. <a href='verify_otp.html'>Verify OTP</a>";
        } catch (Exception $e) {
            echo "Error sending OTP: {$mail->ErrorInfo}";
        }
    } else {
        echo "Email not found.";
    }
}
?>
