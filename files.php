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
$deadline_sql = "SELECT upload_deadline FROM down ORDER BY id DESC LIMIT 1";
$deadline_result = $conn->query($deadline_sql);

if ($deadline_result && $deadline_result->num_rows > 0) {
    $deadline = $deadline_result->fetch_assoc()['upload_deadline'];
}

$current_date = date("Y-m-d H:i");

// Set the deadline if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["set_deadline"])) {
    $new_deadline = $_POST["deadline_date"];

    $stmt = $conn->prepare("INSERT INTO down (upload_deadline) VALUES (?)");
    $stmt->bind_param("s", $new_deadline);
    if ($stmt->execute()) {
        $message = "Deadline set to " . htmlspecialchars($new_deadline);
        $deadline = $new_deadline;
    } else {
        $message = "Failed to set deadline.";
    }
    $stmt->close();
}

// Handle file deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_file"])) {
    $file_id = $_POST["file_id"];
    $file_sql = "SELECT filepath FROM ffiles WHERE id = ?";
    $stmt = $conn->prepare($file_sql);
    $stmt->bind_param("i", $file_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $file = $result->fetch_assoc();
        $filepath = $file['filepath'];

        if (file_exists($filepath)) {
            unlink($filepath);
        }

        $delete_sql = "DELETE FROM ffiles WHERE id = ?";
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->bind_param("i", $file_id);
        if ($delete_stmt->execute()) {
            $message = "File deleted successfully!";
        } else {
            $message = "Error deleting file from database.";
        }
        $delete_stmt->close();
    }
    $stmt->close();
}

// Retrieve files from the database
$sql = "SELECT filename, filepath, uploaded_at, uploader_name, id FROM ffiles ORDER BY uploaded_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View and Set Deadline</title>
</head>
<body>
    <div class="main">
        <h2>Set Upload Deadline</h2>

        <form action="files.php" method="post">
            <label for="deadline_date">Set Upload Deadline:</label>
            <input type="datetime-local" name="deadline_date" required>
            <button type="submit" name="set_deadline">Set Deadline</button>
        </form>

        <p>Current Deadline: <?php echo $deadline ? htmlspecialchars($deadline) : "No deadline set"; ?></p>
    </div>
    <p><?php echo $message; ?></p>

    <h2>Uploaded PDF Files</h2>
    <table>
        <tr>
            <th>Filename</th>
            <th>Uploader</th>
            <th>Download</th>
            <th>Uploaded At</th>
            <th>Delete</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['filename']) . "</td>";
                echo "<td>" . htmlspecialchars($row['uploader_name']) . "</td>";
                echo "<td><a href='" . htmlspecialchars($row['filepath']) . "' download>Download</a></td>";
                echo "<td>" . $row['uploaded_at'] . "</td>";
                echo "<td>
                        <form method='post' style='display:inline;'>
                            <input type='hidden' name='file_id' value='" . $row['id'] . "'>
                            <button type='submit' name='delete_file' onclick=\"return confirm('Are you sure you want to delete this file?');\">Delete</button>
                        </form>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No files uploaded.</td></tr>";
        }
        ?>
    </table>
    <button type="button" onclick="window.location.href='supervisor_dashboard.php'">Back</button>
</body>
</html>

<?php
$conn->close();
?>
