<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="./fontawesome-free-6.2.1-web/css/all.css">
    <title>Quartier</title>
    <style>
        /* New product button style */
        .cadre-new .cadre-img {
            position: relative;
        }

        .cadre-new .cadre-img img {
            width: 100%;
            height: auto;
            border-radius: 10px;
            transition: transform 0.3s ease;
        }

        .cadre-new:hover .cadre-img img {
            transform: scale(1.1);
        }

        .cadre-new .para h1 {
            text-align: center;
            font-size: 1.5rem;
            margin-top: 10px;
        }

        .cadre-new .para button {
            background-color: #3498db;
            color: #fff;
            padding: 10px 20px;
            font-size: 1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .cadre-new .para button:hover {
            background-color: #2980b9;
        }

        /* Header styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        #header {
            background-color: #333;
            color: white;
            padding: 10px 0;
            text-align: center;
        }

        #header .all {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        #header .titel h1 {
            font-size: 2.5rem;
            margin: 0;
        }

        /* Search form style */
        #header form {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        #header input[type="search"] {
            padding: 10px;
            font-size: 1rem;
            width: 80%;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        #header button {
            padding: 10px 20px;
            font-size: 1rem;
            background-color: #3498db;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            margin-left: 10px;
        }

        #header button:hover {
            background-color: #2980b9;
        }

        /* New Product Section */
        #new {
            padding: 50px 20px;
            background-color: #fff;
            text-align: center;
        }

        #new h1 {
            font-size: 2rem;
            margin-bottom: 30px;
        }

        /* Container for products */
        #continer {
            padding: 50px 20px;
            background-color: #eaeaea;
            text-align: center;
        }

        #continer h1 {
            font-size: 2rem;
            margin-bottom: 30px;
        }

        .all-cont {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .cadre {
            background-color: white;
            border-radius: 10px;
            margin: 15px;
            padding: 20px;
            width: 250px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .cadre-bout img {
            width: 100%;
            border-radius: 10px;
        }

        .cadre-para h2 {
            font-size: 1.2rem;
            margin: 10px 0;
        }

        .cadre-para h3 {
            font-size: 1rem;
            color: #333;
        }

        .btn1 button {
            background-color: #3498db;
            color: white;
            padding: 10px;
            margin: 5px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn1 button:hover {
            background-color: #2980b9;
        }

        .btn i {
            font-size: 1.5rem;
        }

        /* Mobile-specific styles */
        .cadre-new-list {
            display: block;
            text-align: left;
            margin-bottom: 15px;
        }

        /* Media Queries for responsiveness */
        @media (max-width: 768px) {
            #header .titel h1 {
                font-size: 2rem;
            }

            .cadre-new .para h1 {
                font-size: 1.2rem;
            }

            #header input[type="search"] {
                width: 60%;
            }

            #header button {
                font-size: 0.9rem;
                padding: 8px 16px;
            }

            .cadre {
                width: 100%;
                margin: 15px 0;
            }

            /* When on mobile, make the new product section into a list */
            .cadre-new {
                display: block;
                text-align: left;
            }

            /* Hide the regular .cadre-new style on mobile */
            .cadre-new-list {
                display: block;
            }

            /* New product section on mobile: display as list */
            #new .all-new {
                display: block;
            }

            #new .cadre-new {
                margin-bottom: 20px;
            }
        }

        @media (max-width: 480px) {
            .cadre-new .para h1 {
                font-size: 1rem;
            }

            #header input[type="search"] {
                width: 50%;
            }

            #header button {
                font-size: 0.8rem;
                padding: 8px 14px;
            }
        }
    </style>
</head>

<body>
    <section id="header">
        <div class="all">
            <nav>
                <div class="nav-logo">
                    <div class="logo">
                        <img src="./img/s.jpg" alt="">
                    </div>
                </div>
            </nav>
            <div class="titel">
                <h1><span>Q</span>uartie<span>r</span></h1>
                <form action="" method="post">
                    <input type="search" name="search" placeholder="Koi de 9 !!!">
                    <button type="submit" name="submit-search">Search</button>
                </form>
            </div>
        </div>
    </section>

    <section id="new">
        <h1>Free tools to sky-rocket your creative freedom</h1>
        <div class="all-new">
            <?php
            include('conn/conn.php');

            // Check if search query is submitted
            if (isset($_POST['submit-search'])) {
                $search_query = mysqli_real_escape_string($conn, $_POST['search']);
                $sql = "SELECT * FROM article WHERE nom LIKE '%$search_query%' LIMIT 4";
            } else {
                // Default query to show the latest products
                $sql = "SELECT * FROM article LIMIT 4";
            }

            $res = mysqli_query($conn, $sql);
            if ($res && mysqli_num_rows($res) > 0) {
                while ($info = mysqli_fetch_assoc($res)) {
                    echo "<form action='s.php' method='post'>
                        <div class='cadre-new'>
                            <div class='cadre-img'>
                                <img src='./img/" . $info['img'] . "' alt=''>
                            </div>
                            <div class='para'>
                                <h1>Discover the new product</h1>
                                <button name='new' value='" . $info['id_article'] . "'>Acheter</button>
                            </div>
                        </div>
                    </form>";
                }
            } else {
                echo "<p>No products found matching your search!</p>";
            }
            ?>
        </div>
    </section>

    <section id="continer">
        <h1>All Products</h1>
        <div class="all-cont">
            <form action="s.php" method="post">
                <?php
                if (isset($_POST['submit-search'])) {
                    $search_query = mysqli_real_escape_string($conn, $_POST['search']);
                    $sql = "SELECT * FROM article WHERE nom LIKE '%$search_query%'";
                } else {
                    $sql = "SELECT * FROM article";
                }

                $res = mysqli_query($conn, $sql);
                if ($res && mysqli_num_rows($res) > 0) {
                    while ($info = mysqli_fetch_assoc($res)) {
                        echo "<div class='cadre'>
                            <div class='cadre-bout'>
                                <img src='./img/" . $info['img'] . "' alt=''>
                            </div>
                            <div class='cadre-para'>
                                <h2>" . $info['nom'] . "</h2>
                                <h3>Prix: " . $info['prix'] . " DZ</h3>
                                <div class='btn1'>
                                    <button name='acheter' value='" . $info['id_article'] . "'>Acheter</button>
                                    <button name='pani' value='" . $info['id_article'] . "' class='btn'>
                                        <i class='fa-solid fa-bag-shopping'></i>
                                    </button>
                                </div>
                            </div>
                        </div>";
                    }
                } else {
                    echo "<p>No products found matching your search!</p>";
                }
                ?>
            </form>
        </div>
    </section>

    <script>
        // Adjust layout on window resize
        function adjustLayout() {
            const isMobile = window.innerWidth <= 768;
            const cadreNew = document.querySelector('.cadre-new');
            if (isMobile) {
                cadreNew.classList.add('cadre-new-list');
            } else {
                cadreNew.classList.remove('cadre-new-list');
            }
        }

        window.addEventListener('resize', adjustLayout);
        window.addEventListener('load', adjustLayout);
    </script>
</body>

</html>