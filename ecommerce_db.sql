-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 17 fév. 2026 à 18:12
-- Version du serveur : 8.2.0
-- Version de PHP : 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ecommerce_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `delivery_address` text NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `order_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity` int NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Structure de la table images pour les produits

CREATE TABLE IF NOT EXISTS `product_images` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `image_url` varchar(500) NOT NULL,
  `is_primary` tinyint(1) DEFAULT '0',
  `sort_order` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Déchargement des données de la table `product_images`
INSERT INTO `product_images` (`id`, `product_id`, `image_url`, `is_primary`, `sort_order`) VALUES
(1, 1, '/images/products/device.jpg', 1, 0),
(2, 2, '/images/products/HP.jpg', 1, 0),
(3, 3, '/images/products/casque.jpg', 1, 0),
(4, 4, '/images/products/montre.jpg', 1, 0),
(5, 5, '/images/products/ipad.jpg', 1, 0),
(6, 6, '/images/products/ipad.jpg', 1, 0),
(7, 7, '/images/products/ipad.jpg', 1, 0),
(8, 8, '/images/products/ipad.jpg', 1, 0),
(9, 9, '/images/products/ipad.jpg', 1, 0),
(10, 10, '/images/products/ipad.jpg', 1, 0),
(11, 11, '/images/products/ipad.jpg', 1, 0),
(12, 12, '/images/products/ipad.jpg', 1, 0);


--
-- Déchargement des données de la table `products`
--
INSERT INTO `products` (`id`, `name`, `price`, `description`) VALUES
(1, 'Smartphone Samsung Galaxy', 599.99, 'Écran 6.5\", 128GB, Quad camera'),
(2, 'Laptop HP Pavilion', 799.99, '15.6\", i5, 8GB RAM, 512GB SSD'),
(3, 'Casque Audio Sony', 129.99, 'Bluetooth, réduction de bruit'),
(4, 'Montre Connectée Apple Watch', 399.99, 'GPS, cardio, écran retina'),
(5, 'Tablette iPad Air', 649.99, '10.9\", 64GB, WiFi'),
(6, 'Enceinte JBL Charge 5', 149.99, 'Bluetooth, 20h autonomie'),
(7, 'Clavier Mécanique Logitech', 89.99, 'RGB, switches tactiles'),
(8, 'Souris Gaming Razer', 59.99, '16000 DPI, RGB'),
(9, 'Disque Dur Externe 1To', 69.99, 'USB 3.0, portable'),
(10, 'Écran 24\" Dell', 199.99, 'Full HD, IPS, HDMI'),
(11, 'Imprimante HP LaserJet', 249.99, 'Noir et blanc, WiFi'),
(12, 'Routeur WiFi 6 TP-Link', 129.99, 'Dual band, gigabit'),
(13, 'Smartphone Samsung Galaxy', 599.99, 'Écran 6.5\", 128GB, Quad camera'),
(14, 'Laptop HP Pavilion', 799.99, '15.6\", i5, 8GB RAM, 512GB SSD'),
(15, 'Casque Audio Sony', 129.99, 'Bluetooth, réduction de bruit'),
(16, 'Montre Connectée Apple Watch', 399.99, 'GPS, cardio, écran retina'),
(17, 'Tablette iPad Air', 649.99, '10.9\", 64GB, WiFi'),
(18, 'Enceinte JBL Charge 5', 149.99, 'Bluetooth, 20h autonomie'),
(19, 'Clavier Mécanique Logitech', 89.99, 'RGB, switches tactiles'),
(20, 'Souris Gaming Razer', 59.99, '16000 DPI, RGB'),
(21, 'Disque Dur Externe 1To', 69.99, 'USB 3.0, portable'),
(22, 'Écran 24\" Dell', 199.99, 'Full HD, IPS, HDMI'),
(23, 'Imprimante HP LaserJet', 249.99, 'Noir et blanc, WiFi'),
(24, 'Routeur WiFi 6 TP-Link', 129.99, 'Dual band, gigabit');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
