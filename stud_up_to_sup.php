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

// Retrieve the latest deadline and student ID
$deadline = null;
$selected_student_id = null;
$deadline_sql = "SELECT upload_deadline, student_id FROM dow ORDER BY id DESC LIMIT 1";
$deadline_result = $conn->query($deadline_sql);

if ($deadline_result && $deadline_result->num_rows > 0) {
    $row = $deadline_result->fetch_assoc();
    $deadline = $row['upload_deadline'];
    $selected_student_id = $row['student_id'];
}

$current_date = date("Y-m-d H:i");

// Set deadline if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["set_deadline"])) {
    $new_deadline = $_POST["deadline_date"];
    $student_id = $_POST["student_id"];

    // Check if student exists
    $check_student = $conn->prepare("SELECT id FROM students WHERE id = ?");
    $check_student->bind_param("i", $student_id);
    $check_student->execute();
    $student_result = $check_student->get_result();

    if ($student_result->num_rows == 0) {
        $message = "Error: Selected student does not exist.";
    } else {
        // Insert the deadline
        $stmt = $conn->prepare("INSERT INTO dow (upload_deadline, student_id) VALUES (?, ?)");
        $stmt->bind_param("si", $new_deadline, $student_id);

        if ($stmt->execute()) {
            $message = "Deadline set for student ID " . htmlspecialchars($student_id) . " until " . htmlspecialchars($new_deadline);
            $deadline = $new_deadline;
            $selected_student_id = $student_id;
        } else {
            $message = "Failed to set deadline.";
        }
        $stmt->close();
    }
    $check_student->close();
}

// Handle file upload (Only for the selected student)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["file_upload"]) && isset($_POST["uploader_id"])) {
    $uploader_id = $_POST["uploader_id"];

    if ($uploader_id != $selected_student_id) {
        $message = "Error: Only the assigned student can upload files.";
    } else {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["file_upload"]["name"]);

        if (move_uploaded_file($_FILES["file_upload"]["tmp_name"], $target_file)) {
            $stmt = $conn->prepare("INSERT INTO ffiles (filename, filepath, uploader_name, uploaded_at) VALUES (?, ?, ?, NOW())");
            $stmt->bind_param("sss", $_FILES["file_upload"]["name"], $target_file, $uploader_id);

            if ($stmt->execute()) {
                $message = "File uploaded successfully!";
            } else {
                $message = "Error saving file to database.";
            }
            $stmt->close();
        } else {
            $message = "Error uploading file.";
        }
    }
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

// Retrieve uploaded files
$sql = "SELECT filename, filepath, uploaded_at, uploader_name, id FROM ffiles ORDER BY uploaded_at DESC";
$result = $conn->query($sql);
?>

 

<h2>Uploaded PDF Files by students</h2>
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
                        <button type='submit' name='delete_file' onclick=\"return confirm('Are you sure?');\">Delete</button>
                    </form>
                  </td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='5'>No files uploaded.</td></tr>";
    }
    ?>
</table>

<button type="button" onclick="window.location.href='manage_uploads_by_sup.php'">Back</button>

</body>
</html>

<?php
$conn->close();
?>
<style>

body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 20px;
}

h2 {
    text-align: center;
    color: #333;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
    background: #fff;
}

th, td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: left;
}

th {
    background-color:  #0f4d0f;
    color: white;
}

td {
    color: #333;
}

button {
    background-color:  #0f4d0f;
    color: white;
    padding: 10px;
    border: none;
    cursor: pointer;
}

button:hover {
    background-color:  #0f4d0f;
}
button[type=button]{

background: black;

}
button[type=button ]:hover {
    background-color:  #000000;
}


</style>