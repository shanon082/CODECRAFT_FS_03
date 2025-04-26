<?php
session_start();
include("db.php");

// Ensure user is logged in
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header('Location: index.php');
    exit;
}

// Check CSRF token
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die("Invalid CSRF token");
}

// Validate file ID
if (!isset($_POST['file_id']) || !is_numeric($_POST['file_id'])) {
    die("Invalid request");
}

$file_id = intval($_POST['file_id']);
$student_id = $_SESSION['user_id'];

// Get file path before deleting
$stmt = $conn->prepare("SELECT file_path FROM upload WHERE id = ? AND recipient_id = ?");
$stmt->bind_param("ii", $file_id, $student_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $file_path = $row['file_path'];

    // Delete from database
    $stmt = $conn->prepare("DELETE FROM upload WHERE id = ? AND recipient_id = ?");
    $stmt->bind_param("ii", $file_id, $student_id);
    if ($stmt->execute()) {
        // Delete file from server
        if (file_exists($file_path)) {
            unlink($file_path);
        }
        echo "<script>alert('File deleted successfully!'); window.location='sup_up_to_student.php';</script>";
    } else {
        echo "<script>alert('Error deleting file!'); window.location='sup_up_to_student.php';</script>";
    }
} else {
    echo "<script>alert('File not found!'); window.location='sup_up_to_student.php';</script>";
}
?>
