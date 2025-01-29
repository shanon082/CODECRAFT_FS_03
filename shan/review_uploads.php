<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "school_database";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, filename, filepath, upload_date FROM ufiles ORDER BY upload_date DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="supervisor.css">
    <title>Review Uploads</title>
</head>
<body>
<?php include("supervisor_header.php"); ?>
<div class="container">
    <h2>Review Uploaded Files</h2>
    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>File Name</th>
                    <th>Download Link</th>
                    <th>Upload Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['filename']); ?></td>
                        <td><a href="<?php echo htmlspecialchars($row['filepath']); ?>" download>Download</a></td>
                        <td><?php echo htmlspecialchars($row['upload_date']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No files have been uploaded yet.</p>
    <?php endif; ?>

    <!--set deadlines-->
<form method="POST" action="view_files.php">
    <label for="student_id">Select Student:</label>
    <select name="student_id" id="student_id">
          <?php
            include("db.php");
            $students = $conn->query("SELECT id, username FROM students");

            echo "<optgroup label='Students'>";
            while ($student = $students->fetch_assoc()) {
                echo "<option value='student_" . $student['id'] . "'>" . htmlspecialchars($student['username']) . "</option>";
            }
            echo "</optgroup>";
            ?>
    </select>

    <label for="deadline_date">Set Deadline:</label>
    <input type="datetime-local" name="deadline_date" id="deadline_date" required>

    <button type="submit">Set Deadline</button>
    </form>


<!-- <?php
// $sql = "SELECT * FROM files WHERE user_id = ?";
// $stmt = $conn->prepare($sql);
// $stmt->bind_param("i", $supervisor_id);
// $stmt->execute();
// $result = $stmt->get_result();
// while ($row = $result->fetch_assoc()) {
//     echo "<tr>
//             <td>" . htmlspecialchars($row['file_path']) . "</td>
//             <td><a href='" . htmlspecialchars($row['file_path']) . "' download>Download</a></td>
//           </tr>";
//}
?> -->

</div>
</body>
</html>
