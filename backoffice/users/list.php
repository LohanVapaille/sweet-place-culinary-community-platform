<?php
include "../config.php";
include "../header/header.php";

$table = "users"; // Remplacer par le nom de la table
$stmt = $pdo->query("SELECT * FROM $table");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-5">
    <h2>Liste de <?= $table ?></h2>
    <a href="add.php" class="btn btn-success mb-3">Ajouter</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <?php foreach (array_keys($rows[0]) as $col): ?>
                    <th><?= $col ?></th>
                <?php endforeach; ?>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $row): ?>
                <tr>
                    <?php foreach ($row as $value): ?>
                        <td><?= $value ?></td>
                    <?php endforeach; ?>
                    <td>
                        <a href="edit.php?id=<?= $row[array_keys($row)[0]] ?>" class="btn btn-warning btn-sm">Modifier</a>
                        <a href="delete.php?id=<?= $row[array_keys($row)[0]] ?>" class="btn btn-danger btn-sm">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- <?php include "../footer.php"; ?> -->