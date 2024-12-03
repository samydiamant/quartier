<?php
session_start();
include('conn/conn.php');

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location:  index.php');
    exit;
}

// Add admin logic
if (isset($_POST['add_admin'])) {
    $admin_name = mysqli_real_escape_string($conn, $_POST['admin_name']);
    $admin_password = mysqli_real_escape_string($conn, $_POST['admin_password']);  // No password hash

    $query = "INSERT INTO admin_users (username, password) VALUES ('$admin_name', '$admin_password')";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Admin added successfully!'); window.location.href = 'dashbord.php';</script>";
    } else {
        echo "<script>alert('Error adding admin!');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Admin</title>
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

        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-size: 16px;
            color: #34495e;
            display: block;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #3498db;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
            padding: 10px 15px;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #2980b9;
        }

        input[type="submit"]:active {
            background-color: #1c598a;
        }

        /* Back to Dashboard Button */
        .back-btn {
            margin-top: 20px;
            background-color: #e74c3c;
            text-decoration: none;
            padding: 8px 16px;
            /* Reduced padding */
            color: white;
            border-radius: 8px;
            display: inline-block;
            text-align: center;
            font-size: 14px;
            /* Reduced font size */
            width: auto;
            /* Allow the button to fit content */
        }

        .back-btn:hover {
            background-color: #c0392b;
        }

        /* Responsive Design */
        @media screen and (max-width: 768px) {
            .dashboard-container {
                padding: 15px;
            }

            h1 {
                font-size: 24px;
            }

            input {
                font-size: 14px;
            }

            .form-container {
                padding: 15px;
            }
        }

        @media screen and (max-width: 480px) {
            h1 {
                font-size: 20px;
            }
        }
    </style>
</head>

<body>

    <div class="dashboard-container">
        <h1>Add New Admin</h1>

        <div class="form-container">
            <form method="POST" action="">
                <div class="form-group">
                    <label for="admin_name">Admin Name</label>
                    <input type="text" id="admin_name" name="admin_name" required>
                </div>
                <div class="form-group">
                    <label for="admin_password">Admin Password</label>
                    <input type="password" id="admin_password" name="admin_password" required>
                </div>
                <input type="submit" name="add_admin" value="Add Admin">
            </form>
            <a href="dashbord.php" class="back-btn">Back to Dashboard</a>
        </div>
    </div>

</body>

</html>