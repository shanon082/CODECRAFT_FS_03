<?php
session_start();
require 'db.php';

$user_id = $_SESSION['user_id'];
$user_role = $_SESSION['role'];

$receiver_id = $_GET['receiver_id'];
$receiver_role = $_GET['receiver_role'];
$typing = $_GET['typing'];

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
        echo 'Invalid role';
        exit;
}

// Update typing status in the corresponding table
$stmt = $conn->prepare("
    UPDATE $receiver_table 
    SET is_typing = ? 
    WHERE id = ?
");
$stmt->bind_param("ii", $typing, $receiver_id);
$stmt->execute();
?>
