<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload File</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="form-container">
        <h2>Upload and Submit File</h2>
        <form action="upload_file_by_coordinator.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="recipient_type">Recipient Type:</label>
                <select name="recipient_type" id="recipient_type" required>
                    <option value="student">Student</option>
                    <option value="supervisor">Supervisor</option>
                    <option value="both">Both</option>
                </select>
            </div>

            <div class="form-group">
                <label for="recipient_id">Select Recipient:</label>
                <select name="recipient_id" id="recipient_id" required>
                    <!-- This will be populated dynamically -->
                    <?php
                    include("db.php");
                    // Fetch recipients based on type
                    $students = $conn->query("SELECT id, username FROM students");
                    $supervisors = $conn->query("SELECT id, username FROM supervisors");

                    echo "<optgroup label='Students'>";
                    while ($student = $students->fetch_assoc()) {
                        echo "<option value='student_" . $student['id'] . "'>" . htmlspecialchars($student['username']) . "</option>";
                    }
                    echo "</optgroup>";

                    echo "<optgroup label='Supervisors'>";
                    while ($supervisor = $supervisors->fetch_assoc()) {
                        echo "<option value='supervisor_" . $supervisor['id'] . "'>" . htmlspecialchars($supervisor['username']) . "</option>";
                    }
                    echo "</optgroup>";
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="file">Choose File:</label>
                <input type="file" name="file" id="file" required>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit">Upload File</button>
                <button type="button" class="btn-back" onclick="window.location.href='coordinator_uploads.php'">Back</button>
            </div>
        </form>
    </div>
</body>
</html>

<style>

/* General reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Body and container styling */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f7f8fa;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    padding: 20px;
}

.form-container {
    background-color: #ffffff;
    padding: 40px;
    border-radius: 10px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 600px;
}

h2 {
    text-align: center;
    color: #2c3e50;
    margin-bottom: 20px;
    font-size: 28px;
}

/* Form Styling */
form {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.form-group {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}

label {
    font-weight: bold;
    font-size: 16px;
    color: #34495e;
    margin-bottom: 8px;
}

select, input[type="file"] {
    padding: 12px;
    width: 100%;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 16px;
    color: #34495e;
    background-color: #fafafa;
}

select:focus, input[type="file"]:focus {
    border-color: #3498db;
    outline: none;
}

.form-actions {
    display: flex;
    justify-content: space-between;
    gap: 10px;
}

button {
    padding: 12px 20px;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    cursor: pointer;
    width: 48%;
    transition: background-color 0.3s ease;
}

.btn-submit {
    background-color:  #0f4d0f;
    color: white;
}

.btn-submit:hover {
    background-color:  #0f4d0f;
}

.btn-back {
    background-color:  #000000;
    color: white;
}

.btn-back:hover {
    background-color:  #000000;
}

/* Responsiveness */
@media (max-width: 768px) {
    .form-container {
        padding: 30px;
        width: 85%;
    }

    h2 {
        font-size: 24px;
    }

    label {
        font-size: 14px;
    }

    select, input[type="file"], button {
        font-size: 14px;
    }

    .form-actions {
        flex-direction: column;
    }

    .form-actions button {
        width: 100%;
        margin-bottom: 10px;
    }
}


</style>
