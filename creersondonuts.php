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

    // Type de beignet
    $type = 'sucré';
    if (isset($_POST['beignet'])) {
        $type = ($_POST['beignet'] == '1') ? 'sucré' : 'salé';
    }

    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');


    if ($name === '' || $description === '') {
        $error = "Le nom et la description sont obligatoires.";
    } else {

        $id_beignet = !empty($_POST['beignet']) ? (int) $_POST['beignet'] : null;
        $id_fourrage = !empty($_POST['fourrage']) ? (int) $_POST['fourrage'] : null;
        $id_glacage = !empty($_POST['glacage']) ? (int) $_POST['glacage'] : null;
        $id_topping = !empty($_POST['topping']) ? (int) $_POST['topping'] : null;

        $stmt = $pdo->prepare("
    INSERT INTO compositions_donuts
    (donut_name, id_beignet, id_fourrage, id_glacage, id_topping, id_createur, description, type, prix)
    VALUES (:name, :beignet, :fourrage, :glacage, :topping, :creator, :description, :type, :prix)
");

        $stmt->execute([
            ':name' => $name,
            ':beignet' => $id_beignet,
            ':fourrage' => $id_fourrage,
            ':glacage' => $id_glacage,
            ':topping' => $id_topping,
            ':creator' => $creator_id,
            ':description' => $description,
            ':type' => $type,
            ':prix' => $_POST['prix']
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

    foreach ($items as $i) {

        $type_col = 'type_' . $name;
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
    <meta name="description"
        content="Fabriquez un donuts ou un bagel personnalisé à partir des ingrédients proposés par SweetPlace, ensuite,partagez et commander le !">
    <?php include 'css/links.php'; ?>
    <link rel="stylesheet" href="css/creer.css">
</head>

<body>
    <?php include 'header/header.php'; ?>

    <div class="welcome">
        <div class="content">
            <h1>La Fabrique à Donuts</h1>
            <?php if ($error): ?>
                <p class="error"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>

            <p class='connectinfo'>
                Vous êtes connecté en tant que
                <?php echo isset($_SESSION['login']) ? htmlspecialchars($_SESSION['login']) : 'Invité'; ?>
            </p>
        </div>
    </div>



    <main id="main-content">
        <div class="content">

            <div class="imgconstructor-container">
                <div class="img-consutructor">
                    <img id="img-beignet" src="images/constructor/beignets/donuts.svg" alt="">
                    <img id="img-fourrage" src="" alt="">
                    <img id="img-glacage" src="" alt="">
                    <img id="img-topping" src="" alt="">
                </div>
                <p class="formprix">Prix : <span id="prix-affichage"> 2€</span></p>
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
                            data-img="images/constructor/beignets/bagel coupe.svg">
                    </div>


                </div>



                <input type="hidden" name="type_final" id="type_final" value="sucré">



                <input type="hidden" name="prix" id="prix" value="2">

                <label for="fourrage">Fourrage</label>
                <?php select('fourrage', $fourrages); ?>
                <label id='labelGlacage' for="glacage">Glaçage</label>
                <?php select('glacage', $glacages); ?>
                <label id='labelTopping' for="topping">Topping</label>
                <?php select('topping', $toppings); ?>



                <label for="componame">Nomme ta composition <span class="oblige">*</span></label>
                <input id='componame' type="text" name="name" placeholder="Nom de la composition" required>

                <label for="compodesc">Décrit en quelques mots ta composition <span class="oblige">*</span></label>
                <textarea id='compodesc' name="description" maxlength="300"
                    placeholder="Description (50 mots max)"></textarea>




                <div class="btnform">
                    <button type="button" class="btn reset" id="resetForm">Réinitialiser</button>


                    <input class="btn" type="submit" value="Publier"></input>
                </div>

            </form>
        </div>
    </main>


    <?php include 'footer/footer.php'; ?>


    <script src="js/header.js"></script>
    <script src="js/constructionDonuts.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const prixBase = 2; // prix du beignet seul
            const prixFourrage = 1;
            const prixGlacage = 0.5;
            const prixTopping = 0.5;

            const selectFourrage = document.getElementById('fourrage');
            const selectGlacage = document.getElementById('glacage');
            const selectTopping = document.getElementById('topping');
            const prixAffichage = document.getElementById('prix-affichage');
            const prixInput = document.getElementById('prix');

            const radioBeignets = document.querySelectorAll('input[name="beignet"]');

            function calculerPrix() {
                let prixTotal = prixBase;

                if (selectFourrage.value) prixTotal += prixFourrage;
                if (selectGlacage.value) prixTotal += prixGlacage;
                if (selectTopping.value) prixTotal += prixTopping;

                prixAffichage.textContent = prixTotal.toFixed(2) + '€';
                prixInput.value = prixTotal.toFixed(2); // pour envoyer à la BDD
            }

            // recalcul à chaque changement d'ingrédient
            selectFourrage.addEventListener('change', calculerPrix);
            selectGlacage.addEventListener('change', calculerPrix);
            selectTopping.addEventListener('change', calculerPrix);

            // recalcul à chaque changement de beignet
            radioBeignets.forEach(radio => {
                radio.addEventListener('change', calculerPrix);
            });

            // calcul initial
            calculerPrix();
        });



        document.getElementById('resetForm').addEventListener('click', () => {
            const form = document.getElementById('form-compo');
            form.reset();

            // reset images
            document.getElementById('img-beignet').src = 'images/constructor/beignets/donuts.svg';
            document.getElementById('img-fourrage').src = '';
            document.getElementById('img-glacage').src = '';
            document.getElementById('img-topping').src = '';

            // reset prix
            document.getElementById('prix-affichage').textContent = '2€';
            document.getElementById('prix').value = '2';

            // reset type
            document.getElementById('type_final').value = 'sucré';
        });


    </script>

    <?php include 'cookies/cookies.php'; ?>
</body>



</html>