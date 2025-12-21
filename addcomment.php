<?php
session_start();
require_once 'config.php'; // doit définir $pdo (PDO) avec exceptions activées

// Vérifier que l'utilisateur est connecté
if (empty($_SESSION['id'])) {
    http_response_code(403);
    echo "Accès refusé : connexion requise.";
    exit;
}

// Récupération et validation des données POST
$id_donuts = isset($_POST['id_donuts']) ? (int) $_POST['id_donuts'] : 0;
$comment_text = trim((string) ($_POST['comment_text'] ?? ''));
$note = isset($_POST['note']) ? (int) $_POST['note'] : null;
$id_auteur = (int) $_SESSION['id'];

$errors = [];
if ($id_donuts <= 0)
    $errors[] = "Produit invalide.";
if ($comment_text === '')
    $errors[] = "Le commentaire est vide.";
if (mb_strlen($comment_text) > 100)
    $errors[] = "Le commentaire est trop long (max 100 caractères).";
if ($note === null || $note < 1 || $note > 5)
    $errors[] = "Note invalide.";

if ($errors) {
    // Simple affichage des erreurs ; tu peux rediriger vers la page du donut et afficher via GET si tu préfères
    foreach ($errors as $e) {
        echo "<p>" . htmlspecialchars($e) . "</p>";
    }
    exit;
}

try {
    // Attention : ta colonne s'appelle `text-comment` dans la table. On garde ce nom exact avec backticks.
    $sql = "INSERT INTO `commentaires` (`text-comment`, `note`, `date`, `id_donuts_concerné`, `id_auteur`)
            VALUES (:text, :note, :date, :id_donuts, :id_auteur)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':text' => $comment_text,
        ':note' => $note,
        ':date' => time(),
        ':id_donuts' => $id_donuts,
        ':id_auteur' => $id_auteur,
    ]);
} catch (PDOException $e) {
    error_log("Erreur insert commentaire : " . $e->getMessage());
    echo "Une erreur est survenue, réessaye plus tard.";
    exit;
}

$_SESSION['comment_added'] = true;

// Redirection vers la page du donuts
header("Location: details_donuts.php?id=" . $id_donuts . '#comment');
exit;
