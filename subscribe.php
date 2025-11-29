<?php
session_start();
require 'config.php';

$user_id = $_SESSION['id'] ?? null;
$target_id = $_POST['user_id'] ?? null;

if (!$user_id || !$target_id || $user_id == $target_id) {
    echo json_encode(['status'=>'error']);
    exit;
}

// Vérifier si déjà abonné
$stmt_check = $pdo->prepare("SELECT COUNT(*) FROM fk_follow WHERE id_user_suivit = ? AND id_user_qui_follow = ?");
$stmt_check->execute([$target_id, $user_id]);
$already = $stmt_check->fetchColumn() > 0;

if ($already) {
    // Se désabonner
    $stmt_del = $pdo->prepare("DELETE FROM fk_follow WHERE id_user_suivit = ? AND id_user_qui_follow = ?");
    $stmt_del->execute([$target_id, $user_id]);
    echo json_encode(['status'=>'unsubscribed']);
} else {
    // S'abonner
    $stmt_add = $pdo->prepare("INSERT INTO fk_follow (id_user_suivit, id_user_qui_follow) VALUES (?, ?)");
    $stmt_add->execute([$target_id, $user_id]);
    echo json_encode(['status'=>'subscribed']);
}

