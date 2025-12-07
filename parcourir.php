<?php

session_start();
require 'config.php';
require 'models/donuts_users.php';

$userId = $_SESSION['id'] ?? 0;

$donuts = getDonutsUsers($pdo, $userId); // TOUS LES DONUTS
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feed</title>
    <?php include 'css/links.php'; ?>

</head>

<body>
    <?php include 'header/header.php'; ?>


    <div class="welcome">
        <div class="content">
            <h1>Les compos de la communauté</h1>
            <p class='slogan'>Parcourez les créateurs et suivez ceux qui vous plaisent le plus !</p>

        </div>
    </div>

    <div class="tendances">
        <div class="cards-container">
            <?php foreach ($donuts as $donut): ?>
                <?php include 'views/_donuts_users.php'; ?>
            <?php endforeach; ?>
        </div>
    </div>



    <script src="js/like.js"></script>
    <script src="js/header.js"></script>

</body>

</html>