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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['supervisor'])) {
    $name = $_POST['supervisor_name'];
    $contact = $_POST['supervisor_contact'];
    $email = $_POST['email'];
    $specialization = $_POST['specialization'];
    $password = $_POST['password'];

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO supervisors (username, supervisor_contact, email, specialization, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $contact, $email, $specialization, $hashed_password);

    if ($stmt->execute()) {
        echo "<script>
            alert('Supervisor added successfully');
            window.location.href = 'Admin_Supervisor_dashboard.php';
        </script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
