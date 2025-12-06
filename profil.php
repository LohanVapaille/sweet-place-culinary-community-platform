<?php
session_start();
require 'config.php'; // doit définir $pdo (instance PDO)
require 'models/stats.php';    // la fonction getTotalLikesForUser

// Vérifier param id
if (!isset($_GET['id'])) {
    header('Location: connexion.php');
    exit();
}

$creator_id = (int) $_GET['id'];
$user_id = isset($_SESSION['id']) ? (int) $_SESSION['id'] : null;

// Récupérer les infos de l'utilisateur (UNE seule requête)
$user = getInfosUser($pdo, $creator_id);

$total_follow = getTotalFollowers($pdo, $creator_id);

$total_likes = getTotalLikesForUser($pdo, $creator_id);

// Si utilisateur inconnu -> 404 simple / redirection
if (!$user) {
    header('HTTP/1.0 404 Not Found');
    echo "Profil introuvable.";
    exit;
}

// Vérifier si l'utilisateur connecté suit déjà ce profil
$is_following = false;
if ($user_id && $user_id !== $creator_id) {
    $stmt_follow = $pdo->prepare("SELECT COUNT(*) FROM fk_follow WHERE id_user_suivit = ? AND id_user_qui_follow = ?");
    $stmt_follow->execute([$creator_id, $user_id]);
    $is_following = (int) $stmt_follow->fetchColumn() > 0;
}

// Récupérer les compositions de donuts créées par l'utilisateur
// On ajoute : nb_likes (déjà présent) et already_liked (pour l'utilisateur connecté)
$sql_compo = "
    SELECT c.*, b.name_beignet, f.name_fourrage, g.name_glacage, t.name_topping,
           (SELECT COUNT(*) FROM fk_like l WHERE l.id_compositions_donuts = c.id_composition) AS nb_likes,
           EXISTS(
             SELECT 1 FROM fk_like l2
             WHERE l2.id_compositions_donuts = c.id_composition
               AND l2.id_users = :currentUser
           ) AS already_liked
    FROM compositions_donuts c
    LEFT JOIN beignets b ON c.id_beignet = b.id_beignet
    LEFT JOIN fourrages f ON c.id_fourrage = f.id_fourrage
    LEFT JOIN glacages g ON c.id_glacage = g.id_glacage
    LEFT JOIN topping t ON c.id_topping = t.id_topping
    WHERE c.id_createur = :creator
    ORDER BY c.id_composition DESC
";
$stmt_compo = $pdo->prepare($sql_compo);
$stmt_compo->execute([':currentUser' => $user_id ?? 0, ':creator' => $creator_id]);
$compositions = $stmt_compo->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>

<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil de <?= htmlspecialchars($user['login'], ENT_QUOTES) ?></title>
    <?php include 'css/links.php'; ?>
    <link rel="stylesheet" href="css/profil.css">
</head>

<body>
    <?php include 'header/header.php'; ?>


    <div class="infoprofil">
        <img src="images/design/profil.webp" alt="photo profil">

        <div class="right">
            <div class="infos">
                <p><?= htmlspecialchars($user['login'], ENT_QUOTES) ?></p>
                <p>Followers : <?= $total_follow ?></p>
                <p>Compo : <?= count($compositions) ?></p>
                <p>Likes : <?= $total_likes ?></p>
            </div>

            <div class="btnprofil">
                <?php if ($user_id === $creator_id): ?>
                    <button class="btn edit-profile">Modifier le profil</button>
                <?php else: ?>
                    <button class="btn follow subscribe-btn <?= $is_following ? 'following' : '' ?>"
                        data-user="<?= $creator_id ?>">
                        <?= $is_following ? 'Suivit' : "Suivre" ?>
                    </button>
                <?php endif; ?>
            </div>

            <p>Salut les zouzous, j’espère que mes donuts vous plairont, n’hésitez pas à vous abonner</p>
        </div>
    </div>

    <div class='tendances'>
        <h2>Compositions de <?= htmlspecialchars($user['login'], ENT_QUOTES) ?></h2>

        <?php if (!empty($compositions)): ?>
            <div class="cards-container">
                <?php foreach ($compositions as $c): ?>
                    <?php
                    // sécurité: normaliser les valeurs attendues
                    $already = !empty($c['already_liked']) ? 1 : 0;
                    $nbLikes = isset($c['nb_likes']) ? (int) $c['nb_likes'] : 0;
                    $compId = isset($c['id_composition']) ? (int) $c['id_composition'] : 0;
                    ?>
                    <div class="card">
                        <h3><?= htmlspecialchars($c['donut_name'], ENT_QUOTES) ?>
                            <?= $c['type'] ? '(' . htmlspecialchars($c['type'], ENT_QUOTES) . ')' : '' ?>
                        </h3>

                        <?php if (!empty($c['image']) || !empty($c['description'])): ?>
                            <div class="content">
                                <?php if (!empty($c['image'])): ?>
                                    <img src="<?= htmlspecialchars($c['image'], ENT_QUOTES) ?>"
                                        alt="<?= htmlspecialchars($c['donut_name'], ENT_QUOTES) ?>">
                                <?php endif; ?>

                                <?php if (!empty($c['description'])): ?>
                                    <p class="compo"><?= nl2br(htmlspecialchars($c['description'], ENT_QUOTES)) ?></p>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <div class="interaction">
                            <a href="addpanier.php?id=<?= $compId ?>" class="btn">Ajouter au panier</a>

                            <div class="like">
                                <!-- i correctement rempli : data-id, data-liked et classe initiale -->
                                <i class="btnlike bx <?= $already ? 'bxs-heart' : 'bx-heart' ?>" data-id="<?= $compId ?>"
                                    data-source="composition" data-liked="<?= $already ? '1' : '0' ?>"></i>
                                <p class="nb_like"><?= $nbLikes ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Aucune composition pour le moment.</p>
        <?php endif; ?>
    </div>

    <script src='js/subscribe.js'></script>

    <script src="js/like.js"></script>
    <script src="js/header.js"></script>


</body>

</html>