<?php
session_start();
include('conn/conn.php');

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: index.php');
    exit;
}

// Handle form submission to insert article into the database
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = mysqli_real_escape_string($conn, $_POST['nom']);
    $prix = mysqli_real_escape_string($conn, $_POST['prix']);

    // Process the images and store them with original names
    $img = uploadImage('img');
    $img2 = uploadImage('img2');
    $img3 = uploadImage('img3');
    $img4 = uploadImage('img4');
    $img5 = uploadImage('img5');

    // Insert the article into the database
    $insert_query = "INSERT INTO article (nom, prix, img, img2, img3, img4, img5) 
                     VALUES ('$nom', '$prix', '$img', '$img2', '$img3', '$img4', '$img5')";

    if (mysqli_query($conn, $insert_query)) {
        echo "<script>alert('Article added successfully!'); window.location.href='dashbord.php';</script>";
    } else {
        echo "<script>alert('Error adding article. Please try again.');</script>";
    }
}

// Function to handle image upload
function uploadImage($input_name)
{
    if (isset($_FILES[$input_name]) && $_FILES[$input_name]['error'] == 0) {
        $file_name = $_FILES[$input_name]['name']; // Keep original name
        $file_tmp = $_FILES[$input_name]['tmp_name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'avif'];
        if (in_array($file_ext, $allowed_extensions)) {
            $file_path = 'img/' . $file_name; // Store in img/ folder with original name
            move_uploaded_file($file_tmp, $file_path);
            return $file_name; // Return original file name
        } else {
            echo "<script>alert('Invalid file type for $input_name. Only JPG, JPEG, PNG, and GIF are allowed.');</script>";
        }
    }
    return null;
}

// Close connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Article</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        .container {
            padding: 20px;
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h1 {
            text-align: center;
            color: #3498db;
            margin-bottom: 40px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-size: 16px;
            color: #2c3e50;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
        }

        .form-group textarea {
            height: 150px;
            resize: vertical;
        }

        .form-group input[type="file"] {
            padding: 5px;
        }

        .submit-btn {
            width: 100%;
            padding: 12px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .submit-btn:hover {
            background-color: #2980b9;
        }

        .back-btn {
            margin-top: 20px;
            background-color: #e74c3c;
            text-decoration: none;
            padding: 8px 16px;
            color: white;
            border-radius: 8px;
            display: inline-block;
            text-align: center;
            font-size: 14px;
            width: auto;
            margin-bottom: 10px;
        }

        .back-btn:hover {
            background-color: #c0392b;
        }

        /* Mobile Responsiveness */
        @media screen and (max-width: 768px) {
            .container {
                padding: 15px;
            }

            h1 {
                font-size: 28px;
            }

            .form-group input,
            .form-group textarea {
                font-size: 14px;
            }

            .submit-btn {
                font-size: 14px;
                padding: 10px;
            }
        }

        @media screen and (max-width: 480px) {
            .container {
                padding: 10px;
            }

            h1 {
                font-size: 24px;
            }

            .submit-btn {
                font-size: 12px;
                padding: 8px;
            }

            .back-btn {
                font-size: 12px;
                padding: 8px;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Add Article</h1>

        <!-- Form to add article -->
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nom">Article Name</label>
                <input type="text" id="nom" name="nom" required>
            </div>

            <div class="form-group">
                <label for="prix">Price (€)</label>
                <input type="number" id="prix" name="prix" required step="0.01">
            </div>

            <div class="form-group">
                <label for="img">Image 1</label>
                <input type="file" id="img" name="img">
            </div>

            <div class="form-group">
                <label for="img2">Image 2</label>
                <input type="file" id="img2" name="img2">
            </div>

            <div class="form-group">
                <label for="img3">Image 3</label>
                <input type="file" id="img3" name="img3">
            </div>

            <div class="form-group">
                <label for="img4">Image 4</label>
                <input type="file" id="img4" name="img4">
            </div>

            <div class="form-group">
                <label for="img5">Image 5</label>
                <input type="file" id="img5" name="img5">
            </div>

            <button type="submit" class="submit-btn">Add Article</button>
        </form>

        <!-- Back to Dashboard Button -->
        <a href="dashbord.php" class="back-btn">Back to Dashboard</a>
    </div>

</body>

</html>