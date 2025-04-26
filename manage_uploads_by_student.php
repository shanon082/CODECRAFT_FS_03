<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="script.js"></script> <!-- Include script.js -->
    <script src="https://kit.fontawesome.com/7a97402827.js"crossorigin="anonymous"></script>
    <title>Admin</title>
    <link rel="stylesheet" href="coordinator.css ">
    

</head>

<body>
    <?php
    include("students_header.php");
    ?>
    <div class="slap">
       
        <button>
            <a href="upload.php">Files to coordinator</a>
        </button>

        <button>
            <a href="student_uploads.php">Files to supervisor</a>
        </button>
        <button>
            <a href="sup_up_to_student.php">Files from supervisor</a>
        </button>
         
        

</body>

</html>
 
 