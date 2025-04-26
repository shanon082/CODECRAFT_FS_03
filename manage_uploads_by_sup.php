<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://kit.fontawesome.com/7a97402827.js"crossorigin="anonymous"></script>
    <script src="script.js"></script> <!-- Include script.js -->
    <link rel="stylesheet" href="coordinator.css ">
    <title>Admin</title>
</head>

<body>
    <?php
    include("supervisor_header.php");
    ?>
    <div class="slap">
       
        <button>
            <a href="coord_up_to_sup.php">uploads from coordinator</a>
        </button>

        <button>
            <a href="stud_up_to_sup.php">uploads from students</a>
        </button>
        <button>
            <a href="uploads_by_supervisor.php">upload your file</a>
        </button>
         
        

</body>

</html>
 