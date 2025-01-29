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
    <title>View and Set Deadline</title>
</head>
<body>
    <div class="main">
        <h2>Set Upload Deadline</h2>

        <!-- Form to set the deadline -->
        <form action="view_files.php" method="post">
            <label for="deadline_date">Set Upload Deadline:</label>
            <input type="datetime-local" name="deadline_date" required>
            <button type="submit" name="set_deadline">Set Deadline</button>
        </form>

        <p>Current Deadline: <?php echo $deadline ? htmlspecialchars($deadline) : "No deadline set"; ?></p></div>
        <p><?php echo $message; ?></p>
     
</div>
    <h2>Uploaded PDF Files</h2>
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
    <button type="button" name = "button" onclick="window.location.href='Coordinator_dashboard.php'">Back</button>
</body>
</html>

<?php
// Close the connection after rendering the HTML
$conn->close();
?>
<style>
 /* Global styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
    height: 1000Ah;
}

body {
    background-color: #f4f4f9;
    color: #333;
    padding: 20px;
    font-size: 16px;
    
}

h2 {
    margin-top: 20px;
    text-align: center;
    color: #333;
    font-size: 1.5rem;
    margin-bottom: 10px;
}

/* Main container */
.main {
    max-width: 600px;
    margin: 0 auto;
    background-color: #ffffff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-top: 50px;
    margin-bottom: 50px;
}

/* Forms and buttons */
form {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

input[type="datetime-local"] {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 1rem;
}

button[type="submit"] {
    background-color: #4CAF50;
    color: #fff;
    padding: 12px;
    border: none;
    border-radius: 4px;
    font-size: 1rem;
    cursor: pointer;
    transition: background-color 0.3s;
}

button[type="submit"]:hover {
    background-color: #45a049;
}
button[name="button"] {
    background-color: black;
    color: #fff;
    padding: 12px;
     margin-left: 300px;
    border-radius: 4px;
    font-size: 1rem;
    cursor: pointer;
    width: 50%;
    transition: background-color 0.3s;
}
p {
    text-align: center;
    color: #555;
    margin-top: 10px;
}

/* Table styles */
table {
    width: 50%;
    margin: 20px auto;
    border-collapse: collapse;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    background-color:white;
}

th, td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

th {
     
     
    font-size: 1.1rem;
    text-align: center;
}

td {
    font-size: 1rem;
}

tr:hover {
    background-color: #f2f2f2;
}

/* Delete button */
form[method="post"] button[type="submit"] {
    background-color: #d9534f;
    color: #fff;
    padding: 8px 12px;
    border: none;
    border-radius: 4px;
    font-size: 0.9rem;
    cursor: pointer;
    transition: background-color 0.3s;
}

form[method="post"] button[type="submit"]:hover {
    background-color: #c9302c;
}

/* Links */
a {
    color: #007bff;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

/* Responsive design */
@media screen and (max-width: 768px) {
    .main {
        width: 50%;
        padding: 15px;
    }

    table {
        width: 50%;
    }

    h2 {
        font-size: 1.3rem;
    }
}

</style>
