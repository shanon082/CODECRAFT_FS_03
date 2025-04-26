<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'], $_SESSION['role'])) {
    exit("Unauthorized access.");
}

$user_id = $_SESSION['user_id'];
$receiver_id = intval($_GET['receiver_id'] ?? 0);

// Connect to the database
$conn = getConnection();

// Mark messages as read
$stmt = $conn->prepare("
    UPDATE messages 
    SET is_read = 1 
    WHERE receiver_id = ? AND sender_id = ?
");
$stmt->bind_param("ii", $user_id, $receiver_id);
$stmt->execute();
?>
