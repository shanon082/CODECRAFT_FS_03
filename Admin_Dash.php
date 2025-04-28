<?php
session_start();
require_once("db.php");

// Fetch counts for dashboard cards
$student_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM students"))['count'];
$coordinator_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM coordinators"))['count'];
$supervisor_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM supervisors"))['count'];

// Fetch recent activities
$recent_activities_query = "SELECT user, role, action, DATE_FORMAT(date, '%Y-%m-%d %H:%i:%s') as formatted_date, details FROM activities ORDER BY date DESC LIMIT 10";
$recent_activities_result = mysqli_query($conn, $recent_activities_query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="script.js"></script> <!-- Include script.js -->
    <title>Admin Dashboard</title>
</head>
<style>
        body {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        background-color: white;
        background: linear-gradient(135deg, #e6f0fa 0%, #f7f9fc 100%);
    }

        .main-content {
            margin-left: 250px;
            padding: 40px;
            flex-grow: 1;
            animation: fadeIn 0.8s ease-out;
        }

        .dashboard-header {
            margin-bottom: 30px;
        }

        .dashboard-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 10px;
            animation: fadeInUp 0.6s ease-out;
        }

        .dashboard-header p {
            font-size: 1.1rem;
            color: #666;
            animation: fadeInUp 0.6s ease-out 0.2s;
        }

        .card-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .card {
            background: #ffffff;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            animation: fadeInUp 0.6s ease-out;
            animation-delay: calc(0.1s * var(--i));
            text-align: center;
        }

        .card:nth-child(1) { --i: 1; }
        .card:nth-child(2) { --i: 2; }
        .card:nth-child(3) { --i: 3; }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .card h3 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 10px;
        }

        .card .count {
            font-size: 2.5rem;
            font-weight: 700;
            color: #00aaff;
            margin-bottom: 15px;
        }

        .card p {
            font-size: 1rem;
            color: #666;
        }

        .table-container {
            background: #ffffff;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            animation: fadeInUp 0.6s ease-out 0.4s;
        }

        .table-container h3 {
            font-size: 1.8rem;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            text-align: left;
            font-size: 0.95rem;
        }

        th {
            background: #f7f9fc;
            font-weight: 600;
            color: #1a1a1a;
        }

        td {
            border-bottom: 1px solid #eee;
            color: #333;
        }

        tr:hover {
            background: #f0f2f5;
        }

        .action-btn {
            padding: 8px 15px;
            background: #00aaff;
            color: #fff;
            border-radius: 6px;
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .action-btn:hover {
            background: #007bff;
            transform: translateY(-2px);
        }

        /* Animations */
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

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 20px;
            }

            .card-container {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .dashboard-header h1 {
                font-size: 2rem;
            }

            .table-container {
                overflow-x: auto;
            }

            .card .count {
                font-size: 2rem;
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
<body>
    <?php
    include("headerAdmin.php");
    ?>
    <div class="main-content">
        <div class="dashboard-header">
            <h1>Welcome, Admin</h1>
            <p>Overview of system users and recent activities.</p>
        </div>
        <div class="card-container">
            <div class="card">
                <h3>Students</h3>
                <div class="count"><?php echo $student_count; ?></div>
                <p>Total registered students in the system.</p>
            </div>
            <div class="card">
                <h3>Coordinators</h3>
                <div class="count"><?php echo $coordinator_count; ?></div>
                <p>Total coordinators managing projects.</p>
            </div>
            <div class="card">
                <h3>Supervisors</h3>
                <div class="count"><?php echo $supervisor_count; ?></div>
                <p>Total supervisors (lecturers) assigned.</p>
            </div>
        </div>
        <div class="table-container">
            <h3>Recent Activity</h3>
            <table>
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Role</th>
                        <th>Action</th>
                        <th>Date</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($recent_activities_result) > 0): ?>
                        <?php while ($activity = mysqli_fetch_assoc($recent_activities_result)): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($activity['user']); ?></td>
                                <td><?php echo htmlspecialchars($activity['role']); ?></td>
                                <td><?php echo htmlspecialchars($activity['action']); ?></td>
                                <td><?php echo htmlspecialchars($activity['formatted_date']); ?></td>
                                <td><a href="#" class="action-btn" onclick="alert('<?php echo addslashes($activity['details']); ?>')">View</a></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">No recent activity found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>