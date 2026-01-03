<?php
session_start();
require_once 'config.php';
require_once 'models/detail_donuts.php'; ?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Mentions Légales</title>
    <?php include 'css/links.php'; ?>
    <link rel="stylesheet" href="css/mentionslegales.css">
</head>

<?php include 'header/header.php' ?>

<body>

    <div class="welcome">
        <div class="content">
            <h1>Mentions Légales & Crédits</h1>
        </div>
    </div>
    <main id="main-content">

        <section>
            <h2>Mentions Légales</h2>


            <div class="footer-column">
                <h3>Informations</h3>

                <ul>
                    <li>SweetPlace est une plateforme collaborative sur laquelle vous pouvez partager vos compositions
                        de donuts et de bagels avec les autres utilisateurs, tester de nouveaux mélanges et découvrir
                        les créations de la communauté. Composez votre panier parmi toutes les recettes proposées sur la
                        plateforme !</li>
                    <br>
                    <li><strong>Éditeur :</strong></li>
                    <li>Raison sociale : Université Gustave Eiffel</li>
                    <li>5 bd Descartes, Champs sur Marne, 77420</li>
                    <li>Siret : 130 026 123 00013</li>
                    <li>APE : 85.42Z</li>
                    <li>Tel : 01 60 95 75 00</li>
                    <li>Responsable édition : Gilles Roussel, directeur de l'université Gustave Eiffel</li>
                    <br>
                    <li><strong>DPO :</strong></li>

                    <li>Véronique Juge </li>
                    <li>5 bd Descartes, Champs sur Marne, 77420</li>
                    <li></li><a
                        href="mailto:protectiondesdonnee-dpo@univ-eiffel.fr">protectiondesdonnee-dpo@univ-eiffel.fr</a>
                    </li>
                    <br><br>
                    <li>Nous ne sommes pas responsables de vos données personnelles</li>
                    <br><br>
                    <li><strong>Hébergement : O2Switch</strong></li>
                    <li>Siteweb : <a target='_blank' href="https://www.o2switch.fr/">02switch.fr</a></li>
                    <li>Chem. des Pardiaux, 63000 Clermont-Ferrand</li>
                    <li>Tel : 04 44 44 60 40</li>
                    <li>Contact : <a href="mailto:support@02switch.fr">support@02switch.fr</a></li>
                    <br>
                    <li>Usage : Projet étudiant</li>

                </ul>


            </div>

            <div class="footer-column">
                <h3>Créateurs</h3>

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
                    <br><br>
                    <li>Étudiants à L'Université Gustave Effeil, 5 bd Descartes, Champs sur Marne, 77420</li>
                </ul>

            </div>


        </section>

        <section>
            <h2>Crédits</h2>

            <div class="footer-column">
                <h3>Crédits Images</h3>

                <ul>
                    <li>Image 1 : lien</li>
                    <li>Image 2 : lien</li>
                    <li>Image 3 : lien</li>
                    <li>Image 4 : lien</li>


                    <br><br>

                </ul>
            </div>

            <div class="footer-column">
                <h3>API</h3>

                <ul>
                    <li>Utilisation d'une API Krispy Kreme pour les donuts dit "Donuts Sweetplace"</li>

                </ul>
            </div>
        </section>










    </main>

    <?php include 'footer/footer.php'; ?>
</body>

</html>