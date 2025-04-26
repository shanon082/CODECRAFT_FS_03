

<?php
include("headerCoordinator.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/7a97402827.js"crossorigin="anonymous"></script>
    <title>Create Announcement</title>
    
</head>
<body>
    
    <form method="POST" action="post_announcement_db.php">
    <h1>Create Announcement</h1>
        <label for="title">Title:</label>
        <input type="text" name="title" id="title" required>

        <label for="message">Message:</label>
        <textarea name="message" id="message" required></textarea>

        <label for="audience">Audience:</label>
        <select name="audience" id="audience">
            <option value="supervisors">Supervisors</option>
            <option value="students">Students</option>
            <option value="all">All</option>
        </select>

        <button type="submit">Post Announcement</button>
    </form>
</body>
</html>



  
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color:rgb(214, 221, 235);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        h1 {
            margin-top: 10px;
            margin-bottom: 10px;
            text-align: center;
            color: #333;
            font-size: 28px;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 400px;
            max-width: 100%;
            align-items: center;
        }

        label {
            font-size: 14px;
            margin-bottom: 6px;
            display: block;
            color: #555;
            width: 90%;
            
        }

        input, textarea {
            width: 90%;
            padding: 12px;
            margin-bottom: 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        select {
            width: 96%;
            padding: 12px;
            margin-bottom: 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        textarea {
            height: 150px;
            resize: none;
        }

        button {
            background-color:  #0f4d0f;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 4px;
            width: 96%;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color:  #0f4d0f;
        }

        /* Add responsiveness */
        @media screen and (max-width: 480px) {
            form {
                width: 100%;
                padding: 15px;
            }
        }

        
body{
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    background-color:     #f0f2f5;
}
.slap{
   margin: 10px;
   margin-top: 70px;
   margin-left: 260px;
   
}
.slap h2{
    color: #000000 ;
    padding: 10px;
    margin-bottom: 20px;
    /* background-color: #F5EFEF; */
}
  

.slap h3{
    color: #000000 ;
    padding: 10px;
    margin-top: 20px;
    /* background-color: #F5EFEF; */
}
.slap button{
    background-color:     #617961;
     ;
    padding: 8px;
    margin-bottom: 20px;
    margin-top: 10px;
    
   
}
 
.slap button a{
    text-decoration: none;
    color:#F5EFEF;
}
 
 
a {
    color: #007bff;
    text-decoration: none;
    justify-content: space-between;
    margin-right: 0px;
 margin-bottom: 20px;
 font-size: medium;
}

a:hover {
    text-decoration: underline;
}
    </style>
 