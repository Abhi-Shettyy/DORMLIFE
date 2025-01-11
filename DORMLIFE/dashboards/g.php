<?php
session_start();
include '../connection/db.php';

// Check if the user is logged in
if (!isset($_SESSION['student_username']) || $_SESSION['student_block'] !== 'G') {
    header("Location: ../students/login.php");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>G Block Hostel - Student Dashboard</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7fc;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #2c3e50;
            color: white;
            padding: 15px 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar h1 {
            font-size: 28px;
            font-weight: bold;
            color: #ecf0f1;
            margin: 0;
        }

        .navbar ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
        }

        .navbar ul li {
            margin: 0 15px;
        }

        .navbar ul li a {
            color: #ecf0f1;
            text-decoration: none;
            font-size: 18px;
            font-weight: 500;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .navbar ul li a:hover {
            background-color: #3498db;
            color: white;
            transform: scale(1.1);
        }

        .navbar .toggle {
            display: none;
            font-size: 28px;
            cursor: pointer;
            color: #ecf0f1;
        }

        .content {
            max-width: 900px;
            margin: 80px auto 50px;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            text-align: center;
            animation: fadeIn 1s ease-in-out;
        }

        .content h2 {
            font-size: 32px;
            color: #2c3e50;
            margin-bottom: 20px;
        }

        .content p {
            font-size: 20px;
            color: #555;
            line-height: 1.8;
        }

        .about-section {
            display: none;
            text-align: left;
            padding: 20px;
            margin: 20px 0;
            background: #ecf0f1;
            border: 1px solid #ddd;
            border-radius: 8px;
            animation: slideDown 0.6s ease-in-out;
        }

        .about-section h3 {
            font-size: 24px;
            color: #2c3e50;
        }

        .about-section p {
            font-size: 18px;
            color: #555;
            line-height: 1.6;
        }

        .logout-btn {
            display: inline-block;
            padding: 12px 20px;
            background-color: #e74c3c;
            color: white;
            font-size: 18px;
            text-decoration: none;
            border-radius: 8px;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }

        .logout-btn:hover {
            background-color: #c0392b;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .navbar ul {
                display: none;
                flex-direction: column;
                background-color: #2c3e50;
                position: absolute;
                top: 70px;
                right: 0;
                width: 100%;
            }

            .navbar ul.active {
                display: flex;
            }

            .navbar .toggle {
                display: block;
            }
        }

        @media (min-width: 769px) {
            .navbar .toggle {
                display: none;
            }
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                max-height: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                max-height: 100vh;
                transform: translateY(0);
            }
        }
    </style>
    <script>
        function toggleMenu() {
            const navbar = document.querySelector('.navbar ul');
            navbar.classList.toggle('active');
        }

        function toggleAbout() {
            const aboutSection = document.getElementById('about-section');
            if (aboutSection.style.display === 'block') {
                aboutSection.style.display = 'none';
            } else {
                aboutSection.style.display = 'block';
            }
        }
    </script>
</head>
<body>
    <div class="navbar">
        <h1>G Block Hostel</h1>
        <span class="toggle" onclick="toggleMenu()">☰</span>
        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="javascript:void(0)" onclick="toggleAbout()">About</a></li>
            <li><a href="#issue">Raise an Issue</a></li>
            <li><a href="#notifications">Notifications</a></li>
            <li><a href="../students/logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="content">
        <h2>Welcome to G Block Hostel</h2>
        <p>
            Experience comfort and convenience at the G Block Hostel. Designed to foster learning and relaxation, the hostel is your perfect home away from home.
        </p>
        <p>
            Situated amidst lush greenery, the hostel offers excellent amenities, recreational facilities, and a vibrant community.
        </p>

        <div id="about-section" class="about-section">
            <h3>About G Block</h3>
            <p>
                G Block is known for its disciplined yet vibrant environment. With top-notch infrastructure, G Block provides the best facilities for residents.
            </p>
        </div>
    </div>
</body>
</html>
