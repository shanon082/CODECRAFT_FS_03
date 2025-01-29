<?php
session_start();
require 'db.php';

if (!isset($_GET['receiver_id']) || !isset($_GET['receiver_role'])) {
    echo '';
    exit;
}

$receiver_id = intval($_GET['receiver_id']);
$receiver_role = $_GET['receiver_role'];

// Connect to the database
$conn = getConnection();

// Determine the table for the receiver based on their role
switch ($receiver_role) {
    case 'admin':
        $receiver_table = 'admins';
        break;
    case 'student':
        $receiver_table = 'students';
        break;
    case 'supervisor':
        $receiver_table = 'supervisors';
        break;
    case 'coordinator':
        $receiver_table = 'coordinators';
        break;
    default:
        echo '';
        exit;
}

// Check typing status from the corresponding table
$stmt = $conn->prepare("SELECT is_typing FROM $receiver_table WHERE id = ?");
$stmt->bind_param("i", $receiver_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo $row['is_typing'] ? 'Typing...' : '';
} else {
    echo '';
}
?>
