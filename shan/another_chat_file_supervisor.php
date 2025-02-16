<?php
include "supervisor_header.php";
include("db.php");
session_start();
$supervisor_id = $_SESSION['user_id'];
$students = $conn->query("SELECT id, student_name FROM engineers WHERE supervisor_id = $supervisor_id;");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat with Students</title>
    <style>
        .contain {
            margin-top: 80px;
            margin-left: 320px;
        }
    </style>
</head>

<body>
    <div class="contain">
        <h2>Student Messages</h2>
        <?php

        $supervisor_id = $_SESSION['user_id'];

        $result = $conn->query("SELECT * FROM messages WHERE sender_id IN (SELECT id FROM engineers WHERE supervisor_id = $supervisor_id) ORDER BY sent_at DESC");
        ?>
        <ul>
            <?php while ($msg = $result->fetch_assoc()): ?>
                <li>
                    <p><?php echo htmlspecialchars($msg['message']); ?></p>
                    <small>Sent at: <?php echo htmlspecialchars($msg['sent_at']); ?></small>
                </li>
            <?php endwhile; ?>
        </ul>
        <h2>Send Message to Students</h2>
        <form method="POST" action="chat_processing.php">
            <label for="message">Message:</label>
            <textarea name="message" id="message" required></textarea>

            <label for="audience">Send To:</label>
            <select name="audience" id="audience">
                <option value="all">All Assigned Students</option>
                <?php while ($student = $students->fetch_assoc()): ?>
                    <option value="<?php echo $student['id']; ?>"><?php echo htmlspecialchars($student['student_name']); ?></option>
                <?php endwhile; ?>
            </select>

            <button type="submit">Send</button>
        </form>
    </div>

</body>

</html>