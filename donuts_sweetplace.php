<?php
session_start();
require 'config.php';
require 'models/donuts_sweetplace.php';

$userId = $_SESSION['id'] ?? 0;

$donuts = getDonutsSweetplace($pdo, $userId); // TOUS LES DONUTS

?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'css/links.php'; ?>
    <title>Donuts Sweet Place</title>

</head>

<?php include 'header/header.php'; ?>

<body>

    <div class="welcome">
        <div class="content">
            <h1>Nos Donuts SWEET PLACE</h1>
            <p class='slogan'>Parcourir les donuts conçus par nos soins</p>

        </div>
    </div>
    <img class="degouline " src="images/design/degouline.jpg" alt="">

    <div class="tendances">
        <div class="cards-container">
            <?php foreach ($donuts as $donut): ?>
                <?php include 'views/_donuts_sweetplace_card.php'; ?>
            <?php endforeach; ?>

        </div>
    </div>


    <script src="js/like.js"></script>
    <script src="js/header.js"></script>
</body>

</html>