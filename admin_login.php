<?php
session_start();

// Hardcoded admin credentials
$admin_username = "kasagga";
$admin_password = "ronald";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Check if credentials match
    if ($username === $admin_username && $password === $admin_password) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;
        header("Location: Admin_Dash.php"); // Redirect to admin dashboard
        exit();
    } else { 
        $error = "Invalid username or password";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Student Management System</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        body, html {
            height: 100%;
            background: linear-gradient(135deg, #e6f0fa 0%, #f7f9fc 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .container {
            width: 1000px;
            max-width: 90%;
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.15);
            display: flex;
            overflow: hidden;
            animation: slideIn 0.8s ease-out;
        }

        .image-container {
            flex: 1;
            background: linear-gradient(45deg, #00aaff, #007bff);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        .image-container img {
            width: 100%;
            height: 100%;
            object-fit: fill;
            opacity: 0.9;
            transition: transform 0.5s ease;
        }

        .image-container:hover img {
            transform: scale(1.05);
        }

        .form-container {
            flex: 1;
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: #fafafa;
        }

        .form-container h2 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 30px;
            text-align: center;
            animation: fadeInUp 0.6s ease-out;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        form input {
            padding: 14px 18px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            font-size: 1rem;
            background: #fff;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        form input:focus {
            border-color: #00aaff;
            box-shadow: 0 0 10px rgba(0, 170, 255, 0.3);
            outline: none;
        }

        .password-container {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #666;
            font-size: 0.9rem;
            transition: color 0.3s;
        }

        .toggle-password:hover {
            color: #00aaff;
        }

        button[type="submit"] {
            padding: 15px;
            background: linear-gradient(45deg, #00aaff, #007bff);
            color: #fff;
            font-size: 1.1rem;
            font-weight: 600;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.4s ease;
            box-shadow: 0 5px 15px rgba(0, 170, 255, 0.4);
        }

        button[type="submit"]:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 170, 255, 0.6);
        }

        .error-message {
            margin-top: 15px;
            color: #d32f2f;
            font-size: 0.95rem;
            text-align: center;
            animation: fadeIn 0.5s ease;
        }

        /* Animations */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(50px);
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
            .container {
                flex-direction: column;
                margin: 20px;
                max-width: 95%;
            }

            .image-container {
                height: 250px;
            }

            .form-container {
                padding: 30px;
            }

            .form-container h2 {
                font-size: 2rem;
            }
        }

        @media (max-width: 480px) {
            .form-container {
                padding: 20px;
            }

            .form-container h2 {
                font-size: 1.8rem;
            }

            form input,
            button[type="submit"] {
                font-size: 0.95rem;
                padding: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="image-container">
            <img src="image/log1.jpg" alt="Admin Login Image" class="image">
        </div>
        <div class="form-container">
            <h2>Admin Login</h2>
            <form action="admin_login.php" method="post">
                <input type="text" name="username" placeholder="Username" required>
                <div class="password-container">
                    <input type="password" name="password" id="password" placeholder="Password" required>
                    <span class="toggle-password" onclick="togglePassword()">Show</span>
                </div>
                <?php if (!empty($error)) echo "<p class='error-message'>$error</p>"; ?>
                <button type="submit" name="submit">Login</button>
            </form>
        </div>
    </div>
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleText = document.querySelector('.toggle-password');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleText.textContent = 'Hide';
            } else {
                passwordInput.type = 'password';
                toggleText.textContent = 'Show';
            }
        }
    </script>
</body>
</html>