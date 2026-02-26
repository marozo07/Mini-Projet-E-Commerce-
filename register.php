<?php
require_once 'config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';

    if (empty($name) || empty($email) || empty($password)) {
        $error = 'Tous les champs sont obligatoires.';
    } elseif (strlen($password) < 6) {
        $error = 'Le mot de passe doit contenir au moins 6 caractères.';
    } elseif ($password !== $password_confirm) {
        $error = 'Les mots de passe ne correspondent pas.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Adresse email invalide.';
    } elseif (user_exists($pdo, $email)) {
        $error = 'Cet email est déjà utilisé.';
    } else {
        try {
            if (register_user($pdo, $name, $email, $password)) {
                $success = 'Inscription réussie ! Vous pouvez vous connecter.';
            } else {
                $error = 'Erreur lors de l\'inscription.';
            }
        } catch (PDOException $e) {
            if (strpos($e->getMessage(), 'users') !== false) {
                $error = 'La table utilisateurs n\'existe pas. Exécutez create_users_table.sql dans phpMyAdmin.';
            } else {
                $error = 'Erreur : ' . $e->getMessage();
            }
        }
    }
}

include 'header.php';
?>

<div class="auth-page">
    <div class="auth-container">
        <h1 class="auth-title"><i class="fa-solid fa-user-plus"></i> Inscription</h1>

        <?php if ($error): ?>
            <div class="auth-message auth-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="auth-message auth-success"><?= htmlspecialchars($success) ?></div>
            <p class="auth-link"><a href="login.php">Se connecter</a></p>
        <?php else: ?>
            <form action="register.php" method="POST" class="auth-form">
                <div class="form-group">
                    <label for="name"><i class="fa-solid fa-user"></i> Nom complet *</label>
                    <input type="text" id="name" name="name" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label for="email"><i class="fa-solid fa-envelope"></i> Email *</label>
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label for="password"><i class="fa-solid fa-lock"></i> Mot de passe *</label>
                    <input type="password" id="password" name="password" required minlength="6">
                </div>
                <div class="form-group">
                    <label for="password_confirm"><i class="fa-solid fa-lock"></i> Confirmer le mot de passe *</label>
                    <input type="password" id="password_confirm" name="password_confirm" required>
                </div>
                <button type="submit" class="btn-primary auth-btn"><i class="fa-solid fa-user-plus"></i> S'inscrire</button>
            </form>
        <?php endif; ?>

        <p class="auth-switch">Déjà inscrit ? <a href="login.php">Se connecter</a></p>
    </div>
</div>

<?php include 'footer.php'; ?>
