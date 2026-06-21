<?php
include "header.php";
include "nav.php";
include "config.php";

// Fetch data from the 'card' table
$sql = "SELECT * FROM card";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<div style='padding: 20px;'>";
    echo "<table border='1' style='width: 100%; border-collapse: collapse; text-align: center; color: white;'>";
    echo "<thead style='background-color: #333; color: white;'>"; // White text for the header
    echo "<tr>";
    echo "<th>ID</th>";
    echo "<th>Image</th>";
    echo "<th>Description</th>";
    echo "<th>Input Box</th>";
    echo "<th>Note</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    // Loop through the data and display each row
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr style='background-color: #444;'>"; // Darker background for rows
        echo "<td>" . $row['cid'] . "</td>";
        echo "<td><img src='uploads/" . $row['image'] . "' alt='Image' style='width: 100px; height: auto;'></td>";
        echo "<td>" . nl2br($row['description']) . "</td>";
        echo "<td><a href='" . $row['input_box'] . "' target='_blank' style='color: #1E90FF;'>" . $row['input_box'] . "</a></td>"; // Link with custom color
        echo "<td>" . $row['note'] . "</td>";
        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
    echo "</div>";
} else {
    echo "<p style='text-align: center; color: white;'>No data found in the table.</p>";
}

// Close the database connection
mysqli_close($conn);
?>
