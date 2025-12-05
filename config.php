<?php
// config.php

// Paramètres de connexion
$host = 'localhost';
$dbname = 'donuts2';
$username = 'root';      // souvent 'root' en local
$password = '';          // vide par défaut sur XAMPP/WAMP

try {
    // Connexion PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    
    // Gestion des erreurs PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Optionnel : retour sous forme de tableau associatif par défaut
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    // Affiche une erreur si la connexion échoue
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>
