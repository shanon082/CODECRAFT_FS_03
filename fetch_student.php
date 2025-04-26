<?php
$conn = new mysqli("localhost", "root", "", "school_database");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {

    $sql = "SELECT  id, username, student_number, student_contact,email, password, role, created_at  FROM  students";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlspecialchars($row["id"]) . "</td>
                     
                    <td>" . htmlspecialchars($row["username"]) . "</td>
                     <td>" . htmlspecialchars($row["student_number"]) . "</td>
                    <td>" . htmlspecialchars($row["student_contact"]) . "</td>
                      <td>" . htmlspecialchars($row["email"]) . "</td>
                      <td>" . htmlspecialchars($row["password"]) . "</td>
                      <td>" . htmlspecialchars($row["role"]) . "</td>
                      <td>" . htmlspecialchars($row["created_at"]) . "</td>
                  <td><a href='edit_student.php?id=" . htmlspecialchars($row["id"]) . "'>Edit</a></td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='5'>0 results</td></tr>";
    }

    -$conn->close();
}
