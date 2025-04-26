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

// Retrieve the current deadline from the database (including date and time)
$deadline = null;
$deadline_sql = "SELECT upload_deadline FROM deadline ORDER BY id DESC LIMIT 1";
$deadline_result = $conn->query($deadline_sql);

if ($deadline_result && $deadline_result->num_rows > 0) {
    $deadline = $deadline_result->fetch_assoc()['upload_deadline'];
}

$current_date = date("Y-m-d H:i"); // Get the current date and time in "YYYY-MM-DD HH:MM" format

// Set the deadline if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["set_deadline"])) {
    $new_deadline = $_POST["deadline_date"];

    // Insert or update the deadline in the database
    $stmt = $conn->prepare("INSERT INTO deadline (upload_deadline) VALUES (?)");
    $stmt->bind_param("s", $new_deadline);
    if ($stmt->execute()) {
        $message = "Deadline set to " . htmlspecialchars($new_deadline);
        $deadline = $new_deadline; // Update the deadline variable
    } else {
        $message = "Failed to set deadline.";
    }
    $stmt->close();
}

// Handle file deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_file"])) {
    $file_id = $_POST["file_id"];
    $file_sql = "SELECT filepath FROM files WHERE id = ?";
    $stmt = $conn->prepare($file_sql);
    $stmt->bind_param("i", $file_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $file = $result->fetch_assoc();
        $filepath = $file['filepath'];
        
        // Delete the file from the server
        if (file_exists($filepath)) {
            unlink($filepath); // Delete the file
        }
        
        // Delete the file record from the database
        $delete_sql = "DELETE FROM files WHERE id = ?";
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->bind_param("i", $file_id);
        if ($delete_stmt->execute()) {
            $message = "File deleted successfully!";
        } else {
            $message = "Error deleting file from database.";
        }
        $delete_stmt->close();
    } else {
        $message = " ";
    }
    $stmt->close();
}

// Retrieve files from the database
$sql = "SELECT * FROM files ORDER BY uploaded_at DESC";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View students' files</title>
</head>
<body>
    <div class="main">
        
 
    <form action="view_files.php" method="post">
    
    <h2>Uploaded PDF files by students</h2>
    <table>
        <tr>
            <th>Filename</th>
            <th>Download</th>
            <th>Uploaded At</th>
            <th>Delete</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['filename']) . "</td>";
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
            echo "<tr><td colspan='4'>No files uploaded.</td></tr>";
        }
        ?>
    </table>
    <button type="button" name = "button" onclick="window.location.href='Coordinator_uploads.php'">Back</button>
</body>
</html>

<?php
// Close the connection after rendering the HTML
$conn->close();
?>
 
 
 <style>

body {
    background-color: #f4f7fc;
    font-family: 'Poppins', sans-serif;
    color: #333;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}
.container {
    width: 90%;
    max-width: 1000px;
    background: white;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
}
h2 {
    text-align: center;
    color: #000000;
    margin-bottom: 25px;
    font-size: 24px;
    font-weight: bold;
}
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    border-radius: 8px;
    overflow: hidden;
    background: white;
}
th, td {
    padding: 15px;
    border: 1px solid #ddd;
    text-align: center;
    font-size: 16px;
}
th {
    background-color:  #0f4d0f;
    color: white;
    font-weight: bold;
}
tr:nth-child(even) {
    background-color: #f0f4f8;
}
tr:hover {
    background-color: #e3e9f0;
    transition: background 0.3s ease;
}
button {
    margin-top: 20px;
    padding: 12px 20px;
  background-color:   #0f4d0f;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    cursor: pointer;
    transition: background 0.3s, transform 0.2s;
}
button:hover {
    background-color:   #0f4d0f;
    transform: scale(1.05);
}
button[type=button]{
    background-color: black;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    cursor: pointer;
    transition: background 0.3s, transform 0.2s;
}
button[type=button]:hover {
    background-color: #333;
    transform: scale(1.05);
}
a {
    text-decoration: none;
    color: #007bff;
    font-weight: bold;
    transition: color 0.3s;
}
a:hover {
    color: #0056b3;
}

 </style>