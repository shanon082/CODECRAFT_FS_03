<?php
include("db.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get selected student and supervisor IDs
    $student_id = $_POST['student_id'];
    $supervisor_id = $_POST['supervisor_id'];

    // Fetch student details
    $student_query = $conn->query("SELECT student_name, student_number, student_contact, email FROM students WHERE id = $student_id");
    $student = $student_query->fetch_assoc();
    $student_name = $student['student_name'];
    $student_number = $student['student_number'];
    $student_contact = $student['student_contact'];
    // $student_email = $student['student_email'];

    // Fetch supervisor details
    $supervisor_query = $conn->query("SELECT supervisor_username, supervisor_contact, email FROM supervisors WHERE id = $supervisor_id");
    $supervisor = $supervisor_query->fetch_assoc();
    $supervisor_username = $supervisor['supervisor_username'];
    $supervisor_contact = $supervisor['supervisor_contact'];
    // $supervisor_email = $supervisor['supervisor_email'];

    // Insert into engineers table
    $insert_query = "INSERT INTO engineers(supervisor_name, supervisor_contact, student_name,  student_number, student_contact)
    VALUES ('$supervisor_username', '$supervisor_contact', '$student_name','$student_number', '$student_contact')";

    // $insert_query = "INSERT INTO engineers(supervisor_name, supervisor_contact,supervisor_email, student_name,  student_number, student_contact, student_email )
    // VALUES ('$supervisor_username', '$supervisor_contact','$supervisor_email', '$student_name','$student_number', '$student_contact', '$student_email')";

    if ($conn->query($insert_query) === TRUE) {
        echo "<script>
        alert('You have assigned a supervisor to a student');
        window.location.href = 'Coordinator_dashboard.php';
    </script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
