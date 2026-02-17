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

<div class="product-detail-container">
    <div class="product-detail">
        <h3><?= htmlspecialchars($product['name']) ?></h3>
        <p class="price-large"><?= number_format($product['price'], 2) ?> $</p>
        <p class="description-full"><?= htmlspecialchars($product['description']) ?></p>
        
        <form action="add_to_cart.php" method="POST" class="add-to-cart-form">
            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
            <div class="quantity-group">
                <label for="quantity">Quantité :</label>
                <input type="number" name="quantity" id="quantity" min="1" value="1" required>
            </div>
            <button type="submit" class="btn-add-large">Ajouter au panier</button>
        </form>
        
        <a href="index.php" class="btn-back">← Retour aux produits</a>
    </div>
</div>

<?php include 'footer.php'; ?>