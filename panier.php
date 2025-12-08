<?php
session_start();

require 'config.php';

// ---------- PROTECTION BASIQUE ----------
if (!isset($_SESSION['id'])) {
  header('Location: connexion.php');
  exit;
}
$user = (int) $_SESSION['id'];

// Si on a un id en GET qui n'est pas l'id de session => redirection
if (!isset($_GET['id']) || (int) $_GET['id'] !== $user) {
  $redirect = 'panier.php?id=' . $user;
  header('Location: ' . $redirect);
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

    if ($stmt->rowCount() > 0) {
      echo json_encode(['success' => true, 'quantite' => $newQty]);
    } else {
      echo json_encode(['success' => false, 'msg' => 'Mise à jour non autorisée ou donnée inchangée']);
    }
    exit;
  }

  echo json_encode(['success' => false, 'msg' => 'Action inconnue']);
  exit;
}

require 'models/panier_user.php';

$panierModel = new PanierModel($pdo);
$items = $panierModel->getItemsByUser($user);







?>
<!doctype html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Panier - Mon Donuts</title>
  <?php include 'css/links.php'; ?>
  <link rel="stylesheet" href="css/panier.css">

</head>

<body>
  <?php include 'header/header.php'; ?>
  <div class="paniercontent">
    <h1>Mon panier</h1>
    <?php if (empty($items)): ?>
      <p class="empty rienpourlemoment">Ton panier est vide.</p>
    <?php else: ?>


    </div>


    <div class='cards-container' id="cart-list">
      <?php foreach ($items as $it): ?>
        <div class="card cart-item"
          data-id_fk_panier="<?php echo htmlspecialchars($it['id_fk_panier'] ?? '', ENT_QUOTES); ?>">
          <?php if (!empty($it['image'])): ?>
            <img src="<?php echo htmlspecialchars($it['image'], ENT_QUOTES); ?>"
              alt="<?php echo htmlspecialchars($it['title'] ?? '', ENT_QUOTES); ?>">
          <?php endif; ?>

          <div class="item-info">
            <div><strong><?php echo htmlspecialchars($it['title'] ?? '', ENT_QUOTES); ?></strong></div>
            <div><?php echo htmlspecialchars($it['description'] ?? '', ENT_QUOTES); ?></div>
            <div style="font-size:0.85rem;color:#888;margin-top:6px">Provenance:
              <?php echo htmlspecialchars($it['source_table'] ?? '', ENT_QUOTES); ?>
            </div>



          </div>
          <div class="actions">
            <div class="qty-control">
              <button class="decrease" aria-label="décrémenter">−</button>
              <div class="qty" data-quantite="<?php echo (int) $it['quantite']; ?>"><?php echo (int) $it['quantite']; ?>
              </div>
              <button class="increase" aria-label="incrémenter">+</button>
            </div>
            <button class="remove" title="Supprimer"><i class='bx bxs-trash'></i></button>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <script src="js/quantitepanier.js"></script>
  <script src="js/header.js"></script>

</body>

</html>