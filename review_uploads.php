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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View and Set Deadline</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <form method="POST" class="deadline-form">
            <label for="student_id">Select Student:</label>
            <select name="student_id" id="student_id">
                <?php
                $students = $conn->query("SELECT id, username FROM students");
                while ($student = $students->fetch_assoc()) {
                    echo "<option value='" . $student['id'] . "'>" . htmlspecialchars($student['username']) . "</option>";
                }
                ?>
            </select>
            
            <h2>Set Upload Deadline</h2>
            <label for="deadline_date">Set Upload Deadline:</label>
            <input type="datetime-local" name="deadline_date" required>
            <button type="submit" name="set_deadline" class="btn">Set Deadline</button>
           
            <button type="button" class="btn back-btn" onclick="window.location.href='supervisor_dashboard.php'">Back</button>
            <p class="message">Current Deadline: <?php echo $deadline ? htmlspecialchars($deadline) : "No deadline set"; ?></p>
            <p class="message status"> <?php echo $message; ?> </p>
        </form>
        
      
    </div>
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
    color: #333;
}
form {
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    max-width: 400px;
    margin: auto;
}
label {
    font-weight: bold;
}
select, input, button {
    width: 100%;
    margin-top: 10px;
    padding: 8px;
    border-radius: 5px;
    border: 1px solid #ccc;
}

input[type="datetime-local"] {
    width: 95%;
    
}
button {
    background-color:   #0f4d0f ;
    color: white;
    border: none;
    cursor: pointer;
}
button:hover {
    background-color:    #0f4d0f ;
}
p {
    text-align: center;
    font-size: 16px;
}

button[type=button ]{
    background: black


}

</style>