<?php
session_start();
include('conn/conn.php');

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location:  index.php');
    exit;
}

// Query to get all the products in stock
$products_query = mysqli_query($conn, "SELECT * FROM article");

// Close connection after use (for security)
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard Stock</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .dashboard-container {
            padding: 30px;
            max-width: 1200px;
            margin: 0 auto;
            background-color: #fff;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h1 {
            text-align: center;
            color: #3498db;
            margin-bottom: 40px;
            font-size: 32px;
        }

        .product-table {
            margin-bottom: 30px;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
            word-wrap: break-word;
        }

        th {
            background-color: #3498db;
            color: white;
            font-weight: bold;
        }

        td {
            background-color: #ecf0f1;
        }

        img {
            border-radius: 5px;
            margin: 2px;
        }

        /* Mobile-Friendly Table */
        @media screen and (max-width: 768px) {
            table {
                border: 0;
                width: 100%;
            }

            table thead {
                display: none;
            }

            table tr {
                display: block;
                margin-bottom: 15px;
                border: 1px solid #ddd;
                border-radius: 8px;
                padding: 10px;
                box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
                background-color: #fff;
            }

            table td {
                display: block;
                text-align: right;
                position: relative;
                padding: 10px;
                border: none;
                font-size: 14px;
            }

            table td::before {
                content: attr(data-label);
                position: absolute;
                left: 10px;
                font-weight: bold;
                text-transform: uppercase;
                color: #7f8c8d;
            }

            table td:last-child {
                text-align: center;
            }
        }

        /* Logout Button */
        .logout-btn {
            margin-top: 20px;
            background-color: #e74c3c;
            text-decoration: none;
            padding: 12px 20px;
            color: white;
            border-radius: 8px;
            display: inline-block;
            text-align: center;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .logout-btn:hover {
            background-color: #c0392b;
        }
    </style>
</head>

<body>

    <div class="dashboard-container">
        <h1>Admin Dashboard Stock</h1>

        <!-- Products Table Section -->
        <div class="product-table">
            <h2>All Products in Stock</h2>
            <table>
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Images</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Display all the products
                    while ($product = mysqli_fetch_assoc($products_query)) {
                        echo "<tr>
                            <td data-label='Product ID'>{$product['id_article']}</td>
                            <td data-label='Name'>{$product['nom']}</td>
                            <td data-label='Price'>{$product['prix']} dz</td>
                            <td data-label='Images'>
                                <img src='img/{$product['img']}' alt='{$product['nom']}' width='50' height='50'>
                                <img src='img/{$product['img2']}' alt='{$product['nom']}' width='50' height='50'>
                                <img src='img/{$product['img3']}' alt='{$product['nom']}' width='50' height='50'>
                                <img src='img/{$product['img4']}' alt='{$product['nom']}' width='50' height='50'>
                                <img src='img/{$product['img5']}' alt='{$product['nom']}' width='50' height='50'>
                            </td>
                            <td data-label='Actions'>
                                <a href='edit_product.php?id={$product['id_article']}' class='edit-btn'>Edit</a> | 
                                <a href='delete_product.php?id={$product['id_article']}' class='delete-btn'>Delete</a>
                            </td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Logout Section -->
        <a href="dashbord.php" class="logout-btn">Back to Dashboard</a>
    </div>

</body>

</html>