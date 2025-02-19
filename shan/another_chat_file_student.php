<?php
include("db.php");
include "students_header.php";
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
        // Query to retrieve messages directed to the student or broadcast to all students
        $result = $conn->query("SELECT * FROM messages WHERE (receiver_id = $student_id OR audience = 'all') ORDER BY sent_at DESC");

        if ($result->num_rows > 0) {
            while ($msg = $result->fetch_assoc()) {
                // Get the sender's name (supervisor)
                $sender_id = $msg['sender_id'];
                $sender_query = $conn->query("SELECT supervisor_name FROM engineers WHERE supervisor_id = $sender_id");
                $sender = $sender_query->fetch_assoc();
                echo "<p><strong>" . htmlspecialchars($sender['supervisor_name']) . ":</strong> " . htmlspecialchars($msg['message']) . " - Sent at: " . htmlspecialchars($msg['sent_at']) . "</p>";
            }
        } else {
            echo "No messages available.";
        }
        ?>
        <h2>Send Message to Supervisor</h2>
        <form method="POST" action="chat_processing_student.php">
            <label for="message">Message:</label>
            <textarea name="message" id="message" required></textarea>

            <label for="audience">Send To:</label>
            <select name="audience" id="audience">
                <option value="all">Assigned Supervisor</option>
                <?php while ($supervisor = $supervisors_result->fetch_assoc()): ?>
                    <option value="<?php echo $supervisor['supervisor_id']; ?>"><?php echo htmlspecialchars($supervisor['supervisor_name']); ?></option>
                <?php endwhile; ?>
            </select>

            <button type="submit">Send</button>
        </form>
    </div>
</body>

</html>
