<?php
include "supervisor_header.php";
include("db.php");
session_start();
$supervisor_id = $_SESSION['user_id'];
$students = $conn->query("SELECT student_id, student_name FROM engineers WHERE supervisor_id = $supervisor_id;");
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
        <h2>Messages from students</h2>
        <?php
        $result = $conn->query("SELECT * FROM messages WHERE receiver_id = $supervisor_id ORDER BY sent_at DESC");

        if ($result->num_rows > 0) {
            while ($msg = $result->fetch_assoc()) {
                // Get the sender's name (student)
                $sender_id = $msg['sender_id'];
                $sender_query = $conn->query("SELECT student_name FROM engineers WHERE student_id = $sender_id");
                $sender = $sender_query->fetch_assoc();
                echo "<p><strong>" . htmlspecialchars($sender['student_name']) . ":</strong> " . htmlspecialchars($msg['message']) . " - Sent at: " . htmlspecialchars($msg['sent_at']) . "</p>";
            }
        } else {
            echo "No messages available.";
        }
        ?>
        <h2>Send Message to Students</h2>
        <label for="message">Message:</label>
        <textarea name="message" id="message" required></textarea>

        <label for="audience">Send To:</label>
        <select name="audience" id="audience">
            <option value="all">All Assigned Students</option>
            <?php while ($student = $students->fetch_assoc()): ?>
                <option value="<?php echo $student['student_id']; ?>"><?php echo htmlspecialchars($student['student_name']); ?></option>
            <?php endwhile; ?>
        </select>

        <button type="submit">Send</button>
    </form>
    </div>

</body>

</html>
