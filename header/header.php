<?php 

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


?>

<header>
    <nav>
        <ul><a href="index.php">Accueil</a></ul>
        <ul><a href="donuts_sweetplace.php">Donuts Sweet Place</a></ul>
        <ul><a href="parcourir.php">Parcourir les créateurs</a></ul>
        <ul><a href="creersondonuts.php">Créer mon donuts</a></ul>


    <?php if(isset($_SESSION['id'])): ?>
        <ul><a href="panier.php?id=<?php echo $_SESSION['id']; ?>"><i class="bx bxs-cart"></i></a></ul>
        <ul><a href="profil.php?id=<?php echo $_SESSION['id']; ?>"><i class="bx bxs-user-circle"></i></a></ul>
        <ul><a href="logout.php"><i class="bx bx-log-out"></i></a></ul>
    <?php else: ?>
        <ul><a href="connexion.php">Se connecter</a></ul>
    <?php endif; ?>
</nav>


</header>
