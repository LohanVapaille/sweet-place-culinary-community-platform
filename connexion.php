<?php
session_start();
include 'config.php'; // connexion PDO

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $mdp = trim($_POST['mdp'] ?? '');

    if (empty($login) || empty($mdp)) {
        $message = "Merci de remplir tous les champs.";
    } else {
        // Vérifier si le login existe
        $stmt = $pdo->prepare("SELECT * FROM users WHERE login = ?");
        $stmt->execute([$login]);
        $user = $stmt->fetch();

        if ($user && password_verify($mdp, $user['mdp'])) {
            // Connexion réussie
            $_SESSION['id'] = $user['id_user'];
            $_SESSION['login'] = $user['login'];

            // Redirection vers une page protégée
            header("Location: index.php");
            exit;
        } else {
            $message = "Login ou mot de passe incorrect.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>

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
            padding: 50px;
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

    <main>
        <div class="connecter">
            <h1>Me connecter</h1>
            <p>Si tu n’as pas de compte, <a href="inscription.php">Crée-en un !</a></p>

            <?php if ($message): ?>
                <div class="message"><?= htmlspecialchars($message) ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <label for="login">Login</label>
                <input type="text" id="login" name="login" required>

                <label for="mdp">Mot de passe</label>
                <input type="password" id="mdp" name="mdp" required>

                <input class="btn" type="submit" value="Me connecter">
            </form>
        </div>

    </main>
</body>

<script src="js/header.js"></script>

</html>