<?php
require_once 'config.php';

$index = isset($_GET['index']) ? (int) $_GET['index'] : -1;

if ($index >= 0 && isset($_SESSION['cart'][$index])) {
    array_splice($_SESSION['cart'], $index, 1);
}

header('Location: cart.php');
exit;
