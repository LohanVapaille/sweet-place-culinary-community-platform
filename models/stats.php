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


/**
 * Récupère tous les donuts compositions likés par un utilisateur.
 */
function getLikedCompositions(PDO $pdo, int $userId): array
{
    $sql = "
       SELECT 
            c.id_composition AS id,
            c.donut_name AS title,
            c.image AS image,
            c.description AS description
        FROM fk_like l
        JOIN compositions_donuts c ON l.id_compositions_donuts = c.id_composition
        WHERE l.id_users = ?

        UNION ALL

        SELECT 
            n.id_donuts_de_base AS id,
            n.title AS title,
            n.img AS image,
            n.description AS description
        FROM fk_like_base l
        JOIN nos_donuts n ON l.id_donuts_de_base = n.id_donuts_de_base
        WHERE l.id_users = ?

        ORDER BY id DESC

    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$userId, $userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

