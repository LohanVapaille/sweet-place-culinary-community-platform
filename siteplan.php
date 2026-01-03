<?php
session_start();
require_once 'config.php';
require_once 'models/detail_donuts.php'; ?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Plan du site</title>
    <?php include 'css/links.php'; ?>
    <link rel="stylesheet" href="css/mentionslegales.css">
</head>

<?php include 'header/header.php' ?>

<body>

    <div class="welcome">
        <div class="content">
            <h1>Plan du site</h1>
        </div>
    </div>
    <main id="main-content">

        <section>



            <div class="footer-column">
                <h3>Plan du site</h3>
                <div class="plan">
                    <ul>
                        <li>Accueil : <a href="index.php">Accueil</a></li>
                        <br>
                        <li>Parcourir les donuts SweetPlace : <a href="donuts_sweetplace.php">Donuts SweetPlace</a>
                        </li><br>
                        <li>Parcourir les créations des autres utilisateurs : <a href="parcourir.php">Parcourir les
                                créations</a></li><br>

                        <li>Créer sa propre compositions de donuts ou bagels : <a href="creersondonuts.php">La
                                Fabrique</a></li><br>
                        <?php if (isset($_SESSION['id'])) {
                            echo "<li>Accéder à mon profil : <a href='profil.php?id=" . $_SESSION['id'] . "'>Mon profil</a></li>";

                        } ?>
                    </ul>
                </div>


            </div>



        </section>











    </main>

    <?php include 'footer/footer.php'; ?>
</body>

</html>