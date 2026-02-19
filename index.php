<?php
require_once 'config.php';
$products = get_all_products($pdo);
include 'header.php'; ?>



<div class="products-container">
    <h1 class="page-title">Nos Produits</h1>

    <div class="products-grid">
        <?php foreach ($products as $product): ?>
            <div class="product-card">

                <div class="product-image">
                    <?php if (!empty($product['image_path'])): ?>
                        <img src="<?= htmlspecialchars($product['image_path']) ?>"
                            alt="<?= htmlspecialchars($product['name']) ?>"
                            onerror="this.src='images/placeholder.jpg'">
                    <?php else: ?>
                        <img src="images/placeholder.jpg" alt="Image non disponible">
                    <?php endif; ?>
                </div>

                <div class="product-info">
                    <h2 class="product-title">
                        <?= htmlspecialchars($product['name']) ?>
                    </h2>

                    <p class="price">
                        <?= number_format($product['price'], 2) ?> $
                    </p>

                    <p class="description">
                        <?= htmlspecialchars($product['description']) ?>
                    </p>

                    <div class="product-actions">
                        <a href="product_detail.php?id=<?= $product['id'] ?>" class="btn-outline">
                            Details
                        </a>

                        <form action="add_to_cart.php" method="POST">
                            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn-primary">
                                Ajouter
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php include 'footer.php'; ?>