<?php
session_start();
require_once 'config.php';
// require_once 'models/detail_donuts.php'; // Utile si vous affichez des stats, sinon facultatif
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>CGU - SweetPlace</title>
    <meta name="description" content="Conditions Générales d'Utilisation et règles de modération de SweetPlace">
    <?php include 'css/links.php'; ?>
    <link rel="stylesheet" href="css/mentionslegales.css">
</head>

<?php include 'header/header.php' ?>

<body>

    <div class="welcome">
        <div class="content">
            <h1>Conditions Générales d'Utilisation</h1>
        </div>
    </div>

    <main id="main-content">

        <section>
            <h2>Règles de Création & Communauté</h2>

            <div class="footer-column">
                <h3>1. Confection de Donuts & Bagels</h3>
                <ul>
                    <li><strong>Personnalisation :</strong> L'utilisateur peut choisir ses ingrédients, donner un nom et
                        une description à sa création.</li>
                    <li><strong>Contenu interdit :</strong> Il est strictement interdit d'utiliser des termes injurieux,
                        diffamatoires, racistes, haineux ou à caractère sexuel dans les noms et descriptions.</li>
                    <li><strong>Originalité :</strong> En soumettant une création, vous acceptez qu'elle soit visible et
                        partagée par l'ensemble de la communauté SweetPlace.</li>
                </ul>
            </div>

            <div class="footer-column">
                <h3>2. Espace Commentaires</h3>
                <ul>
                    <li><strong>Bienveillance :</strong> Les échanges doivent rester courtois. Le harcèlement,
                        l'intimidation et les insultes envers d'autres membres sont proscrits.</li>
                    <li><strong>Publicité :</strong> Le spam et les liens promotionnels non sollicités dans les
                        commentaires seront supprimés.</li>
                    <li><strong>Responsabilité :</strong> L'utilisateur est seul responsable des propos qu'il tient dans
                        l'espace communautaire.</li>
                </ul>
            </div>
        </section>

        <section>
            <h2>Modération & Sécurité</h2>

            <div class="footer-column">
                <h3>Politique de Modération</h3>
                <ul>
                    <li><strong>Type de modération :</strong> Nous appliquons une modération <em>a posteriori</em>. Les
                        contenus sont publiés instantanément mais vérifiés par notre équipe après publication.</li>
                    <li><strong>Signalement :</strong> Tout contenu inapproprié peut être signalé à l'équipe via le
                        formulaire de contact ou le bouton de signalement dédié.</li>
                    <li><strong>Sanctions :</strong> SweetPlace se réserve le droit de supprimer tout donut, bagel ou
                        commentaire ne respectant pas ces règles, et de suspendre le compte de l'utilisateur en cas de
                        récidive.</li>
                </ul>
            </div>

            <div class="footer-column">
                <h3>Protection des Données</h3>
                <ul>
                    <li><strong>Données récoltées :</strong> Seules les données nécessaires à la création de votre
                        compte et à l'affichage de vos créations sont stockées.</li>
                    <li><strong>Droit d'accès :</strong> Conformément au RGPD, vous disposez d'un droit de modification
                        et de suppression de vos données personnelles via votre profil.</li>
                    <li><strong>Usage :</strong> Projet étudiant à but non commercial.</li>
                </ul>
            </div>
        </section>

    </main>

    <?php include 'footer/footer.php'; ?>

    <?php include 'cookies/cookies.php'; ?>
</body>

</html>