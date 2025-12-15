<?php

session_start();
require 'config.php';

if (!isset($_SESSION['id'])) {
    header('Location: connexion.php');
    exit;
}

$creator_id = (int) $_SESSION['id'];
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $type = $_POST['type'] ?? 'sucré'; // donut par défaut
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');


    $id_beignet = !empty($_POST['beignet']) ? (int) $_POST['beignet'] : null;
    $id_fourrage = !empty($_POST['fourrage']) ? (int) $_POST['fourrage'] : null;
    $id_glacage = !empty($_POST['glacage']) ? (int) $_POST['glacage'] : null;
    $id_topping = !empty($_POST['topping']) ? (int) $_POST['topping'] : null;

    if ($name === '') {
        $error = "Le nom est obligatoire.";
    } else {
        $stmt = $pdo->prepare("
            INSERT INTO compositions_donuts
            (donut_name, id_beignet, id_fourrage, id_glacage, id_topping, id_createur, description, type)
            VALUES (:name, :beignet, :fourrage, :glacage, :topping, :creator, :description, :type)
        ");

        $stmt->execute([
            ':name' => $name,
            ':beignet' => $id_beignet,
            ':fourrage' => $id_fourrage,
            ':glacage' => $id_glacage,
            ':topping' => $id_topping,
            ':creator' => $creator_id,
            ':description' => $description,
            ':type' => $type
        ]);

        header('Location: profil.php?id=' . $creator_id);
        exit;
    }
}


$fourrages = $pdo->query("SELECT * FROM fourrages")->fetchAll(PDO::FETCH_ASSOC);
$glacages = $pdo->query("SELECT * FROM glacages")->fetchAll(PDO::FETCH_ASSOC);
$toppings = $pdo->query("SELECT * FROM topping")->fetchAll(PDO::FETCH_ASSOC);



function select($name, $items)
{
    echo "<select name='$name' id='$name'>";
    echo "<option value=''>— Choisir —</option>";
    foreach ($items as $i) {
        // Utilise le vrai type de l'ingrédient
        $type_col = 'type_' . $name; // ex: type_fourrage
        $img_col = 'img_' . $name;
        $name_col = 'name_' . $name;
        $id_col = 'id_' . $name;

        echo "<option value='{$i[$id_col]}' data-img='{$i[$img_col]}' data-type='{$i[$type_col]}'>
            {$i[$name_col]}
        </option>";
    }
    echo "</select>";
}






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
        <h1>Créer un donuts</h1>

        <?php if ($error): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <p class='connect'>
            Vous êtes connecté en tant que
            <?php echo isset($_SESSION['login']) ? htmlspecialchars($_SESSION['login']) : 'Invité'; ?>
        </p>


        <main>
            <div class="content">

                <div class="img-consutructor">
                    <img id="img-beignet" src="images/constructor/beignets/donuts.svg" alt="">
                    <img id="img-fourrage" src="" alt="">
                    <img id="img-glacage" src="" alt="">
                    <img id="img-topping" src="" alt="">
                </div>





                <!-- FORM -->
                <form method="POST" id="form-compo">

                    <p>Créé ta composition de donuts ou de bagel avec les ingrédients proposés.</p>

                    <div class="beignet-switch">
                        <div>
                            <label for="donuts">Donuts (sucré)</label>
                            <input id="donuts" type="radio" name="beignet" value="1" checked
                                data-img="images/constructor/beignets/donuts.svg">
                        </div>


                        <div><label for="bagel">Bagel (salé)</label>
                            <input id='bagel' type="radio" name="beignet" value="2"
                                data-img="images/constructor/beignets/bagel.svg">
                        </div>


                    </div>


                    <input type="hidden" name="type_final" id="type_final" value="sucré">


                    <!-- SELECTS -->


                    <label for="fourrage">Fourrage</label>
                    <?php select('fourrage', $fourrages); ?>
                    <label for="glacage">Glaçage</label>
                    <?php select('glacage', $glacages); ?>
                    <label for="topping">Topping</label>
                    <?php select('topping', $toppings); ?>

                    <label for="componame">Nomme ta composition</label>
                    <input id='componame' type="text" name="name" placeholder="Nom de la composition" required>

                    <label for="compodesc">Décrit en quelques mots ta composition</label>
                    <textarea id='compodesc' name="description" maxlength="300"
                        placeholder="Description (50 mots max)"></textarea>



                    <input class="btn" type="submit" value="Publier"></input>

                </form>
            </div>
        </main>
    </div>

    <script>


    </script>
    <script src="js/header.js"></script>
    <script src="js/constructionDonuts.js"></script>
</body>



</html>