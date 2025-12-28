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

    <div id="main-content" class="filter-container">
        <div>
            <select id="filterType">
                <option value="all">Types</option>
                <option value="sucré">Sucré</option>
                <option value="salé">Salé</option>
            </select>

            <select id="filterPrice">
                <option value="default">Prix </option>
                <option value="priceAsc">Compo à - de 4€</option>
                <option value="priceDesc">Compo à 4€</option>
            </select>

            <select id="filterLikes">
                <option value="default">Popularité</option>
                <option value="likesDesc">Plus populaires</option>
                <option value="likesAsc">Moins poulaires</option>
            </select>
        </div>

        <div>
            <select id="filterNote">
                <option value="default">Notes</option>
                <option value="noteDesc">Les mieux noté</option>
                <option value="noteAsc">Les moins bien noté</option>
            </select>

            <select id="filterName">
                <option value="default">Nom</option>
                <option value="nameAsc">A → Z</option>
                <option value="nameDesc">Z → A</option>
            </select>
        </div>
    </div>




    <div class="tendances">
        <div class="cards-container">
            <?php foreach ($donuts as $donut): ?>
                <?php include 'views/_donuts_users.php'; ?>
            <?php endforeach; ?>
        </div>
    </div>


    <?php include 'footer/footer.php'; ?>

    <script src="js/like.js"></script>
    <script src="js/header.js"></script>
    <script src="js/filtresDonutsUser.js"></script>

</body>

</html>