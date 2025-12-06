<?php
include 'config.php'; // ta connexion PDO

// Message d'erreur ou succès
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération et nettoyage des inputs
    $login = trim($_POST['login'] ?? '');
    $mdp = trim($_POST['mdp'] ?? '');

    if (empty($login) || empty($mdp)) {
        $message = "Merci de remplir tous les champs.";
    } else {
        // Vérifier si le login existe déjà
        $stmt = $pdo->prepare("SELECT * FROM users WHERE login = ?");
        $stmt->execute([$login]);
        if ($stmt->rowCount() > 0) {
            $message = "Ce login est déjà utilisé.";
        } else {
            // Hash du mot de passe
            $hashedPassword = password_hash($mdp, PASSWORD_DEFAULT);

            // Insertion dans la BDD
            $insert = $pdo->prepare("INSERT INTO users (login, mdp) VALUES (?, ?)");
            if ($insert->execute([$login, $hashedPassword])) {
                $message = "Compte créé avec succès ! Vous pouvez maintenant vous connecter.";
            } else {
                $message = "Erreur lors de la création du compte.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>M'inscrire</title>

    <?php include './css/links.php'; ?>

    <style>
        body {

            background-color: white;
        }

        .connecter {
            margin-top: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .connecter p {

            color: #660505;
            font-size: 1.2rem;
            font-weight: 600;
        }

        a {
            color: #660505;
        }

        form {
            margin-top: 40px;
            display: flex;
            flex-direction: column;
        }

        label {
            font-family: "Modak", system-ui;
            color: #660505;
            font-size: 1.5rem;
        }

        input {

            border: 2px solid #660505;
            border-radius: 30px;
            width: 100%;
            height: 58px;
            margin-bottom: 20px;
            font-size: 1.4rem;
            padding: 15px;
        }

        input[type="submit"] {
            width: fit-content;
            padding-top: 0px;
            padding-bottom: 0px;
            margin-left: auto;
            font-family: "Modak", system-ui;
            font-weight: 100 !important;
        }
    </style>

</head>



<body>
    <?php include './header/header.php'; ?>

    <div class="connecter">
        <h1>S'inscrire</h1>
        <p>Si tu as déjà un compte, <a href="connexion.php">Connecte-toi</a></p>

        <?php if ($message): ?>
            <div class="message"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="login">Login</label>
            <input type="text" id="login" name="login" required>

            <label for="mdp">Mot de passe</label>
            <input type="password" id="mdp" name="mdp" required>

            <input class="btn" type="submit" value="M'inscrire">
        </form>
    </div>
    <script src="js/header.js"></script>
</body>

</html>