<?php
include "../config.php";

$table = "users";
$id_col = "id_user"; // Remplacer par le nom de la colonne ID
$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM $table WHERE $id_col=?");
$stmt->execute([$id]);

header("Location: list.php");
