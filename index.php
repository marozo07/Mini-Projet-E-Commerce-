<?php
require_once 'config.php';
$products = get_all_products($pdo);
$featured = array_slice($products, 0, 6);
$heroImage = !empty($products[0]['image_path']) ? htmlspecialchars($products[0]['image_path']) : 'images/placeholder.jpg';
include 'header.php';
?>

<main class="luxury-landing">
    <!-- Hero -->
    <section class="hero animate-fade-in">
        <div class="hero-content">
            <p class="hero-eyebrow">Edition limite 2026</p>
            <h1 class="hero-headline">L'excellence<br>à portée de main</h1>
            <p class="hero-subline">Technologie raffinée pour une existence délibérée</p>
            <a href="#featured" class="hero-cta"><i class="fa-solid fa-arrow-down"></i> Découvrir</a>
        </div>
        <div class="hero-image">
            <img src="<?= $heroImage ?>" alt="BelaElectro – produits premium" 
                 onerror="this.src='images/placeholder.jpg'">
        </div>
    </section>

    <!-- Featured Products -->
    <section id="featured" class="featured-section animate-fade-in">
        <p class="section-eyebrow">Sélection exclusive</p>
        <h2 class="section-title">Pièces d'exception</h2>
        <div class="featured-grid">
            <?php foreach ($featured as $product): ?>
            <a href="product_detail.php?id=<?= $product['id'] ?>" class="featured-card">
                <div class="featured-card-image">
                    <?php if (!empty($product['image_path'])): ?>
                        <img src="<?= htmlspecialchars($product['image_path']) ?>" 
                             alt="<?= htmlspecialchars($product['name']) ?>"
                             onerror="this.src='images/placeholder.jpg'">
                    <?php else: ?>
                        <img src="images/placeholder.jpg" alt="<?= htmlspecialchars($product['name']) ?>">
                    <?php endif; ?>
                    <span class="img-icon-overlay"><i class="fa-solid fa-eye"></i></span>
                </div>
                <div class="featured-card-content">
                    <h3 class="featured-card-title"><?= htmlspecialchars($product['name']) ?></h3>
                    <p class="featured-card-price"><?= number_format($product['price'], 0) ?> $</p>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
        <a href="#all-products" class="section-link"><i class="fa-solid fa-arrow-right"></i> Voir la collection complète</a>
    </section>

    <!-- Storytelling -->
    <section class="story-section animate-fade-in">
        <div class="story-content">
            <p class="story-eyebrow">Notre philosophie</p>
            <h2 class="story-headline">Où l'artisanat rencontre l'innovation</h2>
            <p class="story-body">Chaque pièce BelaElectro est pensée pour ceux qui refusent les compromis. Des matériaux nobles, une finition impeccable, une expérience qui transcende le simple usage.</p>
        </div>
    </section>

    <!-- All Products Grid -->
    <section id="all-products" class="products-section animate-fade-in">
        <p class="section-eyebrow">La collection</p>
        <h2 class="section-title">Tous les produits</h2>
        <div class="luxury-products-grid">
            <?php foreach ($products as $product): ?>
            <a href="product_detail.php?id=<?= $product['id'] ?>" class="luxury-product-card">
                <div class="luxury-product-image">
                    <?php if (!empty($product['image_path'])): ?>
                        <img src="<?= htmlspecialchars($product['image_path']) ?>" 
                             alt="<?= htmlspecialchars($product['name']) ?>"
                             onerror="this.src='images/placeholder.jpg'">
                    <?php else: ?>
                        <img src="images/placeholder.jpg" alt="<?= htmlspecialchars($product['name']) ?>">
                    <?php endif; ?>
                    <span class="img-icon-overlay"><i class="fa-solid fa-eye"></i></span>
                </div>
                <div class="luxury-product-info">
                    <h3><?= htmlspecialchars($product['name']) ?></h3>
                    <p class="luxury-price"><?= number_format($product['price'], 0) ?> $</p>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Subscription -->
    <section class="subscription-section animate-fade-in">
        <div class="subscription-content">
            <p class="subscription-eyebrow">Accès privilégié</p>
            <h2 class="subscription-title">Rejoignez l'exclusivité</h2>
            <p class="subscription-desc">Offres réservées, lancements en avant-première, livraisons prioritaires.</p>
            <form class="subscription-form" action="#" method="POST">
                <input type="email" name="email" placeholder="Votre adresse email" required>
                <button type="submit" class="subscription-btn">S'inscrire</button>
            </form>
        </div>
    </section>

    <!-- Avis clients -->
    <section id="reviews" class="reviews-section animate-fade-in">
        <p class="section-eyebrow">Témoignages</p>
        <h2 class="section-title">Avis de nos clients</h2>
        <div class="reviews-grid">
            <div class="review-card">
                <div class="review-stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                <p class="review-text">« Qualité exceptionnelle et service irréprochable. Ma commande est arrivée dans un packaging soigné. »</p>
                <p class="review-author">— Marie L., Paris</p>
            </div>
            <div class="review-card">
                <div class="review-stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                <p class="review-text">« BelaElectro est devenue ma référence pour l'électronique premium. Des produits au design soigné. »</p>
                <p class="review-author">— Thomas B., Lyon</p>
            </div>
            <div class="review-card">
                <div class="review-stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                <p class="review-text">« Une expérience d'achat raffinée. Livraison rapide et conseils personnalisés. Je recommande. »</p>
                <p class="review-author">— Sophie M., Bordeaux</p>
            </div>
        </div>
    </section>
</main>

<?php include 'footer.php'; ?>
