<?php
$conn = new mysqli("localhost", "root", "", "school_database");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = $conn->real_escape_string($_GET['id']);
 
    
    $sql = "SELECT  id, supervisor_username, supervisor_contact, email, specialization, password FROM supervisors WHERE id = '$id'";
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
    $new_name = $conn->real_escape_string($_POST['supervisor_name']);
    $new_contact = $conn->real_escape_string($_POST['supervisor_contact']);
    $new_email = $conn->real_escape_string($_POST['email']);
    $new_spec = $conn->real_escape_string($_POST['specialization']);
    $new_pass = $conn->real_escape_string($_POST['password']);
    

    $sql = "UPDATE supervisors  SET  id=' $new_id', supervisor_username='$new_name', supervisor_contact='$new_contact', email='$new_email', specialization='$new_spec', password='$new_pass'  WHERE id='$new_id'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
            window.location.href = 'Admin_Supervisor_dashboard.php';
            alert('Records are successfully updated ');
        </script>";
    } else {
        echo "Error in updating records: " . $conn->error;
    }
    
}

// Handle deletion of the records 
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $new_id = $conn->real_escape_string($_POST['id']);
    $new_name = $conn->real_escape_string($_POST['supervisor_name']);
    $new_contact = $conn->real_escape_string($_POST['supervisor_contact']);
    $new_email = $conn->real_escape_string($_POST['email']);
    $new_spec = $conn->real_escape_string($_POST['specialization']);
    $new_pass = $conn->real_escape_string($_POST['password']);
    
    $sql = "DELETE FROM  supervisors WHERE id='$new_id'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
            window.location.href = 'Admin_Supervisor_dashboard.php';
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
    <title>change supervisor</title>
</head>
<body>
    <div class="container">
        <h2>Make changes</h2>
        <form method="POST">
        <label for="id">id:</label>
            <input type="text" id="id" name="id" value="<?php echo htmlspecialchars($row['id']); ?>" readonly><br>

            <label for="supervisor_name">supervisor_name:</label>
            <input type="text" id=" supervisor_name" name=" supervisor_name" value="<?php echo htmlspecialchars($row['supervisor_username']); ?>"><br>

            <label for="supervisor_Contact"> supervisor_contact:</label>
            <input type="text" id="supervisor_contact" name="supervisor_contact" value="<?php echo htmlspecialchars($row['supervisor_contact']); ?>"><br>

            <label for="supervisor_email">supervisor_email:</label>
            <input type="text" id=" supervisor_email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>"><br>

            <label for=" specialization"> Field:</label>
            <input type="text" id="specialization" name="specialization" value="<?php echo htmlspecialchars($row['specialization']); ?>"><br>

            <label for="supervisor_password">supervisor_password:</label>
            <input type="text" id=" supervisor_password" name=" password" value="<?php echo htmlspecialchars($row['password']); ?>"><br>

            
            <button type="submit" name="update" onclick="return confirm('Are you sure you want to update this record?');">Update</button>
            <button type="submit" name="delete" onclick="return confirm('Are you sure you want to delete this record?');">Delete</button>
            <button type="button" name = "button" onclick="window.location.href='Admin_Supervisor_dashboard.php'">Back</button>
            
             
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
    margin: 5px 0 5px;
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

