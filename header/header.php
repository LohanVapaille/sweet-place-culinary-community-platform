<?php if (isset($_SESSION['panier_added'])): ?>
  <div id="toast-panier">🍩 Ajouté au panier !</div>

  <script>
    sessionStorage.setItem('panierNotif', 'true');
  </script>

  <?php unset($_SESSION['panier_added']); ?>
<?php endif; ?>

<a href="#main-content" class="skip-link">Aller au contenu</a>
<header class="<?php echo isset($_SESSION['id']) ? 'connect' : 'noconnect'; ?>">


  <a href="index.php" title="Retour à l'accueil" class="logo">SweetPla<span class="rose">c</span>e<span
      class="sr-only">Retour à
      l'Accueil</span></a>
  <a class='nav' href="donuts_sweetplace.php">Donuts Sweet Place</a>
  <a class='nav' href="parcourir.php">Parcourir les créations</a>
  <a class='nav' href="creersondonuts.php">Créer mon donuts</a>
  <?php if (!isset($_SESSION['id'])): ?>
    <a class="nav" href="connexion.php">Connexion</a>

  <?php endif; ?>

  <div class="burger" id="burger">
    <i class='bx bx-menu'></i>
  </div>



  <div class="mobile-menu" id="mobileMenu">
    <a href="donuts_sweetplace.php">Donuts Sweet Place</a>
    <a href="parcourir.php">Parcourir les créations</a>
    <a href="creersondonuts.php">Créer mon donuts</a>

    <?php if (!isset($_SESSION['id'])): ?>
      <a href="connexion.php">Connexion</a>
    <?php else: ?>
      <a href="profil.php?id=<?php echo $_SESSION['id'] ?>">Mon profil</a>
      <a href="panier.php?id=<?php echo $_SESSION['id'] ?>">Panier</a>
    <?php endif; ?>
  </div>

  <div class="right">
    <?php if (isset($_SESSION['id'])): ?>
      <div class="donut-hover-zone">
        <div class="donut-wrapper">
          <span class="notif-dot"></span>
          <img src="images/design/menudonuts.svg" class="donut" id="donutTrigger">

          <div class="donut-icons">

            <a tabindex='0' href="index.php" class="donut-icon" data-label="Accueil">
              <i class='bx bxs-home-alt-2'></i>
              <span class="sr-only">Retour à l'Accueil</span>

            </a>

            <a tabindex='0' href="panier.php?id=<?php echo $_SESSION['id'] ?>" class="donut-icon" data-label="Panier">
              <i class='bx bxs-basket'></i>
              <span class="sr-only">Mon panier</span>
            </a>

            <a tabindex='0' href="profil.php?id=<?php echo $_SESSION['id'] ?>" class="donut-icon" data-label="Profil">
              <i class='bx bxs-user-circle'></i>
              <span class="sr-only">Mon profil</span>
            </a>

            <a tabindex='0' href="creersondonuts.php" class="donut-icon" data-label="La fabrique">
              <i class='bx bx-buoy'></i>
              <span class="sr-only">La fabrique à donuts</span>
            </a>

          </div>

        </div>

      </div>
    </div>

  <?php endif; ?>
  </div>



</header>