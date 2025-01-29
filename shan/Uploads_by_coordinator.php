<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload File</title>
</head>
<body>
    <h2>Upload and Submit File</h2>
    <form action="upload_file_by_coordinator.php" method="POST" enctype="multipart/form-data">
        <label for="recipient_type">Recipient Type:</label>
        <select name="recipient_type" id="recipient_type" required>
            <option value="student">Student</option>
            <option value="supervisor">Supervisor</option>
            <option value="both">Both</option>
        </select>
        <br><br>

        <label for="recipient_id">Select Recipient:</label>
        <select name="recipient_id" id="recipient_id" required>
            <!-- This will be populated dynamically -->
            <?php
            include("db.php");
            // Fetch recipients based on type
            $students = $conn->query("SELECT id, username FROM students");
            $supervisors = $conn->query("SELECT id, username FROM supervisors");

            echo "<optgroup label='Students'>";
            while ($student = $students->fetch_assoc()) {
                echo "<option value='student_" . $student['id'] . "'>" . htmlspecialchars($student['username']) . "</option>";
            }
            echo "</optgroup>";

            echo "<optgroup label='Supervisors'>";
            while ($supervisor = $supervisors->fetch_assoc()) {
                echo "<option value='supervisor_" . $supervisor['id'] . "'>" . htmlspecialchars($supervisor['username']) . "</option>";
            }
            echo "</optgroup>";
            ?>
        </select>
        <br><br>

        <label for="file">Choose File:</label>
        <input type="file" name="file" id="file" required>
        <br><br>

        <button type="submit">Upload File</button>
    </form>
</body>
</html>
