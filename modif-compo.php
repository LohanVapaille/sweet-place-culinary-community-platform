<?php
session_start();
require_once 'config.php';
require_once 'models/detail_donuts.php';

// Sécurité : utilisateur connecté
if (!isset($_SESSION['id'])) {
    header('Location: index.php');
    exit;
}

// Récupération de l'id
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0) {
    header('Location: index.php');
    exit;
}

// Récupération de la compo
$info = getInfoDonutsById($pdo, $id);

// Doit exister ET être une composition
if (!$info || $info['type'] !== 'composition') {
    header('Location: index.php');
    exit;
}

$compo = $info['data']['composition'];

// 4️⃣ Vérification créateur
if ((int) $compo['creator_id'] !== (int) $_SESSION['id']) {
    header('Location: index.php');
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {

    $name = trim($_POST['donut_name'] ?? '');
    $desc = trim($_POST['description'] ?? '');

    if ($name !== '' && $desc !== '') {
        $stmt = $pdo->prepare("
            UPDATE compositions_donuts
            SET donut_name = :name, description = :desc
            WHERE id_composition = :id
        ");
        $stmt->execute([
            ':name' => $name,
            ':desc' => $desc,
            ':id' => $id
        ]);

        header("Location: modif-compo.php?id=" . $id);
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {

    try {
        $pdo->beginTransaction();

        // Supprimer panier
        $stmt = $pdo->prepare("
            DELETE FROM fk_panier
            WHERE id_compositions_donuts = :id
        ");
        $stmt->execute([':id' => $id]);

        // Supprimer likes
        $stmt = $pdo->prepare("
            DELETE FROM fk_like
            WHERE id_compositions_donuts = :id
        ");
        $stmt->execute([':id' => $id]);

        // Supprimer commentaires
        $stmt = $pdo->prepare("
            DELETE FROM commentaires
            WHERE id_donuts_concerné = :id
        ");
        $stmt->execute([':id' => $id]);

        // Supprimer la composition
        $stmt = $pdo->prepare("
            DELETE FROM compositions_donuts
            WHERE id_composition = :id
        ");
        $stmt->execute([':id' => $id]);

        $pdo->commit();

        header('Location: index.php');
        exit;

    } catch (Exception $e) {
        $pdo->rollBack();
        die('Erreur suppression : ' . $e->getMessage());
    }
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <?php include 'css/links.php' ?>
    <link rel="stylesheet" href="css/modifcompo.css">
</head>

<body>

    <?php include 'header/header.php' ?>
    <main id="main-content">


        <h1>Modifier ma composition</h1>

        <div class="compodetails">
            <div class="img-container">
                <img src="./<?= $compo['img_beignets'] ?>" alt="">

                <?php if (!empty($compo['img_fourrage'])): ?>
                    <img src="./<?= $compo['img_fourrage'] ?>" alt="">
                <?php endif; ?>

                <?php if (!empty($compo['img_glacage'])): ?>
                    <img src="./<?= $compo['img_glacage'] ?>" alt="">
                <?php endif; ?>

                <?php if (!empty($compo['img_topping'])): ?>
                    <img src="./<?= $compo['img_topping'] ?>" alt="">
                <?php endif; ?>
            </div>

            <div class="info">
                <?php if (!empty($compo['name_fourrage'])): ?>
                    <p><?= $compo['name_fourrage'] ?></p>
                <?php endif; ?>


                <?php if (!empty($compo['name_glacage'])): ?>
                    <p> <?= $compo['name_glacage'] ?></p>
                <?php endif; ?>


                <?php if (!empty($compo['name_topping'])): ?>
                    <p><?= $compo['name_topping'] ?></p>
                <?php endif; ?>

            </div>

        </div>
        <form method="post">

            <div class="input-container">
                <label>Nom</label>
                <input type="text" name="donut_name" value="<?= htmlspecialchars($compo['donut_name']) ?>">
            </div>

            <div class="input-container">
                <label>Description</label>
                <textarea name="description"><?= htmlspecialchars($compo['description']) ?></textarea>
            </div>
            <button class="btn" type="submit" name="update">Enregistrer</button>
        </form>

        <hr>

        <form class="delete" method="post" onsubmit="return confirm('Supprimer définitivement cette composition ?');">
            <button type="submit" name="delete">
                Supprimer la composition
            </button>
        </form>
    </main>

    <?php include 'footer/footer.php'; ?>
    <?php include 'cookies/cookies.php'; ?>

</body>

</html>