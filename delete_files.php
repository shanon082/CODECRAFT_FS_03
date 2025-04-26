<?php
session_start();
include("db.php");

// Ensure the user is logged in as a coordinator
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'coordinator') {
    die("Unauthorized access.");
}

// CSRF Protection
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die("CSRF token mismatch.");
}

// Check if file_id is set
if (!isset($_POST['file_id'])) {
    die("Invalid request.");
}

$file_id = intval($_POST['file_id']);

// Fetch file details before deleting
$stmt = $conn->prepare("SELECT file_path FROM upload WHERE id = ?");
$stmt->bind_param("i", $file_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("File not found.");
}

$row = $result->fetch_assoc();
$file_path = $row['file_path'];

// Delete file from the database
$stmt = $conn->prepare("DELETE FROM upload WHERE id = ?");
$stmt->bind_param("i", $file_id);
if ($stmt->execute()) {
    // Delete file from server storage
    if (file_exists($file_path)) {
        unlink($file_path);
    }
    echo "<script>alert('File deleted successfully.'); window.location.href='sup_up_to_coord.php';</script>";
} else {
    echo "<script>alert('Failed to delete file.'); window.location.href='sup_up_to_coord.php';</script>";
}

$stmt->close();
$conn->close();
?>
