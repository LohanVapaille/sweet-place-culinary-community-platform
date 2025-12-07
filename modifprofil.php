<?php
// modifprofil.php
session_start();
require 'config.php'; // doit définir $pdo (instance PDO)
require 'models/stats.php'; // doit définir getInfosUser(...)

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

$errors = [];
$success = null;

// Helper : safe filename random
function random_filename(string $ext = ''): string
{
    try {
        $name = bin2hex(random_bytes(12));
    } catch (Exception $e) {
        $name = uniqid('pp_', true);
    }
    return $name . ($ext ? '.' . $ext : '');
}

// Traitement POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier CSRF
    $postedToken = $_POST['csrf_token'] ?? '';
    if (!hash_equals($csrf, $postedToken)) {
        $errors[] = "Requête invalide (CSRF).";
    } else {
        // --- 1) Changer login si demandé ---
        $newLogin = isset($_POST['login']) ? trim($_POST['login']) : $info_user['login'];
        if ($newLogin === '') {
            $errors[] = "Le login ne peut pas être vide.";
        } elseif ($newLogin !== $info_user['login']) {
            // vérifier unicité
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE login = ? AND id_user != ?");
            $stmt->execute([$newLogin, $id_user]);
            if ((int) $stmt->fetchColumn() > 0) {
                $errors[] = "Ce login est déjà pris.";
            } else {
                // update login
                $stmt = $pdo->prepare("UPDATE users SET login = :login WHERE id_user = :id");
                $stmt->execute([':login' => $newLogin, ':id' => $id_user]);
                $info_user['login'] = $newLogin;
                $success = "Login mis à jour.";
                // si tu utilises le login en session, update-le aussi :
                $_SESSION['login'] = $newLogin;
            }
        }

        // --- 2) Changer description si demandé ---
        if (isset($_POST['description'])) {
            $desc = trim($_POST['description']);
            if ($desc !== $info_user['description']) {
                $stmt = $pdo->prepare("UPDATE users SET description = :descr WHERE id_user = :id");
                $stmt->execute([':descr' => $desc, ':id' => $id_user]);
                $info_user['description'] = $desc;
                $success = ($success ? $success . ' ' : '') . "Description mise à jour.";
            }
        }

        // --- 3) Changer mot de passe ---
        // Pour modifier le mot de passe on demande le mot de passe actuel + nouveau mot de passe + confirmation
        $currentPass = $_POST['current_password'] ?? '';
        $newPass = $_POST['new_password'] ?? '';
        $confirmPass = $_POST['confirm_password'] ?? '';

        if ($currentPass !== '' || $newPass !== '' || $confirmPass !== '') {
            // Il faut que le trio soit rempli pour tenter la modif
            if ($currentPass === '' || $newPass === '' || $confirmPass === '') {
                $errors[] = "Pour changer le mot de passe, remplissez l'ancien mot de passe, le nouveau et la confirmation.";
            } else {
                // vérifier l'ancien mot de passe
                if (!password_verify($currentPass, $info_user['mdp'])) {
                    $errors[] = "Mot de passe actuel invalide.";
                } elseif ($newPass !== $confirmPass) {
                    $errors[] = "La confirmation du nouveau mot de passe ne correspond pas.";
                } else {
                    // Valide : hacher et mettre à jour
                    $hash = password_hash($newPass, PASSWORD_DEFAULT);
                    $stmt = $pdo->prepare("UPDATE users SET mdp = :mdp WHERE id_user = :id");
                    $stmt->execute([':mdp' => $hash, ':id' => $id_user]);
                    $success = ($success ? $success . ' ' : '') . "Mot de passe changé avec succès.";
                    // important : ne jamais afficher le mot de passe en clair
                }
            }
        }

        // --- 4) Upload photo (sans limite côté script) ---
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] !== UPLOAD_ERR_NO_FILE) {
            $file = $_FILES['photo'];
            if ($file['error'] !== UPLOAD_ERR_OK) {
                $errors[] = "Erreur lors de l'upload (code {$file['error']}).";
            } else {
                // vérifier le type réel
                $finfo = new finfo(FILEINFO_MIME_TYPE);
                $mime = $finfo->file($file['tmp_name']);
                $extMap = [
                    'image/jpeg' => 'jpg',
                    'image/pjpeg' => 'jpg',
                    'image/png' => 'png',
                    'image/webp' => 'webp',
                ];

                if (!isset($extMap[$mime])) {
                    $errors[] = "Type de fichier non autorisé. Seuls JPG, PNG et WEBP sont acceptés.";
                } else {
                    $ext = $extMap[$mime];
                    $uploadDirRel = 'images/pp/';
                    $uploadDir = __DIR__ . '/' . $uploadDirRel;
                    if (!is_dir($uploadDir)) {
                        if (!mkdir($uploadDir, 0755, true) && !is_dir($uploadDir)) {
                            $errors[] = "Impossible de créer le dossier de destination.";
                        }
                    }

                    if (empty($errors)) {
                        $newName = random_filename($ext);
                        $targetPath = $uploadDir . $newName;
                        $relativePathForDb = $uploadDirRel . $newName;

                        if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
                            $errors[] = "Impossible de déplacer le fichier uploadé.";
                        } else {
                            @chmod($targetPath, 0644);
                            // Supprimer ancienne photo si elle est dans le dossier attendu
                            if (!empty($info_user['photo'])) {
                                $old = $info_user['photo'];
                                if (strpos($old, $uploadDirRel) === 0) {
                                    $oldFull = __DIR__ . '/' . $old;
                                    if (is_file($oldFull)) {
                                        @unlink($oldFull);
                                    }
                                }
                            }
                            // Mettre à jour la DB
                            $stmt = $pdo->prepare("UPDATE users SET photo = :photo WHERE id_user = :id");
                            $stmt->execute([':photo' => $relativePathForDb, ':id' => $id_user]);
                            $info_user['photo'] = $relativePathForDb;
                            $success = ($success ? $success . ' ' : '') . "Photo mise à jour.";
                        }
                    }
                }
            }
        }
    }
}

// recharger les infos utilisateur pour afficher
$info_user = getInfosUser($pdo, $id_user);

// var_dump($info_user);
?>
<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Modifier mon profil</title>
    <?php include 'css/links.php'; ?>
    <link rel="stylesheet" href="css/modifprofil.css">

</head>

<body>
    <?php include 'header/header.php'; ?>

    <main>
        <h1>Modifier mon profil</h1>

        <div class="messages">
            <?php if (!empty($errors)): ?>
                <?php foreach ($errors as $err): ?>
                    <div class="error"><?= htmlspecialchars($err, ENT_QUOTES) ?></div>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="success"><?= htmlspecialchars($success, ENT_QUOTES) ?></div>
            <?php endif; ?>
        </div>

        <div class="container">
            <div class="left">
                <?php if (!empty($info_user['photo']) && is_file(__DIR__ . '/' . $info_user['photo'])): ?>
                    <img src="<?= htmlspecialchars($info_user['photo'], ENT_QUOTES) ?>" alt="Photo profil">
                <?php else: ?>
                    <img src="images/design/profil.webp" alt="Photo profil par défaut">
                <?php endif; ?>

                <p class="small">Login actuel :
                    <strong><?= htmlspecialchars($info_user['login'], ENT_QUOTES) ?></strong>
                </p>

            </div>


            <div class="right">
                <form class="edit-profile" method="post" enctype="multipart/form-data" autocomplete="off">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf, ENT_QUOTES) ?>">

                    <label for="login">Nouveau login</label>
                    <input type="text" id="login" name="login"
                        value="<?= htmlspecialchars($info_user['login'], ENT_QUOTES) ?>">

                    <label for="description">Description</label>
                    <textarea id="description" name="description"
                        rows="4"><?= htmlspecialchars($info_user['description'] ?? '', ENT_QUOTES) ?></textarea>

                    <label for="photo">Photo de profil</label>
                    <input type="file" id="photo" name="photo" accept="image/jpeg,image/png,image/webp">

                    <hr>

                    <h3>Changer le mot de passe</h3>
                    <label for="current_password">Mot de passe actuel</label>
                    <div class="password-wrapper">
                        <input type="password" id="current_password" name="current_password"
                            placeholder="Mot de passe actuel" autocomplete="current-password"><i
                            class='bx bx-low-vision toggle-pw'></i>
                    </div>

                    <label for="new_password">Nouveau mot de passe</label>
                    <div class="password-wrapper">
                        <input type="password" id="new_password" name="new_password" placeholder="Nouveau mot de passe"
                            autocomplete="new-password">
                        <i class='bx bx-low-vision toggle-pw'></i>
                    </div>

                    <label for="confirm_password">Confirmer le nouveau mot de passe</label>
                    <div class="password-wrapper">
                        <input type="password" id="confirm_password" name="confirm_password"
                            placeholder="Confirmer le nouveau mot de passe" autocomplete="new-password">
                        <i class='bx bx-low-vision toggle-pw'></i>
                    </div>



                    <button type="submit" class="btn">Enregistrer les changements</button>
                </form>
            </div>
        </div>
    </main>


    <script src="js/affichemdp.js"></script>
    <script src="js/header.js"></script>
</body>

</html>