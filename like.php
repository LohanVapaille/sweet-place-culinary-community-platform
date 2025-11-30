<?php
// like.php
header('Content-Type: application/json; charset=utf-8');
session_start();
require 'config.php'; // doit définir $pdo (PDO)

// Méthode
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Lire JSON
$input = json_decode(file_get_contents('php://input'), true);
if (!is_array($input)) $input = [];

// Récupérer l'ID utilisateur depuis la session (priorité à 'id')
$userId = null;
if (!empty($_SESSION['id'])) {
    $userId = (int) $_SESSION['id'];
} else {
    $possibleKeys = ['id_user', 'user_id', 'idUtilisateur', 'user', 'uid'];
    foreach ($possibleKeys as $k) {
        if (!empty($_SESSION[$k])) {
            $userId = (int) $_SESSION[$k];
            break;
        }
    }
}

if (empty($userId)) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Non authentifié']);
    exit;
}

// Accept both 'id_composition' (old) and 'id' (new)
$compositionId = 0;
if (isset($input['id_composition'])) {
    $compositionId = (int) $input['id_composition'];
} elseif (isset($input['id'])) {
    $compositionId = (int) $input['id'];
} elseif (isset($_POST['id_composition'])) {
    // fallback if form-encoded
    $compositionId = (int) $_POST['id_composition'];
} elseif (isset($_POST['id'])) {
    $compositionId = (int) $_POST['id'];
}

if ($compositionId <= 0) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'ID de composition invalide']);
    exit;
}

try {
    // Vérifier si like existe (toggle)
    $stmt = $pdo->prepare("SELECT id_like FROM fk_like WHERE id_compositions_donuts = :comp AND id_users = :user LIMIT 1");
    $stmt->execute([':comp' => $compositionId, ':user' => $userId]);
    $exists = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($exists) {
        // unlike
        $del = $pdo->prepare("DELETE FROM fk_like WHERE id_like = :id_like");
        $del->execute([':id_like' => $exists['id_like']]);
        $liked = false;
    } else {
        // like
        $ins = $pdo->prepare("INSERT INTO fk_like (id_compositions_donuts, id_users) VALUES (:comp, :user)");
        $ins->execute([':comp' => $compositionId, ':user' => $userId]);
        $liked = true;
    }

    // Compter likes
    $count = $pdo->prepare("SELECT COUNT(*) AS c FROM fk_like WHERE id_compositions_donuts = :comp");
    $count->execute([':comp' => $compositionId]);
    $likes = (int) $count->fetch(PDO::FETCH_ASSOC)['c'];

    echo json_encode([
        'success' => true,
        'liked' => $liked,
        'likes' => $likes
    ]);
    exit;

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Erreur base de données']);
    exit;
}

<script src="js/header.js"></script>
