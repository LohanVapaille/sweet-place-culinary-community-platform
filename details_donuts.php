<?php

session_start();
require 'config.php'; // doit définir $pdo (PDO)
require 'models/detail_donuts.php';

$id_donuts = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$info = getInfoDonutsById($pdo, $id_donuts);

if ($info === null) {
    // gérer l'erreur / affichage
    echo "Aucun donuts trouvé pour l'id : " . htmlspecialchars($id_donuts);
    exit;
}

// Exemple : afficher certaines infos
if ($info['type'] === 'composition') {
    $comp = $info['data']['composition'];
    $comments = $info['data']['comments'];


} else {
    $comp = $info['data']['base'];


}

$nb_like = $info['data']['likes_count'];

// var_dump($comp, $nb_like, $comment);
// var_dump($comp, $nb_like, $comments);
// var_dump($_SESSION);


$bannerImage = 'https://cestmondonuts.fr/wp-content/uploads/2023/03/01_18_2022-Cest-Mon-Donuts2030-scaled.jpg';

if ($info['type'] === 'composition' && $comp['composition_type'] === 'sucré') {
    $bannerImage = 'https://www.marketresearchintellect.com/images/blogs/best-doughnut-brands.webp';
} elseif ($info['type'] === 'composition' && $comp['composition_type'] === 'salé') {
    $bannerImage = 'https://www.harrisscarfe.com.au/medias/bagel-topping-recipes-ideas-1.jpg?context=bWFzdGVyfHJvb3R8NDA2MzA0fGltYWdlL2pwZWd8cm9vdC9oM2YvaGY3LzE1NTcyNDk1Nzk0MjA2L2JhZ2VsLXRvcHBpbmctcmVjaXBlcy1pZGVhcy0xLmpwZ3w4MTk5OGI0ZjFhY2U0ZjE4YzEwYzBhMGI4ZjU5ODhmMjk0YmYzMWI1NTMzYTZhN2QyOTFkMDk3NTk1Mjc0Mzk3';
}


?>


<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Détails</title>
    <?php include 'css/links.php'; ?>
    <link rel="stylesheet" href="css/detail.css">
</head>

<body>
    <?php include 'header/header.php'; ?>

    <main>
        <!-- si le donuts est un donuts de base -->
        <?php if ($info['type'] === 'base'): ?>
            <div class="banner" style="background-image: url('<?php echo $bannerImage ?>');">
                <h1>
                    <?php echo $comp['title']; ?>
                </h1>
            </div>




            <div class="base-content base-contentsweetplace">
                <div class="base-left base-leftsweetplace">
                    <img src="<?php echo $comp['img'] ?>" alt="">
                    <p>Proposé par SweetPlace</p>

                </div>

                <div class="base-compo-container">
                    <h2>
                        <?php echo $comp['title']; ?>
                    </h2>
                    <?php echo $comp['description']; ?>
                    <p><?php echo $nb_like; ?> autres personnes ont likés ce produits</p>

                    <div class="btn-container">

                    </div>

                </div>

            <?php endif; ?>

        </div>




        <!-- si le donuts est un donuts compositions -->
        <?php if ($info['type'] === 'composition'): ?>
            <div class="banner" style="background-image: url('<?php echo $bannerImage; ?>');">
                <h1><?php echo htmlspecialchars($comp['donut_name']); ?></h1>
            </div>





            <div class="base-content">
                <div class="base-left">
                    <div class="img-container">
                        <img src="./<?= $comp['img_beignets'] ?>" alt="">

                        <?php if (!empty($comp['img_fourrage'])): ?>
                            <img src="./<?= $comp['img_fourrage'] ?>" alt="">
                        <?php endif; ?>

                        <?php if (!empty($comp['img_glacage'])): ?>
                            <img src="./<?= $comp['img_glacage'] ?>" alt="">
                        <?php endif; ?>

                        <?php if (!empty($comp['img_topping'])): ?>
                            <img src="./<?= $comp['img_topping'] ?>" alt="">
                        <?php endif; ?>
                    </div>

                    <div class="info">
                        <p><?php if (!empty($comp['name_fourrage'])): ?>
                                <?= $comp['name_fourrage'] ?>
                            <?php endif; ?>
                        </p>

                        <p><?php if (!empty($comp['name_glacage'])): ?>
                                <?= $comp['name_glacage'] ?>
                            <?php endif; ?>
                        </p>

                        <p><?php if (!empty($comp['name_topping'])): ?>
                                <?= $comp['name_topping'] ?>
                            <?php endif; ?>
                        </p>
                    </div>

                    <p>Proposé par <a class="green"
                            href="profil.php?id=<?php echo $comp['creator_id'] ?>"><?php echo $comp['creator_login'] ?></a>
                    </p>

                </div>

                <div class=" base-compo-container">

                    <div class="top">
                        <a class="btn back" href="parcourir.php"> <i class='bx bx-arrow-back'></i>Retour</a>
                        <p class=" nblike"><?php echo $nb_like; ?> autres personnes ont likés ce produits</p>

                        <a href="addpanier?id=<?php echo $comp['id_composition'] ?>" class="btn">Ajouter au panier</a>
                    </div>
                    <h2>
                        <?php echo $comp['donut_name']; ?>
                    </h2>
                    <?php echo $comp['description']; ?>


                    <div class="btn-container">

                    </div>
                    <div class="addcomment-container">
                        <?php if (!empty($_SESSION['id'])): ?>
                            <form action="addcomment.php" method="post">
                                <input type="hidden" name="id_donuts" value="<?php echo (int) $id_donuts; ?>">

                                <label for="addComment">Qu'en as-tu pensé ?</label><br>
                                <textarea id="addComment" name="comment_text" rows="4" maxlength="100" required></textarea><br>

                                <label for="rating">Note :</label>
                                <div class="star-rating" id="star-rating">
                                    <i class='bx bx-star' data-value="1"></i>
                                    <i class='bx bx-star' data-value="2"></i>
                                    <i class='bx bx-star' data-value="3"></i>
                                    <i class='bx bx-star' data-value="4"></i>
                                    <i class='bx bx-star' data-value="5"></i>
                                </div>
                                <input type="hidden" name="note" id="note" required>


                                <input class="btn" type="submit" value="Poster"></input>
                            </form>
                        <?php else: ?>
                            <p>Tu dois être connecté pour poster un commentaire. <a href="connexion.php">Se
                                    connecter</a></p>
                        <?php endif; ?>
                    </div>

                </div>

            <?php endif; ?>


    </main>

    <?php if ($info['type'] === 'composition'): ?>
        <?php if (!$comments): ?>
            <div style="display: flex;">
                <p class="rienpourlemoment">Aucun commentaire pour ce donut.</p>
            </div>
        <?php else: ?>
            <div class="bottom">
                <h2>Les avis sur <?php echo htmlspecialchars($comp['donut_name']); ?> </h2>
                <div class="commentcontainer">

                    <?php foreach ($comments as $c):
                        // Récupération infos auteur
                        $user = htmlspecialchars($c['auteur']['login'] ?? 'Anonyme');
                        $photo = !empty($c['auteur']['photo']) ? $c['auteur']['photo'] : 'images/design/profil.webp';
                        $text = nl2br(htmlspecialchars($c['texte']));
                        $note = (int) $c['note'];
                        $date = htmlspecialchars($c['date_readable'] ?? date('d/m/Y', (int) $c['date']));

                        ?>
                        <div class="comment">
                            <div class="comment-header">
                                <img class="comment-avatar" src="<?= $photo ?>" alt="Avatar de <?= $user ?>">
                                <div class="comment-meta">
                                    <strong><?= $user ?></strong>
                                    <div class="comment-stars">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <?php if ($i <= $note): ?>
                                                <i class='bx bxs-star'></i>
                                            <?php else: ?>
                                                <i class='bx bx-star'></i>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                    </div>
                                    <small><?= $date ?></small>
                                </div>
                            </div>
                            <div class="comment-text"><?= $text ?></div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>

    <?php include 'footer/footer.php'; ?>
    <script src="js/header.js"></script>

    <script>const stars = document.querySelectorAll('#star-rating i');
        const noteInput = document.getElementById('note');

        stars.forEach(star => {
            star.addEventListener('click', () => {
                const value = parseInt(star.dataset.value);
                noteInput.value = value; // mettre à jour le input hidden

                // remplir les étoiles
                stars.forEach(s => {
                    if (parseInt(s.dataset.value) <= value) {
                        s.classList.remove('bx-star');
                        s.classList.add('bxs-star'); // étoile pleine
                    } else {
                        s.classList.remove('bxs-star');
                        s.classList.add('bx-star'); // étoile vide
                    }
                });
            });

            // effet hover
            star.addEventListener('mouseenter', () => {
                const value = parseInt(star.dataset.value);
                stars.forEach(s => {
                    if (parseInt(s.dataset.value) <= value) {
                        s.classList.add('hovered');
                    } else {
                        s.classList.remove('hovered');
                    }
                });
            });

            star.addEventListener('mouseleave', () => {
                stars.forEach(s => s.classList.remove('hovered'));
            });
        });
    </script>

</body>

</html>