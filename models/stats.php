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
            NULL AS image,
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


/**
 * Récupère les compositions créées par un utilisateur, avec nb_likes et already_liked.
 */
/**
 * Récupère les compositions créées par un utilisateur, avec nb_likes et already_liked.
 */
function getCompoByUser(PDO $pdo, int $creatorId, int $currentUser = 0, int $limit = 0, bool $random = false): array
{
    $sql = "
        SELECT
        c.id_composition,
        c.donut_name,
        c.description,
        c.prix,
        c.id_createur,
        u.login,
        c.id_beignet,
        c.id_fourrage,
        c.id_glacage,
        c.id_topping,
        b.name_beignet,
        b.img_beignets,
        f.name_fourrage,
        f.img_fourrage,
        g.name_glacage,
        g.img_glacage,
        t.name_topping,
        t.img_topping,
        (SELECT COUNT(*) FROM fk_like l WHERE l.id_compositions_donuts = c.id_composition) AS likes,
        EXISTS(
          SELECT 1 FROM fk_like l2
          WHERE l2.id_compositions_donuts = c.id_composition
            AND l2.id_users = :currentUser
        ) AS already_liked,
        'compo' AS type,
        c.id_createur AS id_user
    FROM compositions_donuts c
        LEFT JOIN beignets b ON c.id_beignet = b.id_beignet
        LEFT JOIN fourrages f ON c.id_fourrage = f.id_fourrage
        LEFT JOIN glacages g ON c.id_glacage = g.id_glacage
        LEFT JOIN topping t ON c.id_topping = t.id_topping
        LEFT JOIN users u ON c.id_createur = u.id_user  -- C'EST LA LIGNE CORRIGÉE
        WHERE c.id_createur = :creator
    ";

    // tri
    if ($random) {
        $sql .= " ORDER BY RAND() ";
    } else {
        $sql .= " ORDER BY c.id_composition DESC ";
    }

    // limite optionnelle
    if ($limit > 0) {
        $sql .= " LIMIT :limit";
    }

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':currentUser', $currentUser, PDO::PARAM_INT);
    $stmt->bindValue(':creator', $creatorId, PDO::PARAM_INT);

    if ($limit > 0) {
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

