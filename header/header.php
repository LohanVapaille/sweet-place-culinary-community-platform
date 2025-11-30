<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<header>
  <nav class="desk">
    <ul>
      <li><a href="index.php">Accueil</a></li>
      <li><a href="donuts_sweetplace.php">Donuts Sweet Place</a></li>
      <li><a href="parcourir.php">Parcourir les créateurs</a></li>
      <li><a href="creersondonuts.php">Créer mon donuts</a></li>

      <?php if (isset($_SESSION['id'])): ?>
        <li><a href="panier.php?id=<?php echo $_SESSION['id']; ?>"><i class="bx bxs-cart"></i></a></li>
        <li><a href="profil.php?id=<?php echo $_SESSION['id']; ?>"><i class="bx bxs-user-circle"></i></a></li>
        <li><a href="logout.php"><i class="bx bx-log-out"></i></a></li>
      <?php else: ?>
        <li><a href="connexion.php">Se connecter</a></li>
      <?php endif; ?>
    </ul>
  </nav>

  <i class="menubg bx bx-menu"></i>

  <nav class="phone">
    <ul>
      <li><a href="index.php">Accueil</a></li>
      <li><a href="donuts_sweetplace.php">Donuts Sweet Place</a></li>
      <li><a href="parcourir.php">Parcourir les créateurs</a></li>
      <li><a href="creersondonuts.php">Créer mon donuts</a></li>

      <?php if (isset($_SESSION['id'])): ?>
        <li><a href="panier.php?id=<?php echo $_SESSION['id']; ?>"><i class="bx bxs-cart"></i></a></li>
        <li><a href="profil.php?id=<?php echo $_SESSION['id']; ?>"><i class="bx bxs-user-circle"></i></a></li>
        <li><a href="logout.php"><i class="bx bx-log-out"></i></a></li>
      <?php else: ?>
        <li><a href="connexion.php">Se connecter</a></li>
      <?php endif; ?>
    </ul>
  </nav>
</header>
