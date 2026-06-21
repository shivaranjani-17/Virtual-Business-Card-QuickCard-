<?php
// Include necessary files
include "header.php"; 
include "homenav.php"; 
include "config.php"; // Ensure this file has the database connection setup

// Initialize login success flag
$login_success = false;

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Query to check if user exists
    $sql = "SELECT username, password FROM shop_owner WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    // If a match is found, login success
    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('Login successful!'); window.location.href='card.php';</script>";
        exit;
    } else {
        $login_success = false;
        $error_message = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop Owner Login</title>
    <style>
        .login-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 30px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            font-family: "Times New Roman", Times, serif;
        }
        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-submit {
            width: 100%;
            padding: 10px;
            background-color: #73d1c9;
            border: none;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }
        .form-submit:hover {
            background-color: #adf0ea;
        }
        .error-message {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Shop Owner Login</h2>

        <?php
        // Display error message if login failed
        if (isset($error_message)) {
            echo "<p class='error-message'>$error_message</p>";
        }
        ?>

        <form action="" method="POST">
            <input type="text" name="username" class="form-input" placeholder="Username" required>
            <input type="password" name="password" class="form-input" placeholder="Password" required>
            <button type="submit" class="form-submit">Login</button>
        </form>
    </div>
</body>
</html>
