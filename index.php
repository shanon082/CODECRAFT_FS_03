<!-- index.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Student Management System</title>
    <link rel="stylesheet" href="./styles/style.css">
</head>
<body>
    <div class="slideshow-container">
        <!-- Slideshow images -->
        <div class="slide fade">
            <img src="./image/school.png" alt="Slide 1">
        </div>
        <div class="slide fade">
            <img src="./image/library.png" alt="Slide 2">
        </div>
        <div class="slide fade">
            <img src="./image/meeting.png" alt="Slide 3">
        </div>
    </div>
    <div class="welcome-overlay">
        <div class="welcome-content">
            <h1>Welcome to the Student Management System</h1>
            <p class="subtitle">Empowering Education, Connecting Futures</p>
            <p>
                Our cutting-edge platform streamlines academic workflows for students, supervisors, and coordinators. 
                Manage assignments, track progress, and collaborate seamlessly in a secure, user-friendly environment.
            </p><br>
            <p>
                Designed with efficiency and innovation in mind, we’re here to support your academic journey every step of the way.
            </p><br>
        </div>
        <a href="loginPage.php" class="get-started-btn">Get Started</a>
    </div>
    <!-- <script>
        let slideIndex = 0;
        showSlides();

        function showSlides() {
            let slides = document.getElementsByClassName("slide");
            for (let i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            slideIndex++;
            if (slideIndex > slides.length) {
                slideIndex = 1;
            }
            slides[slideIndex - 1].style.display = "block";
            setTimeout(showSlides, 1000); // Change slide every 5 seconds
        }
    </script> -->
</body>
</html>