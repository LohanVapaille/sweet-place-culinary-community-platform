-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : ven. 09 jan. 2026 à 14:34
-- Version du serveur : 11.4.9-MariaDB
-- Version de PHP : 8.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `vapaille_donuts`
--

-- --------------------------------------------------------

--
-- Structure de la table `beignets`
--

CREATE TABLE `beignets` (
  `id_beignet` int(11) NOT NULL,
  `name_beignet` varchar(30) NOT NULL,
  `img_beignets` text NOT NULL,
  `type_beignet` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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

CREATE TABLE `commentaires` (
  `id_commentaire` int(11) NOT NULL,
  `text-comment` varchar(100) NOT NULL,
  `note` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  `id_donuts_concerné` int(11) NOT NULL,
  `id_auteur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `commentaires`
--

INSERT INTO `commentaires` (`id_commentaire`, `text-comment`, `note`, `date`, `id_donuts_concerné`, `id_auteur`) VALUES
(13, 'Délicieux, très beau également !', 5, 1765899724, 79, 3),
(14, 'C\'est trop bon !', 5, 1765912519, 52, 2),
(19, 'Hello! Délicieuse compo !', 5, 1765965008, 82, 2),
(20, 'Merci ma soeur', 5, 1766066060, 85, 3),
(21, 'Super composition, ça m\'a l\'air très bon !', 5, 1766524304, 93, 3),
(22, 'incroyblement bon ! on sen bien le goux de ces pieds', 5, 1767794697, 97, 21);

-- --------------------------------------------------------

--
-- Structure de la table `compositions_donuts`
--

CREATE TABLE `compositions_donuts` (
  `id_composition` int(11) NOT NULL,
  `donut_name` varchar(255) DEFAULT NULL,
  `id_beignet` int(11) NOT NULL,
  `id_fourrage` int(11) DEFAULT NULL,
  `id_glacage` int(11) DEFAULT NULL,
  `id_topping` int(11) DEFAULT NULL,
  `id_createur` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `type` varchar(20) NOT NULL,
  `prix` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `compositions_donuts`
--

INSERT INTO `compositions_donuts` (`id_composition`, `donut_name`, `id_beignet`, `id_fourrage`, `id_glacage`, `id_topping`, `id_createur`, `description`, `type`, `prix`) VALUES
(52, 'Chocolinito', 1, 1, 1, 1, 3, 'Donuts tout choco topping M&M\'s', 'sucré', 4),
(79, 'Matcha Bueno', 1, 14, 9, 7, 3, 'Un goût que j\'affectionne depuis longtemps !', 'sucré', 4),
(82, 'Raclettino', 2, 20, 14, 13, 3, 'Bagel raclette avec un peu de salade pour la bonne conscience', 'salé', 4),
(83, 'ChocoFraise', 1, 1, 3, 7, 2, 'Un donuts chocolat et fraise pour les gourmants !!', 'sucré', 4),
(85, 'Oukhty\'nuts', 1, 5, 2, 10, 16, 'Pour vous mes arab girls #tiramisu #adam #grandremplacement #dubaï', 'sucré', 4),
(89, 'Donuts Nutella Simple', 1, 3, NULL, NULL, 16, 'Un donuts simple, sans glaçage, simplement avec du nutella à l\'intérieur. Parfait pour les personnes difficiles en nourriture !', 'sucré', 3),
(90, 'El pouleto', 2, 19, 12, 26, 5, 'Un petit sandwish au poulet pour se mettre bien.', 'salé', 4),
(91, 'Une petite douceur', 1, 2, 7, 10, 5, 'Un bon petit donuts qui mets bien.', 'sucré', 4),
(92, 'El cordon bleu', 2, 24, 14, 11, 5, 'Un petit bagel qui va mettre bien pour cette fin d\'année.', 'salé', 4),
(93, 'Perfectorent', 1, 3, 2, 5, 18, 'Le donuts parfait, délicieux, le donuts, qu\'il est bon !!!!', 'sucré', 4),
(94, 'Make Venezuela Yummy Again', 1, 5, 5, 4, 19, 'En hommage au kidnapping du président tyrannique', 'sucré', 4),
(95, 'Thon Piquant !', 2, 22, 21, 25, 16, 'Un bagel au thon sauce Harrissa, avec un peu de coriande. Idéal pour les personnes qui aiment manger épicé', 'salé', 4),
(97, 'le Mastodonte', 1, 5, 5, 7, 21, 'Donuts au el Morjene et à la pistache Bonne dégustation mon zin !', 'sucré', 4),
(98, 'Big green', 1, 14, 5, 24, 22, 'Pour les aventuriers des saveurs. Il faudrait être fou pour tester un truc pareil mais c\'est ce qui le rend unique', 'sucré', 4);

-- --------------------------------------------------------

--
-- Structure de la table `fk_follow`
--

CREATE TABLE `fk_follow` (
  `id` int(11) NOT NULL,
  `id_user_suivit` int(11) NOT NULL,
  `id_user_qui_follow` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
(72, 15, 2),
(74, 3, 16),
(75, 16, 3),
(77, 5, 18),
(78, 3, 18),
(80, 5, 3),
(81, 18, 3);

-- --------------------------------------------------------

--
-- Structure de la table `fk_like`
--

CREATE TABLE `fk_like` (
  `id_like` int(11) NOT NULL,
  `id_compositions_donuts` int(11) NOT NULL,
  `id_users` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `fk_like`
--

INSERT INTO `fk_like` (`id_like`, `id_compositions_donuts`, `id_users`) VALUES
(128, 52, 2),
(129, 82, 2),
(130, 82, 3),
(136, 52, 16),
(138, 85, 3),
(142, 52, 3),
(143, 79, 3),
(145, 89, 16),
(146, 83, 16),
(148, 83, 5),
(149, 85, 5),
(150, 92, 5),
(151, 90, 5),
(152, 91, 5),
(153, 83, 3),
(154, 89, 3),
(155, 92, 18),
(156, 90, 18),
(157, 52, 18),
(158, 93, 18),
(160, 90, 3),
(161, 91, 3),
(162, 94, 19),
(163, 94, 3),
(165, 93, 3),
(167, 95, 3),
(168, 92, 3),
(170, 95, 20);

-- --------------------------------------------------------

--
-- Structure de la table `fk_like_base`
--

CREATE TABLE `fk_like_base` (
  `id_like` int(11) NOT NULL,
  `id_donuts_de_base` int(11) NOT NULL,
  `id_users` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
(85, 6, 3, '2025-12-16 10:58:28'),
(87, 44, 3, '2025-12-16 15:33:27');

-- --------------------------------------------------------

--
-- Structure de la table `fk_panier`
--

CREATE TABLE `fk_panier` (
  `id_fk_panier` int(11) NOT NULL,
  `id_compositions_donuts` int(11) DEFAULT NULL,
  `source_table` varchar(50) NOT NULL DEFAULT 'compositions_donuts',
  `source_id` int(11) DEFAULT NULL,
  `id_users` int(11) NOT NULL,
  `quantite` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `fk_panier`
--

INSERT INTO `fk_panier` (`id_fk_panier`, `id_compositions_donuts`, `source_table`, `source_id`, `id_users`, `quantite`) VALUES
(22, 51, 'compositions_donuts', 51, 2, 4),
(36, NULL, 'nos_donuts', 46, 5, 4),
(38, 65, 'compositions_donuts', 65, 2, 2),
(39, 52, 'compositions_donuts', 52, 2, 1),
(40, 60, 'compositions_donuts', 60, 2, 2),
(49, 71, 'compositions_donuts', 71, 5, 1),
(50, 70, 'compositions_donuts', 70, 5, 1),
(59, NULL, 'nos_donuts', 46, 3, 5),
(60, 85, 'compositions_donuts', 85, 3, 4),
(61, 89, 'compositions_donuts', 89, 3, 1),
(62, 83, 'compositions_donuts', 83, 3, 1),
(63, 52, 'compositions_donuts', 52, 3, 1),
(64, NULL, 'nos_donuts', 4, 3, 1),
(65, 52, 'compositions_donuts', 52, 18, 1),
(66, 93, 'compositions_donuts', 93, 3, 2),
(67, 94, 'compositions_donuts', 94, 3, 1),
(68, 92, 'compositions_donuts', 92, 3, 1),
(70, 97, 'compositions_donuts', 97, 20, 1),
(71, 95, 'compositions_donuts', 95, 25, 5);

-- --------------------------------------------------------

--
-- Structure de la table `fourrages`
--

CREATE TABLE `fourrages` (
  `id_fourrage` int(11) NOT NULL,
  `name_fourrage` varchar(30) NOT NULL,
  `img_fourrage` text NOT NULL,
  `type_fourrage` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
(18, 'Viande Hachée', 'images/constructor/fourrages/viande hache.svg', 'salé'),
(19, 'Poulet', 'images/constructor/fourrages/poulet.svg', 'salé'),
(20, 'Raclette', 'images/constructor/fourrages/raclette.svg', 'salé'),
(21, 'Saumon', 'images/constructor/fourrages/saumon.svg', 'salé'),
(22, 'Thon', 'images/constructor/fourrages/thon.svg', 'salé'),
(23, 'Kebab', 'images/constructor/fourrages/kebab.svg', 'salé'),
(24, 'Cordon Bleu', 'images/constructor/fourrages/cordon bleu.svg', 'salé'),
(25, 'Jambon', 'images/constructor/fourrages/jambon.svg', 'salé'),
(27, 'Guacamole', 'images/constructor/fourrages/guacamole.svg', 'salé');

-- --------------------------------------------------------

--
-- Structure de la table `glacages`
--

CREATE TABLE `glacages` (
  `id_glacage` int(11) NOT NULL,
  `name_glacage` varchar(40) NOT NULL,
  `img_glacage` text NOT NULL,
  `type_glacage` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
(12, 'Cheddar', 'images/constructor/sauces/cheddar.svg', 'salé'),
(13, 'Mayonnaise', 'images/constructor/sauces/mayonnaise.svg', 'salé'),
(14, 'Fromage Raclette', 'images/constructor/sauces/raclette.svg', 'salé'),
(16, 'Miel', 'images/constructor/glacages/sirop erable.svg', 'sucré'),
(17, 'Sauce Tomate', 'images/constructor/sauces/sauce tomate.svg', 'salé'),
(18, 'Sauce Curry', 'images/constructor/sauces/sauce curry.svg', 'salé'),
(19, 'Sauce Yopi', 'images/constructor/sauces/sauce yopie.svg', 'salé'),
(20, 'Sauce Nuoc-Mam', 'images/constructor/sauces/sauce nuoc mam.svg', 'salé'),
(21, 'Harissa', 'images/constructor/sauces/sauce harissa.svg', 'salé'),
(22, 'Soskipik', 'images/constructor/sauces/soskipik.svg', 'salé'),
(23, 'Pesto', 'images/constructor/sauces/sauce pesto.svg', 'salé');

-- --------------------------------------------------------

--
-- Structure de la table `nos_donuts`
--

CREATE TABLE `nos_donuts` (
  `id_donuts_de_base` int(11) NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `img` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `imgAlt` varchar(255) DEFAULT NULL,
  `bannerUrl` varchar(255) DEFAULT NULL,
  `nutritionalFacts` varchar(255) DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `prix` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(27, 'Double Chocolat Noir', 'https://www.krispykreme.com/menu/doughnuts/double-dark-chocolate', 'images/double-dark-chocolate.jpg', 'Image du Double Chocolat Noir', 'images/double-dark-chocolate-banner.jpg', 'images/double-dark-chocolate-facts.pdf', 'Donuts avec un fourrage chocolat noir, avec, comme si ce n\'était pas assez, un glaçage chocolat noir.', 3),
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
(43, 'Fourré Fraise Sucré', 'https://www.krispykreme.com/menu/doughnuts/powdered-strawberry-filled', 'images/powdered-strawberry-filled.jpg', 'Image du Fourré Fraise Sucré', 'images/powdered-strawberry-filled-banner.jpg', 'images/powdered-strawberry-filled-facts.pdf', 'Rempli de fraise et enrobé de sucre glace.', 1.5),
(44, 'Sucré Fourré Kreme Citron', 'https://www.krispykreme.com/menu/doughnuts/powdered-with-lemon-kreme', 'images/powdered-with-lemon-kreme.jpg', 'Image du Sucré Fourré Kreme Citron', 'images/powdered-with-lemon-kreme-banner.jpg', 'images/powdered-with-lemon-kreme-facts.pdf', 'Beignet sucré fourré d’un délicieux kreme citron.', 2.6),
(45, 'Sucré Fourré Kreme Fraise', 'https://www.krispykreme.com/menu/doughnuts/powdered-with-strawberry-kreme', 'images/powdered-with-strawberry-kreme.jpg', 'Image du Sucré Fourré Kreme Fraise', 'images/powdered-with-strawberry-kreme-banner.jpg', 'images/powdered-with-strawberry-kreme-facts.pdf', 'Beignet sucré garni de kreme fraise sucré.', 2.6),
(46, 'Glaçage Fraise', 'https://www.krispykreme.com/menu/doughnuts/strawberry-iced', 'images/strawberry-iced.jpg', 'Image du Beignet Glaçage Fraise', 'images/strawberry-iced-banner.jpg', 'images/strawberry-iced-facts.pdf', 'Un beignet glacé à la fraise, délicieux et joliment rose.', 2);

-- --------------------------------------------------------

--
-- Structure de la table `topping`
--

CREATE TABLE `topping` (
  `id_topping` int(11) NOT NULL,
  `name_topping` varchar(30) NOT NULL,
  `img_topping` text NOT NULL,
  `type_topping` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `topping`
--

INSERT INTO `topping` (`id_topping`, `name_topping`, `img_topping`, `type_topping`) VALUES
(1, 'M&M\'s', 'images/constructor/toppings/m&m.svg', 'sucré'),
(2, 'Cheddar', 'images/constructor/crudites/cheddar.svg', 'salé'),
(3, 'Motif Étoile', 'images/constructor/toppings/motif étoile.svg', 'sucré'),
(4, 'Motif Cœur', 'images/constructor/toppings/motif coeur.svg', 'sucré'),
(5, 'Motif Point', 'images/constructor/toppings/motif point.svg', 'sucré'),
(6, 'Paillettes', 'images/constructor/toppings/paillette.svg', 'sucré'),
(7, 'Kinder Bueno', 'images/constructor/toppings/kinder bueno.svg', 'sucré'),
(8, 'Oreo', 'images/constructor/toppings/oreo.svg', 'sucré'),
(9, 'KitKat', 'images/constructor/toppings/kitkat.svg', 'sucré'),
(10, 'Spéculos', 'images/constructor/toppings/spéculos.svg', 'sucré'),
(11, 'Bacon', 'images/constructor/crudites/bacon.svg', 'salé'),
(12, 'Oignons Frits', 'images/constructor/crudites/oignon frit.svg', 'salé'),
(13, 'Salade', 'images/constructor/crudites/salade.svg', 'salé'),
(15, 'Parmesan', 'images/constructor/crudites/parmesan.svg', 'salé'),
(17, 'Cornichon', 'images/constructor/crudites/cornichon.svg', 'salé'),
(18, 'Origan', 'images/constructor/crudites/origan.svg', 'salé'),
(19, 'Persil', 'images/constructor/crudites/persil.svg', 'salé'),
(21, 'Champignon', 'images/constructor/crudites/champignon.svg', 'salé'),
(22, 'Doritos', 'images/constructor/crudites/doritos.svg', 'salé'),
(24, 'Clémentine', 'images/constructor/toppings/clémentine.svg', 'sucré'),
(25, 'Coriande', 'images/constructor/crudites/coriande.svg', 'salé'),
(26, 'Oeuf', 'images/constructor/crudites/oeuf.svg', 'salé');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `login` varchar(30) NOT NULL,
  `mdp` varchar(90) NOT NULL,
  `photo` text NOT NULL,
  `description` text NOT NULL,
  `admin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id_user`, `login`, `mdp`, `photo`, `description`, `admin`) VALUES
(2, 'Adam', '$2y$10$2slyKoViqJnp8dbAsa5UfOqcIwKayvXqtYLOoETz3TwfpkfkY5CKG', 'images/pp/afe8c2c182b20652ad288f42.jpg', 'J\'adore les donuts et tout abonnez vous !', 0),
(3, 'Lohan', '$2y$10$KZRzqWWuVTVkIvNLtEFAJuJZ8ssKz6Hyvw6JuV1BsAxqVC1cJnTqS', 'images/pp/cc5dc6aaf38ff13796563e46.jpg', '', 1),
(4, 'MXS_MMS', '$2y$10$KVogGBlsdOvwNW6PsFMaZeFvDaRIva1cifciaD0jSWLfKbPiB.aEK', 'images/pp/92235e754a0796a4ae838de1.png', 'spécialisé dans les compos de détraqué (ig : max_ens8)', 0),
(5, 'paul', '$2y$10$CifqOor2SiO4YeYgt80B3ecm.Phy88tpC1Pr90192f2C1Rrlhx4Yq', 'images/pp/58e23ee3312ab50f2de7aabd.jpg', '', 0),
(15, 'Fatima', '$2y$10$3/rmRvct13WZyfEw29h6BuJSORvFWs4QqBjwQjrL8h/WqXE4xdc2y', 'images/pp/6fc470099fd0d563f8cf75f2.webp', '', 0),
(16, 'Ines', '$2y$10$bu0NZPcDAygrVK2tBzsnsulBfLiLOck6ZVfqe.JZhEDvzzyQSY7l2', 'images/pp/83131364396a7fdf3942b5ec.jpg', '', 0),
(17, 'Ninja_smbr31', '$2y$10$8JkKGNKAedFU.KdZIqC6C.knkO4EpZLlqqCkSUTYfq1X7fNSk.vL.', '', '', 0),
(18, 'Laurent', '$2y$10$y9J0.IF7/B26o3WfRSXx6uDLYoRn8LfmaTzN.O4dYNza1Im8ADXxO', 'images/pp/77aaf52887cc718dbf957211.jpg', 'Je suis moi', 0),
(19, 'manudo', '$2y$10$EHxsYch6gs1lr1ftyVGn/uY44J9i1II9a0tOZCuBP0mf39oR1u6su', '', '', 0),
(20, 'Aurélie', '$2y$10$yGQDlWbc6lZgp4YNUlec7u3XsIIMTBXNgCoCZI0ky018oMR4VRZ/e', 'a', 'a', 0),
(21, 'max', '$2y$10$5rloazIItULR7GjbgijJjOlLhTJZK/f/2v3ftLsKObB0ZQw57hhrW', '', '', 0),
(22, 'timothy@mail.com', '$2y$10$PqDefJ3n3DOf62rnU65x2OQlzLT.wTnx1xSgbqUOR5L6kkIj4AAfy', 'images/pp/64a3157e15b33ef130fb97fb.jpg', '', 0),
(23, 'kanye', '$2y$10$Fe9N8zjcJCtfXToe9dDE8O/8c0DCw12DLriJYpm.WG2dnTN3JAgmO', '', '', 0),
(24, 'admin', '$2y$10$GwfjwTUf//b9TV.Qj88LH.8rEAZvdeG589vEFK4BNbDG47dNKDw3G', 'p', 'p', 1),
(25, 'n', '$2y$10$g6GgV7/9H9MhOEMdS0EbzOhOKAB/gvX/IFlTKLoA0q4KgKvIefFlC', '', '', 0),
(26, 'sdm', '$2y$10$YLL7mp5yU2mFP475S6DN1ex5fn0s2zquR2QqO/bLnFWgtpqF5bqVW', '', '', 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `beignets`
--
ALTER TABLE `beignets`
  ADD PRIMARY KEY (`id_beignet`);

--
-- Index pour la table `commentaires`
--
ALTER TABLE `commentaires`
  ADD PRIMARY KEY (`id_commentaire`),
  ADD KEY `id_auteur` (`id_auteur`),
  ADD KEY `id_donuts_concerné` (`id_donuts_concerné`);

--
-- Index pour la table `compositions_donuts`
--
ALTER TABLE `compositions_donuts`
  ADD PRIMARY KEY (`id_composition`),
  ADD KEY `fk_beignet` (`id_beignet`),
  ADD KEY `fk_createur` (`id_createur`),
  ADD KEY `fk_fourrage` (`id_fourrage`),
  ADD KEY `fk_glacage` (`id_glacage`),
  ADD KEY `fk_topping` (`id_topping`);

--
-- Index pour la table `fk_follow`
--
ALTER TABLE `fk_follow`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user_qui_follow` (`id_user_qui_follow`),
  ADD KEY `id_user_suivit` (`id_user_suivit`);

--
-- Index pour la table `fk_like`
--
ALTER TABLE `fk_like`
  ADD PRIMARY KEY (`id_like`),
  ADD KEY `fk_compo1` (`id_compositions_donuts`),
  ADD KEY `fk_users` (`id_users`);

--
-- Index pour la table `fk_like_base`
--
ALTER TABLE `fk_like_base`
  ADD PRIMARY KEY (`id_like`),
  ADD KEY `id_donuts_de_base` (`id_donuts_de_base`),
  ADD KEY `id_users` (`id_users`),
  ADD KEY `idx_base` (`id_donuts_de_base`,`id_users`);

--
-- Index pour la table `fk_panier`
--
ALTER TABLE `fk_panier`
  ADD PRIMARY KEY (`id_fk_panier`),
  ADD KEY `fk_compo` (`id_compositions_donuts`),
  ADD KEY `fk_users1` (`id_users`),
  ADD KEY `idx_fkpanier_source_user` (`source_table`,`source_id`,`id_users`);

--
-- Index pour la table `fourrages`
--
ALTER TABLE `fourrages`
  ADD PRIMARY KEY (`id_fourrage`);

--
-- Index pour la table `glacages`
--
ALTER TABLE `glacages`
  ADD PRIMARY KEY (`id_glacage`);

--
-- Index pour la table `nos_donuts`
--
ALTER TABLE `nos_donuts`
  ADD PRIMARY KEY (`id_donuts_de_base`);

--
-- Index pour la table `topping`
--
ALTER TABLE `topping`
  ADD PRIMARY KEY (`id_topping`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `beignets`
--
ALTER TABLE `beignets`
  MODIFY `id_beignet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `commentaires`
--
ALTER TABLE `commentaires`
  MODIFY `id_commentaire` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT pour la table `compositions_donuts`
--
ALTER TABLE `compositions_donuts`
  MODIFY `id_composition` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT pour la table `fk_follow`
--
ALTER TABLE `fk_follow`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT pour la table `fk_like`
--
ALTER TABLE `fk_like`
  MODIFY `id_like` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=171;

--
-- AUTO_INCREMENT pour la table `fk_like_base`
--
ALTER TABLE `fk_like_base`
  MODIFY `id_like` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT pour la table `fk_panier`
--
ALTER TABLE `fk_panier`
  MODIFY `id_fk_panier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT pour la table `fourrages`
--
ALTER TABLE `fourrages`
  MODIFY `id_fourrage` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT pour la table `glacages`
--
ALTER TABLE `glacages`
  MODIFY `id_glacage` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT pour la table `nos_donuts`
--
ALTER TABLE `nos_donuts`
  MODIFY `id_donuts_de_base` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT pour la table `topping`
--
ALTER TABLE `topping`
  MODIFY `id_topping` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commentaires`
--
ALTER TABLE `commentaires`
  ADD CONSTRAINT `commentaires_ibfk_1` FOREIGN KEY (`id_auteur`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `commentaires_ibfk_2` FOREIGN KEY (`id_donuts_concerné`) REFERENCES `compositions_donuts` (`id_composition`);

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
