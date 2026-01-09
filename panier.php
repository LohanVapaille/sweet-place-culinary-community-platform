<?php
session_start();
require 'config.php';


if (!isset($_SESSION['id'])) {
  header('Location: connexion.php');
  exit;
}
$user = (int) $_SESSION['id'];

// Si on a un id en GET qui n'est pas l'id de session => redirection
if (!isset($_GET['id']) || (int) $_GET['id'] !== $user) {
  header('Location: panier.php?id=' . $user);
  exit;
}

// ---------- GESTION AJAX (POST) pour update quantity / remove ----------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $action = $_POST['action'] ?? null;
  $raw = file_get_contents('php://input');
  if (!$action && $raw) {
    $data = json_decode($raw, true);
    if (is_array($data)) {
      $action = $data['action'] ?? null;
      $_POST = array_merge($_POST, $data);
    }
  }

  header('Content-Type: application/json; charset=utf-8');

  if ($action === 'update_quantity') {
    $id_fk_panier = isset($_POST['id_fk_panier']) ? (int) $_POST['id_fk_panier'] : 0;
    $newQty = isset($_POST['quantite']) ? (int) $_POST['quantite'] : null;

    if ($id_fk_panier <= 0 || $newQty === null || $newQty < 0) {
      echo json_encode(['success' => false, 'msg' => 'Paramètres invalides']);
      exit;
    }

    if ($newQty === 0) {
      $stmt = $pdo->prepare("DELETE FROM fk_panier WHERE id_fk_panier = :id_fk_panier AND id_users = :id_users");
      $stmt->execute([':id_fk_panier' => $id_fk_panier, ':id_users' => $user]);
      echo json_encode(['success' => true, 'deleted' => true]);
      exit;
    }

    $stmt = $pdo->prepare("UPDATE fk_panier SET quantite = :quantite WHERE id_fk_panier = :id_fk_panier AND id_users = :id_users");
    $stmt->execute([':quantite' => $newQty, ':id_fk_panier' => $id_fk_panier, ':id_users' => $user]);

    echo json_encode(['success' => $stmt->rowCount() > 0, 'quantite' => $newQty]);
    exit;
  }

  echo json_encode(['success' => false, 'msg' => 'Action inconnue']);
  exit;
}

require 'models/panier_user.php';


$panier = getUserPanier($pdo, $user);
// var_dump($panier);

?>
<!doctype html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Mon Panier </title>
  <meta name="description"
    content="Accédez à votre panier SweetPlace et commander les compositions de donuts et/ou de bagels que vous y avez ajouté">
  <?php include 'css/links.php'; ?>
  <link rel="stylesheet" href="css/panier.css">
  <style>
    .composition {
      position: relative;
      width: 150px;
      height: 150px;
    }

    .composition img {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
    }
  </style>
</head>

<body>
  <?php include 'header/header.php'; ?>

  <main>
    <div id="main-content" class="paniercontent">
      <h1>Mon panier</h1>
      <?php if (empty($panier)): ?>
        <p class="empty rienpourlemoment">Ton panier est vide.</p>
      <?php else: ?>
        <div class='cards-container' id="cart-list">
          <?php foreach ($panier as $it): ?>
            <div class="card cart-item" data-id_fk_panier="<?php echo (int) $it['panier_id']; ?>">
              <div class="composition">
                <?php foreach ($it['images'] as $img): ?>
                  <img src="<?php echo htmlspecialchars($img, ENT_QUOTES); ?>" alt="">
                <?php endforeach; ?>
              </div>

              <div class="item-info">
                <div><strong><?php echo htmlspecialchars($it['donut_name'], ENT_QUOTES); ?></strong></div>
                <?php if (!empty($it['description'])): ?>
                  <div><?php echo htmlspecialchars($it['description'], ENT_QUOTES); ?></div>
                <?php endif; ?>
              </div>

              <div class="actions">
                <div class="qty-control">
                  <button class="decrease" aria-label="décrémenter">−</button>
                  <div class="qty" data-quantite="<?php echo (int) $it['quantite']; ?>">
                    <?php echo (int) $it['quantite']; ?>
                  </div>
                  <button class="increase" aria-label="incrémenter">+</button>
                </div>
                <button class="remove" title="Supprimer"><i class='bx bxs-trash'></i></button>
              </div>
            </div>
          <?php endforeach; ?>


          <a class="btn confirmpanier" href="#">Valider le panier</a>
        </div>
      <?php endif; ?>
    </div>
  </main>


  <script src="js/quantitepanier.js"></script>
  <script src="js/header.js"></script>

  <?php include 'cookies/cookies.php'; ?>
</body>

</html>