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

// Add records to the database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['student'])) {
         
        $name = $_POST['student_name'];
        $student_number = $_POST['student_number'];
        $contact = $_POST['student_contact'];
        $email = $_POST['email'];
        $Upassword = $_POST['password'];

        // Hash the password
        $hashed_password = password_hash($Upassword, PASSWORD_DEFAULT);

        // Use prepared statements to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO students (username, student_number, student_contact, email, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $student_number, $contact, $email, $hashed_password);

        if ($stmt->execute()) {
            echo "<script>
                alert('Student added successfully');
                window.location.href = 'Admin_dashboard.php';
            </script>";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }
      
     
     elseif (isset($_POST['supervisor'])) {
        $name = $_POST['supervisor_name'];
        $contact = $_POST['supervisor_contact'];
        $email = $_POST['supervisor_email'];
        $spec = $_POST['specialization'];

        $sql = "INSERT INTO supervisors (username, supervisor_contact,email, specialization) VALUES ('$name', '$contact', '$email', '$spec')";
            
    if (mysqli_query($conn, $sql)) {
        echo "<script>
            alert('You have assigned a supervisor to a student');
            window.location.href = 'Admin_dashboard.php';
        </script>";
    }  else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

        $conn->close();
    }
}

    
?>