 <?php
$conn = new mysqli("localhost", "root", "", "school_database");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    $sql = "SELECT  id, supervisor_name,  supervisor_contact,  student_name, student_number, student_contact FROM  engineers";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlspecialchars($row["id"]) . "</td>
                    <td>" . htmlspecialchars($row["supervisor_name"]) . "</td>
                    <td>" . htmlspecialchars($row["supervisor_contact"]) . "</td>
                    
                    <td>" . htmlspecialchars($row["student_name"]) . "</td>
                     <td>" . htmlspecialchars($row["student_number"]) . "</td>
                    <td>" . htmlspecialchars($row["student_contact"]) . "</td>
                     

                    <td><a href='edit_assignment.php?id=" . htmlspecialchars($row["id"]) . "'>Edit</a></td>
                    <td><a href='delete_assignment.php?id=" . htmlspecialchars($row["id"]) . "'>Delete</a></td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='5'>0 results</td></tr>";
    }

    $conn->close();
}
?>
