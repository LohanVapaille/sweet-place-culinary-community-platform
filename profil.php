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

// var_dump($likedDonuts);


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

    <main id="main-content">
        <div class="infoprofil">
            <button class="btn back" id="btn-back">
                <i class='bx bx-arrow-back'></i>Retour
            </button>
            <div class="left">
                <img src="<?= !empty($user['photo']) ? htmlspecialchars($user['photo'], ENT_QUOTES) : 'images/design/profil.webp' ?>"
                    alt="photo profil">
            </div>
            <div class="allinfosprofil">
                <p class="pseudo"><?= htmlspecialchars($user['login'], ENT_QUOTES) ?></p>
                <div class="stats">
                    <p><span class="chiffre"><?= count($compositions) ?> </span><span class="ecrit">Compos<span
                                class='onlydesk'>itions</span></span>
                    <p><span class="chiffre"><?= $total_follow ?> </span><span class="ecrit">Followers</span></p>

                    <p><span class="chiffre"><?= $total_likes ?> </span><span class="ecrit">Likes <span
                                class='onlydesk'>Obtenus</span></span></p>
                </div>

                <div class="btnprofil ">
                    <?php if ($user_id === $creator_id): ?>
                        <a href='modifprofil.php' class="btn edit-profile">Modifier le profil</a>
                    <?php else: ?>
                        <button class="btn follow subscribe-btn <?= $is_following ? 'following' : '' ?>"
                            data-user="<?= $creator_id ?>">
                            <?= $is_following ? 'Suivit' : "Suivre" ?>
                        </button>
                    <?php endif; ?>
                    <a href='profil.php?id=<?php echo $creator_id ?>#likeddonuts' class="btn edit-profile">Donuts
                        Likés</a>
                </div>


            </div>
        </div>







        <?php
        // ... (code précédent)
        
        $donuts = getCompoByUser($pdo, $creator_id, $user_id);

        // Déterminer la classe CSS pour la grille
        $grid_class = '';
        if (count($donuts) === 1) {
            // Si une seule carte, on ajoute une classe spécifique
            $grid_class = ' single-item';
        }

        // ... (code suivant)
        ?>

        <div class='tendances '>
            <hr>

            <h2>Compositions de <?= htmlspecialchars($user['login'], ENT_QUOTES) ?></h2>

            <?php if (!empty($compositions)): ?>
                <div class="cards-container profildonuts<?= $grid_class ?>">
                    <?php foreach ($compositions as $donut): ?>
                        <?php
                        include 'views/_donuts_users.php' ?>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="rienpourlemoment">Aucune composition pour le moment.</p>
            <?php endif; ?>
        </div>

        <div class="liked">
            <h2>Donuts Likés</h2>


            <div class="liked-donuts-container" id="likeddonuts">

                <?php if (!empty($likedDonuts)): ?>

                    <?php foreach ($likedDonuts as $donut): ?>

                        <?php if ($donut['source'] === 'base'): ?>

                            <div tabindex='0' class="donut-card base" data-id-donuts="<?= (int) $donut['id'] ?>">
                                <?php if (!empty($donut['img_base'])): ?>
                                    <img src="<?= htmlspecialchars($donut['img_base'], ENT_QUOTES) ?>"
                                        alt="<?= htmlspecialchars($donut['title'], ENT_QUOTES) ?>" class="donut-img-base">
                                <?php endif; ?>

                                <p class="donuts_liked_name">
                                    <?= htmlspecialchars($donut['title'], ENT_QUOTES) ?>
                                </p>
                            </div>

                        <?php elseif ($donut['source'] === 'composition'): ?>

                            <div tabindex='0' class="donut-card compo" data-id-donuts="<?= (int) $donut['id'] ?>">
                                <div class="img-container img-container-liked">
                                    <?php if (!empty($donut['img_beignet'])): ?>
                                        <img src="<?= htmlspecialchars($donut['img_beignet'], ENT_QUOTES) ?>" class="layer beignet">
                                    <?php endif; ?>

                                    <?php if (!empty($donut['img_fourrage'])): ?>
                                        <img src="<?= htmlspecialchars($donut['img_fourrage'], ENT_QUOTES) ?>" class="layer fourrage">
                                    <?php endif; ?>

                                    <?php if (!empty($donut['img_glacage'])): ?>
                                        <img src="<?= htmlspecialchars($donut['img_glacage'], ENT_QUOTES) ?>" class="layer glacage">
                                    <?php endif; ?>

                                    <?php if (!empty($donut['img_topping'])): ?>
                                        <img src="<?= htmlspecialchars($donut['img_topping'], ENT_QUOTES) ?>" class="layer topping">
                                    <?php endif; ?>
                                </div>

                                <p class="donuts_liked_name">
                                    <?= htmlspecialchars($donut['title'], ENT_QUOTES) ?>
                                </p>
                            </div>

                        <?php endif; ?>

                    <?php endforeach; ?>

                <?php else: ?>

                    <p class="rienpourlemoment">Pas encore de donuts enregistrés.</p>

                <?php endif; ?>

            </div>


        </div>
    </main>
    <?php include 'footer/footer.php'; ?>

    <script src='js/subscribe.js'></script>
    <script src="js/back.js"></script>
    <script src="js/like.js"></script>
    <script src="js/header.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {


            document.addEventListener('keydown', (e) => {
                const heart = e.target.closest('.donut-card');
                if (!heart) return;

                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault(); // Empêche scroll avec espace
                    heart.click(); // Déclenche ton handler de clic existant
                }
            });
            document.querySelectorAll('.donut-card').forEach(card => {
                card.addEventListener('click', () => {
                    const id = card.dataset.idDonuts;

                    if (id) {
                        window.location.href = `details_donuts.php?id=${id}`;
                    }
                });
            });
        });
    </script>




</body>

</html>