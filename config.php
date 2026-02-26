<?php
session_start();
// Base URL pour les assets
$scriptDir = dirname($_SERVER['SCRIPT_NAME'] ?? '/');
define('BASE_URL', ($scriptDir === '/' || $scriptDir === '\\' || $scriptDir === '.') ? '' : rtrim($scriptDir, '/'));
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
    die("Une erreur est survenue. Veuillez ressayer plus tard.");
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
        } else {
            $product['image_path'] = ltrim($product['image_path'], '/');
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

        //une image par defaut si aucune n'existe.
        if (empty($product['image_path'])) {
            $product['image_path'] = 'images/placeholder.jpg';
        } else {
            $product['image_path'] = ltrim($product['image_path'], '/');
        }
    }

    return $product;
}

// Inscription utilisateur
function register_user($pdo, $name, $email, $password)
{
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    return $stmt->execute([trim($name), trim($email), $hash]);
}

// Vérifier si l'email existe déjà
function user_exists($pdo, $email)
{
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([trim($email)]);
    return $stmt->fetch() !== false;
}

// Connexion utilisateur
function login_user($pdo, $email, $password)
{
    $stmt = $pdo->prepare("SELECT id, name, email, password FROM users WHERE email = ?");
    $stmt->execute([trim($email)]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password'])) {
        return ['id' => $user['id'], 'name' => $user['name'], 'email' => $user['email']];
    }
    return false;
}

/**
 * Valide le panier contre la base (produits existants, prix à jour) et crée la commande.
 * Retourne ['success' => true, 'order_id' => int] ou ['success' => false, 'error' => string]
 */
function create_order($pdo, $customer_name, $customer_email, $delivery_address, $cart)
{
    $name = trim($customer_name);
    $email = trim($customer_email);
    $address = trim($delivery_address);

    if (strlen($name) < 2 || strlen($name) > 255) {
        return ['success' => false, 'error' => 'Le nom doit contenir entre 2 et 255 caractères.'];
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 255) {
        return ['success' => false, 'error' => 'Adresse email invalide.'];
    }
    if (strlen($address) < 5 || strlen($address) > 2000) {
        return ['success' => false, 'error' => 'L\'adresse doit contenir entre 5 et 2000 caractères.'];
    }
    if (empty($cart) || !is_array($cart)) {
        return ['success' => false, 'error' => 'Le panier est vide.'];
    }

    // Revalider chaque article du panier avec les données actuelles de la BDD
    $valid_items = [];
    $total_price = 0.0;

    foreach ($cart as $item) {
        $product_id = (int) ($item['product_id'] ?? 0);
        $quantity = max(1, (int) ($item['quantity'] ?? 1));

        if ($product_id <= 0) {
            return ['success' => false, 'error' => 'Produit invalide dans le panier.'];
        }

        $product = get_product($pdo, $product_id);
        if (!$product) {
            return ['success' => false, 'error' => 'Le produit "' . ($item['name'] ?? '') . '" n\'est plus disponible.'];
        }

        $unit_price = (float) $product['price'];
        $product_name = $product['name'];
        $line_total = $unit_price * $quantity;
        $total_price += $line_total;

        $valid_items[] = [
            'product_id' => $product_id,
            'product_name' => $product_name,
            'quantity' => $quantity,
            'unit_price' => $unit_price,
        ];
    }

    if ($total_price <= 0) {
        return ['success' => false, 'error' => 'Le total de la commande est invalide.'];
    }

    try {
        $pdo->beginTransaction();

        $stmt = $pdo->prepare(
            "INSERT INTO orders (customer_name, customer_email, delivery_address, total_price) VALUES (?, ?, ?, ?)"
        );
        $stmt->execute([$name, $email, $address, round($total_price, 2)]);
        $order_id = (int) $pdo->lastInsertId();

        $stmt_item = $pdo->prepare(
            "INSERT INTO order_items (order_id, product_id, product_name, quantity, unit_price) VALUES (?, ?, ?, ?, ?)"
        );
        foreach ($valid_items as $row) {
            $stmt_item->execute([
                $order_id,
                $row['product_id'],
                $row['product_name'],
                $row['quantity'],
                round($row['unit_price'], 2),
            ]);
        }

        $pdo->commit();
        return ['success' => true, 'order_id' => $order_id];
    } catch (PDOException $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        error_log("Erreur création commande : " . $e->getMessage());
        return ['success' => false, 'error' => 'Une erreur est survenue lors de l\'enregistrement. Veuillez réessayer.'];
    }
}
