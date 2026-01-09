<?php
session_start();
require_once 'config.php';
require_once 'models/detail_donuts.php'; ?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Qui sommes nous ?</title>
    <meta name="description"
        content="Découvrez SweetPlace, la première plateforme de création et de partage de compositions personnalisées de donuts & bagels">
    <?php include 'css/links.php'; ?>
    <link rel="stylesheet" href="css/mentionslegales.css">
</head>

<?php include 'header/header.php' ?>

<body>

    <div class="welcome">
        <div class="content">
            <h1>Qui sommes nous ?</h1>
        </div>
    </div>
    <main id="main-content">

        <section>
            <h2>Ce qu'il faut savoir</h2>


            <div class="footer-column">
                <h3>Concept</h3>

                <ul>
                    <li>
                        SweetPlace est une plateforme collaborative sur laquelle vous pouvez partager vos compositions
                        de donuts et de bagels avec les autres utilisateurs, tester de nouveaux mélanges et découvrir
                        les créations de la communauté. Composez votre panier parmi toutes les recettes proposées sur la
                        plateforme !
                    </li>
                    <br>
                    <li>
                        Il s’agit d’un projet étudiant réalisé dans le cadre du BUT Métiers du Multimédia et de
                        l’Internet (MMI). Ce projet est fictif : les donuts créés par les utilisateurs ne seront
                        malheureusement jamais fabriqués.
                    </li>
                </ul>
            </div>
        </section>

        <section>
            <h2>Qui contactez ?</h2>

            <div class="footer-column">


                <ul>
                    <li>Adam Kassioui : Maquetteur, Designer, UX/UI researcher </li>
                    <a href="mailto:kassiouiadam@gmail.fr">adamkassioui@gmail.com</a>

                    <br><br>

                    <li>Yan Bleu-Cissoko : Maquetteur, Designer, UX/UI researcher </li>
                    <a href="mailto:kassiouiadam@gmail.fr">yanbleucissoko@gmail.com</a>

                    <br><br>

                    <li>Paul-Émmanuel César : Illustrateur, Graphiste Designer, Maquetteur, UX/UI researcher </li>
                    <a href="mailto:kassiouiadam@gmail.fr">paulemmanuelcesar@gmail.com</a>

                    <br><br>

                    <li>Lohan Vapaille : Développeur Front-end/Back-end, UX UI Designer, Webdesigner, UX/UI researcher,
                        Maquetteur
                    </li>

                    <a href="mailto:lohanvapaille@gmail.fr">lohanvapaille@gmail.com</a>
                    <br><br><br>
                    <li>Étudiants à L'Université Gustave Effeil, 5 bd Descartes, Champs sur Marne, 77420</li>
                </ul>
            </div>
        </section>

    </main>

    <?php include 'footer/footer.php'; ?>
    <?php include 'cookies/cookies.php'; ?>
</body>

</html>