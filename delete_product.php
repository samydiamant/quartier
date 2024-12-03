<?php
session_start();
include('conn/conn.php');

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: index.php');
    exit;
}

// Check if the product ID is provided
if (isset($_GET['id'])) {
    $id_article = $_GET['id'];

    // Query to delete the product from the database
    $delete_query = "DELETE FROM article WHERE id_article = '$id_article'";

    if (mysqli_query($conn, $delete_query)) {
        header('Location: stock.php'); // Redirect to the stock page after deletion
        exit;
    } else {
        echo "Error deleting product!";
    }
} else {
    echo "Invalid product ID!";
}

// Close connection after use (for security)
mysqli_close($conn);
?>