<?php
session_start();
require 'config.php';

// Forcer JSON
header('Content-Type: application/json; charset=utf-8');




$user_id = $_SESSION['id'] ?? null;
$target_id = $_POST['user_id'] ?? null;


if (!$user_id) {
    http_response_code(401);
    echo json_encode(['status' => 'not_logged_in', 'message' => 'Utilisateur non authentifié']);
    exit;
}

if (!$target_id || $user_id == (int) $target_id) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Paramètre invalide']);
    exit;
}

// Vérifier si déjà abonné
$stmt_check = $pdo->prepare("SELECT COUNT(*) FROM fk_follow WHERE id_user_suivit = ? AND id_user_qui_follow = ?");
$stmt_check->execute([(int) $target_id, (int) $user_id]);
$already = $stmt_check->fetchColumn() > 0;

if ($already) {
    $stmt_del = $pdo->prepare("DELETE FROM fk_follow WHERE id_user_suivit = ? AND id_user_qui_follow = ?");
    $stmt_del->execute([(int) $target_id, (int) $user_id]);
    echo json_encode(['status' => 'unsubscribed']);
} else {
    $stmt_add = $pdo->prepare("INSERT INTO fk_follow (id_user_suivit, id_user_qui_follow) VALUES (?, ?)");
    $stmt_add->execute([(int) $target_id, (int) $user_id]);
    echo json_encode(['status' => 'subscribed']);
}
