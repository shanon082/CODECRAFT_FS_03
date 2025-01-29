<?php
session_start();
require 'db.php';
include 'students_header.php';

if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$user_role = $_SESSION['role']; // admin, student, supervisor, or coordinator

// Connect to the database
$conn = getConnection();

// Fetch all users across roles (exclude the current user)
$query = "
    SELECT id, username, 'admin' AS role FROM admins WHERE id != ?
    UNION
    SELECT id, username, 'student' AS role FROM students WHERE id != ?
    UNION
    SELECT id, username, 'supervisor' AS role FROM supervisors WHERE id != ?
    UNION
    SELECT id, username, 'coordinator' AS role FROM coordinators WHERE id != ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("iiii", $user_id, $user_id, $user_id, $user_id);
$stmt->execute();
$users = $stmt->get_result();

// Fetch messages between the two users
$receiver_id = $_GET['receiver_id'] ?? null;
$receiver_role = $_GET['role'] ?? null;
$messages = null;

if ($receiver_id && $receiver_role) {
    // Fetch messages
    $stmt = $conn->prepare("
        SELECT m.*, 
               (SELECT username FROM {$receiver_role}s WHERE id = m.sender_id) AS sender_username,
               (SELECT username FROM {$receiver_role}s WHERE id = m.receiver_id) AS receiver_username
        FROM messages m
        WHERE (sender_id = ? AND receiver_id = ?) 
           OR (sender_id = ? AND receiver_id = ?)
        ORDER BY timestamp ASC
    ");
    $stmt->bind_param("iiii", $user_id, $receiver_id, $receiver_id, $user_id);
    $stmt->execute();
    $messages = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Chat</title>
    <style>
        .container {
            margin-left: 300px;
            margin-top: 60px;
        }

        #chat-box {
            width: 100%;
            height: 300px;
            overflow-y: scroll;
            border: 1px solid #ccc;
            margin-bottom: 10px;
            padding: 10px;
            background-color: #f9f9f9;
        }

        #message-form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        #message-form textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            height: 100px;
            resize: none;
        }

        #message-form button {
            padding: 10px;
            width: 100px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        #message-form button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Select a user to chat with:</h2>
        <form method="GET" action="chat.php">
            <select name="receiver_id" required>
                <option value="">Select a user</option>
                <?php while ($user = $users->fetch_assoc()): ?>
                    <option value="<?php echo $user['id']; ?>" 
                        <?php echo ($user['id'] == $receiver_id) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($user['username'] . " (" . $user['role'] . ")"); ?>
                    </option>
                <?php endwhile; ?>
            </select>
            <input type="hidden" name="role" value="<?php echo htmlspecialchars($user_role); ?>">
            <button type="submit">Chat</button>
        </form>

        <?php if ($receiver_id && $receiver_role): ?>
            <h3>Chat with <?php echo htmlspecialchars($receiver_role); ?>: <?php echo htmlspecialchars($receiver_id); ?></h3>

            <div id="chat-box">
                <?php if ($messages && $messages->num_rows > 0): ?>
                    <?php while ($msg = $messages->fetch_assoc()): ?>
                        <p>
                            <strong>
                                <?php echo $msg['sender_id'] == $user_id ? 'You' : htmlspecialchars($msg['sender_username']); ?>:
                            </strong>
                            <?php echo htmlspecialchars($msg['message']); ?>
                            <em>(<?php echo $msg['timestamp']; ?>)</em>
                        </p>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No messages yet.</p>
                <?php endif; ?>
            </div>

            <div id="typing-indicator"></div>

            <form id="message-form" method="POST" action="send_message.php">
                <textarea name="message" placeholder="Type your message..." required></textarea>
                <button type="submit">Send</button>
                <input type="hidden" name="receiver_id" value="<?php echo htmlspecialchars($receiver_id); ?>">
                <input type="hidden" name="receiver_role" value="<?php echo htmlspecialchars($receiver_role); ?>">
            </form>

            <script>
                const chatBox = document.getElementById("chat-box");

                chatBox.scrollTop = chatBox.scrollHeight;
            </script>
        <?php else: ?>
            <p>Please select a user to chat with.</p>
        <?php endif; ?>
    </div>
</body>

</html>
