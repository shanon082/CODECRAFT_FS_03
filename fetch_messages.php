<?php
// fetch_messages.php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    exit("Not logged in.");
}

$user_id = $_SESSION['user_id'];
$user_role = $_SESSION['role'];
$receiver_id = $_GET['receiver_id'];
$receiver_role = $_GET['receiver_role'];

// Connect to the database
$conn = getConnection();

// Fetch messages between the sender and receiver
$stmt = $conn->prepare("
    SELECT m.*, 
           s.username AS sender_name, 
           r.username AS receiver_name
    FROM messages m
    JOIN users s ON m.sender_id = s.id
    JOIN users r ON m.receiver_id = r.id
    WHERE (m.sender_id = ? AND m.receiver_id = ?) 
       OR (m.sender_id = ? AND m.receiver_id = ?)
    ORDER BY m.timestamp ASC
");
$stmt->bind_param("iiii", $user_id, $receiver_id, $receiver_id, $user_id);
$stmt->execute();
$messages = $stmt->get_result();

// Display the message
while ($msg = $messages->fetch_assoc()) {
    $sender_name = $msg['sender_id'] == $user_id ? 'You' : htmlspecialchars($msg['sender_name']);
    echo "<p><strong>$sender_name:</strong> " . htmlspecialchars($msg['message']) . "</p>";
}
?>
