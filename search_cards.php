<?php
// Include required files
include "header.php";
include "usernav.php"; // This file contains the logout button and cart icon
include "config.php";
session_start();

// Initialize variables
$searchTerm = "";
$cards = [];
$error = "";
$cartCount = 0;

// Retrieve username from session
$username = isset($_SESSION['username']) ? $_SESSION['username'] : "Guest";

// Check if the user is logged in
if ($username !== "Guest") {
    // Retrieve the UID from the `users` table
    $userQuery = "SELECT uid FROM users WHERE username = ?";
    $stmt = $conn->prepare($userQuery);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['uid']; // Store UID in session

        // Calculate cart count based on user ID
        $cartQuery = "SELECT COUNT(*) AS cart_count FROM cart WHERE uid = ?";
        $cartStmt = $conn->prepare($cartQuery);
        $cartStmt->bind_param("i", $_SESSION['user_id']);
        $cartStmt->execute();
        $cartResult = $cartStmt->get_result();
        $cartData = $cartResult->fetch_assoc();
        $cartCount = $cartData['cart_count']; // Retrieve cart count
        $cartStmt->close();
    } else {
        $_SESSION['user_id'] = 0;
    }
    $stmt->close();
} else {
    $_SESSION['user_id'] = 0; // For guest users
}

// Handle search functionality
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $searchTerm = trim($_POST['search']);

    if (!empty($searchTerm)) {
        // Search query for the card description
        $sql = "SELECT * FROM card WHERE description LIKE ?";
        $stmt = $conn->prepare($sql);
        $likeTerm = "%$searchTerm%";
        $stmt->bind_param("s", $likeTerm);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $cards = $result->fetch_all(MYSQLI_ASSOC);
        } else {
            $error = "No results found for \"$searchTerm\".";
        }
        $stmt->close();
    } else {
        $error = "Please enter a search term.";
    }
}

// Handle Add to Cart functionality
if (isset($_GET['cid']) && $_SESSION['user_id'] > 0) {
    $cid = $_GET['cid'];
    $uid = $_SESSION['user_id'];

    // Retrieve card details for the given CID
    $sql = "SELECT * FROM card WHERE cid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $cid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $card = $result->fetch_assoc();

        // Insert into cart table
        $insertSql = "INSERT INTO cart (uid, image, description, input_box, note) VALUES (?, ?, ?, ?, ?)";
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bind_param(
            "issss",
            $uid,
            $card['image'],
            $card['description'],
            $card['input_box'],
            $card['note']
        );

        if ($insertStmt->execute()) {
            header("Location: " . $_SERVER['PHP_SELF']); // Avoid resubmission on refresh
            exit;
        }
        $insertStmt->close();
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <title>Search Cards</title>
    <style>
        /* Navbar */
        .navbar .welcome {
            font-size: 18px;
            color: white;
            font-weight: bold;
        }

        .navbar .cart {
            display: flex;
            align-items: center;
            position: relative;
        }

        .cart-icon {
            position: relative;
            font-size: 30px;
            color: white;
            cursor: pointer;
            background: none;
            border: none;
            outline: none;
        }

        .cart-count {
            position: absolute;
            top: -5px;
            right: -10px;
            background-color: red;
            color: white;
            font-size: 14px;
            font-weight: bold;
            border-radius: 50%;
            padding: 2px 6px;
        }

        /* Search Bar */
        .search-container {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }

        .search-container form {
            display: flex;
            gap: 10px;
        }

        .search-container input[type="text"] {
            width: 300px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .search-container button {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .search-container button:hover {
            background-color: #0056b3;
        }

        /* Table */
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            color: white;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
            vertical-align: middle;
        }

        table th {
            background-color: #f4f4f4;
            font-weight: bold;
            font-size: 16px;
            color: black;
        }

        table td img {
            max-width: 100px;
            height: auto;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .add-to-cart-btn {
            background-color: #28a745;
            color: white;
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 5px;
            font-size: 14px;
        }

        .add-to-cart-btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
<div class="navbar">
    <div class="welcome">Welcome, <?php echo htmlspecialchars($username); ?>!</div>
    <div class="cart">
        <form method="GET" action="vcart.php">
            <button type="submit" class="cart-icon">
                <i class="fa fa-shopping-cart"></i>
                <div class="cart-count"><?php echo $cartCount; ?></div>
            </button>
        </form>
    </div>
</div>

<div class="search-container">
    <form method="POST" action="">
        <input type="text" name="search" placeholder="Search by card description..." 
               value="<?php echo htmlspecialchars($searchTerm); ?>" required>
        <button type="submit">Search</button>
    </form>
</div>

<?php if ($error): ?>
    <p class="error"><?php echo $error; ?></p>
<?php endif; ?>

<?php if (!empty($cards)): ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Description</th>
                <th>Input Box</th>
                <th>Note</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cards as $index => $card): ?>
                <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td>
                        <img src="uploads/<?php echo htmlspecialchars($card['image']); ?>" 
                             alt="Card Image" width="100">
                    </td>
                    <td><?php echo htmlspecialchars($card['description']); ?></td>
                    <td>
                        <a href="<?php echo htmlspecialchars($card['input_box']); ?>" target="_blank">Visit Link</a>
                    </td>
                    <td><?php echo htmlspecialchars($card['note']); ?></td>
                    <td>
                        <a href="?cid=<?php echo $card['cid']; ?>" class="add-to-cart-btn">Add to Cart</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
</body>
</html>
