<?php
function getDonutsUsers(PDO $pdo, int $userId = 0, int $limit = 0, bool $random = false): array
{
    $sql = "
    SELECT c.id_composition,
           c.donut_name,
           c.image,
           c.description,
           u.id_user AS creator_id,
           u.login AS creator_name,
           COALESCE(l.likes, 0) AS likes,
           EXISTS(
             SELECT 1 FROM fk_like f
             WHERE f.id_compositions_donuts = c.id_composition
               AND f.id_users = :userId
           ) AS already_liked
    FROM compositions_donuts c
    JOIN users u ON c.id_createur = u.id_user
    LEFT JOIN (
        SELECT id_compositions_donuts, COUNT(*) AS likes
        FROM fk_like
        GROUP BY id_compositions_donuts
    ) l ON l.id_compositions_donuts = c.id_composition
    ";

    // Choix du tri
    if ($random) {
        $sql .= " ORDER BY RAND() ";
    } else {
        $sql .= " ORDER BY c.id_composition DESC ";
    }

    // Limite si demandée
    if ($limit > 0) {
        $sql .= " LIMIT :limit";
    }

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);

    if ($limit > 0) {
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
