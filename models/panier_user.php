<?php function getUserPanier($pdo, $userId)
{
    $stmt = $pdo->prepare("
        SELECT 
            fp.id_fk_panier,
            fp.quantite,
            fp.source_table,
            fp.source_id,
            cd.donut_name,
            cd.description AS cd_description,
            b.img_beignets, f.img_fourrage, g.img_glacage, t.img_topping,
            nd.img AS base_img, nd.title AS base_title, nd.description AS nd_description
        FROM fk_panier fp
        LEFT JOIN compositions_donuts cd ON fp.id_compositions_donuts = cd.id_composition
        LEFT JOIN beignets b ON cd.id_beignet = b.id_beignet
        LEFT JOIN fourrages f ON cd.id_fourrage = f.id_fourrage
        LEFT JOIN glacages g ON cd.id_glacage = g.id_glacage
        LEFT JOIN topping t ON cd.id_topping = t.id_topping
        LEFT JOIN nos_donuts nd ON fp.source_table = 'nos_donuts' AND fp.source_id = nd.id_donuts_de_base
        WHERE fp.id_users = ?
    ");
    $stmt->execute([$userId]);
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $result = [];

    foreach ($items as $item) {
        $images = [];
        $description = null;

        if ($item['source_table'] === 'compositions_donuts' && $item['donut_name']) {
            // Donut personnalisé : on met toutes les images
            if ($item['img_beignets'])
                $images[] = $item['img_beignets'];
            if ($item['img_fourrage'])
                $images[] = $item['img_fourrage'];
            if ($item['img_glacage'])
                $images[] = $item['img_glacage'];
            if ($item['img_topping'])
                $images[] = $item['img_topping'];

            $donutName = $item['donut_name'];
            $description = $item['cd_description'] ?? null;
        } else {
            // Donut de base
            if ($item['base_img'])
                $images[] = $item['base_img'];
            $donutName = $item['base_title'] ?? 'Donut';
            $description = $item['nd_description'] ?? null;
        }

        $result[] = [
            'panier_id' => $item['id_fk_panier'],
            'donut_name' => $donutName,
            'description' => $description,
            'quantite' => $item['quantite'],
            'images' => $images
        ];
    }

    return $result;
}

