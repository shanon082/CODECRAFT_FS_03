<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "school_database";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("<div class='error'>Connection failed: " . $conn->connect_error . "</div>");
}

$message = "";
$deadline = null;

// Retrieve the current deadline from the database
$deadline_sql = "SELECT upload_deadline FROM deadline ORDER BY id DESC LIMIT 1";
$deadline_result = $conn->query($deadline_sql);
if ($deadline_result && $deadline_result->num_rows > 0) {
    $deadline = $deadline_result->fetch_assoc()['upload_deadline'];
}

$current_date = date("Y-m-d");

// Check if upload is allowed
if ($deadline && $current_date > $deadline) {
    $message = "The deadline for uploading files has passed. No further uploads are allowed.";
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["pdf"]) && empty($_POST["set_deadline"])) {
    $filename = $_FILES["pdf"]["name"];
    $file_tmp = $_FILES["pdf"]["tmp_name"];
    $filehash = hash_file("sha256", $file_tmp);
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($filename);

    // Check if file already exists
    $stmt = $conn->prepare("SELECT * FROM files WHERE filehash = ?");
    $stmt->bind_param("s", $filehash);
    $stmt->execute();
    $result = $stmt->get_result();

    // Create uploads directory if it doesn't exist
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    if ($result->num_rows > 0) {
        $message = "File already uploaded, please upload a different file.";
    } else {
        if (move_uploaded_file($file_tmp, $target_file)) {
            $stmt = $conn->prepare("INSERT INTO files (filename, filehash, filepath) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $filename, $filehash, $target_file);
            if ($stmt->execute()) {
                $message = "File uploaded successfully.";
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
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color:  #f0f2f5;;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 450px;
            width: 100%;
            text-align: center;
        }
        h2 { 
            color: #343a40; 
            margin-bottom: 20px;
        }
        .message {
            font-weight: bold;
            color: #dc3545;
            margin-bottom: 15px;
        }
        .btn {
            display: inline-block;
            background: #28a745;
            color: white;
            padding: 12px 8px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.3s;
            width: 48%;
            text-align: center;
            text-decoration: none;
            margin-top: 10px;
        }
        .btn:hover {
            background: #218838;
        }
        .back-btn {
            display: inline-block;
            background:black ;
            color: white;
            padding: 12px 8px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.3s;
            width: 100%;
            text-align: center;
            text-decoration: none;
            margin-top: 10px;
        }
        .back-btn:hover {
            background: #23272b;
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

        <?php if (!$deadline || $current_date <= $deadline): ?>
            <form action="upload.php" method="post" enctype="multipart/form-data">
                <input type="file" name="pdf" accept="application/pdf" required>
                <div style="display: flex; justify-content: space-between;">
                    <button type="submit" class="btn">Upload</button>
                    
                </div>
            </form>
        <?php else: ?>
            <p class="message">The deadline for uploading files has passed.</p>
        <?php endif; ?>
        <a href="manage_uploads_by_student.php" class="back-btn">Back</a>
    </div>
</body>
</html>
