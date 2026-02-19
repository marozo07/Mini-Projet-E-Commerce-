-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 19 fév. 2026 à 01:15
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
  `image_path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Structure de la table images pour les produits
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Déchargement des données de la table `product_images`
INSERT INTO `product_images` (`id`, `product_id`, `image_url`, `is_primary`, `sort_order`) VALUES
(1, 1, '/images/products/device.jpg', 1, 0),
(2, 2, '/images/products/HP.jpg', 1, 0),
(3, 3, '/images/products/casque.jpg', 1, 0),
(4, 4, '/images/products/montre.jpg', 1, 0),
(5, 5, '/images/products/ipad.jpg', 1, 0);

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
(13, 'Webcam Logitech C920', 89.99, 'Full HD, autofocus'),
(14, 'Microphone Blue Yeti', 129.99, 'USB, multi-pattern'),
(15, 'Casque de Réalité Virtuelle Oculus Quest 2', 299.99, 'Standalone, 6GB RAM'),
(16, 'Tablette Graphique Wacom Intuos', 199.99, '8192 niveaux de pression'),
(17, 'Enceinte Sonos One', 199.99, 'WiFi, assistant vocal intégré'),
(18, 'Clé USB 128GB SanDisk', 29.99, 'USB 3.0, haute vitesse'),
(19, 'Support de Téléphone pour Voiture', 19.99, 'Rotation à 360°, fixation ventouse'),
(20, 'Batterie Externe Anker PowerCore', 49.99, '10000mAh, USB-C')
(21, 'Haut-parleur Bluetooth Bose SoundLink', 179.99, 'Bluetooth, 12h autonomie'),
(22, 'Souris Sans Fil Logitech MX Master 3', 99.99, 'Bluetooth, rechargeable'),
(23, 'Clavier Sans Fil Microsoft Surface', 129.99, 'Bluetooth, rétroéclairé'),
(24, 'Casque de Jeu HyperX Cloud II', 149.99, 'USB, son surround 7.1');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
