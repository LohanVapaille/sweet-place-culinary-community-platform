<div class="link-imgfooter"><img class="imgfooter" src="images/design/degouline.jpg" alt="">

    <footer>
        <div class="footer-container">

            <div class="footer-left">
                <h3><a href="mentionslegales">Mentions légales</a></h3>
                <?php

                require_once 'models/stats.php';

                if (isset($_SESSION['id'])) {
                    $userId = $_SESSION['id'];
                    $admin = getInfosUser($pdo, $userId);
                    if ($admin['admin'] === 1) {

                        echo "<h3><a href='backoffice/backoffice.php'>Accéder au backoffice</a></h3>";
                    }

                }


                ?>
                <?php if (!isset($_SESSION['id'])) {
                    echo "<h3><a href='connexion.php'>Se connecter</a></h3>";
                } else {

                    echo "<h3><a href='logout.php'>Se déconnecter</a></h3>";
                } ?>

            </div>

            <div class="footer-left">
                <h3>Plan du site</h3>
                <div class="plan">
                    <a href="index.php">Accueil</a>
                    <a href="donuts_sweetplace.php">Donuts SweetPlace</a>
                    <a href="parcourir.php">Parcourir les créations</a>
                    <a href="creersondonuts.php">La Fabrique</a>
                    <?php if (isset($_SESSION['id'])) {
                        echo "<a href='profil.php?id=" . $_SESSION['id'] . "'>Mon profil</a>";

                    } ?>

                </div>


            </div>

        </div>

        <div class="footer-bottom">
            © 2025 SweetPlace - Projet étudiant réalisé par Adam Kassioui, Paul-Emmanuel Cesar, Bleu-Cissoko Yan et
            Lohan
            Vapaille
        </div>
    </footer>
</div>