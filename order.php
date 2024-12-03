<?php
session_start();
include('conn/conn.php');

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location:  index.php');
    exit;
}

// Handle Confirm and Delete Actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = intval($_POST['order_id']); // Sanitize input

    if (isset($_POST['confirm'])) {
        // Fetch the order details before deleting
        $fetch_order_query = "SELECT * FROM commandes WHERE id_commande = $order_id";
        $result = mysqli_query($conn, $fetch_order_query);
        $order_data = mysqli_fetch_assoc($result);

        if ($order_data) {
            // Insert the order into the archive table
            $archive_query = "INSERT INTO archive (id_commande, nom, telephone, id_article, price, details)
                              VALUES ('{$order_data['id_commande']}', '{$order_data['nom']}', '{$order_data['telephone']}', 
                              '{$order_data['id_article']}', '{$order_data['price']}', '{$order_data['details']}')";
            mysqli_query($conn, $archive_query);

            // Delete the order from the commandes table
            $delete_query = "DELETE FROM commandes WHERE id_commande = $order_id";
            mysqli_query($conn, $delete_query);

            echo "<script>alert('Order #$order_id has been confirmed and archived!'); window.location.reload();</script>";
        }
    } elseif (isset($_POST['delete'])) {
        // Delete the order from the commandes table
        $delete_query = "DELETE FROM commandes WHERE id_commande = $order_id";
        mysqli_query($conn, $delete_query);

        echo "<script>alert('Order #$order_id has been deleted!'); window.location.reload();</script>";
    }
}

// Query to get all orders with product details
$orders_query = mysqli_query($conn, "
    SELECT commandes.*, 
           article.nom AS product_name, 
           article.img AS product_image
    FROM commandes
    JOIN article ON commandes.id_article = article.id_article
");

// Query to get the total number of orders
$order_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total_orders FROM commandes"))['total_orders'];

// Query to calculate total sales (sum of prices in orders)
$total_sales = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(price) AS total_sales FROM commandes"))['total_sales'];
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard Orders</title>
    <style>
        /* General Styles */
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

        /* Table Styles */
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

        table tr:hover {
            background-color: #f9fafb;
        }

        img {
            border-radius: 5px;
        }

        /* Action Buttons */
        .action-btn {
            padding: 8px 16px;
            font-size: 14px;
            font-weight: bold;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .confirm-btn {
            background-color: #2ecc71;
            color: white;
        }

        .confirm-btn:hover {
            background-color: #27ae60;
        }

        .delete-btn {
            background-color: #e74c3c;
            color: white;
        }

        .delete-btn:hover {
            background-color: #c0392b;
        }

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

        /* Responsive Table for Mobile */
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
        }
    </style>
</head>

<body>
    <div class="dashboard-container">
        <h1>Admin Dashboard Orders</h1>
        <div class="stats">
            <p><strong>Total Orders:</strong> <?php echo $order_count; ?></p>
            <p><strong>Total Sales:</strong> <?php echo number_format($total_sales, 2); ?> dz</p>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Phone Number</th>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Product Image</th>
                    <th>Order Price</th>
                    <th>Details</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($order = mysqli_fetch_assoc($orders_query)) {
                    echo "<tr>
                        <td data-label='Order ID'>{$order['id_commande']}</td>
                        <td data-label='Customer Name'>{$order['nom']}</td>
                        <td data-label='Phone Number'>{$order['telephone']}</td>
                        <td data-label='Product ID'>{$order['id_article']}</td>
                        <td data-label='Product Name'>{$order['product_name']}</td>
                        <td data-label='Product Image'>
                            <img src='img/{$order['product_image']}' alt='{$order['product_name']}' width='50' height='50'>
                        </td>
                        <td data-label='Order Price'>{$order['price']} dz</td>
                        <td data-label='Details'>{$order['details']}</td>
                        <td data-label='Actions'>
                            <form method='POST' style='display: inline-block;'>
                                <input type='hidden' name='order_id' value='{$order['id_commande']}'>
                                <button type='submit' name='confirm' class='action-btn confirm-btn'>Confirm</button>
                            </form>
                            <form method='POST' style='display: inline-block;'>
                                <input type='hidden' name='order_id' value='{$order['id_commande']}'>
                                <button type='submit' name='delete' class='action-btn delete-btn'>Delete</button>
                            </form>
                        </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
        <a href="dashbord.php" class="logout-btn">Back to Dashboard</a>
    </div>
</body>

</html>