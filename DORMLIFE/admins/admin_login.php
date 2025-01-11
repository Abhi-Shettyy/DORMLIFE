<?php
session_start();
include '../connection/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Escape special characters to prevent SQL injection
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];
    $block = strtoupper($conn->real_escape_string($_POST['block']));

    // Default error message
    $error_message = "Invalid username or password!";

    // Check the admin credentials based on block
    $query = "SELECT * FROM admins_$block WHERE Username='$username'";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $admin = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $admin['Password'])) {
            $_SESSION['admin_username'] = $username;
            $_SESSION['admin_block'] = $block;
            $_SESSION['admin_name'] = $admin['Name'];

            // Redirect to admin dashboard
            header("Location: ../admins_dashboard/$block.php");
            exit();
        }
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }

        .login-container {
            max-width: 400px;
            margin: 100px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            color: #555;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
        }

        .form-group select {
            background-color: #fff;
        }

        .error-message {
            color: red;
            font-size: 14px;
            text-align: center;
            margin-bottom: 10px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .login-container p {
            text-align: center;
            color: #777;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>Admin Login</h2>
        <form method="POST" action="admin_login.php">
            <div class="form-group">
                <label for="username">Admin's Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Admin's Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="block">Block of Admin</label>
                <select id="block" name="block" required>
                    <option value="">Select block</option>
                    <option value="V">V</option>
                    <option value="G">G</option>
                    <option value="N">N</option>
                </select>
            </div>

            <?php if (!empty($error_message)): ?>
                <p class="error-message"><?= $error_message; ?></p>
            <?php endif; ?>

            <button type="submit">Login</button>
        </form>

        <!-- Link to Student Login -->
        <p style="text-align: center; margin-top: 20px;">
            <a href="../students/login.php" style="color: #4CAF50; text-decoration: none;">Back</a>
        </p>
    </div>
</body>

</html>
