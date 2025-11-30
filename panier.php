<?php
session_start();

require 'config.php';

// ---------- PROTECTION BASIQUE ----------
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}
$sessionUserId = (int) $_SESSION['id'];

// Si on a un id en GET qui n'est pas l'id de session => redirection
if (!isset($_GET['id']) || (int)$_GET['id'] !== $sessionUserId) {
    $redirect = 'panier.php?id=' . $sessionUserId;
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
        $id_fk_panier = isset($_POST['id_fk_panier']) ? (int)$_POST['id_fk_panier'] : 0;
        $newQty = isset($_POST['quantite']) ? (int)$_POST['quantite'] : null;

        if ($id_fk_panier <= 0 || $newQty === null || $newQty < 0) {
            echo json_encode(['success' => false, 'msg' => 'Paramètres invalides']);
            exit;
        }

        if ($newQty === 0) {
            $stmt = $pdo->prepare("DELETE FROM fk_panier WHERE id_fk_panier = :id_fk_panier AND id_users = :id_users");
            $stmt->execute([':id_fk_panier' => $id_fk_panier, ':id_users' => $sessionUserId]);
            echo json_encode(['success' => true, 'deleted' => true]);
            exit;
        }

        $stmt = $pdo->prepare("UPDATE fk_panier SET quantite = :quantite WHERE id_fk_panier = :id_fk_panier AND id_users = :id_users");
        $stmt->execute([':quantite' => $newQty, ':id_fk_panier' => $id_fk_panier, ':id_users' => $sessionUserId]);

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

// ---------- Récupérer items du panier pour l'utilisateur (gère compositions_donuts ET nos_donuts) ----------
$sql = "
SELECT p.id_fk_panier, p.quantite, p.source_table, p.source_id, p.id_compositions_donuts,
       c.id_composition AS c_id, c.donut_name AS c_name, c.image AS c_image, c.description AS c_description,
       n.id_donuts_de_base AS n_id, n.title AS n_title, n.img AS n_image, n.description AS n_description
FROM fk_panier p
LEFT JOIN compositions_donuts c
  ON p.source_table = 'compositions_donuts' AND p.source_id = c.id_composition
LEFT JOIN nos_donuts n
  ON p.source_table = 'nos_donuts' AND p.source_id = n.id_donuts_de_base
WHERE p.id_users = :id_users
ORDER BY p.id_fk_panier DESC
";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id_users' => $sessionUserId]);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Si aucune ligne, on affiche vide
$items = [];
foreach ($rows as $r) {
    // Priorité : données compositions_donuts si présentes, sinon nos_donuts, sinon fallback via id_compositions_donuts
    $title = null; $image = null; $description = null; $source_table = $r['source_table'];
    $source_id = $r['source_id'];

    if (!empty($r['c_name'])) {
        $title = $r['c_name'];
        $image = $r['c_image'];
        $description = $r['c_description'];
        $source_table = 'compositions_donuts';
        $source_id = $r['c_id'];
    } elseif (!empty($r['n_title'])) {
        $title = $r['n_title'];
        $image = $r['n_image'];
        $description = $r['n_description'];
        $source_table = 'nos_donuts';
        $source_id = $r['n_id'];
    } elseif (!empty($r['id_compositions_donuts'])) {
        // fallback : older rows that use id_compositions_donuts column but source_table wasn't set
        $fallbackStmt = $pdo->prepare("SELECT donut_name, image, description FROM compositions_donuts WHERE id_composition = :id LIMIT 1");
        $fallbackStmt->execute([':id' => $r['id_compositions_donuts']]);
        $fb = $fallbackStmt->fetch(PDO::FETCH_ASSOC);
        if ($fb) {
            $title = $fb['donut_name'];
            $image = $fb['image'];
            $description = $fb['description'];
            $source_table = 'compositions_donuts';
            $source_id = (int)$r['id_compositions_donuts'];
        }
    }

    // Si on a toujours rien (source invalide), on saute la ligne
    if ($title === null) continue;

    $items[] = [
        'id_fk_panier' => (int)$r['id_fk_panier'],
        'quantite' => (int)$r['quantite'],
        'title' => $title,
        'image' => $image,
        'description' => $description,
        'source_table' => $source_table,
        'source_id' => $source_id,
    ];
}

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
<div class="h1"><h1>Mon panier</h1></div>

<?php if (empty($items)): ?>
  <div class="empty">Ton panier est vide.</div>
<?php else: ?>
  <div class='cards-container' id="cart-list">
    <?php foreach ($items as $it): ?>
      <div class="card cart-item" data-id_fk_panier="<?php echo htmlspecialchars($it['id_fk_panier'], ENT_QUOTES); ?>">
        <img src="<?php echo htmlspecialchars($it['image'] ?: 'images/default-donut.jpg', ENT_QUOTES); ?>" alt="<?php echo htmlspecialchars($it['title'], ENT_QUOTES); ?>">
        <div class="item-info">
          <div><strong><?php echo htmlspecialchars($it['title'], ENT_QUOTES); ?></strong></div>
          <div ><?php echo htmlspecialchars($it['description'], ENT_QUOTES); ?></div>
          <div style="font-size:0.85rem;color:#888;margin-top:6px">Provenance: <?php echo htmlspecialchars($it['source_table']); ?> (id <?php echo htmlspecialchars($it['source_id']); ?>)</div>
        </div>
        <div class="actions">
          <div class="qty-control">
            <button class="decrease" aria-label="décrémenter">−</button>
            <div class="qty" data-quantite="<?php echo (int)$it['quantite']; ?>"><?php echo (int)$it['quantite']; ?></div>
            <button class="increase" aria-label="incrémenter">+</button>
          </div>
          <button class="remove" title="Supprimer"><i class='bx bxs-trash'></i></button>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

<script>
(function(){
  async function postJSON(data) {
    const resp = await fetch(location.href, {
      method: 'POST',
      headers: {'Content-Type':'application/json'},
      body: JSON.stringify(data),
      credentials: 'same-origin'
    });
    return resp.json();
  }

  function findAncestor(el, selector) {
    while (el && el !== document.body) {
      if (el.matches(selector)) return el;
      el = el.parentElement;
    }
    return null;
  }

  document.getElementById('cart-list')?.addEventListener('click', async function(e){
    const target = e.target;
    // Trouver l'élément .cart-item parent
    const itemEl = findAncestor(target, '.cart-item');
    if (!itemEl) return;

    // Trouver le bouton réel cliquable : increase / decrease / remove
    // On cherche les éléments qui portent ces classes ou un bouton (fallback)
    const actionBtn = target.closest('.increase, .decrease, .remove, button');
    if (!actionBtn) return;

    const id_fk_panier = parseInt(itemEl.getAttribute('data-id_fk_panier'), 10);
    const qtyEl = itemEl.querySelector('.qty');
    let qty = parseInt(qtyEl.textContent, 10);

    // Incrémenter
    if (actionBtn.classList.contains('increase')) {
      qty++;
      const res = await postJSON({ action: 'update_quantity', id_fk_panier: id_fk_panier, quantite: qty });
      if (res.success) {
        qtyEl.textContent = qty;
      } else {
        alert(res.msg || 'Erreur mise à jour');
      }
      return;
    }

    // Décrémenter
    if (actionBtn.classList.contains('decrease')) {
      qty = Math.max(0, qty - 1);
      const res = await postJSON({ action: 'update_quantity', id_fk_panier: id_fk_panier, quantite: qty });
      if (res.success) {
        if (res.deleted) {
          itemEl.remove();
          if (!document.querySelectorAll('.cart-item').length) {
            document.getElementById('cart-list').innerHTML = '<div class="empty">Ton panier est vide.</div>';
          }
        } else {
          qtyEl.textContent = qty;
        }
      } else {
        alert(res.msg || 'Erreur mise à jour');
      }
      return;
    }

    // Supprimer (corbeille)
    if (actionBtn.classList.contains('remove')) {
      if (!confirm('Supprimer cet article du panier ?')) return;
      const res = await postJSON({ action: 'update_quantity', id_fk_panier: id_fk_panier, quantite: 0 });
      if (res.success) {
        itemEl.remove();
        if (!document.querySelectorAll('.cart-item').length) {
          document.getElementById('cart-list').innerHTML = '<div class="empty">Ton panier est vide.</div>';
        }
      } else {
        alert(res.msg || 'Erreur suppression');
      }
      return;
    }

    // Si on clique sur un <button> sans classes spécifiques, on ne fait rien
  });
})();
</script>
<script src="js/header.js"></script>

</body>
</html>
