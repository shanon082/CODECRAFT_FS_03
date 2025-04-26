<?php
$conn = new mysqli("localhost", "root", "", "school_database");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, username, student_number, student_contact, email, password, role, created_at FROM students";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["username"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["student_number"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["student_contact"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["role"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["created_at"]) . "</td>";
        echo "<td><a href='#' class='action-btn edit-btn' 
            data-id='" . htmlspecialchars($row["id"]) . "' 
            data-name='" . htmlspecialchars($row["username"]) . "' 
            data-number='" . htmlspecialchars($row["student_number"]) . "' 
            data-contact='" . htmlspecialchars($row["student_contact"]) . "' 
            data-email='" . htmlspecialchars($row["email"]) . "' >Edit</a></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='9'>No students found.</td></tr>";
}

$conn->close();
?>