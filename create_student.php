<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Students - Student Management System</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="script.js"></script>
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
        }

        .main-content {
            margin-left: 250px;
            padding: 40px;
            flex-grow: 1;
            min-height: 100vh;
            animation: fadeIn 0.8s ease-out;
        }

        .content-header {
            margin-bottom: 30px;
            padding: 0 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            animation: fadeInUp 0.6s ease-out;
        }

        .content-header h2 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1a1a1a;
        }

        .add-btn {
            display: inline-block;
            padding: 12px 24px;
            background: linear-gradient(45deg, #00aaff, #007bff);
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(0, 170, 255, 0.3);
            cursor: pointer;
        }

        .add-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(0, 170, 255, 0.4);
        }

        .table-container {
            background: #ffffff;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            animation: fadeInUp 0.6s ease-out 0.2s;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            text-align: left;
            font-size: 0.95rem;
            color: #333;
        }

        th {
            background: #f7f9fc;
            font-weight: 600;
            color: #1a1a1a;
            border-bottom: 2px solid #eee;
        }

        td {
            border-bottom: 1px solid #eee;
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

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 2000;
            justify-content: center;
            align-items: center;
            animation: fadeIn 0.3s ease-out;
        }

        .modal-content {
            background: #ffffff;
            border-radius: 12px;
            padding: 30px;
            width: 400px;
            max-width: 90%;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            position: relative;
            animation: slideInUp 0.4s ease-out;
        }

        .modal-content h3 {
            font-size: 1.8rem;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 20px;
            text-align: center;
        }

        .modal-content form {
            display: flex;
            flex-direction: column;
        }

        .modal-content input {
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 0.95rem;
            transition: border-color 0.3s ease;
        }

        .modal-content input:focus {
            border-color: #00aaff;
            box-shadow: 0 0 8px rgba(0, 170, 255, 0.2);
            outline: none;
        }

        .modal-content .btn-group {
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .modal-content input[type="submit"],
        .modal-content button {
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 45%;
        }

        .modal-content input[type="submit"] {
            background: linear-gradient(45deg, #00aaff, #007bff);
            color: #fff;
            box-shadow: 0 4px 10px rgba(0, 170, 255, 0.3);
        }

        .modal-content input[type="submit"]:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0, 170, 255, 0.4);
        }

        .modal-content button {
            background: #d32f2f;
            color: #fff;
            box-shadow: 0 4px 10px rgba(211, 47, 47, 0.3);
        }

        .modal-content button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(211, 47, 47, 0.4);
        }

        .close-btn {
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 1.5rem;
            color: #666;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .close-btn:hover {
            color: #1a1a1a;
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

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
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

            .content-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .content-header h2 {
                font-size: 2rem;
            }

            .modal-content {
                width: 90%;
                padding: 20px;
            }
        }

        @media (max-width: 480px) {
            .content-header h2 {
                font-size: 1.8rem;
            }

            .add-btn {
                padding: 10px 20px;
                font-size: 0.95rem;
            }

            th, td {
                font-size: 0.9rem;
                padding: 10px;
            }

            .modal-content h3 {
                font-size: 1.5rem;
            }

            .modal-content input,
            .modal-content input[type="submit"],
            .modal-content button {
                font-size: 0.9rem;
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <?php include 'headerAdmin.php'; ?>
    <div class="main-content">
        <div class="content-header">
            <h2>Students</h2>
            <button class="add-btn" onclick="openModal()">Add Student</button>
        </div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Student Number</th>
                        <th>Contact</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Role</th>
                        <th>Created At</th>
                        <th>Change</th>
                    </tr>
                </thead>
                <tbody>
                    <?php include 'fetch_student.php'; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal" id="addStudentModal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <h3>Add Student</h3>
            <form action="Add_Student.php" method="POST">
                <input type="text" name="student_name" placeholder="Student Name" required>
                <input type="text" name="student_number" placeholder="Student Number" required>
                <input type="text" name="student_contact" placeholder="Student Contact" required>
                <input type="email" name="email" placeholder="Student Email" required>
                <input type="password" name="password" placeholder="Student Password" required>
                <div class="btn-group">
                    <input type="submit" name="student" value="Add Student">
                    <button type="button" onclick="window.location.href='Admin_dashboard.php'">Back</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('addStudentModal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('addStudentModal').style.display = 'none';
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('addStudentModal');
            if (event.target === modal) {
                closeModal();
            }
        };
    </script>
</body>
</html>