<?php

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
<?php include "supervisor_header.php"?>;
    <div class="contain">
        <h3>Messages from students</h3>
        <?php
        $result = $conn->query("SELECT * FROM messages WHERE receiver_id = $supervisor_id ORDER BY sent_at DESC");

        if ($result->num_rows > 0) {
            while ($msg = $result->fetch_assoc()) {
                // Get the sender's name (student)
                $sender_id = $msg['sender_id'];
                $sender_query = $conn->query("SELECT student_name FROM engineers WHERE student_id = $sender_id");
                $sender = $sender_query->fetch_assoc();
                echo "<div class='message'><strong>" . htmlspecialchars($sender['student_name']) . ":</strong> " . 
                         htmlspecialchars($msg['message']) . 
                         "<span class='timestamp'> Sent at: " . htmlspecialchars($msg['sent_at']) . "</span></div>";
            }
        } else {
            echo "No messages available.";
        }
        ?>
        <h3>Send Message to Students</h3>
        <form method="POST" action="chat_processing.php" class="chat-form">
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
<style>
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
