<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign supervisor</title>
</head>
<?php
include("db.php")
?>

<body>
    <div class="container">

        <h2>Assign supervisor</h2>
        <form method="POST" action="assign_supervisor.php">
            <label for="student_id">Select Student:</label>
            <select name="student_id" id="student_id">
                <?php
                $students = $conn->query("SELECT id, username FROM students");
                while ($student = $students->fetch_assoc()) {
                    echo "<option value='" . $student['id'] . "'>" . htmlspecialchars($student['username']) . "</option>";
                }
                ?>
            </select>

            <label for="supervisor_id">Select Supervisor:</label>
            <select name="supervisor_id" id="supervisor_id">
                <!-- Populate with supervisors from the database -->
                <?php
                $supervisors = $conn->query("SELECT id, username FROM supervisors");
                while ($supervisor = $supervisors->fetch_assoc()) {
                    echo "<option value='" . $supervisor['id'] . "'>" . htmlspecialchars($supervisor['username']) . "</option>";
                }
                ?>
            </select>

            <button type="submit">Assign Supervisor</button>
            <button type="button" onclick="window.location.href='Coordinator_dashboard.php'">Back</button>
        </form>
    </div>
</body>

</html>