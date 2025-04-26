<?php

$conn = new mysqli("localhost", "root", "", "school_database");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $supervisor_name = $_POST['supervisor_username'];
        $supervisor_contact = $_POST['supervisor_contact'];
        $student_name = $_POST['student_name'];
        $student_contact = $_POST['student_contact'];
        $student_number = $_POST['student_number'];
        
        

        $sql = "INSERT INTO engineers(supervisor_name, supervisor_contact, student_name, student_contact, student_number )
                VALUES ('$supervisor_name', '$supervisor_contact', '$student_name', '$student_contact', '$student_number')";

        
    if (mysqli_query($conn, $sql)) {
        echo "<script>
            alert('You have assigned a supervisor to a student');
            window.location.href = 'Coordinator_dashboard.php';
        </script>";
    }  else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

        $conn->close();
    }
}
?>
