<?php
session_start();
include("db.php");

// Ensure the user is logged in and has the correct role
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'coordinator') {
    header('Location: index.php'); // Redirect to login if the user is not logged in or not a coordinator
    exit;
}

$coordinator_id = $_SESSION['user_id']; // Use the user_id set in the session
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" 
            integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="coordinator.css?v=1.0">
    <script src="script.js"></script>
    <title>Coordinator Dashboard</title>
</head>

<body>
    <?php include("headerCoordinator.php"); ?>

    <div class="slap">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></h2>

        
        <button><a href="Create_Coordinator_by_Cd.php">Assign Supervisor</a></button>
        <button><a href="view_files.php">Download Files</a></button>
        <button><a href="Uploads_by_coordinator.php">Uploads</a></button>

        <h3>Assigned Supervisors and Students</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Supervisor Name</th>
                <th>Supervisor Contact</th>
                <th>Supervisor Email</th>
                <th>Student Name</th>
                <th>Student Number</th>
                <th>Student Contact</th>
                <th>Student Email</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>

            <?php
            // Query to fetch supervisor and student data from the 'engineers' table
            $sql = "SELECT id, supervisor_name, supervisor_contact, supervisor_email, student_name, student_number, student_contact,student_email FROM engineers";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>" . htmlspecialchars($row["id"]) . "</td>
                        <td>" . htmlspecialchars($row["supervisor_name"]) . "</td>
                        <td>" . htmlspecialchars($row["supervisor_contact"]) . "</td>
                        <td>" . htmlspecialchars($row["supervisor_email"]) . "</td>
                        <td>" . htmlspecialchars($row["student_name"]) . "</td>
                        <td>" . htmlspecialchars($row["student_number"]) . "</td>
                        <td>" . htmlspecialchars($row["student_contact"]) . "</td>
                        <td>" . htmlspecialchars($row["student_email"]) . "</td>
                        
                        <td><a href='edit_assignment.php?id=" . htmlspecialchars($row["id"]) . "'>Edit</a></td>
                        <td><a href='delete_assignment.php?id=" . htmlspecialchars($row["id"]) . "'>Delete</a></td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='10'>No assignments found</td></tr>";
            }

            $conn->close();
            ?>
        </table>
    </div>

</body>

</html>
