<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign supervisor</title>
</head>
<?php
include("db.php")
?>

<body>
    <div class="container">
        

        <h2>Assign supervisor</h2>
        <form method="POST" action="assign_supervisor.php">
            <label for="student_id">Select Student:</label>
            <select name="student_id" id="student_id">
                <?php
                $students = $conn->query("SELECT id, username FROM students");
                while ($student = $students->fetch_assoc()) {
                    echo "<option value='" . $student['id'] . "'>" . htmlspecialchars($student['username']) . "</option>";
                }
                ?>
            </select>

            <label for="supervisor_id">Select Supervisor:</label>
            <select name="supervisor_id" id="supervisor_id">
                <!-- Populate with supervisors from the database -->
                <?php
                $supervisors = $conn->query("SELECT id, username FROM supervisors");
                while ($supervisor = $supervisors->fetch_assoc()) {
                    echo "<option value='" . $supervisor['id'] . "'>" . htmlspecialchars($supervisor['username']) . "</option>";
                }
                ?>
            </select>

            <button type="submit">Assign Supervisor</button>
            <button type="button" onclick="window.location.href='Coordinator_dashboard.php'">Back</button>
        </form>
    </div>
</body>

</html>


    <style>
        body {
            font-family: Arial, sans-serif;
            background-color:  #f4f7fc ;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 350px;
            text-align: center;
        }
        h2 {
            color: #333;
        }
        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }
        select, button {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button[type=submit] {
            background:  #0f4d0f;
            color: white;
            font-size: 16px;
            border: none;
            cursor: pointer;
            transition: 0.3s;
        }
       
        button[type=button] {
            background-color:  #000000;
            color: white;
            font-size: 16px;
            border: none;
            cursor: pointer;
            transition: 0.3s;
        }
    
        .button[type=button]:hover {
            background: #000000;
        }
    </style>
 