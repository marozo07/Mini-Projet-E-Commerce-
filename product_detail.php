<?php
require_once 'config.php';

$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$product = get_product($pdo, $product_id);

if (!$product) {
    header('Location: index.php');
    exit;
}

include 'header.php';
?>

<div class="product-detail-wrapper">

    <div class="product-detail-card">

        <!-- IMAGE -->
        <div class="product-detail-image">
            <?php if(!empty($product['image_path'])): ?>
                <img src="<?= htmlspecialchars($product['image_path']) ?>" 
                    alt="<?= htmlspecialchars($product['name']) ?>"
                    onerror="this.src='images/placeholder.jpg'">
            <?php else: ?>
                <img src="images/placeholder.jpg" alt="Image non disponible">
            <?php endif; ?>
        </div>

        <!-- INFO -->
        <div class="product-detail-info">

            <h1 class="detail-title">
                <?= htmlspecialchars($product['name']) ?>
            </h1>

            <p class="detail-price">
                <?= number_format($product['price'], 2) ?> $
            </p>

            <p class="detail-description">
                <?= htmlspecialchars($product['description']) ?>
            </p>

            <form action="add_to_cart.php" method="POST" class="add-to-cart-form">
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">

                <div class="quantity-box">
                    <label for="quantity">Quantité</label>
                    <input type="number" name="quantity" id="quantity" min="1" value="1" required>
                </div>

                <button type="submit" class="btn-primary large-btn">
                    Ajouter au panier
                </button>
            </form>

            <a href="index.php" class="btn-outline back-btn">
                ← Retour aux produits
            </a>

        </div>
    </div>

</div>

<?php include 'footer.php'; ?>