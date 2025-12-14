<?php
function getDonutsUsers(PDO $pdo, int $userId = 0, int $limit = 0, bool $random = false): array
{
    $sql = "
    SELECT 
        c.id_composition,
        c.donut_name,
        c.description,
        c.type AS composition_type,
        u.id_user,
        u.login,

        -- beignet
        b.id_beignet,
        b.name_beignet,
        b.img_beignets,
        b.type_beignet,

        -- fourrage
        f.id_fourrage,
        f.name_fourrage,
        f.img_fourrage,
        f.type_fourrage,

        -- glacage
        g.id_glacage,
        g.name_glacage,
        g.img_glacage,
        g.type_glacage,

        -- topping
        t.id_topping,
        t.name_topping,
        t.img_topping,
        t.type_topping,

        COALESCE(l.likes, 0) AS likes,
        EXISTS(
          SELECT 1 FROM fk_like f2
          WHERE f2.id_compositions_donuts = c.id_composition
            AND f2.id_users = :userId
        ) AS already_liked

    FROM compositions_donuts c
    JOIN users u ON c.id_createur = u.id_user

    LEFT JOIN beignets b ON c.id_beignet = b.id_beignet
    LEFT JOIN fourrages f ON c.id_fourrage = f.id_fourrage
    LEFT JOIN glacages g ON c.id_glacage = g.id_glacage
    LEFT JOIN topping t ON c.id_topping = t.id_topping

    LEFT JOIN (
        SELECT id_compositions_donuts, COUNT(*) AS likes
        FROM fk_like
        GROUP BY id_compositions_donuts
    ) l ON l.id_compositions_donuts = c.id_composition
    ";

    if ($random) {
        $sql .= " ORDER BY RAND() ";
    } else {
        $sql .= " ORDER BY c.id_composition DESC ";
    }

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




