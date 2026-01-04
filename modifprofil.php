<?php
session_start();
require 'config.php'; // PDO
require 'models/stats.php'; // getInfosUser(...)

if (!isset($_SESSION['id'])) {
    header('Location: index.php');
    exit;
}

$id_user = (int) $_SESSION['id'];
$info_user = getInfosUser($pdo, $id_user);

if (!$info_user) {
    header('Location: index.php');
    exit;
}

// CSRF token simple
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(16));
}
$csrf = $_SESSION['csrf_token'];

$messages = [
    'login' => '',
    'description' => '',
    'photo' => '',
    'password' => ''
];

// Traitement POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postedToken = $_POST['csrf_token'] ?? '';
    if (!hash_equals($csrf, $postedToken)) {
        $messages['general'] = "Requête invalide (CSRF).";
    } else {
        // --- Login ---
        if (isset($_POST['login_submit'])) {
            $newLogin = trim($_POST['login'] ?? '');
            if ($newLogin === '') {
                $messages['login'] = "Le login ne peut pas être vide.";
            } elseif ($newLogin !== $info_user['login']) {
                $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE login = ? AND id_user != ?");
                $stmt->execute([$newLogin, $id_user]);
                if ((int) $stmt->fetchColumn() > 0) {
                    $messages['login'] = "Ce login est déjà pris.";
                } else {
                    $stmt = $pdo->prepare("UPDATE users SET login = :login WHERE id_user = :id");
                    $stmt->execute([':login' => $newLogin, ':id' => $id_user]);
                    $info_user['login'] = $newLogin;
                    $_SESSION['login'] = $newLogin;
                    $messages['login'] = "Login mis à jour.";
                }
            }
        }

        // --- Description ---
        if (isset($_POST['description_submit'])) {
            $desc = trim($_POST['description'] ?? '');
            if ($desc !== $info_user['description']) {
                $stmt = $pdo->prepare("UPDATE users SET description = :descr WHERE id_user = :id");
                $stmt->execute([':descr' => $desc, ':id' => $id_user]);
                $info_user['description'] = $desc;
                $messages['description'] = "Description mise à jour.";
            }
        }

        // --- Photo ---
        if (isset($_POST['photo_submit']) && isset($_FILES['photo'])) {
            $file = $_FILES['photo'];
            if ($file['error'] !== UPLOAD_ERR_NO_FILE && $file['error'] === UPLOAD_ERR_OK) {
                $finfo = new finfo(FILEINFO_MIME_TYPE);
                $mime = $finfo->file($file['tmp_name']);
                $extMap = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
                if (!isset($extMap[$mime])) {
                    $messages['photo'] = "Format non autorisé (JPG, PNG, WEBP).";
                } else {
                    $ext = $extMap[$mime];
                    $uploadDirRel = 'images/pp/';
                    $uploadDir = __DIR__ . '/' . $uploadDirRel;
                    if (!is_dir($uploadDir))
                        mkdir($uploadDir, 0755, true);
                    $newName = bin2hex(random_bytes(12)) . '.' . $ext;
                    $targetPath = $uploadDir . $newName;
                    $relativePath = $uploadDirRel . $newName;
                    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                        if (!empty($info_user['photo']) && strpos($info_user['photo'], $uploadDirRel) === 0) {
                            @unlink(__DIR__ . '/' . $info_user['photo']);
                        }
                        $stmt = $pdo->prepare("UPDATE users SET photo=:photo WHERE id_user=:id");
                        $stmt->execute([':photo' => $relativePath, ':id' => $id_user]);
                        $info_user['photo'] = $relativePath;
                        $messages['photo'] = "Photo mise à jour.";
                    } else {
                        $messages['photo'] = "Erreur lors de l'upload.";
                    }
                }
            }
        }

        // --- Mot de passe ---
        if (isset($_POST['password_submit'])) {
            $currentPass = $_POST['current_password'] ?? '';
            $newPass = $_POST['new_password'] ?? '';
            $confirmPass = $_POST['confirm_password'] ?? '';

            if ($currentPass === '' || $newPass === '' || $confirmPass === '') {
                $messages['password'] = "Remplissez tous les champs pour changer le mot de passe.";
            } elseif (!password_verify($currentPass, $info_user['mdp'])) {
                $messages['password'] = "Mot de passe actuel incorrect.";
            } elseif ($newPass !== $confirmPass) {
                $messages['password'] = "La confirmation ne correspond pas.";
            } else {
                $hash = password_hash($newPass, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("UPDATE users SET mdp=:mdp WHERE id_user=:id");
                $stmt->execute([':mdp' => $hash, ':id' => $id_user]);
                $messages['password'] = "Mot de passe changé avec succès.";
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
    <title>Modifier mon profil</title>
    <?php include 'css/links.php'; ?>
    <link rel="stylesheet" href="css/modifprofil.css">
</head>

<body>
    <?php include 'header/header.php'; ?>

    <main id="main-content">
        <h1>Modifier mon profil</h1>

        <div class="container">

            <?php if (!empty($info_user['photo']) && is_file(__DIR__ . '/' . $info_user['photo'])): ?>
                <img class="pp" src="<?= htmlspecialchars($info_user['photo']) ?>" alt="Photo profil">
            <?php else: ?>
                <img class="pp" src="images/design/profil.webp" alt="Photo profil par défaut">
            <?php endif; ?>
            <p class="small">Login actuel : <strong><?= htmlspecialchars($info_user['login']) ?></strong></p>



            <!-- LOGIN -->
            <div class="allform">
                <form method="post">
                    <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
                    <label for="login">Nouveau login</label>
                    <input type="text" name="login" id="login" value="<?= htmlspecialchars($info_user['login']) ?>">
                    <button type="submit" name="login_submit" class="btn">Modifier login</button>
                    <?php if ($messages['login']): ?>
                        <p class="msg"><?= htmlspecialchars($messages['login']) ?></p><?php endif; ?>
                </form>

                <!-- DESCRIPTION -->
                <form method="post">
                    <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
                    <label for="description">Description</label>
                    <textarea name="description" id="description"
                        rows="3"><?= htmlspecialchars($info_user['description']) ?></textarea>
                    <button type="submit" name="description_submit" class="btn">Modifier description</button>
                    <?php if ($messages['description']): ?>
                        <p class="msg"><?= htmlspecialchars($messages['description']) ?></p><?php endif; ?>
                </form>

                <!-- PHOTO -->
                <form method="post" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
                    <label for="photo">Photo de profil</label>
                    <input type="file" name="photo" id="photo" accept="image/jpeg,image/png,image/webp">
                    <button type="submit" name="photo_submit" class="btn">Modifier photo</button>
                    <?php if ($messages['photo']): ?>
                        <p class="msg"><?= htmlspecialchars($messages['photo']) ?></p><?php endif; ?>
                </form>

                <!-- MOT DE PASSE -->
                <form method="post">
                    <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
                    <h3>Changer mot de passe</h3>
                    <label for="current_password">Mot de passe actuel</label>
                    <div class="password-field">

                        <input type="password" name="current_password" id="current_password">
                        <i class="bx bx-low-vision toggle-pw"></i>
                    </div>
                    <label for="new_password">Nouveau mot de passe</label>
                    <div class="password-field">
                        <input type="password" name="new_password" id="new_password">
                        <i class="bx bx-low-vision toggle-pw"></i>
                    </div>
                    <label for="confirm_password">Confirmer le nouveau mot de passe</label>
                    <div class="password-field">
                        <input type="password" name="confirm_password" id="confirm_password">
                        <i class="bx bx-low-vision toggle-pw"></i>
                    </div>

                    <button type="submit" name="password_submit" class="btn">Confirmer le changement</button>
                    <?php if ($messages['password']): ?>
                        <p class="msg"><?= htmlspecialchars($messages['password']) ?></p><?php endif; ?>
                </form>
            </div>

            <a class='btn deco' href="logout.php">Se déconnecter</a>
        </div>
    </main>

    <?php include 'footer/footer.php'; ?>

    <script src="js/header.js"></script>
    <script src="js/affichemdp.js"></script>

    <?php include 'cookies/cookies.php'; ?>
</body>

</html>