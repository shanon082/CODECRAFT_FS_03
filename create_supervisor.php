
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
     <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
    display: flex;
    min-height:100vh;
    justify-content: center;
    align-items: center;
    
}
.container {
    background: #fff;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 5px;
    width: 400px;
    max-width: 100%;
}
        button {
    padding: 12px;
    margin-top: 10px;
    border: none;
    border-radius: 3px;
    cursor: pointer;
    background-color: darkgreen;
    width: 40%;
    
    
}
input[type="submit"] {
    width: 40%;
    background-color :green;
    padding: 10px ;
    border-radius: 3px;
    padding: 11px;
}
button:hover {
    opacity: 0.9;
}

input[type="text"]
  {
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ddd;
    border-radius: 3px;
    width: 100%;
    box-sizing: border-box;
}
     </style>
    
</head>
<body>
    <div class="container">
        <h2>Welcome, Administrator</h2>

        <h3>Add Supervisor</h3>
        <form action="Add_supervisor.php" method="POST">
            <input type="text" name="supervisor_name" placeholder="Supervisor Name" required>
            <input type="text" name="supervisor_contact" placeholder="Supervisor Contact" required>
            <input type="text" name="email" placeholder="Supervisor email" required>
            <input type="text" name="specialization" placeholder="Supervisor field" required>
            <input type="text" name="password" placeholder="Supervisor Password" required>

            <input type="submit" name="supervisor" value="Add Supervisor">
            <button type="button" onclick="window.location.href='Admin_Supervisor_dashboard.php'">Back</button>
        </form> 