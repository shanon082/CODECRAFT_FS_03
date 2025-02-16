<?php
include("db.php");
session_start();

$student_id = $_SESSION['user_id']; 

$result = $conn->query("SELECT * FROM messages WHERE receiver_id = $student_id OR audience = 'all' ORDER BY sent_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Messages</title>
</head>
<body>
    <h2>Messages</h2>
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
