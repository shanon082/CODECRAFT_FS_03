<?php
include("db.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete the assignment
    $delete_query = "DELETE FROM engineers WHERE id = $id";
    if ($conn->query($delete_query) === TRUE) {
        header("Location: Coordinator_dashboard.php");
        exit;
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
?>
