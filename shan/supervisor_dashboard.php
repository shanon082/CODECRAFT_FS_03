<?php
session_start();
include("db.php");

// Ensure the user is logged in and has the correct role
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'supervisor') {
    header('Location: index.php'); // Redirect to login if the user is not logged in or not a supervisor
    exit;
}

$supervisor_id = $_SESSION['user_id']; // Use the user_id set in the session
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="supervisor.css">
    <title>Supervisor Dashboard</title>
</head>

<body>
    <?php include("supervisor_header.php"); ?>

    <div class="main-content">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></h2>
        <p>Here you can manage and review student submissions.</p><br>
        <button><a href="review_uploads.php">Review Student Submissions</a></button>

        <!-- Announcements Section -->
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

        <!-- Uploaded Files Section -->
        <?php
        $stmt = $conn->prepare("SELECT * FROM uploads WHERE recipient_type IN ('supervisor', 'both') AND recipient_id = ?");
        $stmt->bind_param("i", $supervisor_id);
        $stmt->execute();
        $result = $stmt->get_result();
        ?>
        <div>
            <h2>Uploaded Files</h2>
            <table>
                <tr>
                    <th>File Name</th>
                    <th>Uploaded By</th>
                    <th>Uploaded At</th>
                    <th>Download</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['file_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['uploaded_by']); ?></td>
                        <td><?php echo htmlspecialchars($row['uploaded_at']); ?></td>
                        <td><a href="<?php echo htmlspecialchars($row['file_path']); ?>" download>Download</a></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </div>
</body>

</html>
