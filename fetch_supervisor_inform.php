<?php
$conn = new mysqli("localhost", "root", "", "school_database");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);}
$sql = "SELECT  id, username, supervisor_contact, email,specialization FROM  supervisors";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlspecialchars($row["id"]) . "</td>
                     
                    <td>" . htmlspecialchars($row["username"]) . "</td>
                    <td>" . htmlspecialchars($row["supervisor_contact"]) . "</td>
                     <td>" . htmlspecialchars($row["email"]) . "</td>
                      <td>" . htmlspecialchars($row["specialization"]) . "</td>
                     
                    
                    
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='5'>0 results</td></tr>";
    }

    $conn->close();
    



?>
