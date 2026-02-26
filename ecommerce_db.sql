-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 26 fév. 2026 à 15:01
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  KEY `product_id` (`product_id`),
  CONSTRAINT `fk_order_items_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  `image_path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `description`, `image_path`) VALUES
(1, 'Smartphone Samsung Galaxy', 599.99, 'Écran 6.5\", 128GB, Quad camera', '\"/images/products/device.jpg\"'),
(2, 'Laptop HP Pavilion', 799.99, '15.6\", i5, 8GB RAM, 512GB SSD', '/images/products/device.jpg'),
(3, 'Casque Audio Sony', 129.99, 'Bluetooth, réduction de bruit', NULL),
(4, 'Montre Connectée Apple Watch', 399.99, 'GPS, cardio, écran retina', NULL),
(5, 'Tablette iPad Air', 649.99, '10.9\", 64GB, WiFi', NULL),
(6, 'Enceinte JBL Charge 5', 149.99, 'Bluetooth, 20h autonomie', NULL),
(7, 'Clavier Mecanique Logitech', 89.99, 'RGB, switches tactiles', NULL),
(8, 'Souris Gaming Razer', 59.99, '16000 DPI, RGB', NULL),
(9, 'Disque Dur Externe 1To', 69.99, 'USB 3.0, portable', NULL),
(10, 'Écran 24\" Dell', 199.99, 'Full HD, IPS, HDMI', NULL),
(11, 'Imprimante HP LaserJet', 249.99, 'Noir et blanc, WiFi', NULL),
(12, 'Routeur WiFi 6 TP-Link', 129.99, 'Dual band, gigabit', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `product_images`
--

DROP TABLE IF EXISTS `product_images`;
CREATE TABLE IF NOT EXISTS `product_images` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `image_url` varchar(500) NOT NULL,
  `is_primary` tinyint(1) DEFAULT '0',
  `sort_order` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image_url`, `is_primary`, `sort_order`, `created_at`) VALUES
(1, 1, '/images/products/device.jpg', 1, 0, '2026-02-25 22:11:37'),
(2, 2, '/images/products/HP.jpg', 1, 0, '2026-02-25 22:11:37'),
(3, 3, '/images/products/casque.jpg', 1, 0, '2026-02-25 22:11:37'),
(4, 4, '/images/products/montre.jpg', 1, 0, '2026-02-25 22:11:37'),
(5, 5, '/images/products/ipad.jpg', 1, 0, '2026-02-25 22:11:37'),
(6, 6, '/images/products/JBL.jpg', 1, 0, '2026-02-25 22:11:37'),
(7, 7, '/images/products/keyboard.jpg', 1, 0, '2026-02-25 22:11:37'),
(8, 8, '/images/products/souris.jpg', 1, 0, '2026-02-25 22:11:37'),
(9, 9, '/images/products/SanDisk.jpg', 1, 0, '2026-02-25 22:11:37'),
(10, 10, '/images/products/Dell.jpg', 1, 0, '2026-02-25 22:11:37'),
(11, 11, '/images/products/Imprimante.jpg', 1, 0, '2026-02-25 22:11:37'),
(12, 12, '/images/products/Tp-link.jpg', 1, 0, '2026-02-25 22:11:37');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`) VALUES
(1, 'marozo pierre', 'valenspierre509@gmail.com', '$2y$10$GRCuy.QfO/ao2SS7Fgqaqeviira/SDs/kmUWS5eRri0aXMnQF2W1i', '2026-02-26 14:48:15');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
