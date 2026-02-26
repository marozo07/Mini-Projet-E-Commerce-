<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['cart'])) {
    header('Location: cart.php');
    exit;
}

$qty = $_POST['qty'] ?? [];

foreach ($_SESSION['cart'] as $index => &$item) {
    $pid = (int) $item['product_id'];
    if (isset($qty[$pid])) {
        $newQty = max(0, (int) $qty[$pid]);
        if ($newQty <= 0) {
            unset($_SESSION['cart'][$index]);
        } else {
            $item['quantity'] = $newQty;
        }
    }
}

$_SESSION['cart'] = array_values($_SESSION['cart']);
header('Location: cart.php');
exit;
