<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="script.js"></script> <!-- Include script.js -->
    <title>Details</Details></title>
</head>

<body>
    <?php
       include("headerCoordinator.php"); 
    ?>
    <div class="slap">
        <h2>Supervisors details</h2>
         

        <table>
            <tr>
                <th>id</th>
                <th>Name</th>
                <th>Contact</th>
                <th>email</th>
                <th>Field of specialization</th>
                 
            </tr>


            <?php include 'fetch_supervisor_inform.php'; ?>
        </table>
    </div>

</body>

</html>

<style>
    body {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        background-color: white
    }

    .slap {
        margin: 10px;
        margin-top: 70px;
        margin-left: 260px;
    }

    .slap h2 {
        color: black;
        padding: 10px;
        /* background-color: #F5EFEF; */
    }

    .slap button {
        background-color: rgb(21, 35, 163);
        border: 1px solid gray;
        border-radius: 10px;
        padding: 8px;
        margin-bottom: 20px;
        margin-top: 10px;
    }

    .slap button a {
        text-decoration: none;
        color: #F5EFEF;
    }

    table {
        width: 100%;

    }

    table,
    th,
    td {
        border: 1px solid #000000;
        border-collapse: collapse;
        padding: 2px;

    }

    table tr {
        align-items: center;
        position: relative;
    }

    table tr td {
        background-color: #F5EFEF;
    }

    .copyright {
        float: right;
        margin-top: 100px;
        margin-right: 40px;
        font-weight: 200;
        font-style: italic;
        font-size: 12px;
    }

    .copyright span {
        color: blue;
        cursor: pointer;
    }
</style>