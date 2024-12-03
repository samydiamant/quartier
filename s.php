<?php
include('conn/conn.php');
if (isset($_POST['acheter'])) {
    $id_article = $_POST['acheter'];
} elseif (isset($_POST['new'])) {
    $id_article = $_POST['new'];
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commande</title>
    <link rel="stylesheet" href="index.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .commande-container {
            display: flex;
            flex-wrap: wrap;
            max-width: 900px;
            margin: 50px auto;
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .gallery {
            flex: 1;
            margin-right: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .main-image {
            width: 100%;
            height: auto;
            max-height: 300px;
            border-radius: 10px;
            margin-bottom: 10px;
        }

        .thumbnail-container {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .thumbnail-container img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 5px;
            cursor: pointer;
            transition: transform 0.3s;
        }

        .thumbnail-container img:hover {
            transform: scale(1.1);
        }

        .form-container {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .form-container h1 {
            color: rgba(29, 179, 29, 0.9);
            margin-bottom: 20px;
            text-align: center;
        }

        .form-container form {
            display: flex;
            flex-direction: column;
        }

        .form-container form input,
        .form-container form select,
        .form-container form textarea,
        .form-container form button {
            margin: 10px 0;
            padding: 10px;
            font-size: 16px;
            border: 1px solid rgba(29, 179, 29, 0.5);
            border-radius: 5px;
        }

        .form-container form button {
            background: rgba(29, 179, 29, 0.7);
            color: white;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .form-container form button:hover {
            background: rgba(29, 179, 29, 0.9);
        }

        .back-btn {
            background-color: #3498db;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
            cursor: pointer;
        }

        .back-btn:hover {
            background-color: #2980b9;
        }

        /* Mobile Responsiveness */
        @media screen and (max-width: 768px) {
            .commande-container {
                flex-direction: column;
                padding: 10px;
            }

            .gallery,
            .form-container {
                flex: 1;
                margin-right: 0;
                margin-bottom: 20px;
            }

            .main-image {
                max-height: 250px;
            }

            .thumbnail-container img {
                width: 50px;
                height: 50px;
            }

            .form-container h1 {
                font-size: 24px;
            }

            .form-container form input,
            .form-container form select,
            .form-container form textarea,
            .form-container form button {
                font-size: 14px;
                padding: 8px;
            }
        }

        @media screen and (max-width: 480px) {
            .form-container h1 {
                font-size: 20px;
            }

            .form-container form input,
            .form-container form select,
            .form-container form textarea,
            .form-container form button {
                font-size: 12px;
                padding: 6px;
            }
        }
    </style>
</head>

<body>
    <div class="commande-container">
        <!-- Galerie d'images -->
        <?php
        // Récupérer l'article depuis la base de données
        if (isset($id_article)) {
            $sql = "SELECT * FROM article WHERE id_article='$id_article' ";
            $res = mysqli_query($conn, $sql);
            if ($res) {
                while ($info = mysqli_fetch_assoc($res)) {
                    $price = $info['prix']; // Récupérer le prix
                    echo "<div class='gallery'>
                            <img id='main-image' class='main-image' src='img/" . $info['img'] . "' alt='Produit'>
                            <div class='thumbnail-container'>
                                <img src='img/" . $info['img2'] . "' alt='Produit 2' onclick='changeImage(this.src)'>
                                <img src='img/" . $info['img3'] . "' alt='Produit 3' onclick='changeImage(this.src)'>
                                <img src='img/" . $info['img4'] . "' alt='Produit 4' onclick='changeImage(this.src)'>
                                <img src='img/" . $info['img5'] . "' alt='Produit 5' onclick='changeImage(this.src)'>
                            </div>
                            <p><strong>Prix: €" . $price . "</strong></p> <!-- Affichage du prix -->
                        </div>";
                }
            }
        }
        ?>

        <!-- Formulaire de commande -->
        <div class="form-container">
            <h1>Passer une commande</h1>
            <form action="confirmation.php" method="POST">
                <input type="hidden" name="id_article" value="<?php echo $id_article; ?>">
                <input type="hidden" name="price" value="<?php echo $price; ?>">
                <!-- Envoi du prix dans le formulaire -->

                <input type="text" name="nom" placeholder="Votre nom" required>
                <input type="text" name="adresse" placeholder="Votre adresse" required>
                <input type="tel" name="telephone" placeholder="Votre numéro de téléphone" required>
                <select name="taille" required>
                    <option value="" disabled selected>Choisissez la taille</option>
                    <option value="S">S</option>
                    <option value="M">M</option>
                    <option value="L">L</option>
                    <option value="XL">XL</option>
                    <option value="XXL">XXL</option>
                </select>
                <textarea name="details" rows="4" placeholder="Détails de votre commande (facultatif)"></textarea>
                <button name="sub" type="submit">Envoyer la commande</button>
            </form>

            <!-- Back Button -->
            <a href="index.php" class="back-btn">Retour à l'accueil</a>
        </div>
    </div>

    <script>
        // Fonction pour changer l'image principale
        function changeImage(imageSrc) {
            document.getElementById('main-image').src = imageSrc;
        }
    </script>
</body>

</html>