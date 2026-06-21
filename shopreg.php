<?php
include "header.php";
include "homenav.php";
include "config.php"; // Ensure this file contains the database connection setup

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $shop_name = mysqli_real_escape_string($conn, $_POST['shop_name']);
    $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    
    $sql = "INSERT INTO `shop_owner` (username, password, shop_name, mobile, email, city) 
            VALUES ('$username', '$password', '$shop_name', '$mobile', '$email', '$city')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Registration successful');</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <style>
        .form-container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            font-family: "Times New Roman", Times, serif;
        }
        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
            font-family: "Times New Roman", Times, serif;
        }
        .form-container label {
            font-weight: bold;
            margin-top: 10px;
            display: block;
        }
        .form-container input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-container .form-row {
            display: flex;
            gap: 20px;
        }
        .form-container .form-group {
            flex: 1;
        }
        .form-container button {
            width: 100%;
            padding: 10px;
            background-color: #73d1c9;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .form-container button:hover {
            background-color: #adf0ea;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Registration Form</h2>
        <form action="" method="post">
            <div class="form-row">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="shop_name">Shop Name</label>
                    <input type="text" id="shop_name" name="shop_name" required>
                </div>
                <div class="form-group">
                    <label for="mobile">Mobile Number</label>
                    <input type="tel" id="mobile" name="mobile" pattern="[0-9]{10,13}" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="email">Email ID</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="city">City</label>
                    <input type="text" id="city" name="city" required>
                </div>
            </div>
            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>
