<?php
// Include required files
include "header.php";
include "usernav.php"; // Contains logout button and cart icon
include "config.php";
session_start();

// Check if the user is logged in
$username = isset($_SESSION['username']) ? $_SESSION['username'] : null;

if ($username) {
    // Retrieve UID from the `users` table
    $userQuery = "SELECT uid FROM users WHERE username = ?";
    $stmt = $conn->prepare($userQuery);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $userId = $user['uid']; // User ID of the logged-in user
    $_SESSION['user_id'] = $userId;
    $stmt->close();
} else {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit;
}

// Retrieve cart items for the logged-in user
$cartItems = [];
$error = "";
$cartQuery = "SELECT * FROM cart WHERE uid = ?";
$stmt = $conn->prepare($cartQuery);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $cartItems = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $error = "Your cart is empty.";
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="cart-container">
        <h1>Your Cart</h1>
        <p>Welcome, <?php echo htmlspecialchars($username); ?>!</p>
        <?php if (!empty($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Description</th>
                        <th>Input Box</th>
                        <th>Note</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cartItems as $item): ?>
                        <tr>
                            <td><img src="<?php echo htmlspecialchars($item['image']); ?>" alt="Product Image" width="100"></td>
                            <td><?php echo htmlspecialchars($item['description']); ?></td>
                            <td><?php echo htmlspecialchars($item['input_box']); ?></td>
                            <td><?php echo htmlspecialchars($item['note']); ?></td>
                            <td>
                                <a href="cart.php?delete_id=<?php echo $item['cart_id']; ?>" onclick="return confirm('Are you sure you want to remove this item?');">Remove</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>
