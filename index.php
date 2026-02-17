<?php
require_once 'config.php';

$products = get_all_products($pdo);

include 'header.php';
?>

<div class="products-container">
    <h1>Nos Produits</h1>
    <div class="products-grid">
        <?php foreach($products as $product): ?>
            <div class="product-card">
                <h3><?= htmlspecialchars($product['name']) ?></h3>
                <p class="price"><?= number_format($product['price'], 2) ?> $</p>
                <p class="description"><?= htmlspecialchars($product['description']) ?></p>
                <div class="product-actions">
                    <a href="product_detail.php?id=<?= $product['id'] ?>" class="btn-details">Voir détails</a>
                    <form action="add_to_cart.php" method="POST">
                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="btn-add">Ajouter au panier</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include 'footer.php'; ?>