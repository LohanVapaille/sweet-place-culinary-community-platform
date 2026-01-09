<?php

require "../../config.php";



$table = "commentaires";

$stmt = $pdo->query("SELECT * FROM $table");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste de <?= ucfirst($table) ?></title>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/backoffice.css">
    <link href="https://fonts.googleapis.com/css2?family=Mada:wght@200..900&family=Modak&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="shortcut icon" href="images/design/menudonuts.svg" type="image/x-icon">
</head>

<body>
    <header class="bg-dark text-white p-3 mb-4">
        <div class="container">
            <h1 class="">Backoffice - <?= ucfirst($table) ?></h1>
        </div>
    </header>

    <main class="container">
        <h2 class="mb-4">Liste des <strong><?= ucfirst($table) ?></strong></h2>
        <a href="../backoffice.php" class="btn btn-secondary mb-3">
            <i class="bi bi-arrow-left-circle"></i> Retour au backoffice
        </a>
        <div class="table-responsive shadow-sm rounded">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <?php foreach (array_keys($rows[0]) as $col): ?>
                            <th scope="col"><?= ucfirst(str_replace("_", " ", $col)) ?></th>
                        <?php endforeach; ?>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $row): ?>
                        <tr>
                            <?php foreach ($row as $value): ?>
                                <td><?= htmlspecialchars($value) ?></td>
                            <?php endforeach; ?>
                            <td>
                                <a href="edit.php?id=<?= $row[array_keys($row)[0]] ?>" class="btn btn-sm btn-warning me-1">
                                    <i class="bi bi-pencil-square"></i> Modifier
                                </a>
                                <a href="delete.php?id=<?= $row[array_keys($row)[0]] ?>" class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i> Supprimer
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>

    <footer class="bg-light text-center py-3 mt-4">
        &copy; <?= date("Y") ?> Backoffice
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-QF3k5Uq6CkT9rF1r6I0wM9W1qGzt1GZm+DlHs6c8/w1AwE+0Q5PjF3qzZ+9tF4Vp"
        crossorigin="anonymous"></script>
</body>

</html>