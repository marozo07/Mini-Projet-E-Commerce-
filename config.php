<?php
session_start();
// Configuration de la base de données
define('DB_HOST', 'localhost');
define('DB_NAME', 'ecommerce_db');
define('DB_USER', 'root');
define('DB_PASS', '');

// Connexion la base de donnes avec PDO
try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
    // Vérification de la connexion
} catch (PDOException $e) {
    error_log("Erreur de connexion : " . $e->getMessage());
    die("Une erreur est survenue. Veuillez réessayer plus tard.");
}

function get_all_products($pdo)
{
    $sql = "SELECT 
                p.*,
                (SELECT image_url FROM product_images 
                WHERE product_id = p.id 
                ORDER BY is_primary DESC, sort_order ASC 
                LIMIT 1) as image_path
            FROM products p
            ORDER BY p.id";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $products = $stmt->fetchAll();

    // image par défaut si aucune n'existe.
    foreach ($products as &$product) {
        if (empty($product['image_path'])) {
            $product['image_path'] = 'images/placeholder.jpg';
        }
    }

    return $products;
}

// Fonction pour récupérer un produit par son ID
// function get_product($pdo, $id)
// {
//     $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
//     $stmt->execute([$id]);
//     return $stmt->fetch();
// }

function get_product($pdo, $id)
{
    // Récupérer le produit avec son image principale
    $sql = "SELECT 
                p.*,
                (SELECT image_url FROM product_images 
                WHERE product_id = p.id 
                ORDER BY is_primary DESC, sort_order ASC 
                LIMIT 1) as image_path
            FROM products p
            WHERE p.id = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $product = $stmt->fetch();

    // Si le produit existe, récupérer aussi toutes ses images
    if ($product) {
        $sql_images = "SELECT image_url, is_primary, sort_order 
                    FROM product_images 
                    WHERE product_id = ? 
                    ORDER BY sort_order ASC";
        $stmt = $pdo->prepare($sql_images);
        $stmt->execute([$id]);
        $product['images'] = $stmt->fetchAll();

        //une image par défaut
        if (empty($product['image_path'])) {
            $product['image_path'] = 'images/placeholder.jpg';
        }
    }

    return $product;
}
