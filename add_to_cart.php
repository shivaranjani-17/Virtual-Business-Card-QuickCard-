<?php

include "header.php";
include "usernav.php";
include "config.php"; // Database connection file

// Check if user is logged in
if (!isset($_SESSION['uid'])) {
    header("Location: userlog.php"); // Redirect to login if not logged in
    exit();
}

// Validate and sanitize input
$cid = isset($_GET['cid']) ? intval($_GET['cid']) : 0;
$uid = intval($_SESSION['uid']);

if ($cid > 0) {
    // Fetch the card details from the database
    $sql = "SELECT * FROM card WHERE cid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $cid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $card = $result->fetch_assoc();
        
        // Insert into cart table
        $insertSQL = "INSERT INTO cart (uid, image, description, input_box, note) VALUES (?, ?, ?, ?, ?)";
        $stmtInsert = $conn->prepare($insertSQL);
        $stmtInsert->bind_param(
            "issss",
            $uid,
            $card['images'],
            $card['description'],
            $card['input_box'],
            $card['note']
        );

        if ($stmtInsert->execute()) {
            // Redirect to the search page with a success message
            header("Location: search_cards.php?message=Card added to cart successfully!");
            exit();
        } else {
            // Handle insertion error
            echo "Error: " . $stmtInsert->error;
        }
        $stmtInsert->close();
    } else {
        echo "Card not found.";
    }
    $stmt->close();
} else {
    echo "Invalid card ID.";
}
$conn->close();
?>
