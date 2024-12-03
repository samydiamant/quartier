<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard </title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ecf0f1;
            margin: 0;
            padding: 0;
        }

        .dashboard-container {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        h1 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 40px;
        }

        .button-container {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            justify-content: center;
        }

        .button-container button {
            background-color: #3498db;
            color: white;
            padding: 20px 40px;
            font-size: 18px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            width: 250px;
            height: 70px;
            transition: all 0.3s ease-in-out;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .button-container button:hover {
            background-color: #2980b9;
            transform: scale(1.1);
            /* Increase button size on hover */
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
            /* Add a stronger shadow */
        }

        .button-container button:active {
            background-color: #1c598a;
            /* Darker color when clicked */
            transform: scale(1);
            /* Prevent scaling when clicked */
        }

        .button-container button:focus {
            outline: none;
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
        <h1>Admin Dashboard</h1>

        <!-- Buttons for different actions -->
        <div class="button-container">
            <button onclick="window.location.href='order.php'">Orders</button>
            <button onclick="window.location.href='stock.php'">Stock</button>
            <button onclick="window.location.href='add_admin.php'">Add Admin</button>
            <button onclick="window.location.href='add_article.php'">Add Article</button>
            <button onclick="window.location.href='archive.php'">Archive</button>
            <!-- <button onclick="window.location.href='add_new_article.php'">Add New Article</button> -->

            <!-- <button onclick="window.location.href='total_price.php'">Total Price in This Month</button> -->
        </div>

        <!-- Logout Button -->
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>

</body>

</html>