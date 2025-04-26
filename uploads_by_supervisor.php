<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload File</title>
</head>
<body>
   
    <form action="upload_file_by_supervisor.php" method="POST" enctype="multipart/form-data">
    <h2>Upload and Submit File</h2>
        <label for="recipient_type">Recipient Type:</label>
        <select name="recipient_type" id="recipient_type" required>
            <option value="student">student</option>
            <option value="coordinator">coordinator</option>
            <option value="both">Both</option>
        </select>
        <br><br>

        <label for="recipient_id">Select Recipient:</label>
        <select name="recipient_id" id="recipient_id" required>
            <?php
            include("db.php");

            // Fetch students
            $students = $conn->query("SELECT id, username FROM students");
            $coordinators = $conn->query("SELECT id, username FROM coordinators");

            echo "<optgroup label='Students'>";
            while ($student = $students->fetch_assoc()) {
                echo "<option value='" . $student['id'] . "'>" . htmlspecialchars($student['username']) . "</option>";
            }
            echo "</optgroup>";

            echo "<optgroup label='Coordinators'>";
            while ($coordinator = $coordinators->fetch_assoc()) {
                echo "<option value='" . $coordinator['id'] . "'>" . htmlspecialchars($coordinator['username']) . "</option>";
            }
            echo "</optgroup>";
            ?>
        </select>
        <br><br>

        <label for="file">Choose File:</label>
        <input type="file" name="file" id="file" required>
        <br><br>

        <button type="submit">Upload File</button>
        <button type="button" name = "button" onclick="window.location.href='manage_uploads_by_sup.php'">Back</button>
    </form>
</body>
</html>
<style>

body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.container {
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    width: 400px;
}

h2 {
    text-align: center;
    color: #333;
}

form {
    display: flex;
    flex-direction: column;
    background: white;
    width: 400px;
    border-radius: 10px;


}

label {
    font-weight: bold;
    margin-top: 10px;
}

select, input[type="file"] {
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-top: 5px;
}

button {
    background-color: #0f4d0f;
    color: white;
    border: none;
    padding: 10px;
    border-radius: 5px;
    cursor: pointer;
    margin-top: 15px;
}

button:hover {
    background-color: #0f4d0f;
}

button[type=button] {
    background-color: #000000;
    color: white;
    border: none;
    padding: 10px;
    border-radius: 5px;
    cursor: pointer;
    margin-top: 15px;
}
button[type=button]:hover {
    background-color: #0000000;
}


</style>