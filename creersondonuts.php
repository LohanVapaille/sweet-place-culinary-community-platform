<?php
session_start();
require 'config.php';


$creator_id = isset($_SESSION['id']) ? (int) $_SESSION['id'] : null;

// Messages
$success = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Nettoyage / récupération des champs POST
    $type = $_POST['sucresale'];
    $donut_name = trim($_POST['name'] ?? '');
    $id_beignet = !empty($_POST['beignet']) ? (int) $_POST['beignet'] : null;
    $id_fourrage = !empty($_POST['fourrage']) ? (int) $_POST['fourrage'] : null;
    $id_glacage = !empty($_POST['glacage']) ? (int) $_POST['glacage'] : null;
    $id_topping = !empty($_POST['topping']) ? (int) $_POST['topping'] : null;
    $image_url = trim($_POST['image'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if ($creator_id === null) {
        $error = "Vous devez être connecté pour créer un donut.";
    } else {
        try {


            // Prépare la requête d'insertion
            // J'utilise la table "compositions" et les champs que tu as fournis.
            $sql = "INSERT INTO compositions_donuts
                (donut_name, id_beignet, id_fourrage, id_glacage, id_topping, id_createur, description, type)
                VALUES (:donut_name, :id_beignet, :id_fourrage, :id_glacage, :id_topping, :id_createur, :description, :type)";

            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':donut_name', $donut_name, PDO::PARAM_STR);
            $stmt->bindValue(':id_beignet', $id_beignet, $id_beignet === null ? PDO::PARAM_NULL : PDO::PARAM_INT);
            $stmt->bindValue(':id_fourrage', $id_fourrage, $id_fourrage === null ? PDO::PARAM_NULL : PDO::PARAM_INT);
            $stmt->bindValue(':id_glacage', $id_glacage, $id_glacage === null ? PDO::PARAM_NULL : PDO::PARAM_INT);
            $stmt->bindValue(':id_topping', $id_topping, $id_topping === null ? PDO::PARAM_NULL : PDO::PARAM_INT);
            $stmt->bindValue(':id_createur', $creator_id, PDO::PARAM_INT);
            $stmt->bindValue(':description', $description !== '' ? $description : null, $description !== '' ? PDO::PARAM_STR : PDO::PARAM_NULL);
            $stmt->bindValue(':type', $type !== '' ? $type : null, $type !== '' ? PDO::PARAM_STR : PDO::PARAM_NULL);

            $stmt->execute();

            $success = "Composition ajoutée avec succès ! ";
            header("Location: profil.php?id=" . $_SESSION['id']);
            exit();


        } catch (PDOException $e) {
            $error = "Erreur lors de l'ajout : " . $e->getMessage();
        }
    }
}


// ------------- Récupération des listes pour les selects -------------

// Remplace les noms de tables si nécessaire
$beignets_stmt = $pdo->query("SELECT id_beignet AS id, name_beignet AS label, img_beignets AS img FROM beignets");
$fourrages_stmt = $pdo->query("SELECT id_fourrage AS id, name_fourrage AS label, img_fourrage AS img FROM fourrages");
$glacages_stmt = $pdo->query("SELECT id_glacage AS id, name_glacage AS label, img_glacage AS img FROM glacages");
$toppings_stmt = $pdo->query("SELECT id_topping AS id, name_topping AS label, img_topping AS img FROM topping");



$beignets = $beignets_stmt->fetchAll(PDO::FETCH_ASSOC);
$fourrages = $fourrages_stmt->fetchAll(PDO::FETCH_ASSOC);
$glacages = $glacages_stmt->fetchAll(PDO::FETCH_ASSOC);
$toppings = $toppings_stmt->fetchAll(PDO::FETCH_ASSOC);



?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer mon donuts</title>
    <?php include 'css/links.php'; ?>
    <link rel="stylesheet" href="css/creer.css">
</head>

<body>
    <?php include 'header/header.php'; ?>

    <div class="creer">
        <h1>Créer / Publier un donuts</h1>

        <?php if (!empty($success)): ?>
            <div class="alert success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="alert error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <p class='connect'>
            Vous êtes connecté en tant que
            <?php echo isset($_SESSION['login']) ? htmlspecialchars($_SESSION['login']) : 'Invité'; ?>
        </p>


        <div class="img-consutructor">
            <img src="images/constructor/donuts/beignet test.svg" alt="">
            <img src="images/constructor/donuts/fourrage test.svg" alt="">
            <img src="images/constructor/donuts/glaçage test.svg" alt="">
            <img src="images/constructor/donuts/toppings test.svg" alt="">
        </div>

        <div class="img-consutructor2">
            <img src="images/constructor/bagel/bagel test.svg" alt="">
            <img src="images/constructor/bagel/bagel fourrage test.svg" alt="">
            <img src="images/constructor/bagel/bagel glaçage test.svg" alt="">
            <img src="images/constructor/bagel/bagel topping test.svg" alt="">
        </div>




        <main>
            <div class="content">

                <!-- Si tu veux permettre l'upload de fichiers, ajoute enctype="multipart/form-data" -->
                <form method="POST" action="">
                    <div class="row">
                        <div class="input-object">
                            <div class="label-el">
                                <label for="sucresale">Choisir le type</label>
                                <select name="sucresale" id="sucresale">
                                    <option value="sucré" data-img="images/food/types/sucre.svg">Sucré</option>
                                    <option value="salé" data-img="images/food/types/sel.svg">Salé</option>
                                    <option value="les2" data-img="images/food/types/les2.svg">Les 2 (sucré & salé)
                                    </option>
                                </select>
                            </div>
                            <div class="fusion">
                                <img id="img-type" src="" alt="Type">
                                <p>Type de donuts : <span id='name-type'>Sucré</span></p>
                            </div>
                        </div>
                        <div class="input-object">
                            <div class="label-el">
                                <label for="beignet">Choisir un beignet</label>
                                <select name="beignet" id="beignet">

                                    <?php foreach ($beignets as $b): ?>
                                        <option value="<?= (int) $b['id'] ?>" data-img="<?= htmlspecialchars($b['img']) ?>"
                                            <?= (isset($_POST['beignet']) && $_POST['beignet'] == $b['id']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($b['label']) ?>
                                        </option>
                                    <?php endforeach; ?>

                                </select>
                            </div>
                            <div class="fusion">
                                <img id="img-beignet" src="images/food/beignets/nature.svg" alt="Beignet">
                                <p>Beignet : <span id='name-beignet'>Pas séléctionné</span></p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-object">
                            <div class="label-el">
                                <label for="fourrage">Choisir un fourrage</label>
                                <select name="fourrage" id="fourrage">
                                    <option value="">Séléctionne un fourrage</option>
                                    <?php foreach ($fourrages as $f): ?>
                                        <option value="<?= (int) $f['id'] ?>" data-img="<?= htmlspecialchars($f['img']) ?>"
                                            <?= (isset($_POST['fourrage']) && $_POST['fourrage'] == $f['id']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($f['label']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="fusion">
                                <img id="img-fourrage" src="images/food/fourrage/chocolat.svg" alt="Fourrage">
                                <p>Fourrage : <span id='name-fourrage'>Pas séléctionné</span></p>
                            </div>
                        </div>
                        <div class="input-object">
                            <div class="label-el">
                                <label for="glacage">Choisir un glaçage</label>
                                <select name="glacage" id="glacage">
                                    <option value="">Séléctionne un glaçage</option>
                                    <?php foreach ($glacages as $g): ?>
                                        <option value="<?= (int) $g['id'] ?>" data-img="<?= htmlspecialchars($g['img']) ?>"
                                            <?= (isset($_POST['glacage']) && $_POST['glacage'] == $g['id']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($g['label']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="fusion">
                                <img class='imgbig' id="img-glacage" src="images/food/glacages/chocolat.svg"
                                    alt="Glacage">
                                <p>Glaçage : <span id='name-glacage'>Pas séléctionné</span></p>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="input-object">
                            <div class="label-el">
                                <label for="topping">Choisir un topping</label>
                                <select name="topping" id="topping">
                                    <option value="">Séléctionne un topping</option>
                                    <?php foreach ($toppings as $t): ?>
                                        <option value="<?= (int) $t['id'] ?>" data-img="<?= htmlspecialchars($t['img']) ?>"
                                            <?= (isset($_POST['topping']) && $_POST['topping'] == $t['id']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($t['label']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="fusion">
                                <img id="img-topping" src="images/food/topping/m&m.svg" alt="Topping">
                                <p>Topping : <span id='name-topping'>Pas séléctionné</span></p>
                            </div>
                        </div>
                        <div class="input-object">
                            <div class="label-el">
                                <label for="taille">Choisir une taille</label>
                                <select name="taille" id="taille">
                                    <option value="">Séléctionne une taille</option>
                                    <option value="normal">Normal</option>
                                    <option value="big">Gros</option>
                                    <option value="mini">Mini</option>


                                </select>
                            </div>
                        </div>


                    </div>

                    <br><br>
                    <label for="name">Choisir un nom</label>
                    <input class="alone" id="name" name="name" type="text"
                        value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>">

                    <label for="description">Décrit ton beignet</label>
                    <textarea class="alone" id="description" name="description" type="text"
                        value="<?= isset($_POST['description']) ? htmlspecialchars($_POST['description']) : '' ?>"></textarea>



                    <input class="btn" type="submit" value="Ajouter">
                </form>
            </div>
        </main>
    </div>


</body>
<script src="js/constructionDonuts.js"></script>
<script src="js/header.js"></script>

</html>