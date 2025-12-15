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

// // var_dump($comp, $nb_like, $comment);
// var_dump($comp, $nb_like, $comments);
// var_dump($_SESSION);

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
            <div class="banner">
                <h1>
                    <?php echo $comp['title']; ?>
                </h1>
            </div>




            <div class="base-content">
                <div class="base-left">
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
            <div class="banner">
                <h1>
                    <?php echo $comp['donut_name']; ?>
                </h1>
            </div>




            <div class="base-content">
                <div class="base-left">

                    <p>Proposé par <?php echo $comp['creator_login'] ?></p>

                </div>

                <div class="base-compo-container">
                    <h2>
                        <?php echo $comp['donut_name']; ?>
                    </h2>
                    <?php echo $comp['description']; ?>
                    <p><?php echo $nb_like; ?> autres personnes ont likés ce produits</p>

                    <div class="btn-container">

                    </div>
                    <div class="comment-container">
                        <?php if (!empty($_SESSION['id'])): ?>
                            <form action="addcomment.php" method="post">
                                <input type="hidden" name="id_donuts" value="<?php echo (int) $id_donuts; ?>">

                                <label for="addComment">Qu'en as-tu pensé ?</label><br>
                                <textarea id="addComment" name="comment_text" rows="4" maxlength="100" required></textarea><br>

                                <label for="rating">Note (1-5) :</label>
                                <select id="rating" name="note" required>
                                    <option value="5">5</option>
                                    <option value="4">4</option>
                                    <option value="3">3</option>
                                    <option value="2">2</option>
                                    <option value="1">1</option>
                                </select><br>

                                <button type="submit">Poster</button>
                            </form>
                        <?php else: ?>
                            <p>Tu dois être connecté pour poster un commentaire. <a href="connexion.php">Se connecter</a></p>
                        <?php endif; ?>
                    </div>
                    <?php if (!$comments) {
                        echo "<p>Aucun commentaire pour ce donut.</p>";
                    } else {
                        foreach ($comments as $c) {
                            $user = htmlspecialchars($c['id_auteur'] ?? 'Anonyme');
                            $text = nl2br(htmlspecialchars($c['texte']));
                            $note = (int) $c['note'];
                            $date = date('d/m/Y H:i', (int) $c['date']);
                            echo "<div class='comment'>
                <div class='meta'><strong>{$user}</strong> — {$note}/5 — <small>{$date}</small></div>
                <div class='text'>{$text}</div>
             </div>";
                        }
                    }
                    ?>
                </div>

            <?php endif; ?>

        </div>
    </main>
    <?php include 'footer/footer.php'; ?>
    <script src="js/header.js"></script>

</body>

</html>