<?php
session_start();
include '../connection/db.php';

// Ensure that the admin is logged in
if (!isset($_SESSION['admin_username'])) {
    header("Location: ../admins/admin_login.php"); // Redirect to login page if not logged in
    exit();
}

$error_message = ""; // Initialize error message variable
$success_message = ""; // Initialize success message variable

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and fetch input values
    $name = $_POST['name'];
    $age = $_POST['age'];
    $department = $_POST['department'];
    $year = $_POST['year'];
    $address = $_POST['address'];
    $username = $_POST['username'];
    $password = $_POST['password']; // Plain text password to hash
    $created_by = $_SESSION['AdminID']; // Admin who created the student
    
    // Hash the password before storing it
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Check if the username already exists in Block N
    $check_query = "SELECT * FROM Students_n WHERE Username=?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $error_message = "Username already exists. Please choose another.";
    } else {
        // Prepare the INSERT query using prepared statements for Block N student registration
        $insert_query = "INSERT INTO Students_n (Name, Age, Department, Year, Address, Username, Password, RegisteredBy) 
                         VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("sissssss", $name, $age, $department, $year, $address, $username, $hashed_password, $created_by);

        if ($stmt->execute()) {
            // Redirect to the admin dashboard after successful registration for Block N
            header("Location: ../admins_dashboard/n.php"); // Replace 'admin_dashboard_n.php' with your actual dashboard page for Block N
            exit();
        } else {
            // Output the error message for debugging
            echo "Error: " . $stmt->error;
            $error_message = "Error: " . $stmt->error;
        }
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Student for Block N</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
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
        label {
            font-weight: bold;
            margin-bottom: 8px;
            display: block;
        }
        input[type="text"], input[type="password"], input[type="number"], textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 15px;
            font-size: 16px;
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #45a049;
        }
        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 20px;
        }
        .success-message {
            color: green;
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Register Student for Block N</h2>

        <!-- Display error or success message -->
        <?php if ($error_message): ?>
            <p class="error-message"><?= $error_message; ?></p>
        <?php endif; ?>
        <?php if ($success_message): ?>
            <p class="success-message"><?= $success_message; ?></p>
        <?php endif; ?>

        <form method="POST" action="register_n.php">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" required>

            <label for="age">Age</label>
            <input type="number" id="age" name="age" required>

            <label for="department">Department</label>
            <input type="text" id="department" name="department" required>

            <label for="year">Year</label>
            <input type="text" id="year" name="year" required>

            <label for="address">Address</label>
            <textarea id="address" name="address" required></textarea>

            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Register Student</button>
        </form>
    </div>

</body>
</html>

<?php
$conn->close();
?>
s