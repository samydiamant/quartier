<?php
session_start();
include('conn/conn.php');

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: index.php');
    exit;
}

// Query to get all archived orders with product details
$archive_query = mysqli_query($conn, "
    SELECT archive.*, 
           article.nom AS product_name, 
           article.img AS product_image
    FROM archive
    JOIN article ON archive.id_article = article.id_article
");

// Query to calculate the total price of archived orders
$total_price = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(price) AS total_price FROM archive"))['total_price'];

// Query to get the total number of archived orders
$total_archived = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total_archived FROM archive"))['total_archived'];
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard Archive</title>
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

        .stats {
            margin-bottom: 30px;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .archive-table {
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
                text-align: right;
            }

            table td[data-label="Archived At"] {
                white-space: normal;
                padding-bottom: 10px;
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
        <h1>Admin Dashboard Archive</h1>

        <!-- Total Stats Section -->
        <div class="stats">
            <p><strong>Total Archived Orders:</strong> <?php echo $total_archived; ?></p>
            <p><strong>Total Archived Orders Price:</strong> <?php echo number_format($total_price, 2); ?> dz</p>
        </div>

        <!-- Archived Orders Table Section -->
        <div class="archive-table">
            <h2>Archived Orders</h2>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer Name</th>
                        <th>Phone Number</th>
                        <th>Product Name</th>
                        <th>Product Image</th>
                        <th>Details</th>
                        <th>Archived At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Display all the archived orders
                    while ($order = mysqli_fetch_assoc($archive_query)) {
                        echo "<tr>
                            <td data-label='Order ID'>{$order['id_commande']}</td>
                            <td data-label='Customer Name'>{$order['nom']}</td>
                            <td data-label='Phone Number'>{$order['telephone']}</td>
                            <td data-label='Product Name'>{$order['product_name']}</td>
                            <td data-label='Product Image'>
                                <img src='img/{$order['product_image']}' alt='{$order['product_name']}' width='50' height='50'>
                            </td>
                            <td data-label='Details'>{$order['details']}</td>
                            <td data-label='Archived At'>{$order['archived_at']}</td>
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