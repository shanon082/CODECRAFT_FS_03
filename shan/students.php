<?php
session_start();
include("db.php");

// Ensure the user is logged in and has the correct role
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header('Location: index.php'); // Redirect to login if the user is not logged in or not a student
    exit;
}

$student_id = $_SESSION['user_id']; // Use the user_id set in the session
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="coordinator.css">
    <title>Student Dashboard</title>
</head>

<body>

    <?php include("students_header.php"); ?>

    <div class="slap">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></h2>
        <button><a href="upload.php">Upload a report or proposal file</a></button>

        <!-- Assigned Supervisor Section -->
        <?php
        $stmt = $conn->prepare("SELECT supervisor_name, supervisor_email, supervisor_contact 
                        FROM engineers WHERE student_id = ?");
        $stmt->bind_param("i", $student_id); // Using session user_id
        $stmt->execute();
        $result = $stmt->get_result();
        ?>
        <div>
            <h2>Assigned Supervisor</h2>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <p><b>Name:</b> <?php echo htmlspecialchars($row['supervisor_name']); ?></p>
                    <p><b>Email:</b> <?php echo htmlspecialchars($row['supervisor_email']); ?></p>
                    <p><b>Contact:</b> <?php echo htmlspecialchars($row['supervisor_contact']); ?></p>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No supervisor assigned yet.</p>
            <?php endif; ?>
        </div>



        <!-- Announcements Section -->
        <?php
        $result = $conn->query("SELECT * FROM announcements WHERE audience IN ('students', 'all') ORDER BY created_at DESC");
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
        $stmt = $conn->prepare("SELECT * FROM uploads WHERE recipient_type IN ('student', 'both') AND recipient_id = ?");
        $stmt->bind_param("i", $student_id);
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
<script>
    $(document).ready(function() {
        // Load header content
        $('.head_content_student').load('students_header.php', function(response, status, xhr) {
            if (status == "error") {
                console.log("Error loading header: " + xhr.status + " " + xhr.statusText);
            }
        });
    });
</script>

</html>