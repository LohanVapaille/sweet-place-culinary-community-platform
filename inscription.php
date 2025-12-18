<?php
session_start();

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
                $_SESSION['flash_message'] = "✅ Votre compte a été créé avec succès ! Vous pouvez vous connecter.";
                header('Location: connexion.php');
                exit;

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
        :root {
            --mainfont: "Modak", system-ui;
            --textfont: "Mada", sans-serif;
            --white: #f1f8f5;
            --whiterose: #faf4f0;
            --brown: #4e3626;
            --green: #089b65;
            --rose: #ff9298;
        }

        body {

            background-color: white;
        }





        .connecter {
            margin-top: 120px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            padding: 50px;
        }

        .connecter p {

            color: var(--brown);
            font-size: 1.2rem;
            font-weight: 600;
        }

        a {
            color: var(--green);
        }

        form {
            margin-top: 40px;
            display: flex;
            flex-direction: column;
        }

        label {
            font-family: "Mada", sans-serif;
            color: var(--brown);
            font-size: 1.5rem;
            font-weight: 600;
        }

        input {

            border: 2px solid var(--brown);
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
            font-family: "Mada", sans-serif;
            font-weight: 700 !important;
        }

        .flash-message p {

            font-family: "Mada", sans-serif;
            color: #660505;
        }

        h1 {
            color: var(--brown);
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