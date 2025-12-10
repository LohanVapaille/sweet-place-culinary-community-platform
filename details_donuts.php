<?php
session_start();

require 'config.php';

// ---------- PROTECTION BASIQUE ----------
if (!isset($_SESSION['id'])) {
    header('Location: connexion.php');
    exit;
}
$user = (int) $_SESSION['id'];

?>
<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Details</title>
    <?php include 'css/links.php'; ?>
    <link rel="stylesheet" href="css/panier.css">

</head>

<body>
    <?php include 'header/header.php'; ?>

    <script src="js/header.js"></script>

</body>

</html>