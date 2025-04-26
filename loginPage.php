<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Student Management System</title>
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
            background-image: url('./image/school.png');
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .container {
            width: 1200px;
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

        form select,
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

        form select:focus,
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

        form a {
            text-align: right;
            color: #00aaff;
            text-decoration: none;
            font-size: 0.95rem;
            margin-bottom: 20px;
            transition: color 0.3s;
        }

        form a:hover {
            color: #007bff;
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

            form select,
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
            <img src="./image/log1.jpg" alt="Login Image" class="image">
        </div>
        <div class="form-container">
            <h2>Login</h2>
            <form action="login.php" method="post">
                <select name="role" id="sel" required>
                    <option value="" disabled selected>Select Role</option>
                    <option value="student">Student</option>
                    <option value="supervisor">Supervisor</option>
                    <option value="coordinator">Coordinator</option>
                </select>
                <input type="text" name="user_number" placeholder="User Number/Username" required>
                <div class="password-container">
                    <input type="password" name="password" id="password" placeholder="Password" required>
                    <span class="toggle-password" onclick="togglePassword()">Show</span>
                </div>
                <a href="forgot_password.html">Forgot Password?</a>
                <button type="submit" name="submit">Login</button>
                <?php if (isset($_GET['error'])) { ?>
                    <p class="error-message"><?php echo htmlspecialchars($_GET['error']); ?></p>
                <?php } ?>
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