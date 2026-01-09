<?php
// like_base.php
header('Content-Type: application/json; charset=utf-8');
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}


$input = json_decode(file_get_contents('php://input'), true);

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
    echo json_encode([
        'success' => false,
        'message' => 'Non authentifié',
        'redirect' => 'connexion.php'
    ]);
    exit;
}
$donutId = isset($input['id']) ? (int) $input['id'] : 0;
if ($donutId <= 0) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'ID de donut invalide']);
    exit;
}

try {

    $stmt = $pdo->prepare("SELECT id_like FROM fk_like_base WHERE id_donuts_de_base = :did AND id_users = :uid LIMIT 1");
    $stmt->execute([':did' => $donutId, ':uid' => $userId]);
    $exists = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($exists) {
        $del = $pdo->prepare("DELETE FROM fk_like_base WHERE id_like = :id_like");
        $del->execute([':id_like' => $exists['id_like']]);
        $liked = false;
    } else {
        $ins = $pdo->prepare("INSERT INTO fk_like_base (id_donuts_de_base, id_users) VALUES (:did, :uid)");
        $ins->execute([':did' => $donutId, ':uid' => $userId]);
        $liked = true;
    }

    // Compter
    $count = $pdo->prepare("SELECT COUNT(*) AS c FROM fk_like_base WHERE id_donuts_de_base = :did");
    $count->execute([':did' => $donutId]);
    $likes = (int) $count->fetch(PDO::FETCH_ASSOC)['c'];

    echo json_encode(['success' => true, 'liked' => $liked, 'likes' => $likes]);
    exit;

} catch (PDOException $e) {
    http_response_code(500);

    echo json_encode(['success' => false, 'message' => 'Erreur base de données']);
    exit;
}
