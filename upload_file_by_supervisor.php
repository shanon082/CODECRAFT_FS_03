<?php
session_start();
include("db.php");

// Ensure the user is logged in and has the correct role
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'supervisor') {
    header('Location: index.php'); // Redirect to login if the user is not logged in or not a supervisor
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $recipient_type = $_POST['recipient_type']; // Expected values: 'student', 'coordinator', or 'both'
    $recipient_ids = $_POST['recipient_id']; // This will be an array or a single value
    $file = $_FILES['file'];

    // ✅ Validate file upload
    if ($file['error'] === 0) {
        $fileName = basename($file['name']);
        $uploadDir = "uploads/"; // Ensure this folder exists and is writable
        $filePath = $uploadDir . time() . "_" . $fileName;

        if (move_uploaded_file($file['tmp_name'], $filePath)) {
            // ✅ Ensure $recipient_ids is always an array (even if it's a single value)
            if (!is_array($recipient_ids)) {
                $recipient_ids = [$recipient_ids]; // Convert to an array if it's a single value
            }

            // ✅ Handle recipient insertion based on the recipient type
            foreach ($recipient_ids as $recipient_id) {
                if ($recipient_type == 'student') {
                    // Check if recipient is a student
                    $stmt = $conn->prepare("SELECT id FROM students WHERE id = ?");
                } elseif ($recipient_type == 'coordinator') {
                    // Check if recipient is a coordinator
                    $stmt = $conn->prepare("SELECT id FROM coordinators WHERE id = ?");
                } elseif ($recipient_type == 'both') {
                    // Check if recipient is either a student or coordinator
                    $stmt = $conn->prepare("SELECT id FROM students WHERE id = ? UNION SELECT id FROM coordinators WHERE id = ?");
                } else {
                    die("Invalid recipient type.");
                }

                $stmt->bind_param("i", $recipient_id);
                $stmt->execute();
                $stmt->store_result();

                if ($stmt->num_rows > 0) {
                    // ✅ Insert file details into the database
                    $stmt = $conn->prepare("INSERT INTO upload (file_name, file_path, recipient_type, recipient_id, uploaded_by, uploaded_at) VALUES (?, ?, ?, ?, ?, NOW())");
                    $uploadedBy = htmlspecialchars($_SESSION['user_name']); // Ensure session is set
                    $stmt->bind_param("sssis", $fileName, $filePath, $recipient_type, $recipient_id, $uploadedBy);

                    if (!$stmt->execute()) {
                        echo "Database error: " . $stmt->error;
                    }
                } else {
                    echo "Error: Recipient ID $recipient_id does not exist.";
                }
            }

            echo "File uploaded and notification sent successfully!";
        } else {
            echo "Error: Failed to move the uploaded file.";
        }
    } else {
        echo "Error: File upload failed.";
    }
}
?>
