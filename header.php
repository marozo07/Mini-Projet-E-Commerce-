<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BelaElectro — Premium Digital</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style><?php
    $cssFile = __DIR__ . '/styles.css';
    if (file_exists($cssFile)) {
        echo file_get_contents($cssFile);
    }
    ?></style>
</head>
<body>
    <header class="luxury-header">
        <div class="header-inner">
            <a href="index.php" class="logo">BelaElectro</a>
            <button type="button" class="hamburger-btn" id="hamburgerBtn" aria-label="Ouvrir le menu">
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
            </button>
            <nav class="main-nav" id="mainNav">
                <a href="index.php#featured"><i class="fa-solid fa-grid-2"></i> Collection</a>
                <a href="cart.php" class="nav-cart"><i class="fa-solid fa-cart-shopping"></i> Panier<?php 
                    if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): 
                        ?><span class="cart-count"><?= array_sum(array_column($_SESSION['cart'], 'quantity')) ?></span><?php 
                    endif; 
                ?></a>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Déconnexion</a>
                <?php else: ?>
                    <a href="login.php"><i class="fa-solid fa-right-to-bracket"></i> Connexion</a>
                    <a href="register.php"><i class="fa-solid fa-user-plus"></i> Inscription</a>
                <?php endif; ?>
            </nav>
        </div>
        <div class="nav-overlay" id="navOverlay" aria-hidden="true"></div>
    </header>
    <main>
