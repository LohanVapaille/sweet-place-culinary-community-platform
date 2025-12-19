<header class="<?php echo isset($_SESSION['id']) ? 'connect' : 'noconnect'; ?>">


  <a href="index.php" class="logo">SWEETPLA<span class="rose">C</span>E.</a>
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
          <img src="images/design/menudonuts.svg" class="donut">

          <div class="donut-icons">
            <a href="index.php"><i class='bx bxs-home-alt-2'></i></a>
            <a href="panier.php?id=<?php echo $_SESSION['id'] ?>"><i class='bx bxs-basket'></i></a>
            <a href="profil.php?id=<?php echo $_SESSION['id'] ?>"><i class='bx bxs-user-circle'></i></a>
            <a href="creersondonuts.php"><i class='bx bx-buoy'></i></a>

          </div>
        </div>
      </div>

    <?php endif; ?>
  </div>



</header>





<script>
  const logo = document.getElementById('logoTrigger');
  const megaMenu = document.getElementById('megaMenu');

  const donut = document.getElementById('donutTrigger');
  const donutIcons = donut ? donut.querySelector('.donut-icons') : null;



  // DONUT ICONS
  if (donut) {
    donut.addEventListener('mouseenter', () => {
      donutIcons.style.display = 'block';
    });

    donut.addEventListener('mouseleave', () => {
      donutIcons.style.display = 'none';
    });
  }

  if (donut) {
    donut.addEventListener('mouseenter', () => {
      donutIcons.style.opacity = '1';
      donutIcons.style.pointerEvents = 'auto';
    });

    donut.addEventListener('mouseleave', () => {
      donutIcons.style.opacity = '0';
      donutIcons.style.pointerEvents = 'none';
    });
  }

</script>