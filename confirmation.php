<?php
// Inclure le fichier de connexion
include('conn/conn.php');

// Vérifier que le formulaire a bien été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer et sécuriser les données du formulaire
    $nom = mysqli_real_escape_string($conn, $_POST['nom']);
    $adresse = mysqli_real_escape_string($conn, $_POST['adresse']);
    $telephone = mysqli_real_escape_string($conn, $_POST['telephone']);
    $taille = mysqli_real_escape_string($conn, $_POST['taille']);
    $details = mysqli_real_escape_string($conn, $_POST['details']);
    $id_article = mysqli_real_escape_string($conn, $_POST['id_article']); // ID de l'article transmis via un champ caché

    // Récupérer le prix du produit depuis la base de données
    $sql_price = "SELECT prix FROM article WHERE id_article = '$id_article'";
    $result_price = mysqli_query($conn, $sql_price);
    $price = 0; // Default price if not found
    if ($result_price) {
        $product = mysqli_fetch_assoc($result_price);
        $price = $product['prix'];
    }

    // Requête pour insérer les données dans la table "commandes"
    $sql = "INSERT INTO commandes (nom, adresse, telephone, taille, details, id_article, price) 
            VALUES ('$nom', '$adresse', '$telephone', '$taille', '$details', '$id_article', '$price')";

    // Exécuter la requête
    if (mysqli_query($conn, $sql)) {
        // Afficher un message de confirmation
        echo "<!DOCTYPE html>
        <html lang='fr'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Confirmation de commande</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f4f4f4;
                    text-align: center;
                    padding: 50px;
                }
                .confirmation {
                    background: #fff;
                    padding: 20px;
                    border-radius: 10px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                    display: inline-block;
                    text-align: left;
                }
                .confirmation h1 {
                    color: rgba(29, 179, 29, 0.9);
                }
                .confirmation p {
                    font-size: 18px;
                    line-height: 1.5;
                }
                .confirmation a {
                    display: inline-block;
                    margin-top: 20px;
                    padding: 10px 20px;
                    color: white;
                    background: rgba(29, 179, 29, 0.9);
                    text-decoration: none;
                    border-radius: 5px;
                }
                .confirmation a:hover {
                    background: rgba(29, 179, 29, 0.7);
                }
            </style>
        </head>
        <body>
            <div class='confirmation'>
                <h1>Merci, $nom !</h1>
                <p>Votre commande a été enregistrée avec succès.</p>
                <p><strong>Adresse :</strong> $adresse</p>
                <p><strong>Téléphone :</strong> $telephone</p>
                <p><strong>Taille :</strong> $taille</p>
                <p><strong>Détails :</strong> " . (!empty($details) ? $details : 'Aucun détail fourni') . "</p>
                <p><strong>Prix total :</strong> €$price</p> <!-- Affichage du prix -->
                <a href='index.php'>Retour à l'accueil</a>
            </div>
        </body>
        </html>";
    } else {
        // Afficher un message d'erreur en cas d'échec
        echo "<h1>Erreur</h1>";
        echo "<p>Une erreur est survenue lors de l'enregistrement de votre commande : " . mysqli_error($conn) . "</p>";
    }
} else {
    // Rediriger si la page est accédée directement
    header('Location: index.php');
    exit;
}
?>