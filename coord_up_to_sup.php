<?php
session_start();
include("db.php");

// Ensure the user is logged in and has the correct role
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'supervisor') {
    header('Location: index.php'); // Redirect to login if the user is not logged in or not a supervisor
    exit;
}

$supervisor_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="supervisor.css?v=1">
    <title>Supervisor Uploads</title>
</head>

<body>
    <div class="container">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></h2>
        <p>Here you can manage uploaded files by a coordinator.</p>

        <!-- Uploaded Files Section -->
        <?php
        $stmt = $conn->prepare("SELECT * FROM uploads WHERE recipient_type IN ('supervisor', 'both') AND recipient_id = ?");
        $stmt->bind_param("i", $supervisor_id);
        $stmt->execute();
        $result = $stmt->get_result();
        ?>
        <div class="uploads-section">
            <h2>Uploaded Files by Project Coordinator</h2>
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
            <button type="button" onclick="window.location.href='manage_uploads_by_sup.php'">Back</button>
        </div>
    </div>
</body>

</html>


<style>

 /* Import Google Fonts */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

/* General Styling */
body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #f8f9fa, #e3e7eb);
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

/* Main Container */
.container {
    width: 90%;
    max-width: 900px;
    background: white;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
    text-align: center;
}

/* Header Styling */
h1 {
    font-size: 28px;
    color: #333;
    margin-bottom: 10px;
}

.description {
    font-size: 16px;
    color: #666;
    margin-bottom: 20px;
}

/* Table Styling */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table th, table td {
    border: 1px solid #ddd;
    padding: 12px;
    text-align: center;
}

table th {
    background-color:       #0f4d0f;
    color: white;
    font-size: 16px;
}

table tr:nth-child(even) {
    background-color: #f2f2f2;
}

table tr:hover {
    background-color: #e9ecef;
}

/* Download Button */
.download-btn {
    text-decoration: none;
    padding: 8px 15px;
    background-color: #007BFF;
    color: white;
    border-radius: 5px;
    font-size: 14px;
    transition: 0.3s;

   
}

.download-btn:hover {
    background-color: #0056b3;
}

/* Back Button */
button[type=button]{
    background-color: black;
    color: white;
    padding: 12px 20px;
    font-size: 16px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: 0.3s;
    margin-top: 20px;
    position: left;
    width: 100%;
}

.back-btn:hover {
    background-color: #218838;
}

/* Responsive Design */
@media (max-width: 768px) {
    .container {
        width: 95%;
        padding: 20px;
    }

    table th, table td {
        padding: 10px;
        font-size: 14px;
    }

    .back-btn {
        width: 100%;
        padding: 10px;
    }
}


</style>
