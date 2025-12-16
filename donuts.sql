-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 16 déc. 2025 à 11:15
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `donuts`
--

-- --------------------------------------------------------

--
-- Structure de la table `beignets`
--

DROP TABLE IF EXISTS `beignets`;
CREATE TABLE IF NOT EXISTS `beignets` (
  `id_beignet` int NOT NULL AUTO_INCREMENT,
  `name_beignet` varchar(30) NOT NULL,
  `img_beignets` text NOT NULL,
  `type_beignet` varchar(20) NOT NULL,
  PRIMARY KEY (`id_beignet`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `beignets`
--

INSERT INTO `beignets` (`id_beignet`, `name_beignet`, `img_beignets`, `type_beignet`) VALUES
(1, 'Donuts', 'images/constructor/beignets/donuts.svg', 'sucré'),
(2, 'Bagel', 'images/constructor/beignets/bagel.svg', 'salé');

-- --------------------------------------------------------

--
-- Structure de la table `commentaires`
--

DROP TABLE IF EXISTS `commentaires`;
CREATE TABLE IF NOT EXISTS `commentaires` (
  `id_commentaire` int NOT NULL AUTO_INCREMENT,
  `text-comment` varchar(100) NOT NULL,
  `note` int NOT NULL,
  `date` int NOT NULL,
  `id_donuts_concerné` int NOT NULL,
  `id_auteur` int NOT NULL,
  PRIMARY KEY (`id_commentaire`),
  KEY `id_auteur` (`id_auteur`),
  KEY `id_donuts_concerné` (`id_donuts_concerné`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `commentaires`
--

INSERT INTO `commentaires` (`id_commentaire`, `text-comment`, `note`, `date`, `id_donuts_concerné`, `id_auteur`) VALUES
(8, 'Gout délicieux', 4, 1765834150, 60, 2);

-- --------------------------------------------------------

--
-- Structure de la table `compositions_donuts`
--

DROP TABLE IF EXISTS `compositions_donuts`;
CREATE TABLE IF NOT EXISTS `compositions_donuts` (
  `id_composition` int NOT NULL AUTO_INCREMENT,
  `donut_name` varchar(255) DEFAULT NULL,
  `id_beignet` int NOT NULL,
  `id_fourrage` int NOT NULL,
  `id_glacage` int NOT NULL,
  `id_topping` int NOT NULL,
  `id_createur` int NOT NULL,
  `description` text,
  `type` varchar(20) NOT NULL,
  `prix` float NOT NULL,
  PRIMARY KEY (`id_composition`),
  KEY `fk_beignet` (`id_beignet`),
  KEY `fk_createur` (`id_createur`),
  KEY `fk_fourrage` (`id_fourrage`),
  KEY `fk_glacage` (`id_glacage`),
  KEY `fk_topping` (`id_topping`)
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `compositions_donuts`
--

INSERT INTO `compositions_donuts` (`id_composition`, `donut_name`, `id_beignet`, `id_fourrage`, `id_glacage`, `id_topping`, `id_createur`, `description`, `type`, `prix`) VALUES
(51, 'Akhi\'nut', 2, 2, 2, 1, 2, 'Un bon donuts à la vanille et au café, le tout sur un beignet plein.', 'sucré', 0),
(52, 'Chocolinito', 1, 1, 1, 1, 3, 'Donuts tout choco topping M&M\'s', 'sucré', 0),
(60, 'Le Durger', 2, 18, 12, 11, 3, 'Un Hambuger en donut, délicieux', 'salé', 0),
(61, 'Abri\'pique', 2, 12, 21, 11, 3, 'Beignet plein fourré à l\'abricot et recouvert d\'harissa', 'sucré', 0),
(72, 'Chocolat base', 2, 6, 1, 10, 15, 'Un petit beignet aux sucres', 'sucré', 0),
(73, 'Abri\'pique', 2, 12, 8, 10, 15, 'Petit beignet fourré à l\'abricot', 'sucré', 0),
(78, 'Abri\'pique', 1, 12, 11, 9, 2, 'dzdqzdzq', 'sucré', 0);

-- --------------------------------------------------------

--
-- Structure de la table `fk_follow`
--

DROP TABLE IF EXISTS `fk_follow`;
CREATE TABLE IF NOT EXISTS `fk_follow` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_user_suivit` int NOT NULL,
  `id_user_qui_follow` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user_qui_follow` (`id_user_qui_follow`),
  KEY `id_user_suivit` (`id_user_suivit`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `fk_follow`
--

INSERT INTO `fk_follow` (`id`, `id_user_suivit`, `id_user_qui_follow`) VALUES
(65, 2, 3),
(67, 4, 3),
(68, 3, 4),
(69, 4, 15),
(70, 15, 3),
(71, 3, 2),
(72, 15, 2);

-- --------------------------------------------------------

--
-- Structure de la table `fk_like`
--

DROP TABLE IF EXISTS `fk_like`;
CREATE TABLE IF NOT EXISTS `fk_like` (
  `id_like` int NOT NULL AUTO_INCREMENT,
  `id_compositions_donuts` int NOT NULL,
  `id_users` int NOT NULL,
  PRIMARY KEY (`id_like`),
  KEY `fk_compo1` (`id_compositions_donuts`),
  KEY `fk_users` (`id_users`)
) ENGINE=InnoDB AUTO_INCREMENT=110 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `fk_like_base`
--

DROP TABLE IF EXISTS `fk_like_base`;
CREATE TABLE IF NOT EXISTS `fk_like_base` (
  `id_like` int NOT NULL AUTO_INCREMENT,
  `id_donuts_de_base` int NOT NULL,
  `id_users` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_like`),
  KEY `id_donuts_de_base` (`id_donuts_de_base`),
  KEY `id_users` (`id_users`),
  KEY `idx_base` (`id_donuts_de_base`,`id_users`)
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `fk_like_base`
--

INSERT INTO `fk_like_base` (`id_like`, `id_donuts_de_base`, `id_users`, `created_at`) VALUES
(7, 6, 2, '2025-11-28 14:47:22'),
(9, 1, 2, '2025-11-28 14:51:44'),
(10, 2, 2, '2025-11-28 14:51:47'),
(11, 3, 2, '2025-11-28 14:51:48'),
(12, 50, 2, '2025-11-28 14:59:42'),
(14, 49, 2, '2025-11-28 15:02:09'),
(15, 48, 2, '2025-11-28 15:02:13'),
(19, 48, 3, '2025-11-28 15:11:17'),
(20, 46, 3, '2025-11-28 15:11:19'),
(22, 40, 3, '2025-11-28 20:28:29'),
(23, 7, 3, '2025-11-28 20:34:52'),
(24, 33, 3, '2025-11-28 20:34:53'),
(26, 3, 3, '2025-11-28 20:35:16'),
(27, 31, 3, '2025-11-28 20:38:13'),
(28, 1, 3, '2025-11-28 20:38:14'),
(29, 41, 3, '2025-11-28 20:38:15'),
(30, 12, 3, '2025-11-28 20:38:16'),
(31, 28, 3, '2025-11-28 20:38:17'),
(32, 15, 3, '2025-11-28 20:38:18'),
(33, 14, 3, '2025-11-29 12:53:24'),
(34, 17, 3, '2025-11-29 13:10:12'),
(35, 9, 3, '2025-12-01 09:39:56'),
(36, 50, 3, '2025-12-01 09:41:08'),
(37, 29, 2, '2025-12-01 09:43:22'),
(38, 49, 3, '2025-12-01 13:19:46'),
(42, 9, 2, '2025-12-03 15:46:14'),
(43, 19, 2, '2025-12-06 00:56:13'),
(44, 4, 3, '2025-12-06 16:19:26'),
(45, 34, 3, '2025-12-06 16:19:29'),
(47, 45, 3, '2025-12-06 17:57:52'),
(48, 22, 3, '2025-12-06 18:05:29'),
(49, 10, 3, '2025-12-06 18:05:31'),
(50, 43, 3, '2025-12-06 19:12:12'),
(53, 44, 3, '2025-12-06 19:44:22'),
(54, 46, 2, '2025-12-07 11:17:23'),
(56, 8, 5, '2025-12-08 18:31:35'),
(57, 14, 5, '2025-12-08 18:32:01'),
(58, 4, 5, '2025-12-08 18:32:02'),
(59, 27, 5, '2025-12-08 18:32:38'),
(60, 12, 5, '2025-12-08 18:32:39'),
(61, 16, 5, '2025-12-08 18:32:40'),
(62, 2, 5, '2025-12-08 18:32:41'),
(63, 1, 5, '2025-12-08 18:32:42'),
(64, 9, 5, '2025-12-08 18:32:43'),
(66, 46, 5, '2025-12-08 21:01:07'),
(67, 40, 5, '2025-12-08 21:01:12'),
(68, 18, 2, '2025-12-08 21:27:10'),
(69, 5, 2, '2025-12-08 21:27:11'),
(72, 19, 5, '2025-12-08 22:13:30'),
(73, 46, 15, '2025-12-09 09:56:58'),
(74, 37, 15, '2025-12-09 10:16:16'),
(75, 14, 15, '2025-12-09 10:16:17'),
(76, 18, 15, '2025-12-09 10:16:18'),
(77, 13, 15, '2025-12-09 10:16:19'),
(78, 2, 15, '2025-12-09 10:16:20'),
(79, 27, 15, '2025-12-09 10:16:21'),
(80, 43, 2, '2025-12-10 07:36:02'),
(81, 31, 2, '2025-12-10 08:18:38'),
(82, 17, 2, '2025-12-10 08:18:40'),
(83, 39, 2, '2025-12-12 16:17:56'),
(84, 35, 3, '2025-12-14 10:38:21'),
(85, 6, 3, '2025-12-16 10:58:28');

-- --------------------------------------------------------

--
-- Structure de la table `fk_panier`
--

DROP TABLE IF EXISTS `fk_panier`;
CREATE TABLE IF NOT EXISTS `fk_panier` (
  `id_fk_panier` int NOT NULL AUTO_INCREMENT,
  `id_compositions_donuts` int DEFAULT NULL,
  `source_table` varchar(50) NOT NULL DEFAULT 'compositions_donuts',
  `source_id` int DEFAULT NULL,
  `id_users` int NOT NULL,
  `quantite` int NOT NULL,
  PRIMARY KEY (`id_fk_panier`),
  KEY `fk_compo` (`id_compositions_donuts`),
  KEY `fk_users1` (`id_users`),
  KEY `idx_fkpanier_source_user` (`source_table`,`source_id`,`id_users`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `fk_panier`
--

INSERT INTO `fk_panier` (`id_fk_panier`, `id_compositions_donuts`, `source_table`, `source_id`, `id_users`, `quantite`) VALUES
(9, NULL, 'nos_donuts', 6, 2, 3),
(22, 51, 'compositions_donuts', 51, 2, 4),
(32, NULL, 'nos_donuts', 46, 3, 1),
(33, NULL, 'nos_donuts', 44, 3, 1),
(36, NULL, 'nos_donuts', 46, 5, 4),
(38, 65, 'compositions_donuts', 65, 2, 2),
(39, 52, 'compositions_donuts', 52, 2, 1),
(40, 60, 'compositions_donuts', 60, 2, 2),
(43, 72, 'compositions_donuts', 72, 3, 3),
(49, 71, 'compositions_donuts', 71, 5, 1),
(50, 70, 'compositions_donuts', 70, 5, 1);

-- --------------------------------------------------------

--
-- Structure de la table `fourrages`
--

DROP TABLE IF EXISTS `fourrages`;
CREATE TABLE IF NOT EXISTS `fourrages` (
  `id_fourrage` int NOT NULL AUTO_INCREMENT,
  `name_fourrage` varchar(30) NOT NULL,
  `img_fourrage` text NOT NULL,
  `type_fourrage` varchar(30) NOT NULL,
  PRIMARY KEY (`id_fourrage`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `fourrages`
--

INSERT INTO `fourrages` (`id_fourrage`, `name_fourrage`, `img_fourrage`, `type_fourrage`) VALUES
(1, 'Chocolat', 'images/constructor/fourrages/chocolat.svg', 'sucré'),
(2, 'Café', 'images/constructor/fourrages/cafe.svg', 'sucré'),
(3, 'Nutella', 'images/constructor/fourrages/nutella.svg', 'sucré'),
(4, 'Fraise', 'images/constructor/fourrages/fraise.svg', 'sucré'),
(5, 'El Mordjene', 'images/constructor/fourrages/el mordjene.svg', 'sucré'),
(6, 'Caramel', 'images/constructor/fourrages/caramel.svg', 'sucré'),
(8, 'Pistache', 'images/constructor/fourrages/pistache.svg', 'sucré'),
(9, 'Spéculos', 'images/constructor/fourrages/speculos.svg', 'sucré'),
(10, 'Vanille', 'images/constructor/fourrages/vanille.svg', 'sucré'),
(11, 'Framboise', 'images/constructor/fourrages/framboise.svg', 'sucré'),
(12, 'Abricot', 'images/constructor/fourrages/abricot.svg', 'sucré'),
(13, 'Citron', 'images/constructor/fourrages/citron.svg', 'sucré'),
(14, 'Matcha', 'images/constructor/fourrages/matcha.svg', 'sucré'),
(15, 'Sésame Noir', 'images/constructor/fourrages/sesame noir.svg', 'sucré'),
(16, 'Chocolat Noir', 'images/constructor/fourrages/chocolat noir.svg', 'sucré'),
(17, 'Beurre de Cacahuète', 'images/constructor/fourrages/beurre de cacahuete.svg', 'sucré'),
(18, 'Viande Hachée', 'images/food/fourrage/viande hachée.svg', 'salé'),
(19, 'Poulet', 'images/food/fourrage/poulet.svg', 'salé'),
(20, 'Raclette', 'images/food/fourrage/raclette.svg', 'salé'),
(21, 'Saumon', 'images/food/fourrage/saumon.svg', 'salé'),
(22, 'Thon', 'images/food/fourrage/thon.svg', 'salé'),
(23, 'Kebab', 'images/food/fourrage/kebab.svg', 'salé'),
(24, 'Cordon Bleu', 'images/food/fourrage/cordon bleu.svg', 'salé'),
(25, 'Falafel', 'images/food/fourrage/falafel.svg', 'salé'),
(27, 'Guacamole', 'images/food/fourrage/guacamole.svg', 'salé');

-- --------------------------------------------------------

--
-- Structure de la table `glacages`
--

DROP TABLE IF EXISTS `glacages`;
CREATE TABLE IF NOT EXISTS `glacages` (
  `id_glacage` int NOT NULL AUTO_INCREMENT,
  `name_glacage` varchar(40) NOT NULL,
  `img_glacage` text NOT NULL,
  `type_glacage` varchar(20) NOT NULL,
  PRIMARY KEY (`id_glacage`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `glacages`
--

INSERT INTO `glacages` (`id_glacage`, `name_glacage`, `img_glacage`, `type_glacage`) VALUES
(1, 'Chocolat', 'images/constructor/glacages/chocolat.svg', 'sucré'),
(2, 'Vanille', 'images/constructor/glacages/vanille.svg', 'sucré'),
(3, 'Fraise', 'images/constructor/glacages/fraise.svg', 'sucré'),
(5, 'Pistache', 'images/constructor/glacages/pistache.svg', 'sucré'),
(6, 'Chocolat Blanc', 'images/constructor/glacages/chocolat blanc.svg', 'sucré'),
(7, 'Chocolat Noir', 'images/constructor/glacages/chocolat noir.svg', 'sucré'),
(8, 'Caramel', 'images/constructor/glacages/caramel.svg', 'sucré'),
(9, 'Caramel Beurre Salé', 'images/constructor/glacages/caramel beurre sale.svg', 'sucré'),
(10, 'Café', 'images/constructor/glacages/cafe.svg', 'sucré'),
(11, 'Sirop d\'Érable', 'images/constructor/glacages/sirop erable.svg', 'sucré'),
(12, 'Cheddar', 'images/food/glacages/cheddar.svg', 'salé'),
(13, 'Mayonnaise', 'images/food/glacages/mayonnaise.svg', 'salé'),
(14, 'Fromage Raclette', 'images/food/glacages/raclette.svg', 'salé'),
(15, 'Panure', 'images/food/glacages/panure.svg', 'salé'),
(16, 'Miel', 'images/food/glacages/miel.svg', 'salé'),
(17, 'Tomate', 'images/food/glacages/tomate.svg', 'salé'),
(18, 'Sauce Curry', 'images/food/glacages/curry.svg', 'salé'),
(19, 'Sauce Yopi', 'images/food/glacages/yopi.svg', 'salé'),
(20, 'Sauce Nuoc-Mam', 'images/food/glacages/nuoc nam.svg', 'salé'),
(21, 'Harissa', 'images/food/glacages/harissa.svg', 'salé'),
(22, 'Soskipik', 'images/food/glacages/soskipik.svg', 'salé'),
(23, 'Pesto', 'images/food/glacages/pesto.svg', 'salé');

-- --------------------------------------------------------

--
-- Structure de la table `nos_donuts`
--

DROP TABLE IF EXISTS `nos_donuts`;
CREATE TABLE IF NOT EXISTS `nos_donuts` (
  `id_donuts_de_base` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `img` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `imgAlt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bannerUrl` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nutritionalFacts` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `prix` float NOT NULL,
  PRIMARY KEY (`id_donuts_de_base`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `nos_donuts`
--

INSERT INTO `nos_donuts` (`id_donuts_de_base`, `title`, `url`, `img`, `imgAlt`, `bannerUrl`, `nutritionalFacts`, `description`, `prix`) VALUES
(1, 'Beignet Glaçage Chocolat', 'https://www.krispykreme.com/menu/doughnuts/chocolate-glazed-doughnut', 'images/chocolate-glazed-doughnut.jpg', 'Image du Beignet Glaçage Chocolat', 'images/chocolate-glazed-doughnut-banner.jpg', 'images/chocolate-glazed-doughnut-facts.pdf', 'Notre classique Original Glazed® recouvert d’un riche glaçage au chocolat. *Disponible les vendredis Chocolate Glaze dans les points participants.', 2.5),
(2, 'Glacé avec Garniture KREME', 'https://www.krispykreme.com/menu/doughnuts/glazed-with-kreme-filling', 'images/glazed-with-kreme-filling.jpg', 'Image du Beignet Glacé avec Garniture KREME', 'images/glazed-with-kreme-filling-banner.jpg', 'images/glazed-with-kreme-filling-facts.pdf', 'Ce beignet levé est glacé puis garni de notre délicieux KREME.', 3),
(3, 'Cake Glaçage Chocolat', 'https://www.krispykreme.com/menu/doughnuts/chocolate-iced-cake', 'images/chocolate-iced-cake.jpg', 'Image du Cake Glaçage Chocolat', 'images/chocolate-iced-cake-banner.jpg', 'images/chocolate-iced-cake-facts.pdf', 'Notre beignet cake traditionnel trempé à la main dans un glaçage au chocolat décadent.', 3),
(4, 'Beignet OREO Cookie Glacé', 'https://www.krispykreme.com/menu/doughnuts/oreo®-cookie-glazed-doughnut', 'images/oreo®-cookie-glazed-doughnut.jpg', 'Image du Beignet OREO Cookie Glacé', 'images/oreo®-cookie-glazed-doughnut-banner.jpg', 'images/oreo®-cookie-glazed-doughnut-facts.pdf', 'Original Glazed® recouvert d’un glaçage OREO®, garni de Cookies & KREME™, décoré d’un filet de glaçage et de morceaux d’OREO®.', 3.5),
(5, 'Chocolat Glaçé Fourré Framboise', 'https://www.krispykreme.com/menu/doughnuts/chocolate-iced-raspberry-filled', 'images/chocolate-iced-raspberry-filled.jpg', 'Image du Beignet Chocolat Glaçé Fourré Framboise', 'images/chocolate-iced-raspberry-filled-banner.jpg', 'images/chocolate-iced-raspberry-filled-facts.pdf', 'Fourré d’une douce gelée de framboise, ce beignet est nappé de glaçage chocolat avec un délicat tourbillon rouge.', 3.2),
(6, 'Cake Chocolat Glacé', 'https://www.krispykreme.com/menu/doughnuts/glazed-chocolate-cake', 'images/glazed-chocolate-cake.jpg', 'Image du Cake Chocolat Glacé', 'images/glazed-chocolate-cake-banner.jpg', 'images/glazed-chocolate-cake-facts.pdf', 'Pour les amoureux du cake au chocolat : riche, moelleux et intense. Le tout recouvert de notre glaçage signature.', 3),
(7, 'Cake Myrtille Glaçé', 'https://www.krispykreme.com/menu/doughnuts/glazed-blueberry-cake', 'images/glazed-blueberry-cake.jpg', 'Image du Cake Myrtille Glaçé', 'images/glazed-blueberry-cake-banner.jpg', 'images/glazed-blueberry-cake-facts.pdf', 'Un beignet cake classique débordant de saveur de myrtille, puis glacé pour une combinaison irrésistible.', 3),
(8, 'Fourré Pomme Cannelle', 'https://www.krispykreme.com/menu/doughnuts/cinnamon-apple-filled', 'images/cinnamon-apple-filled.jpg', 'Image du Fourré Pomme Cannelle', 'images/cinnamon-apple-filled-banner.jpg', 'images/cinnamon-apple-filled-facts.pdf', 'Inspiré de la tarte aux pommes : fourré d’un compoté pomme-cannelle et enrobé d’un mélange sucre-cannelle.', 3.2),
(9, 'OREO Cookie Over-the-Top', 'https://www.krispykreme.com/menu/doughnuts/oreo®-cookie-over-the-top-doughnut', 'images/oreo®-cookie-over-the-top-doughnut.jpg', 'Image du OREO Cookie Over-the-Top', 'images/oreo®-cookie-over-the-top-doughnut-banner.jpg', 'images/oreo®-cookie-over-the-top-doughnut-facts.pdf', 'Un beignet OREO® Cookie Glazed garni de Cookies & KREME™, nappé de glaçage chocolat et décoré d’une gaufrette OREO®.', 3.6),
(10, 'Cinnamon Bun', 'https://www.krispykreme.com/menu/doughnuts/cinnamon-bun', 'images/cinnamon-bun.jpg', 'Image du Cinnamon Bun', 'images/cinnamon-bun-banner.jpg', 'images/cinnamon-bun-facts.pdf', 'Qui n’aime pas un cinnamon bun ? Régalez-vous avec notre pâte à la cannelle recouverte de notre glaçage signature.', 3),
(11, 'REESE’S Classique', 'https://www.krispykreme.com/menu/doughnuts/reese-s-classic', 'images/reese-s-classic.jpg', 'Image du REESE’S Classique', 'images/reese-s-classic-banner.jpg', 'images/reese-s-classic-facts.pdf', 'Beignet fourré au Peanut Butter Kreme™ de REESE’S, nappé de glaçage chocolat HERSHEY’S, décoré de pépites beurre de cacahuète et d’un filet chocolat et sauce REESE’S.', 3.6),
(12, 'Sucre à la Cannelle', 'https://www.krispykreme.com/menu/doughnuts/cinnamon-sugar', 'images/cinnamon-sugar.jpg', 'Image du Beignet Sucre à la Cannelle', 'images/cinnamon-sugar-banner.jpg', 'images/cinnamon-sugar-facts.pdf', 'Notre anneau classique roulé dans un mélange sucre-cannelle pour une gourmandise simple et parfaite.', 2),
(13, 'Original Fourré Kreme Original', 'https://www.krispykreme.com/menu/doughnuts/original-filled-original-kreme™', 'images/original-filled-original-kreme™.jpg', 'Image du Original Fourré Kreme Original', 'images/original-filled-original-kreme™-banner.jpg', 'images/original-filled-original-kreme™-facts.pdf', 'Original Fourré, Kreme Original™ : notre iconique Original Glazed® garni de Kreme blanc classique et décoré d’un filet de glaçage.', 2),
(14, 'Cake Crème Aigre Glaçé', 'https://www.krispykreme.com/menu/doughnuts/glazed-sour-cream', 'images/glazed-sour-cream.jpg', 'Image du Cake Crème Aigre Glaçé', 'images/glazed-sour-cream-banner.jpg', 'images/glazed-sour-cream-facts.pdf', 'Ce cake riche et moelleux est nappé de notre glaçage Original pour une touche finale parfaite.', 3),
(15, 'Original Fourré Kreme Chocolat', 'https://www.krispykreme.com/menu/doughnuts/original-filled-chocolate-kreme™', 'images/original-filled-chocolate-kreme™.jpg', 'Image du Original Fourré Kreme Chocolat', 'images/original-filled-chocolate-kreme™-banner.jpg', 'images/original-filled-chocolate-kreme™-facts.pdf', 'Original Fourré, Kreme Chocolat™ : notre Original Glazed® garni de Kreme chocolat et décoré d’un filet de glaçage chocolat.', 2),
(16, 'Original Glazed', 'https://www.krispykreme.com/menu/doughnuts/original-glazed-doughnut', 'images/original-glazed-doughnut.jpg', 'Image du Original Glazed', 'images/original-glazed-doughnut-banner.jpg', 'images/original-glazed-doughnut-facts.pdf', 'Surveillez la Hot Light™ ! Elle signifie que nos Original Glazed® tout juste sortis du four sont disponibles à ce moment précis.', 1.6),
(17, 'Glacé Chocolat', 'https://www.krispykreme.com/menu/doughnuts/chocolate-iced-glazed', 'images/chocolate-iced-glazed.jpg', 'Image du Glacé Chocolat', 'images/chocolate-iced-glazed-banner.jpg', 'images/chocolate-iced-glazed-facts.pdf', 'Pour les amateurs de chocolat ! Notre Original Glazed® trempé dans un glaçage chocolat onctueux.', 2),
(18, 'Glacé Chocolat avec Vermicelles', 'https://www.krispykreme.com/menu/doughnuts/chocolate-iced-glazed-with-sprinkles', 'images/chocolate-iced-glazed-with-sprinkles.jpg', 'Image du Glacé Chocolat avec Vermicelles', 'images/chocolate-iced-glazed-with-sprinkles-banner.jpg', 'images/chocolate-iced-glazed-with-sprinkles-facts.pdf', 'Notre Original Glazed® trempé dans du glaçage chocolat puis recouvert de vermicelles colorés.', 2),
(19, 'OREO Cookies & KREME', 'https://www.krispykreme.com/menu/doughnuts/oreo-cookies-and-kreme', 'images/oreo-cookies-and-kreme.jpg', 'Image du OREO Cookies & KREME', 'images/oreo-cookies-and-kreme-banner.jpg', 'images/oreo-cookies-and-kreme-facts.pdf', 'Un favori des fans ! Fourré de Cookies & Kreme OREO®, nappé de glaçage chocolat noir et décoré de morceaux d’OREO®.', 3.5),
(21, 'Cruller Glacé Chocolat', 'https://www.krispykreme.com/menu/doughnuts/chocolate-iced-glazed-cruller', 'images/chocolate-iced-glazed-cruller.jpg', 'Image du Cruller Glacé Chocolat', 'images/chocolate-iced-glazed-cruller-banner.jpg', 'images/chocolate-iced-glazed-cruller-facts.pdf', 'Notre cake découpé en cruller, glacé puis nappé de notre glaçage chocolat décadent.', 3),
(22, 'Torsade à la Cannelle', 'https://www.krispykreme.com/menu/doughnuts/cinnamon-twist', 'images/cinnamon-twist.jpg', 'Image de la Torsade à la Cannelle', 'images/cinnamon-twist-banner.jpg', 'images/cinnamon-twist-facts.pdf', 'Une délicieuse torsade : pâte levée façonnée à la main puis entièrement recouverte de sucre à la cannelle.', 3),
(23, 'Glacé Chocolat Fourré KREME', 'https://www.krispykreme.com/menu/doughnuts/chocolate-iced-with-kreme-filling', 'images/chocolate-iced-with-kreme-filling.jpg', 'Image du Glacé Chocolat Fourré KREME', 'images/chocolate-iced-with-kreme-filling-banner.jpg', 'images/chocolate-iced-with-kreme-filling-facts.pdf', 'Un favori : garni de notre léger et onctueux KREME™, puis nappé de notre glaçage chocolat classique.', 2.6),
(24, 'Cake Batter', 'https://www.krispykreme.com/menu/doughnuts/cake-batter-doughnut', 'images/cake-batter-doughnut.jpg', 'Image du Cake Batter', 'images/cake-batter-doughnut-banner.jpg', 'images/cake-batter-doughnut-facts.pdf', 'Nous célébrons les anniversaires chaque jour : fourré au Cake Batter KREME, nappé de glaçage jaune et de confettis colorés.', 2.6),
(25, 'Fourré Crème Pâtissière Chocolat', 'https://www.krispykreme.com/menu/doughnuts/chocolate-iced-custard-filled', 'images/chocolate-iced-custard-filled.jpg', 'Image du Fourré Crème Pâtissière Chocolat', 'images/chocolate-iced-custard-filled-banner.jpg', 'images/chocolate-iced-custard-filled-facts.pdf', 'Fourré de crème pâtissière et trempé dans un riche glaçage chocolat. Miam !', 2.6),
(26, 'Glacé Fourré Framboise', 'https://www.krispykreme.com/menu/doughnuts/glazed-raspberry-filled', 'images/glazed-raspberry-filled.jpg', 'Image du Glacé Fourré Framboise', 'images/glazed-raspberry-filled-banner.jpg', 'images/glazed-raspberry-filled-facts.pdf', 'Glacé puis garni d’une gelée de framboise douce et acidulée.', 2.5),
(27, 'Double Chocolat Noir', 'https://www.krispykreme.com/menu/doughnuts/double-dark-chocolate', 'images/double-dark-chocolate.jpg', 'Image du Double Chocolat Noir', 'images/double-dark-chocolate-banner.jpg', 'images/double-dark-chocolate-facts.pdf', '', 3),
(28, 'Dulce De Leche', 'https://www.krispykreme.com/menu/doughnuts/dulce-de-leche', 'images/dulce-de-leche.jpg', 'Image du Dulce De Leche', 'images/dulce-de-leche-banner.jpg', 'images/dulce-de-leche-facts.pdf', 'Originaire d’Amérique latine : une douceur crémeuse saveur caramel. Fourré de dulce de leche et enrobé de sucre cristallisé.', 3),
(29, 'Glacé Fourré Citron', 'https://www.krispykreme.com/menu/doughnuts/glazed-lemon-filled', 'images/glazed-lemon-filled.jpg', 'Image du Glacé Fourré Citron', 'images/glazed-lemon-filled-banner.jpg', 'images/glazed-lemon-filled-facts.pdf', 'Fourré d’un citron intense et recouvert du glaçage Original.', 2.6),
(30, 'Glaçage Fraise et Vermicelles', 'https://www.krispykreme.com/menu/doughnuts/strawberry-iced-with-sprinkles', 'images/strawberry-iced-with-sprinkles.jpg', 'Image du Beignet Fraise avec Vermicelles', 'images/strawberry-iced-with-sprinkles-banner.jpg', 'images/strawberry-iced-with-sprinkles-facts.pdf', 'Original Glazed® trempé dans un glaçage fraise et décoré de vermicelles arc-en-ciel.', 2),
(31, 'Canelle Glaçé', 'https://www.krispykreme.com/menu/doughnuts/glazed-cinnamon', 'images/glazed-cinnamon.jpg', 'Image du Glacé Cannelle', 'images/glazed-cinnamon-banner.jpg', 'images/glazed-cinnamon-facts.pdf', 'Un goût réconfortant : cannelle, douceur et nostalgie. Un beignet levé glacé à la cannelle.', 2),
(33, 'Cruller Glaçé', 'https://www.krispykreme.com/menu/doughnuts/glazed-cruller', 'images/glazed-cruller.jpg', 'Image du Cruller Glaçé', 'images/glazed-cruller-banner.jpg', 'images/glazed-cruller-facts.pdf', 'Riche et moelleux, un twist du cake classique, glacé de notre glaçage signature.', 2),
(34, 'Glacé au Sirop d’Érable', 'https://www.krispykreme.com/menu/doughnuts/maple-iced-glazed', 'images/maple-iced-glazed.jpg', 'Image du Glacé Érable', 'images/maple-iced-glazed-banner.jpg', 'images/maple-iced-glazed-facts.pdf', 'Original Glazed® nappé d’un glaçage saveur érable.', 2.6),
(35, 'Mini Original Glazed', 'https://www.krispykreme.com/menu/doughnuts/mini-original-glazed-doughnuts', 'images/mini-original-glazed-doughnuts.jpg', 'Image des Mini Original Glazed', 'images/mini-original-glazed-doughnuts-banner.jpg', 'images/mini-original-glazed-doughnuts-facts.pdf', 'Même goût que l’Original Glazed®, en plus petit.', 1.5),
(36, 'Mini Chocolat Glacé', 'https://www.krispykreme.com/menu/doughnuts/mini-chocolate-iced-glazed', 'images/mini-chocolate-iced-glazed.jpg', 'Image des Mini Chocolat Glacé', 'images/mini-chocolate-iced-glazed-banner.jpg', 'images/mini-chocolate-iced-glazed-facts.pdf', 'Même goût que le Chocolat Glacé classique, en version mini.', 1.5),
(37, 'Mini Chocolat Glacé et Vermicelles', 'https://www.krispykreme.com/menu/doughnuts/mini-chocolate-iced-with-sprinkles', 'images/mini-chocolate-iced-with-sprinkles.jpg', 'Image des Mini Chocolat et Vermicelles', 'images/mini-chocolate-iced-with-sprinkles-banner.jpg', 'images/mini-chocolate-iced-with-sprinkles-facts.pdf', 'Même goût que la version classique avec vermicelles, en plus petit.', 1.5),
(38, 'Mini Fraise Glacée avec Vermicelles', 'https://www.krispykreme.com/menu/doughnuts/mini-strawberry-iced-with-sprinkles', 'images/mini-strawberry-iced-with-sprinkles.jpg', 'Image des Mini Fraise avec Vermicelles', 'images/mini-strawberry-iced-with-sprinkles-banner.jpg', 'images/mini-strawberry-iced-with-sprinkles-facts.pdf', 'Même goût que la version fraise avec vermicelles, en format mini.', 0),
(39, 'Cheesecake New York', 'https://www.krispykreme.com/menu/doughnuts/new-york-cheesecake', 'images/new-york-cheesecake.jpg', 'Image du Cheesecake New York', 'images/new-york-cheesecake-banner.jpg', 'images/new-york-cheesecake-facts.pdf', 'Fourré de cheesecake crémeux, nappé de glaçage cream cheese et saupoudré de graham croquant.', 3),
(40, 'Fourré Myrtille Sucré', 'https://www.krispykreme.com/menu/doughnuts/powdered-blueberry-filled', 'images/powdered-blueberry-filled.jpg', 'Image du Fourré Myrtille Sucré', 'images/powdered-blueberry-filled-banner.jpg', 'images/powdered-blueberry-filled-facts.pdf', 'Beignet levé rempli de myrtille et enrobé de sucre glace.', 2.6),
(43, 'Fourré Fraise Sucré', 'https://www.krispykreme.com/menu/doughnuts/powdered-strawberry-filled', 'images/powdered-strawberry-filled.jpg', 'Image du Fourré Fraise Sucré', 'images/powdered-strawberry-filled-banner.jpg', 'images/powdered-strawberry-filled-facts.pdf', 'Rempli de fraise et enrobé de sucre glace.', 0),
(44, 'Sucré Fourré Kreme Citron', 'https://www.krispykreme.com/menu/doughnuts/powdered-with-lemon-kreme', 'images/powdered-with-lemon-kreme.jpg', 'Image du Sucré Fourré Kreme Citron', 'images/powdered-with-lemon-kreme-banner.jpg', 'images/powdered-with-lemon-kreme-facts.pdf', 'Beignet sucré fourré d’un délicieux kreme citron.', 2.6),
(45, 'Sucré Fourré Kreme Fraise', 'https://www.krispykreme.com/menu/doughnuts/powdered-with-strawberry-kreme', 'images/powdered-with-strawberry-kreme.jpg', 'Image du Sucré Fourré Kreme Fraise', 'images/powdered-with-strawberry-kreme-banner.jpg', 'images/powdered-with-strawberry-kreme-facts.pdf', 'Beignet sucré garni de kreme fraise sucré.', 2.6),
(46, 'Glaçage Fraise', 'https://www.krispykreme.com/menu/doughnuts/strawberry-iced', 'images/strawberry-iced.jpg', 'Image du Beignet Glaçage Fraise', 'images/strawberry-iced-banner.jpg', 'images/strawberry-iced-facts.pdf', 'Un beignet glacé à la fraise, délicieux et joliment rose.', 2);

-- --------------------------------------------------------

--
-- Structure de la table `topping`
--

DROP TABLE IF EXISTS `topping`;
CREATE TABLE IF NOT EXISTS `topping` (
  `id_topping` int NOT NULL AUTO_INCREMENT,
  `name_topping` varchar(30) NOT NULL,
  `img_topping` text NOT NULL,
  `type_topping` varchar(20) NOT NULL,
  PRIMARY KEY (`id_topping`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `topping`
--

INSERT INTO `topping` (`id_topping`, `name_topping`, `img_topping`, `type_topping`) VALUES
(1, 'M&M\'s', 'images/food/topping/m&m.svg', 'sucré'),
(2, 'Cheddar', 'images/food/topping/cheddar.svg', 'salé'),
(3, 'Motif Étoile', 'images/food/topping/motif étoile.svg', 'sucré'),
(4, 'Motif Cœur', 'images/food/topping/motif coeur.svg', 'sucré'),
(5, 'Motif Point', 'images/food/topping/motif point.svg', 'sucré'),
(6, 'Paillettes', 'images/food/topping/paillette.svg', 'sucré'),
(7, 'Kinder Bueno', 'images/food/topping/kinder bueno.svg', 'sucré'),
(8, 'Oreo', 'images/food/topping/oreo.svg', 'sucré'),
(9, 'KitKat', 'images/food/topping/kitkat.svg', 'sucré'),
(10, 'Spéculos', 'images/food/topping/spéculos.svg', 'sucré'),
(11, 'Bacon', 'images/food/topping/bacon.svg', 'salé'),
(12, 'Oignons Frits', 'images/food/topping/oignon frit.svg', 'salé'),
(13, 'Graines de Sésame', 'images/food/topping/graine de sésame.svg', 'salé'),
(15, 'Parmesan', 'images/food/topping/parmesan.svg', 'salé'),
(16, 'Riz Soufflé', 'images/food/topping/riz soufflé.svg', 'salé'),
(17, 'Cornichon', 'images/food/topping/cornichon.svg', 'salé'),
(18, 'Origan', 'images/food/topping/origan.svg', 'salé'),
(19, 'CBD ', 'images/food/topping/cbd.svg', 'salé'),
(20, 'Fromage végan', 'images/food/topping/fromage vegan.svg', 'salé'),
(21, 'Champignon', 'images/food/topping/champignon.svg', 'salé'),
(22, 'Doritos', 'images/food/topping/doritos.svg', 'salé'),
(23, 'Crevettes ', 'images/food/topping/crevette.svg', 'salé'),
(24, 'Clémentine', 'images/food/topping/clémentine.svg', 'salé');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `login` varchar(30) NOT NULL,
  `mdp` varchar(90) NOT NULL,
  `photo` text NOT NULL,
  `description` text NOT NULL,
  `admin` int NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id_user`, `login`, `mdp`, `photo`, `description`, `admin`) VALUES
(2, 'Adam', '$2y$10$2slyKoViqJnp8dbAsa5UfOqcIwKayvXqtYLOoETz3TwfpkfkY5CKG', 'images/pp/afe8c2c182b20652ad288f42.jpg', 'J\'adore les donuts et tout abonnez vous !', 0),
(3, 'Lohan', '$2y$10$acMN1dNLzLnFvieiPcI2F.pOppFerwMM/xsQMjumere2KhcxQu7ba', 'images/pp/cc5dc6aaf38ff13796563e46.jpg', '', 0),
(4, 'MXS_MMS', '$2y$10$KVogGBlsdOvwNW6PsFMaZeFvDaRIva1cifciaD0jSWLfKbPiB.aEK', 'images/pp/92235e754a0796a4ae838de1.png', 'spécialisé dans les compos de détraqué (ig : max_ens8)', 0),
(5, 'paul', '$2y$10$CifqOor2SiO4YeYgt80B3ecm.Phy88tpC1Pr90192f2C1Rrlhx4Yq', '', '', 0),
(15, 'Fatima', '$2y$10$3/rmRvct13WZyfEw29h6BuJSORvFWs4QqBjwQjrL8h/WqXE4xdc2y', 'images/pp/6fc470099fd0d563f8cf75f2.webp', '', 0);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commentaires`
--
ALTER TABLE `commentaires`
  ADD CONSTRAINT `commentaires_ibfk_1` FOREIGN KEY (`id_auteur`) REFERENCES `users` (`id_user`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `commentaires_ibfk_2` FOREIGN KEY (`id_donuts_concerné`) REFERENCES `compositions_donuts` (`id_composition`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `compositions_donuts`
--
ALTER TABLE `compositions_donuts`
  ADD CONSTRAINT `fk_beignet` FOREIGN KEY (`id_beignet`) REFERENCES `beignets` (`id_beignet`),
  ADD CONSTRAINT `fk_createur` FOREIGN KEY (`id_createur`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `fk_fourrage` FOREIGN KEY (`id_fourrage`) REFERENCES `fourrages` (`id_fourrage`),
  ADD CONSTRAINT `fk_glacage` FOREIGN KEY (`id_glacage`) REFERENCES `glacages` (`id_glacage`),
  ADD CONSTRAINT `fk_topping` FOREIGN KEY (`id_topping`) REFERENCES `topping` (`id_topping`);

--
-- Contraintes pour la table `fk_follow`
--
ALTER TABLE `fk_follow`
  ADD CONSTRAINT `fk_follow_ibfk_1` FOREIGN KEY (`id_user_qui_follow`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `fk_follow_ibfk_2` FOREIGN KEY (`id_user_suivit`) REFERENCES `users` (`id_user`);

--
-- Contraintes pour la table `fk_like`
--
ALTER TABLE `fk_like`
  ADD CONSTRAINT `fk_compo1` FOREIGN KEY (`id_compositions_donuts`) REFERENCES `compositions_donuts` (`id_composition`),
  ADD CONSTRAINT `fk_users` FOREIGN KEY (`id_users`) REFERENCES `users` (`id_user`);

--
-- Contraintes pour la table `fk_panier`
--
ALTER TABLE `fk_panier`
  ADD CONSTRAINT `fk_users1` FOREIGN KEY (`id_users`) REFERENCES `users` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
