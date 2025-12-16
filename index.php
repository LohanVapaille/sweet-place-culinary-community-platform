<?php
session_start();
require 'config.php';
require 'models/donuts_sweetplace.php';
require 'models/donuts_users.php';

$userId = $_SESSION['id'] ?? 0;

$donutsSweetplace = getDonutsSweetplace($pdo, $userId, 6, true); // 6 random

$donutsUsers = getDonutsUsers($pdo, $userId, 6, true);

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

            <a href="creersondonuts.php" class="btncta">Publie ta compo préférée</a>

        </div>
    </div>
    <!-- <img class="degouline" src="images/design/degouline.jpg" alt=""> -->
    <!-- SECTION : compositions populaires -->
    <div class="tendances">
        <h2>Les plus populaires</h2>
        <div class="cards-container">
            <?php foreach ($donutsUsers as $donut): ?>
                <?php include 'views/_donuts_users.php'; ?>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- SECTION : nos donuts (compos Sweet Place) -->
    <div class="tendances nosdonuts">
        <h2>Les compos Sweet Place</h2>
        <div class="cards-container">
            <?php foreach ($donutsSweetplace as $donut): ?>
                <?php include 'views/_donuts_sweetplace_card.php'; ?>
            <?php endforeach; ?>

        </div>
    </div>

    <?php include 'footer/footer.php'; ?>

    <script src="js/like.js"></script>
    <script src="js/header.js"></script>


</body>

</html>