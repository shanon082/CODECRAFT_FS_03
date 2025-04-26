<?php
session_start();
include("db.php");

// Ensure the user is logged in and has the correct role
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'supervisor') {
    header('Location: index.php'); // Redirect to login if the user is not logged in or not a supervisor
    exit;
}

$supervisor_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supervisor Dashboard</title>
    <link rel="stylesheet" href="coordinator.css ">
   
</head>

<body>
    <?php include("supervisor_header.php"); ?>

    <div class="slap">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></h2>
        <p>Here you can see the details of students assigned to you.</p><br>
        


        <!-- Assigned Students Section -->
        <?php
        $stmt = $conn->prepare("SELECT student_name, student_number, student_email, student_contact 
                        FROM engineers WHERE supervisor_id = ?");
        $stmt->bind_param("i", $supervisor_id);
        $stmt->execute();
        $result = $stmt->get_result();
        ?>
        <div>
            <h2>Assigned Students</h2>
            <?php if ($result->num_rows > 0): ?>
                <ul>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <li>
                            <b>Name:</b> <?php echo htmlspecialchars($row['student_name']); ?><br>
                            <b>Student Number:</b> <?php echo htmlspecialchars($row['student_number']); ?><br>
                            <b>Email:</b> <?php echo htmlspecialchars($row['student_email']); ?><br>
                            <b>Contact:</b> <?php echo htmlspecialchars($row['student_contact']); ?>
                        </li>
                        <hr>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p>No students assigned yet.</p>
            <?php endif; ?>
        </div>


 
</body>

</html>