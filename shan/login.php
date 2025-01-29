<?php
ob_start(); // Start output buffering
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usernumber = $_POST['user_number'];
    $password = $_POST['password'];
    $role = $_POST['role']; // Get the selected role

    // Map the role to the corresponding table and columns
    switch ($role) {
        case 'student':
            $table = 'students';
            $column = 'student_number';
            $password_column = 'password';
            break;
        case 'admin':
            $table = 'admins';
            $column = 'username';
            $password_column = 'password';
            break;
        case 'supervisor':
            $table = 'supervisors';
            $column = 'username';
            $password_column = 'password';
            break;
        case 'coordinator':
            $table = 'coordinators';
            $column = 'username';
            $password_column = 'password';
            break;
        default:
            header('Location: index.php?error=' . urlencode('Invalid role selected.'));
            exit;
    }

    // Prepare the SQL statement
    $query = $conn->prepare("SELECT * FROM $table WHERE $column=? AND $password_column=?");
    $query->bind_param("ss", $usernumber, $password);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Store session data
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $role;
        $_SESSION['user_name'] = $user['username'] ?? $user['admin_name'] ?? $user['username'] ?? $user['username'];
        $_SESSION['user_email'] = $user['email'] ?? $user['email'] ?? $user['email'] ?? $user['email'];
        $_SESSION['user_contact'] = $user['student_contact'] ?? $user['admin_contact'] ?? $user['supervisor_contact'] ?? $user['coordinator_contact'];

        // Redirect to the respective dashboard
        switch ($role) {
            case 'student':
                header('Location: students.php');
                break;
            case 'admin':
                header('Location: Admin_dashboard.php');
                break;
            case 'supervisor':
                header('Location: supervisor_dashboard.php');
                break;
            case 'coordinator':
                header('Location: Coordinator_dashboard.php');
                break;
        }
        exit;
    } else {
        header('Location: index.php?error=' . urlencode('Wrong username or password'));
        exit;
    }
}
?>
