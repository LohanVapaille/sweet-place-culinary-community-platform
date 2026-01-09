<?php
require "../../config.php";

$table = "commentaires";
$id_col = "id_commentaire";
$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM $table WHERE $id_col=?");
$stmt->execute([$id]);

header("Location: list.php");
