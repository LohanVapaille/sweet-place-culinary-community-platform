<?php


function getInfosUser(PDO $pdo, int $userId): ?array
{
    $sql = "SELECT * FROM users WHERE id_user = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    return $user ?: null; // retourne null si aucun utilisateur
}

/**
 * Nombre total de likes reçus par un utilisateur sur toutes ses compositions.
 */
function getTotalLikesForUser(PDO $pdo, int $userId): int
{
    $sql = "
        SELECT COUNT(*) AS total_likes
        FROM fk_like l
        JOIN compositions_donuts c ON l.id_compositions_donuts = c.id_composition
        WHERE c.id_createur = ?
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$userId]);
    return (int) $stmt->fetchColumn();
}

/**
 * Nombre total de followers pour un utilisateur.
 */
function getTotalFollowers(PDO $pdo, int $userId): int
{
    $sql = "
        SELECT COUNT(*) AS total_followers
        FROM fk_follow
        WHERE id_user_suivit = ?
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$userId]);
    return (int) $stmt->fetchColumn();
}

