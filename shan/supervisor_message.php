<?php
include("db.php");
session_start();

$supervisor_id = $_SESSION['user_id']; 

$result = $conn->query("SELECT * FROM messages WHERE sender_id IN (SELECT id FROM students WHERE supervisor_id = $supervisor_id) ORDER BY sent_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages from Students</title>
</head>
<body>
    <h2>Student Messages</h2>
    <ul>
        <?php while ($msg = $result->fetch_assoc()): ?>
            <li>
                <p><?php echo htmlspecialchars($msg['message']); ?></p>
                <small>Sent at: <?php echo htmlspecialchars($msg['sent_at']); ?></small>
            </li>
        <?php endwhile; ?>
    </ul>
</body>
</html>
