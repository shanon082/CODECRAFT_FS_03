<?php
$conn = new mysqli("localhost", "root", "", "school_database");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = $conn->real_escape_string($_GET['id']);
 
    
    $sql = "SELECT    id, supervisor_name, supervisor_contact, student_name, student_contact, student_number FROM engineers WHERE id = '$id'";
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
    
    $new_supervisor_name = $conn->real_escape_string($_POST['supervisor_name']);
    $new_student_name = $conn->real_escape_string($_POST['student_name']);
     

    $sql = "UPDATE  engineers SET   supervisor_name='$new_supervisor_name', supervisor_contact='$new_contact1', student_name='$new_student_name' WHERE id='$new_id'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
            window.location.href = 'coordinator.php';
            alert('Records are successfully updated ');
        </script>";
    } else {
        echo "Error in updating records: " . $conn->error;
    }
    
}

// Handle deletion of the records 
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $new_id = $conn->real_escape_string($_POST['id']);
    $new_supervisor_name = $conn->real_escape_string($_POST['supervisor_name']);
    $new_contact1 = $conn->real_escape_string($_POST['supervisor_contact']);
    $new_student_name = $conn->real_escape_string($_POST['student_name']);
    $new_contact2 = $conn->real_escape_string($_POST['student_contact']);
    $new_number = $conn->real_escape_string($_POST['student_number']);
    $sql = "DELETE FROM engineers WHERE id='$new_id'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
            window.location.href = 'coordinator.php';
            alert('Record deleted successfully!');
        </script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$conn->close();
?>


    </div>
</body>
</html>

 
 