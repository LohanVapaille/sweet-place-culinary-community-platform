<header class="header">

  <div class="topbar">
    <!-- LOGO -->
    <div class="logo-container" id="logoTrigger">
      <p class="logo">SWEETPLA<span class="rose">C</span>E.</p>
    </div>

    <!-- DROITE -->
    <div class="right">
      <?php if (!isset($_SESSION['id'])): ?>
        <a href="connexion.php" class="login">Se connecter</a>
      <?php else: ?>
        <div class="donut-hover-zone">
          <div class="donut-wrapper">
            <img src="images/design/menudonuts.png" class="donut">

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
  </div>

  <!-- MENU FULL WIDTH -->
  <div class="mega-menu" id="megaMenu">
    <ul>
      <li><a href="index.php">Accueil</a></li>
      <li><a href="donuts_sweetplace.php">Donuts Sweet Place</a></li>
      <li><a href="parcourir.php">Parcourir les créateurs</a></li>
      <li><a href="creersondonuts.php">Créer mon donuts</a></li>
    </ul>
  </div>

</header>

<script>
  const logo = document.getElementById('logoTrigger');
  const megaMenu = document.getElementById('megaMenu');

  const donut = document.getElementById('donutTrigger');
  const donutIcons = donut ? donut.querySelector('.donut-icons') : null;

  // MEGA MENU
  logo.addEventListener('mouseenter', () => {
    megaMenu.style.display = 'block';
  });



  logo.addEventListener('mouseleave', () => {
    setTimeout(() => {
      if (!megaMenu.matches(':hover')) {
        megaMenu.style.display = 'none';
      }
    }, 100);
  });

  logo.addEventListener('click', () => {
    megaMenu.style.display = 'block';
  });

  megaMenu.addEventListener('mouseleave', () => {
    megaMenu.style.display = 'none';
  });

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