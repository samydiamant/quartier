<?php
include('conn/conn.php');
session_start();

// Admin credentials (hardcoded for this example, avoid this in production)
$admin_username = 'admin';
$admin_password = 'password';  // Use a plaintext password for testing (not recommended for production)

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the submitted credentials
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query the database for the admin user
    $sql = "SELECT * FROM admin_users WHERE username = '$username' LIMIT 1";
    $res = mysqli_query($conn, $sql);

    if ($res && mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);

        // Verify the submitted password with the stored password (plaintext)
        if ($row['username'] == $username && $row['password'] == $password) {
            // If the username and password match, set the session and redirect to the dashboard
            $_SESSION['admin_logged_in'] = true;
            header('Location: dashbord.php');
            exit;
        } else {
            // Incorrect password
            $error_message = "Invalid credentials, please try again.";
        }
    } else {
        // No such user found
        $error_message = "Invalid credentials, please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #2c3e50;
        }

        .login-container input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .login-container button {
            width: 100%;
            padding: 10px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .login-container button:hover {
            background-color: #2980b9;
        }

        .error-message {
            color: red;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>

<body>

    <div class="login-container">
        <h2>Admin Login</h2>
        <?php if (isset($error_message))
            echo "<p class='error-message'>$error_message</p>"; ?>
        <form action="admin_login.php" method="POST">
            <input type="text" name="username" placeholder="Username" required><br><br>
            <input type="password" name="password" placeholder="Password" required><br><br>
            <button type="submit">Login</button>
        </form>
    </div>

</body>

</html>