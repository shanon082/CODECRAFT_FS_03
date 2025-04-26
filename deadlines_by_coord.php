 

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
    <script src="https://kit.fontawesome.com/7a97402827.js"crossorigin="anonymous"></script>
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
            <button type="button" name = "button" onclick="window.location.href='Coordinator_uploads.php'">Back</button>
        </form>

        <p>Current Deadline: <?php echo $deadline ? htmlspecialchars($deadline) : "No deadline set"; ?></p></div>
        <p><?php echo $message; ?></p>
       
     
</div>
     
     
</body>
</html>

 
 <style>
/* General styles */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.main {
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    width: 400px;
    text-align: center;
}

h2 {
    color: #333;
}

form {
    margin-top: 15px;
}

label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: #555;
}

input[type="datetime-local"] {
    width: 95%;
    padding: 8px;
    margin-right: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

button {
    background-color:  #0f4d0f ;
    color: white;
    border: none;
    padding: 10px;
    margin-bottom: 10px;
    width: 100%;
    border-radius: 5px;
    cursor: pointer;
    transition: background 0.3s;
}

button:hover {
    background-color:   #0f4d0f;
}

p {
    font-size: 14px;
    color: #666;
}

/* Back button */
button[name="button"] {
    background-color: black;

   
}

button[name="button"]:hover {
    background-color:rgb(3, 12, 20);
}


 </style>