<?php
require "../../config.php";

$table = "compositions_donuts";
$id_col = "id_composition";
$id = $_GET['id'];

// Supprimer les likes liés à cette composition
$stmt = $pdo->prepare("DELETE FROM fk_like WHERE id_compositions_donuts = ?");
$stmt->execute([$id]);

// Supprimer les paniers liés à cette composition
$stmt = $pdo->prepare("DELETE FROM fk_panier WHERE id_compositions_donuts = ?");
$stmt->execute([$id]);

// Supprimer les commentaires liés à cette composition
$stmt = $pdo->prepare("DELETE FROM commentaires WHERE id_donuts_concerné = ?");
$stmt->execute([$id]);

// Supprimer la composition
$stmt = $pdo->prepare("DELETE FROM $table WHERE $id_col = ?");
$stmt->execute([$id]);

// Redirection
header("Location: list.php");
exit;
