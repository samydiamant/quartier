<?php
session_start();
include('conn/conn.php');

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location:  index.php');
    exit;
}

// Check if the product ID is provided
if (isset($_GET['id'])) {
    $id_article = $_GET['id'];

    // Query to get the product details from the database
    $product_query = mysqli_query($conn, "SELECT * FROM article WHERE id_article = '$id_article'");
    $product = mysqli_fetch_assoc($product_query);

    // Check if product exists
    if (!$product) {
        echo "Product not found!";
        exit;
    }
} else {
    echo "Invalid product ID!";
    exit;
}

// Update product if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $prix = $_POST['prix'];

    // Handling image upload
    $img = $_FILES['img']['name'];
    $img2 = $_FILES['img2']['name'];
    $img3 = $_FILES['img3']['name'];
    $img4 = $_FILES['img4']['name'];
    $img5 = $_FILES['img5']['name'];

    // Directory to store images
    $upload_dir = 'img/';

    // Function to handle image uploads
    function uploadImage($image, $upload_dir)
    {
        $image_tmp = $_FILES[$image]['tmp_name'];
        $image_name = $_FILES[$image]['name'];
        $target_path = $upload_dir . basename($image_name);

        // Move the uploaded image to the target folder
        if (move_uploaded_file($image_tmp, $target_path)) {
            return $image_name;
        } else {
            return '';  // Return empty string if image upload fails
        }
    }

    // Upload images and get the new image paths
    $img = uploadImage('img', $upload_dir) ?: $product['img'];
    $img2 = uploadImage('img2', $upload_dir) ?: $product['img2'];
    $img3 = uploadImage('img3', $upload_dir) ?: $product['img3'];
    $img4 = uploadImage('img4', $upload_dir) ?: $product['img4'];
    $img5 = uploadImage('img5', $upload_dir) ?: $product['img5'];

    // Update query to modify the product in the database
    $update_query = "UPDATE article SET nom = '$nom', prix = '$prix', img = '$img', img2 = '$img2', img3 = '$img3', img4 = '$img4', img5 = '$img5' WHERE id_article = '$id_article'";

    if (mysqli_query($conn, $update_query)) {
        header('Location: stock.php'); // Redirect to the stock page after update
        exit;
    } else {
        echo "Error updating product!";
    }
}

// Close connection after use (for security)
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ecf0f1;
            margin: 0;
        }

        .form-container {
            max-width: 600px;
            margin: 50px auto;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #2c3e50;
        }

        input[type="text"],
        input[type="number"],
        input[type="file"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #2980b9;
        }

        .back-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #e74c3c;
            color: white;
            border-radius: 5px;
            text-decoration: none;
        }

        .back-btn:hover {
            background-color: #c0392b;
        }

        /* Mobile Responsiveness */
        @media screen and (max-width: 768px) {
            .form-container {
                padding: 10px;
            }

            h1 {
                font-size: 24px;
                margin-bottom: 20px;
            }

            input[type="text"],
            input[type="number"],
            input[type="file"] {
                padding: 10px;
            }

            input[type="submit"] {
                width: 100%;
                padding: 15px;
            }
        }

        @media screen and (max-width: 480px) {
            h1 {
                font-size: 20px;
            }

            input[type="text"],
            input[type="number"],
            input[type="file"] {
                padding: 8px;
            }

            input[type="submit"] {
                padding: 12px;
            }
        }
    </style>
</head>

<body>

    <div class="form-container">
        <h1>Edit Product</h1>
        <form method="POST" enctype="multipart/form-data">
            <label for="nom">Product Name</label>
            <input type="text" id="nom" name="nom" value="<?php echo $product['nom']; ?>" required>

            <label for="prix">Price</label>
            <input type="number" id="prix" name="prix" value="<?php echo $product['prix']; ?>" required>

            <label for="img">Image 1</label>
            <input type="file" id="img" name="img">

            <label for="img2">Image 2</label>
            <input type="file" id="img2" name="img2">

            <label for="img3">Image 3</label>
            <input type="file" id="img3" name="img3">

            <label for="img4">Image 4</label>
            <input type="file" id="img4" name="img4">

            <label for="img5">Image 5</label>
            <input type="file" id="img5" name="img5">

            <input type="submit" value="Update Product">
        </form>

        <a href="stock.php" class="back-btn">Back to Stock</a>
    </div>

</body>

</html>