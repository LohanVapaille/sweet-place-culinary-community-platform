<?php 

session_start();
require 'config.php'; // $pdo

// id user (si non connecté => 0)
$userId = isset($_SESSION['id']) ? (int)$_SESSION['id'] : 0;

$sql = "
    SELECT c.id_composition,
           c.donut_name,
           c.image,
           c.description,
           u.id_user AS creator_id,
           u.login AS creator_name,
           COALESCE(l.likes, 0) AS likes,
           -- already_liked: 1 si l'utilisateur actuel a liké, 0 sinon
           EXISTS(
             SELECT 1 FROM fk_like f
             WHERE f.id_compositions_donuts = c.id_composition
               AND f.id_users = :userId
           ) AS already_liked
    FROM compositions_donuts c
    JOIN users u ON c.id_createur = u.id_user
    LEFT JOIN (
        SELECT id_compositions_donuts, COUNT(*) AS likes
        FROM fk_like
        GROUP BY id_compositions_donuts
    ) l ON l.id_compositions_donuts = c.id_composition
    ORDER BY c.id_composition DESC
";

$stmt = $pdo->prepare($sql);
$stmt->execute([':userId' => $userId]);
$donuts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feed</title>
    <?php include 'css/links.php'; ?>
    <style>

        .creator{

            text-decoration: none;
            color: #660505;
        }
        .creator:hover{

            text-decoration: underline;
        }
    </style>
</head>
<body>
    <?php include 'header/header.php'; ?>


        <div class="welcome" style="border : none; height: 150px;">
        <div class="content"  style="border : none; height: 100px;" >
            <h1>Les compos de la communauté</h1>
            <p class='slogan'>Parcourez les créateurs et suivez ceux qui vous plaisent le plus !</p>
            
        </div>
    </div>

    <div class="tendances">
        <div class="cards-container">
            <?php foreach ($donuts as $donut): ?>
                <div class="card">

                    <!-- Titre -->
                    <h3><?= htmlspecialchars($donut['donut_name']) ?></h3>

                    <div class="content">
                        <!-- Image -->
                        <?php if (!empty($donut['image'])): ?>
    <img src="<?= htmlspecialchars($donut['image']) ?>" 
         alt="<?= htmlspecialchars($donut['donut_name']) ?>">
<?php endif; ?>


                        <!-- Description -->
                        <p class="compo"><?= htmlspecialchars($donut['description']) ?></p>
                    </div>

                    <div class="interaction">
                        <!-- Bouton panier -->
                        <a href="addpanier.php?id=<?= $donut['id_composition'] ?>" class="btn">
                            Ajouter au panier
                        </a>

                        <!-- Zone "like" statique -->
                        <div class="like">
                            <i class="btnlike bx <?= $donut['already_liked'] ? 'bxs-heart' : 'bx-heart' ?>"
   data-id="<?= $donut['id_composition'] ?>"
   data-liked="<?= $donut['already_liked'] ? '1' : '0' ?>"></i>


                            <p class="nb_like"><?= $donut['likes'] ?></p>

                            <!-- Lien vers le créateur -->
                            
                        </div></div>

                        <a class='creator' href="profil.php?id=<?= $donut['creator_id'] ?>">par 
                                <?= htmlspecialchars($donut['creator_name']) ?>
                            </a>
                    </div>

                
            <?php endforeach; ?>
        </div>
    </div>

    <script src="js/like.js"></script>

</body>
</html>
