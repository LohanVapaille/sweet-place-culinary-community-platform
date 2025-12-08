<?php
session_start();
require 'config.php';
require 'models/stats.php';

// Vérifier param id
if (!isset($_GET['id'])) {
    header('Location: connexion.php');
    exit();
}

$creator_id = (int) $_GET['id'];
$user_id = isset($_SESSION['id']) ? (int) $_SESSION['id'] : 0;

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

$compositions = getCompoByUser($pdo, $creator_id, $user_id);

$likedDonuts = getLikedCompositions($pdo, $creator_id);


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
        <div class="left">
            <img src="<?= !empty($user['photo']) ? htmlspecialchars($user['photo'], ENT_QUOTES) : 'images/design/profil.webp' ?>"
                alt="photo profil">

            <p class="onlyphone"><?= htmlspecialchars($user['login'], ENT_QUOTES) ?></p>
        </div>

        <div class="right">
            <div class="infos">
                <p class='onlydesk'><?= htmlspecialchars($user['login'], ENT_QUOTES) ?></p>
                <p><span class="green">Followers : </span><?= $total_follow ?></p>
                <p><span class="green">Compo : </span><?= count($compositions) ?></p>
                <p><span class="green">Likes obtenus : </span><?= $total_likes ?></p>
            </div>

            <div class="btnprofil">
                <?php if ($user_id === $creator_id): ?>
                    <a href='modifprofil.php' class="btn edit-profile">Modifier le profil</a>
                <?php else: ?>
                    <button class="btn follow subscribe-btn <?= $is_following ? 'following' : '' ?>"
                        data-user="<?= $creator_id ?>">
                        <?= $is_following ? 'Suivit' : "Suivre" ?>
                    </button>
                <?php endif; ?>
                <a href='profil.php?id=<?php echo $creator_id ?>#likeddonuts' class="btn edit-profile">Donuts
                    Enregistrés</a>
            </div>



            <p><?php echo $user['description'] ?></p>
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

    <div class="liked">
        <h2>Donuts Enregistrés</h2>


        <div class="liked-donuts-container" id="likeddonuts">
            <?php foreach ($likedDonuts as $donut): ?>
                <div class="donut-card">
                    <?php if (!empty($donut['image'])): ?>
                        <img src="<?php echo htmlspecialchars($donut['image'], ENT_QUOTES); ?>"
                            alt="<?php echo htmlspecialchars($donut['title'], ENT_QUOTES); ?>">
                    <?php endif; ?>
                    <h3><?php echo htmlspecialchars($donut['title'], ENT_QUOTES); ?></h3>



                </div>
            <?php endforeach; ?>
        </div>

    </div>

    <?php include 'footer/footer.php'; ?>

    <script src='js/subscribe.js'></script>

    <script src="js/like.js"></script>
    <script src="js/header.js"></script>


</body>

</html>