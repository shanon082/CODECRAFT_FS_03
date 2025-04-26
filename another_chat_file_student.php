<?php
include("db.php");
include "students_header.php";
session_start();

// Check if the session variable exists
if (!isset($_SESSION['user_id'])) {
    die("Error: Unauthorized access. Please log in.");
}

$student_id = $_SESSION['user_id'];

// Fetch the assigned supervisor(s)
$supervisors_stmt = $conn->prepare("SELECT supervisor_id, supervisor_name FROM engineers WHERE student_id = ?");
$supervisors_stmt->bind_param("i", $student_id);
$supervisors_stmt->execute();
$supervisors_result = $supervisors_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/7a97402827.js"crossorigin="anonymous"></script>
    <title>Chat with Supervisors</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h3>Messages from Supervisor</h3>
        <div class="messages">
            <?php
            // Fetch messages for the logged-in student
            $msg_stmt = $conn->prepare("SELECT * FROM messages WHERE receiver_id = ? OR audience = 'all' ORDER BY sent_at DESC");
            $msg_stmt->bind_param("i", $student_id);
            $msg_stmt->execute();
            $result = $msg_stmt->get_result();

            if ($result->num_rows > 0) {
                while ($msg = $result->fetch_assoc()) {
                    $sender_id = $msg['sender_id'];

                    // Fetch supervisor's name
                    $sender_stmt = $conn->prepare("SELECT supervisor_name FROM engineers WHERE supervisor_id = ?");
                    $sender_stmt->bind_param("i", $sender_id);
                    $sender_stmt->execute();
                    $sender_result = $sender_stmt->get_result();
                    $sender = $sender_result->fetch_assoc();

                    // Handle the case where the supervisor is not found
                    $sender_name = $sender ? htmlspecialchars($sender['supervisor_name']) : "Unknown Sender";

                    echo "<div class='message'><strong>" . $sender_name . ":</strong> " . 
                         htmlspecialchars($msg['message']) . 
                         "<span class='timestamp'> Sent at: " . htmlspecialchars($msg['sent_at']) . "</span></div>";
                }
            } else {
                echo "<p class='no-messages'>No messages available.</p>";
            }
            ?>
        </div>

        <h3>Send Message to Supervisor</h3>
        <form method="POST" action="chat_processing_student.php" class="chat-form">
            <label for="message">Message:</label>
            <textarea name="message" id="message" required></textarea>

            <label for="audience">Send To:</label>
            <select name="audience" id="audience">
                <option value="all">Assigned Supervisor</option>
                <?php while ($supervisor = $supervisors_result->fetch_assoc()): ?>
                    <option value="<?php echo htmlspecialchars($supervisor['supervisor_id']); ?>">
                        <?php echo htmlspecialchars($supervisor['supervisor_name']); ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <button type="submit">Send</button>
        </form>
    </div>
</body>
</html>

<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

.container {
    width: 40%;
     margin-left: 480px;
    background: white;
    padding: 20px;
    border-radius: 20px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}

h2 {
    color: white;
    font-size: 24px;
    display: flex;

}
h3{
    color: #333;
    margin-top: 50px;
    margin-right: 50px;
}

.messages {
    background: #fafafa;
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 20px;
    max-height: 300px;
    overflow-y: auto;
}

.message {
    padding: 10px;
    margin: 10px 0;
    border-bottom: 1px solid #ddd;
}

.timestamp {
    display: block;
    font-size: 12px;
    color: gray;
}

.no-messages {
    text-align: center;
    color: gray;
}

.chat-form {
    display: flex;
    flex-direction: column;
}

.chat-form label {
    margin-top: 10px;
    font-weight: bold;
}

.chat-form textarea {
    width: 100%;
    height: 100px;
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
}

.chat-form select, .chat-form button {
    margin-top: 10px;
    padding: 10px;
    border-radius: 5px;
    border: none;
    cursor: pointer;
}

.chat-form button {
    background: #0f4d0f;
    color: white;
    font-size: 16px;
}

.chat-form button:hover {
    background: #0c3b0c;
}
body{
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    background-color:     #f0f2f5;
}
.slap{
   margin: 10px;
   margin-top: 70px;
   margin-left: 260px;
   
}
.slap h2{
    color: #000000 ;
    padding: 10px;
    margin-bottom: 20px;
    /* background-color: #F5EFEF; */
}
  

.slap h3{
    color: #000000 ;
    padding: 10px;
    margin-top: 20px;
    /* background-color: #F5EFEF; */
}
.slap button{
    background-color:     #617961;
     ;
    padding: 8px;
    margin-bottom: 20px;
    margin-top: 10px;
    
   
}
 
.slap button a{
    text-decoration: none;
    color:#F5EFEF;
}
 
 
a {
    color: #007bff;
    text-decoration: none;
    justify-content: space-between;
    margin-right: 0px;
 margin-bottom: 20px;
 font-size: medium;
}

a:hover {
    text-decoration: underline;
}
</style>
