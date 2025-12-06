<?php
function getDonutsSweetplace(PDO $pdo, int $userId = 0, int $limit = 0, bool $random = false): array
{
    $sql = "
        SELECT d.id_donuts_de_base,
               d.title,
               d.img,
               d.imgAlt,
               d.description,
               COALESCE(l.likes, 0) AS likes,
               EXISTS(
                 SELECT 1 FROM fk_like_base f
                 WHERE f.id_donuts_de_base = d.id_donuts_de_base
                   AND f.id_users = :userId
               ) AS already_liked
        FROM nos_donuts d
        LEFT JOIN (
            SELECT id_donuts_de_base, COUNT(*) AS likes
            FROM fk_like_base
            GROUP BY id_donuts_de_base
        ) l ON l.id_donuts_de_base = d.id_donuts_de_base
    ";

    // Tri ou aléatoire
    if ($random) {
        $sql .= " ORDER BY RAND() ";
    } else {
        $sql .= " ORDER BY d.id_donuts_de_base DESC ";
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
