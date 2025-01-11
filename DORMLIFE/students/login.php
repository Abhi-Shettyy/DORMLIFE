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

    // Check if block selection is valid
    if (in_array($block, ['V', 'G', 'N'])) {
        // Prepare query based on selected block
        $query = "SELECT * FROM Students_$block WHERE Username = '$username'";

        // Execute query and handle results
        $result = $conn->query($query);

        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Verify password (make sure it's hashed in the database)
            if (password_verify($password, $user['Password'])) {
                // Set session variables
                $_SESSION['csn_usn'] = $user['csn_usn'];
                $_SESSION['student_username'] = $username;
                $_SESSION['student_block'] = $block;
                $_SESSION['student_name'] = $user['Name'];
                $_SESSION['student_department'] = $user['Department'];

                // Redirect to block-specific dashboard
                header("Location: ../dashboards/v.php" . urlencode($user['username']));
                exit();
            } else {
                $error_message = "Incorrect password!";
            }
        } else {
            $error_message = "No user found with this username!";
        }
    } else {
        $error_message = "Invalid block selection!";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login</title>
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
        <h2>Student Login</h2>

        <form method="POST" action="login.php">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="block">Block</label>
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

        <p style="text-align: center; margin-top: 20px;">
            Admin?
            <a href="../admins/admin_login.php" style="color: #4CAF50; text-decoration: none;">Sign-in Admin</a>
        </p>
    </div>
</body>

</html>