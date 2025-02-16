<?php
include("db.php");
session_start();
$student_id = $_SESSION['user_id']; 
$supervisors_result = $conn->query("SELECT supervisor_id, supervisor_name FROM engineers WHERE student_id = $student_id;");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat with Supervisors</title>
    <style>
        .contain {
            margin-top: 80px;
            margin-left: 320px;
        }
    </style>
</head>
<body>
    <div class="contain">
        <h2>Messages from Supervisor</h2>
        <?php
        // Retrieve the messages for the student
        $result = $conn->query("SELECT * FROM messages WHERE receiver_id = $student_id OR audience = 'all' ORDER BY sent_at DESC");
        ?>
        <ul>
            <?php while ($msg = $result->fetch_assoc()): ?>
                <li>
                    <p><?php echo htmlspecialchars($msg['message']); ?></p>
                    <small>Sent at: <?php echo htmlspecialchars($msg['sent_at']); ?></small>
                </li>
            <?php endwhile; ?>
        </ul>

        <h2>Send Message to Supervisor</h2>
        <form method="POST" action="chat_processing_student.php">
            <label for="message">Message:</label>
            <textarea name="message" id="message" required></textarea>

            <label for="audience">Send To:</label>
            <select name="audience" id="audience">
                <option value="all">All Assigned Supervisors</option>
                <?php while ($supervisor = $supervisors_result->fetch_assoc()): ?>
                    <option value="<?php echo $supervisor['supervisor_id']; ?>"><?php echo htmlspecialchars($supervisor['supervisor_name']); ?></option>
                <?php endwhile; ?>
            </select>

            <button type="submit">Send</button>
        </form>
    </div>
</body>
</html>
