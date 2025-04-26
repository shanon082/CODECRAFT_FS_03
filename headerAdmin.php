
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZ CliNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #e6f0fa 0%, #f7f9fc 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x:hidden;
        }

        header {
            background: linear-gradient(45deg, #00aaff, #007bff);
            padding: 15px 40px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            position: sticky;
            top: 0;
            z-index: 1000;
            animation: slideInDown 0.6s ease-out;
        }

        header h2 {
            font-size: 1.8rem;
            font-weight: 700;
            color: #ffffff;
            text-align: start;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            line-height: 1.4;
        }

        .sidebar {
            width: 250px;
            background: #ffffff;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            padding-top: 100px;
            box-shadow: 2px 0 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            z-index: 999;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .sidebar nav {
            padding: 20px;
            flex-grow: 1;
        }

        .sidebar ul {
            list-style: none;
        }

        .sidebar ul li {
            margin-bottom: 15px;
        }

        .sidebar ul li a.links {
            display: block;
            padding: 12px 20px;
            font-size: 1.1rem;
            font-weight: 500;
            color: #333;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
            animation: fadeInUp 0.5s ease-out;
            animation-delay: calc(0.1s * var(--i));
        }

        .sidebar ul li:nth-child(1) a { --i: 1; }
        .sidebar ul li:nth-child(2) a { --i: 2; }
        .sidebar ul li:nth-child(3) a { --i: 3; }

        .sidebar ul  ul li a.links:hover {
            background: #00aaff;
            color: #fff;
            transform: translateX(10px);
            box-shadow: 0 4px 10px rgba(0, 170, 255, 0.3);
        }

        .sidebar ul li a.links.active {
            background: linear-gradient(45deg, #00aaff, #007bff);
            color: #fff;
            font-weight: 600;
            box-shadow: 0 4px 10px rgba(0, 170, 255, 0.4);
        }

        .sidebar a[href="admin_logout.php"] {
            display: block;
            padding: 12px 20px;
            font-size: 1rem;
            font-weight: 500;
            color: #d32f2f;
            text-decoration: none;
            border-radius: 8px;
            margin: 20px;
            text-align: center;
            background: rgba(211, 47, 47, 0.1);
            transition: all 0.3s ease;
            animation: fadeInUp 0.5s ease-out 0.4s;
        }

        .sidebar a[href="admin_logout.php"]:hover {
            background: #d32f2f;
            color: #fff;
            transform: translateY(-3px);
            box-shadow: 0 4px 10px rgba(211, 47, 47, 0.4);
        }

        /* Animations */
        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            header {
                padding: 15px 20px;
            }

            header h2 {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 480px) {
            .sidebar {
                width: 180px;
                padding-top: 80px;
            }

            .sidebar ul li a.links {
                font-size: 1rem;
                padding: 10px 15px;
            }

            .sidebar a[href="admin_logout.php"] {
                font-size: 0.95rem;
                padding: 10px 15px;
            }

            header h2 {
                font-size: 1.3rem;
            }
        }
    </style>
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
        <img src="./image/log1.jpg" alt="logo" style="width: 50px; height: 50px; border-radius: 50%; margin-right: 20px; float: left;">
        <h2>Final Year Project Management System</h2>
    </header>
    <div class="sidebar">
        <nav>
            <ul>
                <li><a href="Admin_Dash.php" class="links">Dashboard</a></li>
                <li><a href="Admin_dashboard.php" class="links">Student</a></li>
                <li><a href="Admin_Coordinator_dashboard.php" class="links">Coordinators</a></li>
                <li><a href="Admin_Supervisor_dashboard.php" class="links">Supervisors</a></li>
            </ul>
        </nav>
        <a href="admin_logout.php">Logout</a>
    </div>
</body>
</html>