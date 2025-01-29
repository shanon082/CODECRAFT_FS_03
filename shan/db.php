<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "school_database";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

function getConnection() {
    $server = "localhost";
    $username = "root";  // Your DB username
    $password = "";      // Your DB password
    $dbname = "school_database";  // Your database name

    // Create connection
    $conn = new mysqli($server, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

?>
