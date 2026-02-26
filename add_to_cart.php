<?php

require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$product_id = isset($_POST['product_id']) ? (int) $_POST['product_id'] : 0;
$quantity = isset($_POST['quantity']) ? max(1, (int) $_POST['quantity']) : 1;

if ($product_id <= 0) {
    header('Location: index.php');
    exit;
}

$product = get_product($pdo, $product_id);
if (!$product) {
    header('Location: index.php');
    exit;
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$found = false;
foreach ($_SESSION['cart'] as &$item) {
    if ((int) $item['product_id'] === $product_id) {
        $item['quantity'] += $quantity;
        $found = true;
        break;
    }
}

if (!$found) {
    $_SESSION['cart'][] = [
        'product_id' => $product_id,
        'quantity'   => $quantity,
        'name'       => $product['name'],
        'price'      => $product['price'],
        'image_path' => $product['image_path'] ?? 'images/placeholder.jpg',
    ];
}

header('Location: cart.php');
exit;
