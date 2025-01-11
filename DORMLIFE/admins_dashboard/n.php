<?php
session_start();
include '../connection/db.php';

// Ensure that the admin is logged in
if (!isset($_SESSION['admin_username'])) {
    header("Location: ../admins/admin_login.php"); // Redirect to login page if not logged in
    exit();
}

// Fetch students from block V
$query_v = "SELECT * FROM Students_n";
$result_v = $conn->query($query_v);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Block N</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }
        .dashboard-container {
            max-width: 1000px;
            margin: 50px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        td {
            background-color: #f9f9f9;
        }
        .btn {
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        .btn:hover {
            background-color: #45a049;
        }
        .register-btn {
            margin-bottom: 20px;
            display: inline-block;
            background-color: #007bff;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h2>Welcome, <?php echo $_SESSION['admin_name']; ?></h2>
        <a href="../admins/admin_logout.php" class="btn">Logout</a>
        
        <!-- Register Student Button -->
        <a href="../register_student/register_n.php" class="btn register-btn">Register Student for Block N</a>

        <h3>List of Students in Block N</h3>
        <?php if ($result_v->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Department</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result_v->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['StudentID']; ?></td>
                            <td><?php echo $row['Name']; ?></td>
                            <td><?php echo $row['Username']; ?></td>
                            <td><?php echo $row['Department']; ?></td>
                            <td>
                                <a href="edit_student.php?id=<?php echo $row['StudentID']; ?>" class="btn">Edit</a>
                                <a href="delete_student.php?id=<?php echo $row['StudentID']; ?>" class="btn" onclick="return confirm('Are you sure you want to delete this student?')">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No students found in Block N.</p>
        <?php endif; ?>
    </div>
</body>
</html>
<?php
$conn->close();
?>
