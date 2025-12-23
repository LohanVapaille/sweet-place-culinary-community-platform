<?php
include "../config.php";


$table = "users"; // Remplacer par le nom de la table
$columns = ["login", "mdp", "photo", "description", "admin"]; // Remplacer par les colonnes de la table

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $placeholders = implode(',', array_fill(0, count($columns), '?'));
    $stmt = $pdo->prepare("INSERT INTO $table (" . implode(',', $columns) . ") VALUES ($placeholders)");
    $stmt->execute(array_map(fn($col) => $_POST[$col], $columns));
    header("Location: list.php");
}

?>

<div class="container mt-5">
    <h2>Ajouter à <?= $table ?></h2>
    <form method="post">
        <?php foreach ($columns as $col): ?>
            <div class="mb-3">
                <label><?= $col ?></label>
                <input type="text" name="<?= $col ?>" class="form-control" required>
            </div>
        <?php endforeach; ?>
        <button class="btn btn-success">Ajouter</button>
    </form>
</div>