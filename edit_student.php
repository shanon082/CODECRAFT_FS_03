<?php
$conn = new mysqli("localhost", "root", "", "school_database");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = $conn->real_escape_string($_GET['id']);
 
    
    $sql = "SELECT  id, username, student_contact, student_number, email, password FROM students WHERE id = '$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "There is no matching records";
        exit;
    }
} else {
    echo "Invalid request.";
    exit;
}

// Handle form submission for updating the supervisors and students
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $new_id = $conn->real_escape_string($_POST['id']);
    $new_name = $conn->real_escape_string($_POST['student_name']);
    $new_contact = $conn->real_escape_string($_POST['student_contact']);
    $new_number = $conn->real_escape_string($_POST['student_number']);
    $new_email = $conn->real_escape_string($_POST['email']);
    $new_password = $conn->real_escape_string($_POST['password']);
    

    $sql = "UPDATE students  SET  id=' $new_id', username='$new_name', student_contact='$new_contact', student_number='$new_number', email='$new_email',password='$new_password'  WHERE id='$new_id'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
            window.location.href = 'Admin_dashboard.php';
            alert('Records are successfully updated ');
        </script>";
    } else {
        echo "Error in updating records: " . $conn->error;
    }
    
}

// Handle deletion of the records 
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $new_id = $conn->real_escape_string($_POST['id']);
    $new_name = $conn->real_escape_string($_POST['student_name']);
    $new_contact = $conn->real_escape_string($_POST['student_contact']);
    $new_number = $conn->real_escape_string($_POST['student_number']);
    $new_email = $conn->real_escape_string($_POST['email']);
    $new_password = $conn->real_escape_string($_POST['password']);
    $sql = "DELETE FROM  students WHERE id='$new_id'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
            window.location.href = 'Admin_dashboard.php';
            alert('Record deleted successfully!');
        </script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="edit_coordinator.css">
    <title>change students</title>
</head>
<body>
    <div class="container">
        <h2>Edit information</h2>
        <form method="POST">
        <label for="id">id:</label>
            <input type="text" id="id" name="id" value="<?php echo htmlspecialchars($row['id']); ?>" readonly><br>

            <label for="student_name">student_name:</label>
            <input type="text" id=" student_name" name=" student_name" value="<?php echo htmlspecialchars($row['username']); ?>"><br>

            <label for="student_name">student_number:</label>
            <input type="text" id=" student_number" name="student_number" value="<?php echo htmlspecialchars($row['student_number']); ?>"><br>


            <label for="student_Contact"> student_contact:</label>
            <input type="text" id="student_contact" name="student_contact" value="<?php echo htmlspecialchars($row['student_contact']); ?>"><br>

            <label for=" student_email"> student_email:</label>
            <input type="text" id="student_email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>"><br>

            <label for=" student_password"> student_password:</label>
            <input type="text" id="student_password" name="password" value="<?php echo htmlspecialchars($row['password']); ?>"><br>

            
            <button type="submit" name="update" onclick="return confirm('Are you sure you want to update this record?');">Update</button>
            <button type="submit" name="delete" onclick="return confirm('Are you sure you want to delete this record?');">Delete</button>
            <button type="button" name = "button" onclick="window.location.href='Admin_dashboard.php'">Back</button>
            
             
        </form>
    </div>
</body>
</html>
.
<style>
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

.container {
    background: #fff;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 5px;
    width: 400px;
    max-width: 100%;
}

h2 {
    text-align: center;
    color: #333;
}

form {
    display: flex;
    flex-direction: column;
}

label {
    margin: 10px 0 5px;
    color: #555;
}

input[type="text"]
  {
    padding: 5px;
    margin-bottom: 10px;
    border: 1px solid #ddd;
    border-radius: 3px;
    width: 100%;
    box-sizing: border-box;
}

button {
    padding: 10px;
    margin-top: 10px;
    border: none;
    border-radius: 3px;
    cursor: pointer;
    color: #fff;
    
}

button[type="submit"] {
    background: #5cb85c;
}

button[name="delete"] {
    background: #d9534f;
}
button[name="button"] {
    background: #000000;
}

button:hover {
    opacity: 0.9;
}
</style>