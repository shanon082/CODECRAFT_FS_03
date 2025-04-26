<?php
session_start();
include("db.php");

// Ensure the user is logged in and has the correct role
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'coordinator') {
    header('Location: index.php'); // Redirect to login if the user is not logged in or not a coordinator
    exit;
}

$coordinator_id = $_SESSION['user_id']; // Use the user_id set in the session
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" 
            integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
            <script src="https://kit.fontawesome.com/7a97402827.js"crossorigin="anonymous"></script>
    <link rel="stylesheet" href="coordinator.css ">
    <script src="script.js"></script>
    <title>Coordinator uploads</title>
</head>

<body>
    <?php include("headerCoordinator.php"); ?>

    <div class="slap">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></h2>

        <h3>Downloads </h3>
        
        <button><a href="view_files.php">Downloads from students</a></button>
        <button><a href="Uploads_by_coordinator.php">Upload files</a></button>
        <button><a href="sup_up_to_coord.php">Downloads from supervisors</a></button>
       
      <h3>Forms </h3>
      
      <button><a href="consent_form.php"> Guide Consent Form</a></button>
        <button><a href=" attendance_form.php">Attendance Form</a></button>
</body>

</html>
