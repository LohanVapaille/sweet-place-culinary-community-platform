<?php
session_start();
require 'config.php'; // doit définir $pdo (PDO connecté à la BDD 'donuts')

// Vérifs
if (!isset($pdo) || !($pdo instanceof PDO)) {
    die('Erreur : connexion BDD introuvable. Vérifie config.php.');
}
if (!isset($_SESSION['id'])) {
    header('Location: connexion.php'); // ou autre page
    exit;
}
$userId = (int) $_SESSION['id'];

// Récupérer id en GET
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $back = $_SERVER['HTTP_REFERER'] ?? 'feed.php';
    header('Location: ' . $back);
    exit;
}
$incomingId = (int) $_GET['id'];

// Déterminer la source selon ta règle (nos_donuts : ids 1..50 ; compositions : >=51)
$sourceTable = ($incomingId <= 50) ? 'nos_donuts' : 'compositions_donuts';
$sourceId = $incomingId;

// Vérifier que la source existe (sécurité)
if ($sourceTable === 'nos_donuts') {
    $stmt = $pdo->prepare("SELECT id_donuts_de_base FROM nos_donuts WHERE id_donuts_de_base = :id LIMIT 1");
    $stmt->execute([':id' => $sourceId]);
    if (!$stmt->fetch()) {
        $back = $_SERVER['HTTP_REFERER'] ?? 'feed.php';
        header('Location: ' . $back);
        exit;
    }
} else {
    $stmt = $pdo->prepare("SELECT id_composition FROM compositions_donuts WHERE id_composition = :id LIMIT 1");
    $stmt->execute([':id' => $sourceId]);
    if (!$stmt->fetch()) {
        $back = $_SERVER['HTTP_REFERER'] ?? 'feed.php';
        header('Location: ' . $back);
        exit;
    }
}

// Vérifier s'il existe déjà une ligne panier pour cette user+source
$checkSql = "SELECT id_fk_panier, quantite, id_compositions_donuts, source_table, source_id
             FROM fk_panier
             WHERE id_users = :id_user AND source_table = :source_table AND source_id = :source_id
             LIMIT 1";
$check = $pdo->prepare($checkSql);
$check->execute([
    ':id_user' => $userId,
    ':source_table' => $sourceTable,
    ':source_id' => $sourceId
]);
$existing = $check->fetch(PDO::FETCH_ASSOC);

if ($existing) {
    // incrémenter la quantité
    $newQty = (int)$existing['quantite'] + 1;
    $upd = $pdo->prepare("UPDATE fk_panier SET quantite = :q WHERE id_fk_panier = :id_fk_panier AND id_users = :id_user");
    $upd->execute([
        ':q' => $newQty,
        ':id_fk_panier' => $existing['id_fk_panier'],
        ':id_user' => $userId
    ]);
} else {
    // insérer nouvelle ligne : on remplit aussi id_compositions_donuts si source = compositions_donuts (optionnel)
    if ($sourceTable === 'compositions_donuts') {
        $ins = $pdo->prepare("
            INSERT INTO fk_panier (id_compositions_donuts, id_users, quantite, source_table, source_id)
            VALUES (:id_compo, :id_user, :quantite, :source_table, :source_id)
        ");
        $ins->execute([
            ':id_compo' => $sourceId,
            ':id_user' => $userId,
            ':quantite' => 1,
            ':source_table' => $sourceTable,
            ':source_id' => $sourceId
        ]);
    } else {
        // provenance nos_donuts : on laisse id_compositions_donuts NULL
        $ins = $pdo->prepare("
            INSERT INTO fk_panier (id_compositions_donuts, id_users, quantite, source_table, source_id)
            VALUES (NULL, :id_user, :quantite, :source_table, :source_id)
        ");
        $ins->execute([
            ':id_user' => $userId,
            ':quantite' => 1,
            ':source_table' => $sourceTable,
            ':source_id' => $sourceId
        ]);
    }
}

// Redirection vers la page précédente ou feed
$back = $_SERVER['HTTP_REFERER'] ?? 'feed.php';
header('Location: ' . $back);
exit;
