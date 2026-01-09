<?php
session_start();
require "../config.php";
require '../models/stats.php';



if (!isset($_SESSION['id'])) {
    header('Location: ../index.php');
    exit;
} else {
    $userId = $_SESSION['id'];
    $admin = getInfosUser($pdo, $userId);
    if ($admin['admin'] === 0) {

        header('Location: ../index.php');
        exit;
    }

}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Backoffice - SweetPlace</title>

    <link href="https://fonts.googleapis.com/css2?family=Mada:wght@200..900&family=Modak&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="shortcut icon" href="images/design/menudonuts.svg" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="css/backoffice.css">

    <style>
        .dashboard-card {
            transition: 0.2s ease-in-out;
            border-radius: 15px;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>

<body>

    <header class="bg-dark text-white py-3 mb-4">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 class=" mb-0">Backoffice - SweetPlace</h1>
            <a href="../index.php" class="btn btn-outline-light">
                <i class="bi bi-box-arrow-left"></i> Retour au site
            </a>
        </div>
    </header>

    <main class="container">
        <h2 class="mb-4">Gestion du site</h2>

        <div class="row g-4">
            <!-- Utilisateurs -->
            <div class="col-md-4">
                <a href="users/list.php" class="text-decoration-none">
                    <div class="shadow-sm bg-white p-4 text-center dashboard-card">
                        <i class="bi bi-people-fill fs-1 text-primary"></i>
                        <h5 class="mt-3">Utilisateurs</h5>
                        <p class="text-muted">Gérer les comptes et accès</p>
                    </div>
                </a>
            </div>

            <!-- Compositions Donuts -->
            <div class="col-md-4">
                <a href="compos/list.php" class="text-decoration-none">
                    <div class="shadow-sm bg-white p-4 text-center dashboard-card">
                        <i class="bi bi-bag-heart-fill fs-1 text-danger"></i>
                        <h5 class="mt-3">Compositions Donuts</h5>
                        <p class="text-muted">Modifier, supprimer</p>
                    </div>
                </a>
            </div>

            <!-- Commentaires -->
            <div class="col-md-4">
                <a href="comments/list.php" class="text-decoration-none">
                    <div class="shadow-sm bg-white p-4 text-center dashboard-card">
                        <i class="bi bi-chat-dots-fill fs-1 text-success"></i>
                        <h5 class="mt-3">Commentaires</h5>
                        <p class="text-muted">Modération & gestion</p>
                    </div>
                </a>
            </div>
        </div>
    </main>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>