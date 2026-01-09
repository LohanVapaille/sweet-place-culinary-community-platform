<?php
require "../../config.php";

$table = "users";
$id_col = "id_user";
$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM fk_like WHERE id_users=?");
$stmt->execute([$id]);

$stmt = $pdo->prepare("DELETE FROM fk_follow WHERE id_user_suivit=?");
$stmt->execute([$id]);

$stmt = $pdo->prepare("DELETE FROM fk_follow WHERE id_user_qui_follow=?");
$stmt->execute([$id]);

$stmt = $pdo->prepare("DELETE FROM fk_like_base WHERE id_users=?");
$stmt->execute([$id]);

$stmt = $pdo->prepare("DELETE FROM fk_panier WHERE id_users=?");
$stmt->execute([$id]);

$stmt = $pdo->prepare("DELETE FROM commentaires WHERE id_auteur=?");
$stmt->execute([$id]);

$stmt = $pdo->prepare("DELETE FROM compositions_donuts WHERE id_createur=?");
$stmt->execute([$id]);


$stmt = $pdo->prepare("DELETE FROM $table WHERE $id_col=?");
$stmt->execute([$id]);

header("Location: list.php");
