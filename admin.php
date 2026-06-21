<?php
session_start();
include "header.php"; // Include the header file
include "homenav.php"; // Include the navigation bar
include "config.php"; // Include the database configuration

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the username and password from the login form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to check admin credentials
    $query = "SELECT * FROM admin WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the credentials are valid
    if ($result->num_rows > 0) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;

        // Add the alert message
        echo "<script>
            alert('Admin logged in successfully');
            window.location.href = 'vcard.php'; // Redirect to the admin dashboard
        </script>";
        exit();
    } else {
        $error = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        .login-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            font-family: "Times New Roman", Times, serif;
            color: white;
        }
        .login-container h2 {
            text-align: center;
            font-family: "Times New Roman", Times, serif;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
        .error {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Admin Login</h2>
        <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" style="width: 100%; padding: 10px; background-color: #0077b5; color: white; border: none; border-radius: 5px;">Login</button>
        </form>
    </div>
</body>
</html>
