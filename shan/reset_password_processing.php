<?php
session_start();
require 'db.php';

unset($_SESSION['error']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $_SESSION['error'] = "Passwords do not match.";
        header("Location: reset_password.php");
        exit();
    }

    $email = $_SESSION['email'];
    $role = $_POST['role'];

    switch ($role) {
        case 'student':
            $table = 'students';
            $column = 'email';
            $password_column = 'password';
            break;
        case 'admin':
            $table = 'admins';
            $column = 'admin_username';
            $password_column = 'password';
            break;
        case 'supervisor':
            $table = 'supervisors';
            $column = 'email';
            $password_column = 'password';
            break;
        case 'coordinator':
            $table = 'coordinators';
            $column = 'email';
            $password_column = 'password';
            break;
        default:
            header('Location: index.php?error=' . urlencode('Invalid role selected.'));
            exit;
    }

    $stmt = $conn->prepare("UPDATE $table SET $password_column = ? WHERE $column = ?");
    $stmt->bind_param("ss", $password, $email);
    $stmt->execute();

    header("Location: index.php");
}
?>
