<?php
session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'], $_SESSION['role'])) {
    // Get the sender details from session
    $sender_id = $_SESSION['user_id'];
    $sender_role = $_SESSION['role'];

    // Sanitize and validate input
    $receiver_id = isset($_POST['receiver_id']) ? intval($_POST['receiver_id']) : null;
    $receiver_role = isset($_POST['receiver_role']) ? htmlspecialchars($_POST['receiver_role']) : null;
    $message = isset($_POST['message']) ? htmlspecialchars(trim($_POST['message'])) : null;

    // Check if inputs are valid
    if (empty($receiver_id) || empty($receiver_role) || empty($message)) {
        echo "Invalid input. Please ensure all fields are filled.";
        exit;
    }

    // Connect to the database
    $conn = getConnection();

    $receiverExists = false;

    switch ($receiver_role) {
        case 'admin':
            $stmt = $conn->prepare("SELECT id FROM admins WHERE id = ?");
            break;
        case 'student':
            $stmt = $conn->prepare("SELECT id FROM students WHERE id = ?");
            break;
        case 'supervisor':
            $stmt = $conn->prepare("SELECT id FROM supervisors WHERE id = ?");
            break;
        case 'coordinator':
            $stmt = $conn->prepare("SELECT id FROM coordinators WHERE id = ?");
            break;
        default:
            die("Invalid receiver role.");
    }

    $stmt->bind_param("i", $receiver_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $receiverExists = true;
    }

    if (!$receiverExists) {
        die("Error: Receiver does not exist.");
    }


    // Prepare the query
    $stmt = $conn->prepare("
        INSERT INTO messages (sender_id, sender_role, receiver_id, receiver_role, message)
        VALUES (?, ?, ?, ?, ?)
    ");
    if (!$stmt) {
        echo "Error preparing statement: " . $conn->error;
        exit;
    }

    // Bind parameter
    $stmt->bind_param("isiss", $sender_id, $sender_role, $receiver_id, $receiver_role, $message);

    // Execute the query
    if ($stmt->execute()) {
        // Redirect to the chat page for the same user
        header("Location: chat.php?receiver_id=$receiver_id&role=$receiver_role");
        exit;
    } else {
        echo "Error sending message: " . $stmt->error;
        exit;
    }
} else {
    echo "Unauthorized access or invalid request.";
    exit;
}
