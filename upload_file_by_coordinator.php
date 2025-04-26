<?php
session_start();
include("db.php");

// Ensure the user is logged in and has the correct role
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'coordinator') {
    header('Location: index.php'); // Redirect to login if the user is not logged in or not a student
    exit;
}

$student_id = $_SESSION['user_id']; // Use the user_id set in the session
?>
 

<?php
include("db.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $recipient_type = $_POST['recipient_type'];
    $recipient_id = $_POST['recipient_id'];
    $file = $_FILES['file'];

    // Parse recipient_id into type and actual ID
    [$type, $id] = explode('_', $recipient_id);

    // Validate file
    if ($file['error'] === 0) {
        $fileName = basename($file['name']);
        $uploadDir = "uploads/"; // Ensure this folder exists and is writable
        $filePath = $uploadDir . time() . "_" . $fileName;

        if (move_uploaded_file($file['tmp_name'], $filePath)) {
            // Check if the recipient_id exists in the appropriate table
            if ($type == 'student') {
                $stmt = $conn->prepare("SELECT id FROM students WHERE id = ?");
            } elseif ($type == 'supervisor') {
                $stmt = $conn->prepare("SELECT id FROM supervisors WHERE id = ?");
            } else {
                echo "Invalid recipient type.";
                exit;
            }

            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                // Insert file details into the database
                $stmt = $conn->prepare("INSERT INTO uploads (file_name, file_path, recipient_type, recipient_id, uploaded_by, uploaded_at) VALUES (?, ?, ?, ?, ?, NOW())");
                $uploadedBy =   htmlspecialchars($_SESSION['user_name']); // Replace with the actual coordinator username or ID
                $stmt->bind_param("sssis", $fileName, $filePath, $recipient_type, $id, $uploadedBy);

                if ($stmt->execute()) {
                    echo "File uploaded and notification sent successfully!";
                } else {
                    echo "Database error: " . $stmt->error;
                }
            } else {
                echo "Recipient does not exist.";
            }
        } else {
            echo "Failed to move the uploaded file.";
        }
    } else {
        echo "Error uploading file.";
    }
}
?>
