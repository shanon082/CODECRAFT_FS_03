<?php
include('db.php');

require 'PHPMailer/PHPMailer/PHPMailer.php';
require 'PHPMailer/PHPMailer/SMTP.php';
require 'PHPMailer/PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $message = $_POST['message'];
    $audience = $_POST['audience'];

    // Insert announcement into the database
    $stmt = $conn->prepare("INSERT INTO announcements (title, message, audience) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $title, $message, $audience);

    if ($stmt->execute()) {
        echo "Announcement posted successfully!";
        
        // Fetch emails based on the audience
        $emails = [];
        if ($audience === "students" || $audience === "all") {
            $result = $conn->query("SELECT email FROM students");
            while ($row = $result->fetch_assoc()) {
                $emails[] = $row['email'];
            }
        }
        if ($audience === "supervisors" || $audience === "all") {
            $result = $conn->query("SELECT email FROM supervisors");
            while ($row = $result->fetch_assoc()) {
                $emails[] = $row['email'];
            }
        }

        // Send email notifications
        if (!empty($emails)) {
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; 
                $mail->SMTPAuth = true;
                $mail->Username = 'kasaggaronald516@gmail.com';
                $mail->Password = 'mqnf ehqd qmtk fbes'; 
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom('kasaggaronald516@gmail.com', 'final year project:: Project Coordinator');
                $mail->Subject = "New Announcement: $title";
                $mail->Body = $message;
                $mail->isHTML(true);

                foreach ($emails as $email) {
                    $mail->addAddress($email);
                }

                $mail->send();
                echo " Email notifications sent successfully!";
            } catch (Exception $e) {
                echo " Email notification failed: " . $mail->ErrorInfo;
            }
        }
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
