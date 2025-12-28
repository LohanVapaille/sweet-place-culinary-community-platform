<?php
session_start();
require 'config.php';
require 'models/donuts_sweetplace.php';
require 'models/donuts_users.php';

$userId = $_SESSION['id'] ?? 0;

$donutsSweetplace = getDonutsSweetplace($pdo, $userId, 6, true); // 6 random

$donutsUsers = getDonutsUsers($pdo, $userId, 5, true);

// var_dump($donutsUsers);

?>

<!DOCTYPE html>

<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'css/links.php'; ?>
    <title>Sweet Place</title>
</head>

<?php include 'header/header.php'; ?>

<body>
    <div class="welcome">
        <div class="content">
            <h1>L’endroit où la douceur prend forme</h1>



        </div>
    </div>

    <div id="main-content" class="presentation-container">
        <div class="concept">
            <h2>Imagine une compo, on la réalise !</h2>
            <p><span class="logo logodesign">SWEETPLA<span class="rose">C</span>E</span>, c'est un concept remplit de
                gourmandise. Sur cette plateforme tu peux concevoir et partager tes compositions avec les autres, et les
                commander si tu veux les gouter. <br><br>De plus, si une personne commande une de tes compositions,
                tu
                gagneras
                des
                points dans ta cagnotte !</p>
            <a href="creersondonuts.php" class="btn btncta start">Commencer à créer mes compos<span
                    class="onlydesk">itions</span></a>
        </div>
        <img src="https://www.knnidiomas.com.br/_next/image?url=https%3A%2F%2Fwp.knnidiomas.com.br%2Fwp-content%2Fuploads%2F2020%2F06%2Fbagel-vs-donut-qual-a-diferenca-1553710782.png&w=3840&q=75"
            alt="">

        <!-- <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSTDWLZCPNG7dzLIwEJ0fhpkbPgbq6r22dbHQ&s" alt=""> -->

    </div>
    <!-- <img class="degouline" src="images/design/degouline.jpg" alt=""> -->
    <!-- SECTION : compositions populaires -->
    <div class="tendances mt-30">
        <h2>Les compos de la communauté</h2>
        <div class="cards-container">
            <?php foreach ($donutsUsers as $donut): ?>
                <?php include 'views/_donuts_users.php'; ?>
            <?php endforeach; ?>
            <div class="cta-usercommu">
                <h3>Toi aussi, créé ta composition maintenant</h3>
                <a href="creersondonuts.php"><i class='bx bx-plus'></i></a>
            </div>
        </div>
    </div>

    <!-- SECTION : nos donuts (compos Sweet Place) -->
    <div class="tendances nosdonuts mt-30">
        <h2>Les compos Sweet Place</h2>
        <div class="cards-container">
            <?php foreach ($donutsSweetplace as $donut): ?>
                <?php include 'views/_donuts_sweetplace_card.php'; ?>
            <?php endforeach; ?>

        </div>
        <a href="donuts_sweetplace.php" class="btn ctasweetplace"> Voir tout le catalogue
        </a>
    </div>

    <?php include 'footer/footer.php'; ?>

    <script src="js/like.js"></script>
    <script src="js/header.js"></script>


</body>

</html>