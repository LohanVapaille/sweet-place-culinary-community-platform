<footer>
    <div class="footer-container">

        <div class="footer-content">
            <h3><a href="mentionslegales.php">Mentions légales & Crédits</a></h3>
            <h3><a href="siteplan.php">Plan du site</a></h3>
            <h3><a href="quisommesnous.php">Qui sommes nous ?</a></h3>
            <?php

            require_once 'models/stats.php';

            if (isset($_SESSION['id'])) {
                $userId = $_SESSION['id'];
                $admin = getInfosUser($pdo, $userId);
                if ($admin['admin'] == 1) {

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

    </div>

    <div class="footer-bottom">
        © 2025 SweetPlace - Projet étudiant réalisé par Adam Kassioui, Paul-Emmanuel Cesar, Bleu-Cissoko Yan et
        Lohan
        Vapaille
    </div>
</footer>
</div>