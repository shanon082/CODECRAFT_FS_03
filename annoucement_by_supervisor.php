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
    <script src="https://kit.fontawesome.com/7a97402827.js"crossorigin="anonymous"></script>
    <link rel="stylesheet" href="coordinator.css">
    <title>announcement Dashboard</title>
</head>

<body>
    <?php include("supervisor_header.php"); ?>

    <div class="slap">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></h2>
         
       



        <!-- Announcements Section -->
        <?php
        $result = $conn->query("SELECT * FROM announcements WHERE audience IN ('supervisors', 'all') ORDER BY created_at DESC");
        ?>
        <div>
            <h2>Announcements</h2>
            <ul>
                <?php while ($announcement = $result->fetch_assoc()): ?>
                    <li>
                        <h3><?php echo htmlspecialchars($announcement['title']); ?></h3>
                        <p><?php echo htmlspecialchars($announcement['message']); ?></p>
                        <small>Posted on: <?php echo htmlspecialchars($announcement['created_at']); ?></small>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>

         
     
        
    </div>
</body>

</html>