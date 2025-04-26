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

if (isset($_POST['coordinator'])) {
    $name = $_POST['coordinator_name'];
    $contact = $_POST['coordinator_contact'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO coordinators (username, coordinator_contact, email, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $contact, $email, $hashed_password);

    if ($stmt->execute()) {
        echo "<script>
            alert('Coordinator added successfully');
            window.location.href = 'Admin_Coordinator_dashboard.php';
        </script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}

if (isset($_POST['supervisor'])) {
    $name = $_POST['supervisor_name'];
    $contact = $_POST['supervisor_contact'];
    $email = $_POST['email'];
    $spec = $_POST['specialization'];

    $sql = "INSERT INTO supervisors (username, supervisor_contact,email, specialization) VALUES ('$name', '$contact', '$email', '$spec')";
        
    if (mysqli_query($conn, $sql)) {
        echo "<script>
            alert('You have assigned a supervisor to a student');
            window.location.href = 'Admin_Supervisor_dashboard.php';
        </script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    $conn->close();
}

?>
