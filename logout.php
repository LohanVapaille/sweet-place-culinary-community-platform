<?php
session_start();        // Démarre la session
session_unset();        // Supprime toutes les variables de session
session_destroy();      // Détruit la session sur le serveur

// Optionnel : supprime le cookie de session du navigateur
setcookie(session_name(), '', time() - 3600);

// Redirection vers la page de connexion ou l'accueil
header("Location: index.php");
exit;
