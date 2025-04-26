<?php
include("db.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the current assignment
    $query = $conn->query("SELECT * FROM engineers WHERE id = $id");
    $assignment = $query->fetch_assoc();

    // Fetch all students and supervisors
    $students = $conn->query("SELECT id, username, email, student_contact FROM students");
    $supervisors = $conn->query("SELECT id, username,email, supervisor_contact FROM supervisors");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $supervisor_id = $_POST['supervisor_id'];
    $student_id = $_POST['student_id'];

    // Retrieve selected student and supervisor details
    $student_query = $conn->query("SELECT username, student_number, student_contact, email FROM students WHERE id = $student_id");
    $student = $student_query->fetch_assoc();

    $supervisor_query = $conn->query("SELECT username, supervisor_contact, email FROM supervisors WHERE id = $supervisor_id");
    $supervisor = $supervisor_query->fetch_assoc();

    // Update the engineers table with the selected values
    $update_query = "
        UPDATE engineers 
        SET 
            supervisor_name = '" . $supervisor['username'] . "', 
            supervisor_contact = '" . $supervisor['supervisor_contact'] . "', 
            supervisor_email = '" . $supervisor['email'] . "',
            student_name = '" . $student['username'] . "', 
            student_number = '" . $student['student_number'] . "', 
            student_contact = '" . $student['student_contact'] . "', 
            student_email = '" . $student['email'] . "'
            
        WHERE id = $id";

    if ($conn->query($update_query) === TRUE) {
        header("Location: Coordinator_dashboard.php");
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Assignment</title>
</head>

<body>
    <h2>Edit Assignment</h2>
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $assignment['id']; ?>">

        <label for="supervisor_id">Select Supervisor:</label>
        <select name="supervisor_id" id="supervisor_id" required>
            <?php
            while ($supervisor = $supervisors->fetch_assoc()) {
                $selected = ($supervisor['supervisor_name'] === $assignment['supervisor_name']) ? 'selected' : '';
                echo "<option value='" . $supervisor['id'] . "' $selected>" . htmlspecialchars($supervisor['username']) . "</option>";
            }
            ?>
        </select>

        <label for="student_id">Select Student:</label>
        <select name="student_id" id="student_id" required>
            <?php
            while ($student = $students->fetch_assoc()) {
                $selected = ($student['student_name'] === $assignment['student_name']) ? 'selected' : '';
                echo "<option value='" . $student['id'] . "' $selected>" . htmlspecialchars($student['username']) . "</option>";
            }
            ?>
        </select>

        <button type="submit">Update</button>
        <button type="button" onclick="window.location.href='Coordinator_dashboard.php'">Cancel</button>
    </form>
</body>

</html>
