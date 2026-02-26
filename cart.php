<?php
/**
 * Page Panier
 */
require_once 'config.php';

$cart = $_SESSION['cart'] ?? [];
$total = 0;

include 'header.php';
?>

<div class="cart-page">
    <h1 class="page-title">Mon Panier</h1>

    <?php if (empty($cart)): ?>
        <div class="cart-container cart-empty">
            <p><i class="fa-solid fa-cart-shopping fa-2x"></i></p>
            <p>Votre panier est vide.</p>
            <a href="index.php" class="btn-primary"><i class="fa-solid fa-bag-shopping"></i> Continuer mes achats</a>
        </div>
    <?php else: ?>
        <div class="cart-container">
            <form action="update_cart.php" method="POST">
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Produit</th>
                            <th>Prix unitaire</th>
                            <th>Quantité</th>
                            <th>Sous-total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart as $index => $item): 
                            $subtotal = $item['price'] * $item['quantity'];
                            $total += $subtotal;
                            $imgPath = ltrim($item['image_path'] ?? 'images/placeholder.jpg', '/');
                            $pid = (int) $item['product_id'];
                        ?>
                        <tr class="cart-row">
                            <td data-label="Image">
                                <img src="<?= htmlspecialchars($imgPath) ?>" 
                                     alt="<?= htmlspecialchars($item['name']) ?>"
                                     class="cart-product-image">
                            </td>
                            <td data-label="Produit">
                                <a href="product_detail.php?id=<?= $pid ?>" class="cart-product-name">
                                    <?= htmlspecialchars($item['name']) ?>
                                </a>
                            </td>
                            <td data-label="Prix"><?= number_format($item['price'], 2) ?> $</td>
                            <td data-label="Quantité">
                                <input type="number" name="qty[<?= $pid ?>]" 
                                       value="<?= (int) $item['quantity'] ?>" min="1" 
                                       class="cart-qty-input">
                            </td>
                            <td data-label="Sous-total"><?= number_format($subtotal, 2) ?> $</td>
                            <td data-label="" class="cart-row-actions">
                                <a href="remove_from_cart.php?index=<?= $index ?>" class="btn-remove" 
                                   onclick="return confirm('Supprimer ce produit du panier ?');">
                                    <i class="fa-solid fa-trash"></i> Supprimer
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="cart-actions">
                    <div>
                        <button type="submit" class="btn-update"><i class="fa-solid fa-arrows-rotate"></i> Mettre à jour</button>
                        <a href="index.php" class="btn-outline"><i class="fa-solid fa-bag-shopping"></i> Continuer mes achats</a>
                    </div>
                    <div>
                        <a href="clear_cart.php" class="btn-clear" 
                           onclick="return confirm('Vider tout le panier ?');"><i class="fa-solid fa-trash-can"></i> Vider le panier</a>
                        <span class="total-section">Total : <?= number_format($total, 2) ?> $</span>
                        <a href="checkout.php" class="btn-checkout"><i class="fa-solid fa-credit-card"></i> Commander</a>
                    </div>
                </div>
            </form>
        </div>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
