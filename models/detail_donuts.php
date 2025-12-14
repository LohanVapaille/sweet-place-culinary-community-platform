<?php
/**
 * Récupère les infos d'un donuts (composition ou base) sous forme de tableau PHP.
 *
 * @param PDO $pdo Instance PDO (connectée)
 * @param int $id  id de la ressource (peut être id_composition ou id_donuts_de_base)
 * @return array|null Retourne un tableau associatif contenant 'type' et 'data', ou null si introuvable.
 */
function getInfoDonutsById(PDO $pdo, int $id): ?array
{
    // sanitize
    $id = (int) $id;
    if ($id <= 0) {
        return null;
    }

    // 1) Vérifier si c'est une composition
    $checkComp = $pdo->prepare("SELECT 1 FROM compositions_donuts WHERE id_composition = :id LIMIT 1");
    $checkComp->execute([':id' => $id]);
    if ($checkComp->fetchColumn()) {
        // Récupérer la composition + créateur + beignet/fourrage/glacage/topping
        $sql = "
            SELECT
              c.id_composition,
              c.donut_name,
              c.description,
              c.type AS composition_type,
              u.id_user   AS creator_id,
              u.login     AS creator_login,
              u.photo     AS creator_photo,
              u.description AS creator_description,
              b.id_beignet,
              b.name_beignet,
              b.img_beignets,
              b.type_beignet,
              f.id_fourrage, f.name_fourrage, f.img_fourrage, f.type_fourrage,
              g.id_glacage,  g.name_glacage,  g.img_glacage,  g.type_glacage,
              t.id_topping,  t.name_topping,  t.img_topping,  t.type_topping
            FROM compositions_donuts c
            JOIN users u ON c.id_createur = u.id_user
            JOIN beignets b ON c.id_beignet = b.id_beignet
            LEFT JOIN fourrages f ON c.id_fourrage = f.id_fourrage
            LEFT JOIN glacages  g ON c.id_glacage  = g.id_glacage
            LEFT JOIN topping    t ON c.id_topping  = t.id_topping
            WHERE c.id_composition = :id
            LIMIT 1
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        $comp = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$comp) {
            return null;
        }

        // Likes count (fk_like)
        $stmt = $pdo->prepare("SELECT COUNT(*) AS nb FROM fk_like WHERE id_compositions_donuts = :id");
        $stmt->execute([':id' => $id]);
        $likes = (int) $stmt->fetchColumn();

        // Commentaires pour cette composition
        $stmt = $pdo->prepare("
            SELECT id_commentaire, `text-comment` AS texte, note, `date`, id_auteur
            FROM commentaires
            WHERE id_donuts_concerné = :id
            ORDER BY `date` DESC
        ");
        $stmt->execute([':id' => $id]);
        $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Enrichir les commentaires avec les infos auteurs (login/photo) si on veut
        // Récupérer les auteurs en masse pour éviter N+1
        $authorIds = [];
        foreach ($comments as $c) {
            $authorIds[(int) $c['id_auteur']] = true;
        }
        $authors = [];
        if (!empty($authorIds)) {
            $placeholders = implode(',', array_fill(0, count($authorIds), '?'));
            $idsVals = array_keys($authorIds);
            $q = $pdo->prepare("SELECT id_user, login, photo FROM users WHERE id_user IN ($placeholders)");
            $q->execute($idsVals);
            $rows = $q->fetchAll(PDO::FETCH_ASSOC);
            foreach ($rows as $r) {
                $authors[(int) $r['id_user']] = $r;
            }
        }

        // Convertir la date si c'est un timestamp int -> ajouter une date lisible
        foreach ($comments as &$c) {
            if (is_numeric($c['date'])) {
                $ts = (int) $c['date'];
                // si la valeur semble être un timestamp (>= 1970) on convertit
                if ($ts > 0) {
                    $c['date_readable'] = date('Y-m-d H:i:s', $ts);
                } else {
                    $c['date_readable'] = $c['date'];
                }
            } else {
                $c['date_readable'] = $c['date'];
            }
            $aid = (int) $c['id_auteur'];
            $c['auteur'] = $authors[$aid] ?? null;
        }
        unset($c);

        // Compter commentaires
        $comments_count = count($comments);

        // Construire le tableau de retour
        $result = [
            'type' => 'composition',
            'data' => [
                'composition' => $comp,
                'likes_count' => $likes,
                'comments_count' => $comments_count,
                'comments' => $comments,
            ],
        ];

        return $result;
    }

    // 2) Sinon vérifier si c'est un donut de base (nos_donuts)
    $checkBase = $pdo->prepare("SELECT 1 FROM nos_donuts WHERE id_donuts_de_base = :id LIMIT 1");
    $checkBase->execute([':id' => $id]);
    if ($checkBase->fetchColumn()) {
        $stmt = $pdo->prepare("SELECT * FROM nos_donuts WHERE id_donuts_de_base = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $base = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$base) {
            return null;
        }

        // Likes count sur la base (fk_like_base)
        $stmt = $pdo->prepare("SELECT COUNT(*) AS nb FROM fk_like_base WHERE id_donuts_de_base = :id");
        $stmt->execute([':id' => $id]);
        $likes = (int) $stmt->fetchColumn();

        $result = [
            'type' => 'base',
            'data' => [
                'base' => $base,
                'likes_count' => $likes
            ]
        ];

        return $result;
    }

    // Rien trouvé
    return null;
}
