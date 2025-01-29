<?php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $message = $_POST['message'];
    $audience = $_POST['audience'];

    $stmt = $conn->prepare("INSERT INTO announcements (title, message, audience) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $title, $message, $audience);

    if ($stmt->execute()) {
        echo "Announcement posted successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
