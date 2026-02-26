<?php
require_once 'config.php';

if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $error = 'Email et mot de passe requis.';
    } else {
        $user = login_user($pdo, $email, $password);
        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            $redirect = $_SESSION['redirect_after_login'] ?? $_GET['redirect'] ?? 'index.php';
            unset($_SESSION['redirect_after_login']);
            $allowed = ['index.php', 'checkout.php', 'cart.php', 'product_detail.php'];
            $target = in_array($redirect, $allowed) ? $redirect : 'index.php';
            header('Location: ' . $target);
            exit;
        } else {
            $error = 'Email ou mot de passe incorrect.';
        }
    }
}

include 'header.php';
?>

<div class="auth-page">
    <div class="auth-container">
        <h1 class="auth-title">Connexion</h1>

        <?php if ($error): ?>
            <div class="auth-message auth-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form action="login.php" method="POST" class="auth-form">
            <div class="form-group">
                <label for="email"><i class="fa-solid fa-envelope"></i> Email</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label for="password"><i class="fa-solid fa-lock"></i> Mot de passe </label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn-primary auth-btn"><i class="fa-solid fa-right-to-bracket"></i> Se connecter</button>
        </form>

        <p class="auth-switch">Pas encore inscrit ? <a href="register.php">Creer un compte</a></p>
    </div>
</div>

<?php include 'footer.php'; ?>
