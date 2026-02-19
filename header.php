<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce Mini Projet</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="header-container">
            <div class="logo">
                <a href="index.php">Bela Store </a>

            </div>
            <nav>
                <ul>
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="cart.php">Panier 
                        <?php if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
                            (<?= array_sum(array_column($_SESSION['cart'], 'quantity')) ?>)
                        <?php endif; ?>
                    </a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main>