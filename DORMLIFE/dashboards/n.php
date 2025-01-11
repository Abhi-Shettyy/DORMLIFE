<?php
session_start();
include '../connection/db.php';

// Check if the user is logged in
if (!isset($_SESSION['student_username']) || $_SESSION['student_block'] !== 'N') {
    header("Location: ../student/login.php");
    exit();
}

// Fetch student details
$username = $_SESSION['student_username'];
$query = "SELECT * FROM students_n WHERE Username='$username'";
$result = $conn->query($query);

if ($result && $result->num_rows > 0) {
    $student = $result->fetch_assoc();
} else {
    echo "Error fetching data.";
    exit();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - N Block</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }

        .dashboard-container {
            max-width: 800px;
            margin: 50px auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .student-info {
            margin-bottom: 20px;
        }

        .student-info p {
            font-size: 16px;
            color: #555;
            margin: 8px 0;
        }

        .logout-btn {
            display: block;
            width: 100%;
            padding: 12px;
            background: #e74c3c;
            color: #fff;
            text-align: center;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
            border-radius: 4px;
            margin-top: 20px;
        }

        .logout-btn:hover {
            background: #c0392b;
        }
    </style>
</head>
<body>
<div class="dashboard-container">
    <h1>Welcome, <?= htmlspecialchars($student['Name']); ?>!</h1>
    <div class="student-info">
        <p><strong>Age:</strong> <?= $student['Age']; ?></p>
        <p><strong>Department:</strong> <?= $student['Department']; ?></p>
        <p><strong>Year:</strong> <?= $student['Year']; ?></p>
        <p><strong>Address:</strong> <?= htmlspecialchars($student['Address']); ?></p>
        <p><strong>Registered By Admin ID:</strong> <?= $student['RegisteredBy']; ?></p>
    </div>
    <a href="../students/logout.php" class="logout-btn">Logout</a>
</div>
</body>
</html>
