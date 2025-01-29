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
elseif (isset($_POST['coordinator'])) {
    $name = $_POST['coordinator_name'];
    $contact = $_POST['coordinator_contact'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $sql = "INSERT INTO coordinators (username, coordinator_contact,email,password) VALUES ('$name', '$contact', '$email', '$pass')";
        
if (mysqli_query($conn, $sql)) {
    echo "<script>
        alert('You have assigned a supervisor to a student');
        window.location.href = 'Admin_Coordinator_dashboard.php';
    </script>";
}  else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

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
}  else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    $conn->close();
}


?>
