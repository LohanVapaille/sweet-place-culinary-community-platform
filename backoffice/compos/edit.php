<?php
include "../config.php";


$table = "compositions_donuts";
$columns = ["donut_name", "id_beignet", "id_fourrage", "id_glacage", "id_topping", "id_createur", "description", "type", "prix"];
$id_col = "id_composition"; // Nom de la colonne ID

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM $table WHERE $id_col=?");
$stmt->execute([$id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $set = implode(',', array_map(fn($c) => "$c=?", $columns));
    $stmt = $pdo->prepare("UPDATE $table SET $set WHERE $id_col=?");
    $stmt->execute([...array_map(fn($c) => $_POST[$c], $columns), $id]);
    header("Location: list.php");
}
?>

<div class="container mt-5">
    <h2>Modifier <?= $table ?></h2>
    <form method="post">
        <?php foreach ($columns as $col): ?>
            <div class="mb-3">
                <label><?= $col ?></label>
                <input type="text" name="<?= $col ?>" class="form-control" value="<?= $row[$col] ?>" required>
            </div>
        <?php endforeach; ?>
        <button class="btn btn-warning">Modifier</button>
    </form>
</div>