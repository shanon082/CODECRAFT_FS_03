<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
        $result = $conn->query("SELECT * FROM announcements WHERE audience IN ('supervisors', 'all') ORDER BY created_at DESC");
        ?>
        <div>
            <h2>Announcements</h2>
            <ul>
                <?php while ($announcement = $result->fetch_assoc()): ?>
                    <li>
                        <h3><?php echo htmlspecialchars($announcement['title']); ?></h3>
                        <p><?php echo htmlspecialchars($announcement['message']); ?></p>
                        <small>Posted on: <?php echo htmlspecialchars($announcement['created_at']); ?></small>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>
</body>
</html>