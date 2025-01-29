<?php
 

// Database connection (Replace with your database details)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "school_database";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
 

 if (isset($_POST['supervisor'])) {
    $name = $_POST['supervisor_name'];
    $contact = $_POST['supervisor_contact'];
    $email = $_POST['email'];
    $spec = $_POST['specialization'];
    $password = $_POST['password'];

    $sql = "INSERT INTO supervisors (username, supervisor_contact,email, specialization, password) VALUES ('$name', '$contact', '$email', '$spec','$password')";
        
if (mysqli_query($conn, $sql)) {
    echo "<script>
        alert('You have added a supervisor');
        window.location.href = 'Admin_Supervisor_dashboard.php';
    </script>";
}  else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    $conn->close();
}
}

?>
