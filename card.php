<?php
include "header.php";
include "nav.php";
include "config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Initialize variables
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $input_box = mysqli_real_escape_string($conn, $_POST['input_box']);
    $note = mysqli_real_escape_string($conn, $_POST['note']);

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image_name = $_FILES['image']['name'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_extension = pathinfo($image_name, PATHINFO_EXTENSION);
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array(strtolower($image_extension), $allowed_extensions)) {
            $new_image_name = uniqid("img_", true) . '.' . $image_extension;
            $upload_path = "uploads/" . $new_image_name;

            // Create the uploads directory if not exists
            if (!is_dir("uploads")) {
                mkdir("uploads", 0777, true);
            }

            if (move_uploaded_file($image_tmp_name, $upload_path)) {
                // Insert data into the database
                $sql = "INSERT INTO card (image, description, input_box, note) VALUES (?, ?, ?, ?);";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "ssss", $new_image_name, $description, $input_box, $note);

                if (mysqli_stmt_execute($stmt)) {
                    echo "<script>alert('Data successfully uploaded!');</script>";
                } else {
                    echo "<script>alert('Database insertion failed: " . mysqli_error($conn) . "');</script>";
                }

                mysqli_stmt_close($stmt);
            } else {
                echo "<script>alert('Failed to move uploaded file.');</script>";
            }
        } else {
            echo "<script>alert('Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.');</script>";
        }
    } else {
        echo "<script>alert('Error in file upload: " . $_FILES['image']['error'] . "');</script>";
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Form</title>
    <style>
        .form-container {
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
            font-family: Arial, sans-serif;
            margin-top: 50px;
        }
        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-group button {
            width: 100%;
            padding: 10px;
            background-color: #a87de8;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .form-group button:hover {
            background-color: #bba2e0;
            
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Upload Form</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="image">Upload Image</label>
                <input type="file" id="image" name="image" accept="image/*" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="4" placeholder="Enter description here..." required></textarea>
            </div>
            <div class="form-group">
                <label for="input-box">Media Links</label>
                <input type="text" id="input-box" name="input_box" placeholder="Enter text here..." required>
            </div>
            <div class="form-group">
                <label for="note">Note</label>
                <textarea id="note" name="note" rows="3" placeholder="Enter additional notes here..."></textarea>
            </div>
            <div class="form-group">
                <button type="submit">Submit</button>
            </div>
        </form>
    </div>
</body>
</html>


