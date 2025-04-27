<?php
$conn = new mysqli("localhost", "root", "", "school_database");

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
} else {

  $sql = "SELECT  id, username, coordinator_contact, email, password, role, created_at  FROM  coordinators";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      echo "<tr>";
      echo " <td>" . htmlspecialchars($row["id"]) . "</td>";
      echo "<td>" . htmlspecialchars($row["username"]) . "</td>";
      echo "<td>" . htmlspecialchars($row["coordinator_contact"]) . "</td>   ";
      echo "  <td>" . htmlspecialchars($row["email"]) . "</td>";
      echo "  <td>" . htmlspecialchars($row["role"]) . "</td>";
      echo "  <td>" . htmlspecialchars($row["created_at"]) . "</td>";
      // echo "<td><a href='edit_coordinators.php?id=" . htmlspecialchars($row["id"]) . "'>Edit</a></td>";
      echo "<td><a href='#' class='action-btn edit-btn' 
            data-id='" . htmlspecialchars($row["id"]) . "' 
            data-name='" . htmlspecialchars($row["username"]) . "'  
            data-contact='" . htmlspecialchars($row["coordinator_contact"]) . "' 
            data-email='" . htmlspecialchars($row["email"]) . "' >Edit</a></td>";
      echo "</tr>";
    }
  } else {
    echo "<tr><td colspan='9'>0 No cordinators found</td></tr>";
  }

  $conn->close();
}
