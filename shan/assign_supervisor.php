<?php
include("db.php");

require 'PHPMailer/PHPMailer/PHPMailer.php';
require 'PHPMailer/PHPMailer/SMTP.php';
require 'PHPMailer/PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get selected student and supervisor ID
    $student_id = $_POST['student_id'];
    $supervisor_id = $_POST['supervisor_id'];

    // Fetch student details
    $student_query = $conn->query("SELECT username, student_number, student_contact, email FROM students WHERE id = $student_id");
    $student = $student_query->fetch_assoc();
    $student_name = $student['username'];
    $student_number = $student['student_number'];
    $student_contact = $student['student_contact'];
    $student_email = $student['email'];

    // Fetch supervisor details
    $supervisor_query = $conn->query("SELECT username, supervisor_contact, email FROM supervisors WHERE id = $supervisor_id");
    $supervisor = $supervisor_query->fetch_assoc();
    $supervisor_username = $supervisor['username'];
    $supervisor_contact = $supervisor['supervisor_contact'];
    $supervisor_email = $supervisor['email'];

    // Insert into engineers table
    $insert_query = "INSERT INTO engineers(supervisor_name, supervisor_contact,supervisor_email, student_name,  student_number, student_contact, student_email )
    VALUES ('$supervisor_username', '$supervisor_contact','$supervisor_email', '$student_name','$student_number', '$student_contact', '$student_email')";

    if ($conn->query($insert_query) === TRUE) {
        // Send email notifications
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Replace with your SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'kasaggaronald516@gmail.com'; // Your email
            $mail->Password = 'mqnf ehqd qmtk fbes'; // Your email password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('kasaggaronald516@gmail.com', 'final year project:: Project Assignment');
            $mail->isHTML(true);

            // Email to Student
            $mail->clearAddresses();
            $mail->addAddress($student_email);
            $mail->Subject = "Supervisor Assigned";
            $mail->Body = "Dear $student_name,<br><br>
                You have been assigned a supervisor:<br>
                <b>Supervisor Name:</b> $supervisor_username<br>
                <b>Contact:</b> $supervisor_contact<br>
                <br>Best regards,<br>Project Management Team";

            $mail->send();

            // Email to Supervisor
            $mail->clearAddresses();
            $mail->addAddress($supervisor_email);
            $mail->Subject = "New Student Assigned";
            $mail->Body = "Dear $supervisor_username,<br><br>
                A new student has been assigned to you:<br>
                <b>Student Name:</b> $student_name<br>
                <b>Student Number:</b> $student_number<br>
                <b>Contact:</b> $student_contact<br>
                <br>Best regards,<br>Project Management Team";

            $mail->send();

            echo "<script>
                alert('You have assigned a supervisor to a student, and email notifications have been sent.');
                window.location.href = 'Coordinator_dashboard.php';
            </script>";
        } catch (Exception $e) {
            echo "Error sending email: " . $mail->ErrorInfo;
        }
    } else {
        echo "Error: " . $conn->error;
    }
}
