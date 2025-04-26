<?php
session_start();

// Ensure the user is logged in and has the correct role
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header('Location: index.php'); // Redirect to login if the user is not logged in or not a student
    exit;
}

$student_id = $_SESSION['user_id']; // Use the user_id set in the session

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "school_database";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";
$deadline = null;
$upload_allowed = false;

// Fetch the latest deadline for the logged-in student (Fixed query execution)
$logged_in_student = $_SESSION['user_name'];
$deadline_sql = "SELECT upload_deadline FROM dow WHERE student_id = (SELECT id FROM students WHERE username = ?) ORDER BY id DESC LIMIT 1";

$stmt = $conn->prepare($deadline_sql);
$stmt->bind_param("s", $logged_in_student);
$stmt->execute();
$deadline_result = $stmt->get_result();

if ($deadline_result->num_rows > 0) {
    $row = $deadline_result->fetch_assoc();
    $deadline = $row['upload_deadline'];
}

$stmt->close(); // Close the statement after execution

$current_date = date("Y-m-d H:i:s"); // Use full DATETIME format for accurate comparison
$upload_allowed = $deadline && ($current_date <= $deadline);

// Handle file upload
if ($_SERVER["REQUEST_METHOD"] == "POST" && $upload_allowed && isset($_FILES["pdf"])) {
    $filename = $_FILES["pdf"]["name"];
    $file_tmp = $_FILES["pdf"]["tmp_name"];
    $filehash = hash_file("sha256", $file_tmp);
    $uploader_name = htmlspecialchars($_SESSION['user_name']); 
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($filename);

    // Ensure the uploads directory exists
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // Check if the file already exists in the database
    $sql = "SELECT * FROM ffiles WHERE filepath = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $filehash);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $message = "File already uploaded, please upload a different file.";
    } else {
        // Save file to the server
        if (move_uploaded_file($file_tmp, $target_file)) {
            $sql = "INSERT INTO ffiles (filename, filepath, uploader_name) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $filename, $target_file, $uploader_name);

            if ($stmt->execute()) {
                $message = "File uploaded successfully by " . htmlspecialchars($uploader_name);
            } else {
                $message = "Failed to save file data.";
            }
        } else {
            $message = "Failed to upload file.";
        }
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload PDF</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f4f7fc;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }
        h2 {
            color: #333;
            margin-bottom: 15px;
        }
        p {
            font-size: 14px;
            color: #555;
        }
        .message {
            font-weight: bold;
            color: #d9534f;
        }
        form {
            margin-top: 20px;
        }
        input[type="file"] {
            display: none;
        }
        label {
            display: inline-block;
            background: #007bff;
            color: #fff;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 10px;
            font-weight: 500;
        }
        label:hover {
            background: #0056b3;
        }
        button {
            color: #fff;
            padding: 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            font-weight: 600;
        }
        button[type=submit] {
            background: #0f4d0f;
        }
        button:hover {
            background: #0d3c0d;
        }
        .back-btn {
            background: #000000;
            margin-top: 10px;
        }
        .back-btn:hover {
            background: #222;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Upload PDF File</h2>

        <?php if ($deadline): ?>
            <p><strong>Current Upload Deadline:</strong> <?php echo htmlspecialchars($deadline); ?></p>
        <?php else: ?>
            <p>No deadline has been set for uploads.</p>
        <?php endif; ?>

        <?php if ($message): ?>
            <p class="message"> <?php echo $message; ?> </p>
        <?php endif; ?>

        <?php if ($upload_allowed): ?>
            <form action="student_uploads.php" method="post" enctype="multipart/form-data">
                <label for="pdf"><i class="fas fa-upload"></i> Select PDF File</label>
                <input type="file" name="pdf" id="pdf" accept="application/pdf" required>
                <button type="submit">Upload</button>
            </form>
        <?php else: ?>
            <p><strong>The deadline for uploading files has passed. No further uploads are allowed.</strong></p>
        <?php endif; ?>

        <button type="button" class="back-btn" onclick="window.location.href='manage_uploads_by_student.php'">Back</button>
    </div>
</body>
</html>
