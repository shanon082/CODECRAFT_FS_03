<?php
include("db.php");
session_start();

if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to send a message.");
}

$student_id = $_SESSION['user_id']; 
$message = $_POST['message'];
$audience = $_POST['audience']; 


if (empty($message)) {
    die("Message cannot be empty.");
}

if ($audience !== 'all') {
    $supervisor_check = $conn->query("SELECT id FROM engineers WHERE id = $audience AND student_id = $student_id");

    if ($supervisor_check->num_rows == 0) {
        die("Error: Selected supervisor is not assigned to this student.");
    }

    // Insert the message to the selected supervisor
    $stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, audience, message) VALUES (?, ?, 'supervisor', ?)");
    $stmt->bind_param("iis", $student_id, $audience, $message);

    if (!$stmt->execute()) {
        echo "Error executing message insert: " . $stmt->error;
    } else {
        echo "Message sent to supervisor!";
    }
} else {
    $supervisors = $conn->query("SELECT supervisor_id FROM engineers WHERE student_id = $student_id");

    while ($row = $supervisors->fetch_assoc()) {
        $supervisor_id = $row['supervisor_id'];

        // Insert the message to each supervisor
        $stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, audience, message) VALUES (?, ?, 'supervisor', ?)");
        $stmt->bind_param("iis", $student_id, $supervisor_id, $message);

        if (!$stmt->execute()) {
            echo "Error executing message insert: " . $stmt->error;
        }
    }
    echo "Message sent to the supervisors!";
}

?>
