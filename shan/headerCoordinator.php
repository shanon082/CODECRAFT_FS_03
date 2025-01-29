<?php
session_start();
//if (!isset($_SESSION['username'])) {
    //header('Location: index.php');
    //exit();
//}
?>
 <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="headerAdmin.css">


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $(document).ready(function () {
            var path = window.location.pathname.split("/").pop();
            $('.links').each(function () {
                var href = $(this).attr('href');
                if (path === href) {
                    $(this).addClass('active');
                }
            });
        });
    </script>
</head>

<body>
    <header>
    <h2>FINAL YEAR PROJECT MANAGEMENT SYSTEM FOR THE SCHOOL OF ENGINEERING AND TECHNOLOGY (SUN)</h2>
        
    </header>

    <div class="sidebar">
    <nav>
            <ul>
                <ul>
                    <li><a href="" class="links">Student</a></li>
                    <li><a href="" class="links">Coordinators</a></li>
                    <li><a href="post_announcement.php" class="links">Announcements</a></li>
                </ul>
            </ul>
            <a href="logout.php">Logout..</a>
        </nav>
    </div>
</body>

</html>

