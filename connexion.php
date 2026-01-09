<?php
session_start();
include 'config.php';
$flash = $_SESSION['flash_message'] ?? null;
unset($_SESSION['flash_message']);

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $mdp = trim($_POST['mdp'] ?? '');

    if (empty($login) || empty($mdp)) {
        $message = "Merci de remplir tous les champs.";
    } else {

        $stmt = $pdo->prepare("SELECT * FROM users WHERE login = ?");
        $stmt->execute([$login]);
        $user = $stmt->fetch();

        if ($user && password_verify($mdp, $user['mdp'])) {

            $_SESSION['id'] = $user['id_user'];
            $_SESSION['login'] = $user['login'];


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
            margin-top: 20px;
        }

        input {

            border: 2px solid var(--brown);
            border-radius: 30px;
            width: 100%;
            height: 58px;

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

        .password-field {
            width: 100%;
            align-items: center;
            margin-bottom: 20px;
        }

        .password-field i {

            font-size: 2rem;
        }

        @media (max-width: 768px) {
            .phrase {

                text-align: center;
                display: flex;
                flex-direction: column;

            }
        }
    </style>

</head>

<body>
    <?php include './header/header.php'; ?>

    <main>
        <div id="main-content" class="connecter">
            <h1>Me connecter</h1>
            <?php if (!$flash): ?>

                <p class="phrase">Si tu n’as pas de compte, <a href="inscription.php">Crée-en un !</a></p>

            <?php endif; ?>


            <?php if ($flash): ?>
                <div class="flash-message">
                    <p><?= htmlspecialchars($flash) ?></p>
                </div>
            <?php endif; ?>


            <?php if ($message): ?>
                <div class="message"><?= htmlspecialchars($message) ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <label for="login">Login</label>
                <input type="text" id="login" name="login" required>

                <label for="mdp">Mot de passe</label>

                <div class="password-field">
                    <input type="password" name="mdp" id="mdp" required>
                    <i class="bx bx-low-vision toggle-pw"></i>
                </div>

                <input class="btn" type="submit" value="Me connecter">
            </form>
        </div>

    </main>
</body>

<script src="js/header.js"></script>
<script src="js/affichemdp.js"></script>

</html>