<?php
include("headerCoordinator.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Announcement</title>
    <style>
        form{
            margin-top: 50px;
            margin-left: 300px;
        }
    </style>
</head>
<body>
    <h2>Chat with supervisor</h2>
    <form method="POST" action="chat_processing.php">
        <label for="title">Title:</label>
        <input type="text" name="title" id="title" required>

        <label for="message">Message:</label>
        <textarea name="message" id="message" required></textarea>

        <label for="audience">Audience:</label>
        <select name="audience" id="audience">
            <option value="students">Students</option>
            <option value="all">All</option>
        </select>

        <button type="submit">Send message</button>
    </form>
</body>
</html>
