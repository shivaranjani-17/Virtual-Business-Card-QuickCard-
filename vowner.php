<?php
include "header.php";
include "nav.php";
include "config.php"; // Ensure this file has your database connection setup
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Users</title>
    <style>
        .table-container {
            width: 90%;
            margin: 20px auto;
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
            color: white;
        }
        table th {
            background-color: #f4f4f4;
            font-weight: bold;
            color: black;
        }
        h2 {
            text-align: center;
            margin-top: 20px;
           color: white;
        }
    </style>
</head>
<body>

<div class="table-container">
    <h2>View Shop Owners</h2>
    <table>
        <thead>
            <tr>
                <th>SID</th>
                <th>Username</th>
                <th>SHOP NAME</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>City</th>
                
            </tr>
        </thead>
        <tbody>
            <?php
            // Connect to the database
            $sql = "SELECT * FROM shop_owner";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                // Fetch and display each row
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['sid'] . "</td>";
                    echo "<td>" . $row['username'] . "</td>";
                    echo "<td>" . $row['shop_name'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . $row['mobile'] . "</td>";
                    echo "<td>" . $row['city'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No records found</td></tr>";
            }

            mysqli_close($conn);
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
