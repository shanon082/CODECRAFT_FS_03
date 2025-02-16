<?php
include('db.php');
require 'PHPMailer/PHPMailer/PHPMailer.php';
require 'PHPMailer/PHPMailer/SMTP.php';
require 'PHPMailer/PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = $_POST['message'];
    $audience = $_POST['audience'];
    $sender_id = $_SESSION['user_id']; // Supervisor ID

    // Debugging
    echo "Sender ID: " . $sender_id; // Check the sender_id value
    echo "Message: " . $message; // Check the message value
    echo "Audience: " . $audience; // Check the audience

    // Validate sender_id exists in the engineers table (Supervisor)
    $sender_check = $conn->query("SELECT id FROM engineers WHERE supervisor_id = $sender_id AND supervisor_id IS NOT NULL");
    if ($sender_check->num_rows == 0) {
        die("Error: Sender ID does not exist in the engineers table.");
    }

    if ($audience == 'all') {
        // Send to all assigned students
        $students = $conn->query("SELECT student_id, student_email FROM engineers WHERE supervisor_id = $sender_id");
        while ($row = $students->fetch_assoc()) {
            $receiver_id = $row['student_id']; // Use the student_id field here

            // Validate receiver_id exists in engineers table
            $receiver_check = $conn->query("SELECT id FROM engineers WHERE student_id = $receiver_id");
            if ($receiver_check->num_rows == 0) {
                die("Error: Receiver ID (Student) does not exist in the database.");
            }

            $stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, audience, message) VALUES (?, ?, 'student', ?)");
            $stmt->bind_param("iis", $sender_id, $receiver_id, $message);
            if (!$stmt->execute()) {
                echo "Error executing message insert: " . $stmt->error;
            }
        }
    } else {
// Send to a specific student
$receiver_id = intval($audience); // Ensure audience contains student_id in this case

// Validate receiver_id (student) exists in the engineers table
$receiver_check = $conn->query("SELECT id FROM engineers WHERE id = $receiver_id");

if ($receiver_check->num_rows == 0) {
    die("Error: Receiver ID (Student) does not exist in the database.");
}

$stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, audience, message) VALUES (?, ?, 'student', ?)");
$stmt->bind_param("iis", $sender_id, $receiver_id, $message);

if (!$stmt->execute()) {
    echo "Error executing message insert: " . $stmt->error;
}

    }

    echo "Message sent successfully!";
} else {
    echo "Invalid request.";
}
?>
