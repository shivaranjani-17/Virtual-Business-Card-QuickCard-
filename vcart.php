<?php
include "config.php";
include "header.php";
include "usernav.php";
session_start();

// Check if the user is logged in
$username = isset($_SESSION['username']) ? $_SESSION['username'] : "Guest";

if ($username !== "Guest") {
    // Fetch the logged-in user's ID
    $userQuery = "SELECT uid FROM users WHERE username = ?";
    $stmt = $conn->prepare($userQuery);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $userResult = $stmt->get_result();
    $user = $userResult->fetch_assoc();
    $userId = $user['uid'];
    $stmt->close();
} else {
    // Redirect to login if not logged in
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart Table</title>
    <style>
        .table-container {
            max-width: 900px;
            margin: auto;
            overflow-x: auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-family: "Times New Roman", Times, serif;
        }
        th, td {
            text-align: left;
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .image-cell img {
            max-width: 100px;
            border-radius: 4px;
        }
        h2 {
            text-align: center;
            font-family: "Times New Roman", Times, serif;
        }
    </style>
</head>
<body>
    <div class="table-container">
        <h2>Your Cart</h2>
        <table>
            <thead>
                <tr>
                    <th>Cart ID</th>
                    <th>Image</th>
                    <th>Description</th>
                    <th>Input Box</th>
                    <th>Note</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Query to fetch cart data for the logged-in user
                $cartQuery = "SELECT * FROM cart WHERE uid = ?";
                $stmt = $conn->prepare($cartQuery);
                $stmt->bind_param("i", $userId);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['cart_id']}</td>
                                <td class='image-cell'><img src='uploads/{$row['image']}' alt='Cart Image'></td>
                                <td>{$row['description']}</td>
                                <td>{$row['input_box']}</td>
                                <td>{$row['note']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Your cart is empty.</td></tr>";
                }
                $stmt->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
