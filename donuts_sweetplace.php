<?php
session_start();
require 'config.php';
$userId = isset($_SESSION['id']) ? (int)$_SESSION['id'] : 0;

$sql2 = "
    SELECT d.id_donuts_de_base,
           d.title,
           d.img,
           d.imgAlt,
           d.description,
           COALESCE(l.likes, 0) AS likes,
           EXISTS(
             SELECT 1 FROM fk_like_base f
             WHERE f.id_donuts_de_base = d.id_donuts_de_base
               AND f.id_users = :userId
           ) AS already_liked
    FROM nos_donuts d
    LEFT JOIN (
        SELECT id_donuts_de_base, COUNT(*) AS likes
        FROM fk_like_base
        GROUP BY id_donuts_de_base
    ) l ON l.id_donuts_de_base = d.id_donuts_de_base
    ORDER BY d.id_donuts_de_base DESC
";

$stmt2 = $pdo->prepare($sql2);
$stmt2->execute([':userId' => $userId]);
$donuts = $stmt2->fetchAll(PDO::FETCH_ASSOC);
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

    <div class="welcome" style="border : none; height: 150px;">
        <div class="content"  style="border : none; height: 100px;" >
            <h1>Nos Donuts SWEET PLACE</h1>
            <p class='slogan'>Parcourir les donuts conçus par nos soins</p>
            
        </div>
    </div>

    <div class="tendances">
        <div class="cards-container">
            <?php foreach ($donuts as $donut): ?>
                <div class="card">
                    <h3><?= htmlspecialchars($donut['title']) ?></h3>
                    <div class="content">
                        <img src="<?= htmlspecialchars($donut['img']) ?>" alt="<?= htmlspecialchars($donut['imgAlt']) ?>">
                        <p class="compo"><?= htmlspecialchars($donut['description']) ?></p>
                    </div>
                    <div class="interaction">
                        <a href="addpanier.php?id=<?= htmlspecialchars($donut['id_donuts_de_base']) ?>" class="btn">Ajouter au panier</a>
                        <div class="like">
                            <i class="bx btnlike <?= $donut['already_liked'] ? 'bxs-heart' : 'bx-heart' ?>"
   data-id="<?= $donut['id_donuts_de_base'] ?>"
   data-source="base"
   data-liked="<?= $donut['already_liked'] ? '1' : '0' ?>"></i>


                            <p class="nb_like"><?= $donut['likes']?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>


    <script src="js/like.js"></script>
</body>

</html>