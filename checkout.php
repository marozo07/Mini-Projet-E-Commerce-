<?php
require_once 'config.php';

// Contrainte : l'utilisateur doit être connecté pour passer commande
if (!isset($_SESSION['user_id'])) {
    $_SESSION['redirect_after_login'] = 'checkout.php';
    header('Location: login.php');
    exit;
}

$cart = $_SESSION['cart'] ?? [];

if (empty($cart)) {
    header('Location: cart.php');
    exit;
}

$total = 0;
foreach ($cart as $item) {
    $total += ($item['price'] ?? 0) * ($item['quantity'] ?? 1);
}

$success = false;
$error_message = '';
$order_id = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = create_order(
        $pdo,
        $_POST['name'] ?? '',
        $_POST['email'] ?? '',
        $_POST['address'] ?? '',
        $cart
    );

    if ($result['success']) {
        $_SESSION['cart'] = [];
        $success = true;
        $order_id = $result['order_id'];
    } else {
        $error_message = $result['error'];
    }
}

include 'header.php';
?>

<?php if ($success): ?>
<div class="confirmation-container">
    <h1 class="page-title">Commande validée</h1>
    <div class="success-message">
        Merci pour votre commande !<?php if ($order_id): ?> Référence : <strong>#<?= (int) $order_id ?></strong><?php endif; ?><br>
        Vous recevrez un email de confirmation.
    </div>
    <a href="index.php" class="btn-primary"><i class="fa-solid fa-house"></i> Retour à l'accueil</a>
</div>
<?php else: ?>
<div class="checkout-container">
    <h1 class="page-title">Finaliser la commande</h1>
    <?php if ($error_message): ?>
    <div class="checkout-error">
        <i class="fa-solid fa-circle-exclamation"></i> <?= htmlspecialchars($error_message) ?>
    </div>
    <?php endif; ?>
    <p class="checkout-total">Total : <strong><?= number_format($total, 2) ?> $</strong></p>
    
    <form action="checkout.php" method="POST" class="checkout-form">
        <div class="form-group">
            <label for="name">Nom complet *</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($_POST['name'] ?? $_SESSION['user_name'] ?? '') ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email *</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? $_SESSION['user_email'] ?? '') ?>" required>
        </div>
        <div class="form-group">
            <label for="address">Adresse de livraison *</label>
            <textarea id="address" name="address" required><?= htmlspecialchars($_POST['address'] ?? '') ?></textarea>
        </div>
        <div class="form-actions">
            <a href="cart.php" class="btn-secondary"><i class="fa-solid fa-arrow-left"></i> Retour au panier</a>
            <button type="submit" class="btn-primary"><i class="fa-solid fa-check"></i> Confirmer la commande</button>
        </div>
    </form>
</div>
<?php endif; ?>

<?php include 'footer.php'; ?>
