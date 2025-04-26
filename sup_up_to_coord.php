<?php
session_start();
include("db.php");

// Ensure the user is logged in and has the correct role
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'coordinator') {
    header('Location: index.php'); // Redirect to login if the user is not logged in
    exit;
}

$coordinator_id = $_SESSION['user_id']; // Corrected variable name

 

// CSRF token generation (if not set)
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
    <title>Supervisor Uploads</title>
</head>
<body>
    <div class="main-content">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></h2>
        <p>Here you can manage uploaded files by a supervisor.</p><br>

        <!-- Fetch Uploaded Files -->
        <?php
        $stmt = $conn->prepare("SELECT * FROM upload WHERE recipient_type IN ('coordinator', 'both') AND recipient_id = ?");
        $stmt->bind_param("i", $coordinator_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Debugging: Check if there are any results
        if ($result->num_rows === 0) {
            echo "<p>No files uploaded yet.</p>";
        }
        ?>

        <div>
            <h2>Uploaded Files by Project Supervisor</h2>
            <table border="1">
                <tr>
                    <th>File Name</th>
                    <th>Uploaded By</th>
                    <th>Uploaded At</th>
                    <th>Download</th>
                    <th>Delete</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['file_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['uploaded_by']); ?></td>
                        <td><?php echo htmlspecialchars($row['uploaded_at']); ?></td>
                        <td>
                            <a href="<?php echo htmlspecialchars($row['file_path']); ?>" download>Download</a>
                        </td>
                        <td>
                            <form method="POST" action="delete_files.php">
                                <input type="hidden" name="file_id" value="<?php echo $row['id']; ?>">
                                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                <button type="submit" onclick="return confirm('Are you sure you want to delete this file?');">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
            
   
        </div>
        <button type="button" name = "button" onclick="window.location.href='coordinator_uploads.php'">Back</button>
    </div>
     
</body>
</html>

<style>

    /* General reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Body styling */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f4f4;
    color: #333;
    padding: 20px;
}

/* Main Content */
.main-content {
    background-color: #ffffff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
    max-width: 1000px;
    margin: 0 auto;
}

/* Heading */
h2 {
    color: #2c3e50;
    font-size: 24px;
    text-align: center;
    margin-bottom: 15px;
}

/* Table Styling */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table th, table td {
    padding: 12px;
    text-align: center;
    border: 1px solid #ddd;
}

table th {
    background-color:  #0f4d0f;
    color: white;
}

table td {
    background-color: #fafafa;
}

/* Button Styling */
button {
    padding: 10px 20px;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    border: none;
    transition: background-color 0.3s;
}

button[type="button"] {
    background-color: #000000;
    color: white;
}

button[type="button"]:hover {
    background-color: #000000;
}

button[type="submit"] {
    background-color: #0f4d0f;
    color: white;
}

button[type="submit"]:hover {
    background-color: #0f4d0f;
}

/* Form and Table Specific */
form {
    margin-top: 20px;
    text-align: center;
}

form input[type="hidden"] {
    display: none;
}

form button {
    width: 100px;
    margin: 0 auto;
    font-size: 14px;
}

/* Link Styling */
a {
    text-decoration: none;
    color: #3498db;
    font-weight: bold;
}

a:hover {
    text-decoration: underline;
}

/* Responsive Styling */
@media (max-width: 768px) {
    .main-content {
        padding: 15px;
    }

    h2 {
        font-size: 20px;
    }

    table th, table td {
        padding: 8px;
        font-size: 14px;
    }

    button {
        font-size: 14px;
    }
}

</style>