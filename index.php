<?php
// page d'accueil avec deux tableaux : compositions populaires + nos_donuts
session_start();
require 'config.php'; // doit définir $pdo (PDO instance)

$userId = isset($_SESSION['id']) ? (int)$_SESSION['id'] : 0;

// 1) Récupérer les compositions populaires (avec auteur, likes, already_liked)
$sql_compo = "
    SELECT c.id_composition,
           c.donut_name,
           c.image,
           c.description,
           u.id_user AS creator_id,
           u.login AS creator_name,
           COALESCE(l.likes, 0) AS likes,
           EXISTS(
             SELECT 1 FROM fk_like f WHERE f.id_compositions_donuts = c.id_composition AND f.id_users = :userId
           ) AS already_liked
    FROM compositions_donuts c
    JOIN users u ON c.id_createur = u.id_user
    LEFT JOIN (
        SELECT id_compositions_donuts, COUNT(*) AS likes
        FROM fk_like
        GROUP BY id_compositions_donuts
    ) l ON l.id_compositions_donuts = c.id_composition
    ORDER BY likes DESC, c.id_composition DESC
    LIMIT 6
";

$stmt = $pdo->prepare($sql_compo);
$stmt->execute([':userId' => $userId]);
$popularCompositions = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 2) Récupérer les nos_donuts (avec likes et already_liked)
// On garde un affichage aléatoire limité à 6 (comme tu avais)
$sql_base = "
    SELECT d.id_donuts_de_base,
           d.title,
           d.img,
           d.imgAlt,
           d.description,
           d.url,
           COALESCE(lb.likes, 0) AS likes,
           EXISTS(
             SELECT 1 FROM fk_like_base fb WHERE fb.id_donuts_de_base = d.id_donuts_de_base AND fb.id_users = :userId
           ) AS already_liked
    FROM nos_donuts d
    LEFT JOIN (
        SELECT id_donuts_de_base, COUNT(*) AS likes
        FROM fk_like_base
        GROUP BY id_donuts_de_base
    ) lb ON lb.id_donuts_de_base = d.id_donuts_de_base
    ORDER BY RAND()
    LIMIT 6
";

$stmt2 = $pdo->prepare($sql_base);
$stmt2->execute([':userId' => $userId]);
$donuts = $stmt2->fetchAll(PDO::FETCH_ASSOC);
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
        <h1>BIENVENUE SUR SWEET PLACE</h1>
        <p class='slogan'>L’endroit où la douceur prend forme</p>
        <a href="creersondonuts.php" class="btncta">Publie ta compo préférée</a>
        <p class="phrase_accroche">Découvre les compositions les plus folles faites par les créateurs, tu peux aussi
            publier les tiennes sur ton profil </p>
    </div>
</div>

<!-- SECTION : compositions populaires -->
<div class="tendances">
    <h2>Les plus populaires</h2>
    <div class="cards-container">
        <?php if (!empty($popularCompositions)): ?>
            <?php foreach ($popularCompositions as $comp): ?>
                <?php
                    $compId = (int)($comp['id_composition'] ?? 0);
                    $likes = isset($comp['likes']) ? (int)$comp['likes'] : 0;
                    $already = !empty($comp['already_liked']) ? 1 : 0;
                ?>
                <div class="card">
                    <h3><?= htmlspecialchars($comp['donut_name'] ?? 'Sans titre') ?></h3>
                    <div class="content">
                        <?php if (!empty($comp['image'])): ?>
                            <img src="<?= htmlspecialchars($comp['image']) ?>" alt="<?= htmlspecialchars($comp['donut_name']) ?>">
                        <?php endif; ?>
                        <?php if (!empty($comp['description'])): ?>
                            <p class="compo"><?= nl2br(htmlspecialchars($comp['description'])) ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="interaction">
                        <a href="addpanier.php?id=<?= $compId ?>" class="btn">Ajouter au panier</a>
                        <div class="like">
                            <i class="btnlike bx <?= $already ? 'bxs-heart' : 'bx-heart' ?>"
                               data-id="<?= $compId ?>"
                               data-source="composition"
                               data-liked="<?= $already ? '1' : '0' ?>"></i>
                            <p class="nb_like"><?= $likes ?></p>
                        </div>
                        <p class="creator">par <a class="creator" href="profil.php?id=<?= (int)($comp['creator_id'] ?? 0) ?>">
                            <?= htmlspecialchars($comp['creator_name'] ?? 'Anonyme') ?></a></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucune composition populaire pour le moment.</p>
        <?php endif; ?>
    </div>
</div>

<!-- SECTION : nos donuts (compos Sweet Place) -->
<div class="tendances nosdonuts">
    <h2>Les compos Sweet Place</h2>
    <div class="cards-container">
        <?php foreach ($donuts as $donut): ?>
            <?php
                $baseId = (int)($donut['id_donuts_de_base'] ?? 0);
                $likes_base = isset($donut['likes']) ? (int)$donut['likes'] : 0;
                $already_base = !empty($donut['already_liked']) ? 1 : 0;
            ?>
            <div class="card">
                <h3><?= htmlspecialchars($donut['title'] ?? 'Sans titre') ?></h3>
                <div class="content">
                    <?php if (!empty($donut['img'])): ?>
                        <img src="<?= htmlspecialchars($donut['img']) ?>" alt="<?= htmlspecialchars($donut['imgAlt'] ?? '') ?>">
                    <?php endif; ?>
                    <?php if (!empty($donut['description'])): ?>
                        <p class="compo"><?= nl2br(htmlspecialchars($donut['description'])) ?></p>
                    <?php endif; ?>
                </div>
                <div class="interaction">
                    <a href="<?= htmlspecialchars($donut['url'] ?? '#') ?>" class="btn">Ajouter au panier</a>
                    <div class="like">
                        <i class="btnlike bx <?= $already_base ? 'bxs-heart' : 'bx-heart' ?>"
                           data-id="<?= $baseId ?>"
                           data-source="base"
                           data-liked="<?= $already_base ? '1' : '0' ?>"></i>
                        <p class="nb_like"><?= $likes_base ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script src="js/like.js"></script>
<script src="js/header.js"></script>


</body>

</html>
