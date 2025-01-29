<?php
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

// Retrieve the current deadline from the database
$deadline = null;
$deadline_sql = "SELECT upload_deadline FROM deadline ORDER BY id DESC LIMIT 1";
$deadline_result = $conn->query($deadline_sql);

if ($deadline_result && $deadline_result->num_rows > 0) {
    $deadline = $deadline_result->fetch_assoc()['upload_deadline'];
}

$current_date = date("Y-m-d"); // Get the current date in "YYYY-MM-DD" format

// Check if the current date is past the deadline before allowing file uploads
if ($deadline && $current_date > $deadline) {
    $message = "The deadline for uploading files has passed. No further uploads are allowed.";
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["pdf"]) && empty($_POST["set_deadline"])) {
    $filename = $_FILES["pdf"]["name"];
    $file_tmp = $_FILES["pdf"]["tmp_name"];
    $filehash = hash_file("sha256", $file_tmp);
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($filename);

    // Check if file already exists
    $sql = "SELECT * FROM files WHERE filehash = ?";
    $stmt = $conn->prepare($sql);
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
        // Save file to the server
        if (move_uploaded_file($file_tmp, $target_file)) {
            $sql = "INSERT INTO files (filename, filehash, filepath) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
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
    <link rel="stylesheet" href="styles.css">
    <title>Upload PDF</title>
</head>
<body>

    <h2>Upload PDF File</h2>

    <?php if ($deadline): ?>
        <!-- Show current deadline -->
        <p><strong>Current Upload Deadline:</strong> <?php echo htmlspecialchars($deadline); ?></p>
    <?php else: ?>
        <!-- No deadline set -->
        <p>No deadline has been set for uploads.</p>
    <?php endif; ?>

    <!-- Display message based on upload status or deadline -->
    <?php if ($message): ?>
        <p><strong><?php echo $message; ?></strong></p>
    <?php endif; ?>

    <?php if (!$deadline || $current_date <= $deadline): ?>
        <!-- Form to upload the file -->
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <input type="file" name="pdf" accept="application/pdf" required>
            <button type="submit">Upload</button>
        </form>
    <?php else: ?>
        <p>The deadline for uploading files has passed.</p>
    <?php endif; ?>

</body>

<button type="button" name = "button" onclick="window.location.href='students.php'">Back</button>
</html> 
<style>
    /* Global styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

body {
    background-color: #f0f2f5;
    color: #333;
    padding: 20px;
    font-size: 16px;
}

h2 {
    text-align: center;
    color: #333;
    font-size: 1.8rem;
    margin-bottom: 20px;
    font-weight: 500;
    margin-top: 70px;
}

/* Main container */
.main-container {
    max-width: 500px;
    margin: 0 auto;
    background-color: #ffffff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

/* Forms and buttons */
form {
    display: flex;
     flex-direction: column;
    gap: 10px;
    margin-left: 400px;
    margin-top: 30px;
    margin-right: 400px;
    background-color: white;
}

input[type="file"] {
    padding: 12px;
    border-radius: 4px;
    border: 1px solid #ccc;
    font-size: 1rem;
    cursor: pointer;
}

button {
    background-color: #4CAF50;
    color: #ffffff;
    padding: 12px;
    border: none;
    border-radius: 4px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #45a049;
}

button[name="button"] {
    background-color: black;
    color: #fff;
    padding: 12px;
     margin-left: 400px;
     margin-right: 400px;
    border-radius: 4px;
    font-size: 1rem;
    cursor: pointer;
    width: 39.7%;
    
    transition: background-color 0.3s;
}
/* Message and deadline styles */
p {
    text-align: center;
    color: #555;
    margin-top: 10px;
    font-size: 1rem;
}

.message {
    text-align: center;
    font-weight: bold;
    color: #d9534f; /* Red for errors or deadlines */
}

.success-message {
    color: #5cb85c; /* Green for success */
}

.deadline-info {
    color: #f0ad4e; /* Orange for deadline info */
    font-weight: 500;
}

/* Links */
a {
    color: #007bff;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

 
@media screen and (max-width: 768px) {
    .main-container {
        width: 90%;
        padding: 15px;
    }
 
}

</style>