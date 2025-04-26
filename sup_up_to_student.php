<?php
session_start();
include("db.php");

// Ensure the user is logged in and has the correct role
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header('Location: index.php'); // Redirect to login if the user is not logged in
    exit;
}

$student_id = $_SESSION['user_id']; // Assign student ID from session

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
    <link rel="stylesheet" href="styles.css"> <!-- Linking External CSS -->
</head>

<body>
    <div class="container">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></h2>
        <p>Here you can manage uploaded files by a supervisor.</p><br>

        <!-- Uploaded Files Section -->
        <?php
        $stmt = $conn->prepare("SELECT * FROM upload WHERE recipient_type IN ('student', 'both') AND recipient_id = ?");
        $stmt->bind_param("i", $student_id);
        $stmt->execute();
        $result = $stmt->get_result();
        ?>
        <div class="uploads">
            <h2>Uploaded Files by Project Supervisor</h2>
            <table>
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
                        <td><a href="<?php echo htmlspecialchars($row['file_path']); ?>" download class="download-btn">Download</a></td>
                        <td>
                            <form method="POST" action="delete_file.php">
                                <input type="hidden" name="file_id" value="<?php echo $row['id']; ?>">
                                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                <button type="submit" class="delete-btn" onclick="return confirm('Are you sure you want to delete this file?');">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>
        <button type="button" class="back-btn" onclick="window.location.href='manage_uploads_by_student.php'">Back</button>
    </div>
</body>

</html>
<style>

body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

.container {
    width: 80%;
    margin: auto;
    background: white;
    padding: 20px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    margin-top: 50px;
}

h2 {
    color: #333;
}

.uploads table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.uploads table, th, td {
    border: 1px solid #ddd;
}

th, td {
    padding: 12px;
    text-align: left;
}

th {
    background:  #0f4d0f;
    color: white;
}

.download-btn {
    text-decoration: none;
     
}

.delete-btn {
    background: #dc3545;
    color: white;
    border: none;
    padding: 5px 10px;
    cursor: pointer;
    border-radius: 4px;
}

.delete-btn:hover {
    background: #c82333;
}

.back-btn {
    background: #000000;
    color: white;
    padding: 10px 20px;
    border: none;
    cursor: pointer;
    border-radius: 4px;
    margin-top: 20px;
}

.back-btn:hover {
    background: #5a6268;
}



</style>