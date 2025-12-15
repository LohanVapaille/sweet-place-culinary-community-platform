<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$cartCount = 0;
if (isset($_SESSION['id'])) {
  // Récupérer le total des quantités dans le panier
  require_once 'config.php';
  $stmt = $pdo->prepare("SELECT SUM(quantite) FROM fk_panier WHERE id_users = :id");
  $stmt->execute([':id' => $_SESSION['id']]);
  $cartCount = (int) $stmt->fetchColumn();
}
?>

<header>
  <nav class="desk">
    <p class="logo">SWEETPLACE.</p>
    <ul>
      <li><a href="index.php">Accueil</a></li>
      <li><a href="donuts_sweetplace.php">Donuts Sweet Place</a></li>
      <li><a href="parcourir.php">Parcourir les créateurs</a></li>
      <li><a href="creersondonuts.php">Créer mon donuts</a></li>

      <?php if (isset($_SESSION['id'])): ?>
        <li>
          <a href="panier.php?id=<?php echo $_SESSION['id']; ?>">
            <i class="bx bxs-cart"></i>
            <span id="cart-count"><?php echo $cartCount; ?></span>
          </a>
        </li>
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
        <li>
          <a href="panier.php?id=<?php echo $_SESSION['id']; ?>">
            <i class="bx bxs-cart"></i>
            <span id="cart-count"><?php echo $cartCount; ?></span>
          </a>
        </li>
        <li><a href="profil.php?id=<?php echo $_SESSION['id']; ?>"><i class="bx bxs-user-circle"></i></a></li>
        <li><a href="logout.php"><i class="bx bx-log-out"></i></a></li>
      <?php else: ?>
        <li><a href="connexion.php">Se connecter</a></li>
      <?php endif; ?>
    </ul>
  </nav>
</header>

<div class="gta-overlay" id="gtaMenu">
  <div class="gta-close" id="closeMenu">✕</div>

  <div class="gta-radial">
    <<svg class="donut-svg" viewBox="0 0 500 500" xmlns="http://www.w3.org/2000/svg">

      <!-- SEGMENTS -->
      <g class="donut-segments">

        <!-- ACCUEIL -->
        <path class="segment" data-link="index.php" d="M250 50
         A200 200 0 0 1 423 150
         L345 195
         A110 110 0 0 0 250 140
         Z" />

        <!-- DONUTS -->
        <path class="segment" data-link="donuts_sweetplace.php" d="M423 150
         A200 200 0 0 1 423 350
         L345 305
         A110 110 0 0 0 345 195
         Z" />

        <!-- CRÉATEURS -->
        <path class="segment" data-link="parcourir.php" d="M423 350
         A200 200 0 0 1 250 450
         L250 360
         A110 110 0 0 0 345 305
         Z" />

        <!-- CRÉER -->
        <path class="segment" data-link="creersondonuts.php" d="M250 450
         A200 200 0 0 1 77 350
         L155 305
         A110 110 0 0 0 250 360
         Z" />

        <!-- MENTIONS -->
        <path class="segment" data-link="mentions.php" d="M77 350
         A200 200 0 0 1 77 150
         L155 195
         A110 110 0 0 0 155 305
         Z" />

        <!-- CONNEXION / LOGOUT -->
        <path class="segment" data-link="connexion.php" d="M77 150
         A200 200 0 0 1 250 50
         L250 140
         A110 110 0 0 0 155 195
         Z" />

      </g>

      <!-- ARCS DE TEXTE (INVISIBLES) -->
      <defs>
        <path id="t1" d="M250 95 A155 155 0 0 1 365 160" />
        <path id="t2" d="M385 180 A155 155 0 0 1 385 320" />
        <path id="t3" d="M365 340 A155 155 0 0 1 250 405" />
        <path id="t4" d="M250 405 A155 155 0 0 1 135 340" />
        <path id="t5" d="M115 320 A155 155 0 0 1 115 180" />
        <path id="t6" d="M135 160 A155 155 0 0 1 250 95" />
      </defs>

      <!-- TEXTE (NON SCALÉ) -->
      <g class="donut-text">
        <text>
          <textPath href="#t1" startOffset="50%">Accueil</textPath>
        </text>
        <text>
          <textPath href="#t2" startOffset="50%">Donuts Sweet Place</textPath>
        </text>
        <text>
          <textPath href="#t3" startOffset="50%">Parcourir les créateurs</textPath>
        </text>
        <text>
          <textPath href="#t4" startOffset="50%">Créer mon donut</textPath>
        </text>
        <text>
          <textPath href="#t5" startOffset="50%">Mentions légales</textPath>
        </text>
        <text>
          <textPath href="#t6" startOffset="50%">Connexion</textPath>
        </text>
      </g>

      <!-- TROU CENTRAL -->
      <circle cx="250" cy="250" r="105" fill="rgba(0,0,0,0.9)" />
      </svg>
  </div>
</div>

<script>
  const logo = document.querySelector('.logo');
  const overlay = document.getElementById('gtaMenu');
  const closeBtn = document.getElementById('closeMenu');

  logo.addEventListener('click', () => {
    overlay.classList.add('active');
    document.body.style.overflow = 'hidden';
  });

  closeBtn.addEventListener('click', () => {
    overlay.classList.remove('active');
    document.body.style.overflow = '';
  });
</script>