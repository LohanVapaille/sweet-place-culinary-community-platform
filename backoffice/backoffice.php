<?php
include ".../config.php";
include "./header/header.php";
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Backoffice</title>

    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mada:wght@200..900&family=Modak&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="shortcut icon" href="images/design/menudonuts.svg" type="image/x-icon">

</head>

<div class="container mt-5">
    <h1>Backoffice Donuts</h1>
    <div class="row">
        <div class="col-md-3">
            <a href="users/list.php" class="btn btn-primary w-100 mb-2">Utilisateurs</a>
        </div>
        <div class="col-md-3">
            <a href="compos/list.php" class="btn btn-primary w-100 mb-2">Compositions Users</a>
        </div>
        <div class="col-md-3">
            <a href="beignets/list.php" class="btn btn-primary w-100 mb-2">Beignets</a>
        </div>
        <div class="col-md-3">
            <a href="commentaires/list.php" class="btn btn-primary w-100 mb-2">Commentaires</a>
        </div>
    </div>
</div>

<?php include "../footer/footer.php"; ?>