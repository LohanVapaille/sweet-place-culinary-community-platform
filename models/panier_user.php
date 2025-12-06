<?php
class PanierModel
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Récupère tous les items du panier pour un utilisateur donné
     */
    public function getItemsByUser(int $userId): array
    {
        $sql = "
        SELECT p.id_fk_panier, p.quantite, p.source_table, p.source_id, p.id_compositions_donuts,
               c.id_composition AS c_id, c.donut_name AS c_name, c.image AS c_image, c.description AS c_description,
               n.id_donuts_de_base AS n_id, n.title AS n_title, n.img AS n_image, n.description AS n_description
        FROM fk_panier p
        LEFT JOIN compositions_donuts c
          ON p.source_table = 'compositions_donuts' AND p.source_id = c.id_composition
        LEFT JOIN nos_donuts n
          ON p.source_table = 'nos_donuts' AND p.source_id = n.id_donuts_de_base
        WHERE p.id_users = :id_users
        ORDER BY p.id_fk_panier DESC
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id_users' => $userId]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $items = [];
        foreach ($rows as $r) {
            if ($r['source_table'] === 'compositions_donuts') {
                $title = $r['c_name'];
                $image = $r['c_image'];
                $description = $r['c_description'];
                $source_id = $r['c_id'];
            } elseif ($r['source_table'] === 'nos_donuts') {
                $title = $r['n_title'];
                $image = $r['n_image'];
                $description = $r['n_description'];
                $source_id = $r['n_id'];
            } else {
                // source invalide, on ignore
                continue;
            }

            $items[] = [
                'id_fk_panier' => (int) $r['id_fk_panier'],
                'quantite' => (int) $r['quantite'],
                'title' => $title ?? '',
                'image' => $image ?? '',
                'description' => $description ?? '',
                'source_table' => $r['source_table'] ?? '',
                'source_id' => $source_id ?? 0,
            ];
        }

        return $items;
    }
}
