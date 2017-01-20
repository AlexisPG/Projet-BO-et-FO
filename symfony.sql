-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Ven 20 Janvier 2017 à 17:05
-- Version du serveur: 5.5.53-0ubuntu0.14.04.1
-- Version de PHP: 5.5.9-1ubuntu4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `symfony`
--

-- --------------------------------------------------------

--
-- Structure de la table `app_user`
--

CREATE TABLE IF NOT EXISTS `app_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `token` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `birthday` date NOT NULL,
  `avatar` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_88BDF3E9F85E0677` (`username`),
  UNIQUE KEY `UNIQ_88BDF3E9E7927C74` (`email`),
  UNIQUE KEY `UNIQ_88BDF3E95F37A13B` (`token`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=45 ;

--
-- Contenu de la table `app_user`
--

INSERT INTO `app_user` (`id`, `username`, `password`, `email`, `is_active`, `token`, `birthday`, `avatar`) VALUES
(32, 'Alexis', '$2y$12$yYjI7l4DusSj5JoZ66LuG.3UZYNJYlRGxIFt350eVcTH1qAEBfSi.', 'alexis@alexis.com', 1, '9713006e72ae003248e18100dbbf7259', '0000-00-00', ''),
(33, 'User', '$2y$12$NpgAp5Eo2dfueSOmVcYV5eeys.UP4v3u3GMN2czl6iUIBUtEyDEgG', 'user@gmail.com', 0, '82bdb6979cd1ab882663981a64b0ec01', '0000-00-00', ''),
(35, 'steffen', '$2y$12$s9H9KOL0rKBuV4n0X4guaOxKKSigR4HXEh1.PscANJpEhy2U0LPUi', 'eazd@ezdez.com', 0, '5291470b6faf17b14f2ac72ae7137ad5', '0000-00-00', ''),
(36, 'Susu', '$2y$12$d/0q68o4/pJZynPoTSKcY.v17dTz.c9XVhU8b07l4faXFwMcgKhVS', 'susu@gmail.com', 0, 'c74b0d5da1f43d32126044291895a167', '2012-01-01', '/tmp/phpyKfsy0'),
(38, 'Cyril', '$2y$12$JVIWO8wliGkaEZ94Wfoy..ssvePxsYJ5T4Oj.nxw/6FYSZ14b2aBu', 'cyril@cyril.com', 1, '20329b75a530dae9f7df0d0d222bef7a', '2012-04-03', '/tmp/phpQJ104J'),
(39, 'rgg', '$2y$12$7jLMQvoKrqrHpsZcTvznx.q/SsJj4o1sjE2T8g5mrEAaZgBDySpYm', 'crgeyril@cyril.com', 1, 'd5f937ba6baa99b8541ebcea2fa222f9', '2012-04-03', '/tmp/php8AoaOd'),
(41, 'gregreg', '$2y$12$.2kBHBt5nORdxeYHLRgeDOcpaQkD46G.WHyNFTNFBEHq0jsEHAIjW', 'rezgezf@cyril.com', 1, '104898b52d10b2b42f11c8455331a6c0', '2012-04-03', '/tmp/phpcyxypC'),
(42, 'fezfez', '$2y$12$5.elp9Tl629NdBz5rLsLM.9eKJQ.uxFXydw.SLUgbWP2dRkOkS.Se', 'hgfghfghghf@cyril.com', 1, '865fd8231ba4e31c1ce38c61d2f49260', '2012-04-03', '/tmp/php49WBK9'),
(43, 'dvsvsv', '$2y$12$pql7O57pF5yly4GcwbwBmu17ACqVQsE9knv7z7V8fx5DTwL.BVa6q', 'jyt@cyril.com', 1, '6be9d8be21ac92c856c7da7636c4f7ab', '2012-04-03', '/tmp/phpQHx6YV'),
(44, 'rfef', '$2y$12$pJcUsdxToJzkxshaN0rej.GKi2kz5mhHWThlWpE.5n1YYxhrG.jQW', 'kuyky@cyril.com', 1, '38018085bf73a3eb0490c64b83acbd04', '2012-04-03', 'c5ee06af332ba572a5692c28f8986ce2.jpeg');

-- --------------------------------------------------------

--
-- Structure de la table `brand`
--

CREATE TABLE IF NOT EXISTS `brand` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=53 ;

--
-- Contenu de la table `brand`
--

INSERT INTO `brand` (`id`, `title`) VALUES
(13, 'Titre 1'),
(18, 'un nouveau titre'),
(19, 'dezdzd rvdezcv'),
(20, 'un nouveau titre'),
(21, 'un noutre'),
(22, 'un nouveau titre'),
(33, 'un nouveau titre'),
(34, 'un nouveau titre'),
(35, 'un nouveau titre'),
(36, 'un nouveau titre'),
(37, 'un nouveau titre'),
(38, 'un nouveau titre'),
(39, 'un nouveau titre'),
(40, 'un nouveau titre'),
(41, 'un nouveau titre'),
(42, 'un nouveau titre'),
(43, 'un nouveau titre'),
(44, 'un nouveau titre'),
(45, 'un nouveau titre'),
(46, 'un nouveau titre'),
(47, 'un nouveau titre');

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `position` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=59 ;

--
-- Contenu de la table `category`
--

INSERT INTO `category` (`id`, `title`, `description`, `position`, `active`) VALUES
(36, 'Jeans', 'Catégorie - 0', 9, 1),
(37, 'Shirts', 'Catégorie - 1', 57, 1),
(38, 'Jupes', 'Catégorie - 2', 61, 1),
(49, 'Pulls', 'Catégorie - 3', 38, 1),
(50, 'Accessoires', 'Catégorie - 4', 8, 1),
(56, 'Hello', 'It''s me you a kind of hello', 75, 0),
(57, 'fyhntntn', 'nfgnfgnfgnfgn', 71, 0),
(58, '<ul>\r\n	<li><strong>dczc / </strong><s><em>dedez</em></s><strong>dezd</strong></li>\r\n</ul>', 'Couais nnjd', 12, 1);

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `author` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `content` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_creation` datetime NOT NULL,
  `score` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9474526C4584665A` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titleFR` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `descriptionFR` longtext COLLATE utf8_unicode_ci NOT NULL,
  `price` double NOT NULL,
  `quantity` int(11) NOT NULL,
  `id_brand` int(11) NOT NULL,
  `date_creation` datetime NOT NULL,
  `date_edit` datetime NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `titleEN` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `descriptionEN` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D34A04ADF2D7B868` (`id_brand`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=15 ;

--
-- Contenu de la table `product`
--

INSERT INTO `product` (`id`, `titleFR`, `descriptionFR`, `price`, `quantity`, `id_brand`, `date_creation`, `date_edit`, `image`, `titleEN`, `descriptionEN`) VALUES
(1, 'produit en francais', 'Description en fr', 147, 275, 13, '2017-01-16 11:33:39', '2017-01-16 11:33:39', '0d54f860b02f1a3b233d799568fa51eb.jpeg', 'Title EN', 'Hello is it me ?Hello is it me ?Hello is it me ?Hello is it me ?Hello is it me ?Hello is it me ?Hello is it me ?Hello is it me ?'),
(2, 'uiluil', 'luiluilui', 3568, 386, 18, '2017-01-16 11:33:54', '2017-01-16 11:50:18', '3d35d8fb16100396c2682dcfe067d66c.jpeg', 'Hello is it me ? ezfez', 'Hello is it me ? zadazdazHello is it me ?Hello is it me ?'),
(3, 'hy;,yju,', ',hj,jh,jh,hj,hj', 2574, 254, 19, '2017-01-16 11:34:12', '2017-01-16 11:34:12', 'logo.png', 'Hello is me ?', 'Hello is it me ?ezffez'),
(4, ',yhju,yuj,', ';uiui;;;ui;ui;ui;ui', 147, 275, 39, '2017-01-16 11:34:27', '2017-01-16 11:50:33', 'ffe3e6102f1dc47265c130ea9ca4498c.png', '', ''),
(5, 'Lorem ipsum', 'rvfve vrvervevre rvfver vrverv evrervf vervrve rvevre ', 17, 83, 13, '2017-01-16 11:51:55', '2017-01-16 11:51:55', 'dd1c5dcf6c2d6b0daff096d37b0b5027.jpeg', '', ''),
(6, 'vezd a', 'dezdezrvfvervrvervevrervfvervrvervevre', 39, 98, 33, '2017-01-16 11:52:14', '2017-01-16 11:52:14', 'b7e10ed2eecb43baaa7d71eca8e15b5f.png', '', ''),
(7, 'iu_jè', 'rvfvervrvervevrervfvervrvervevre', 3968, 98, 33, '2017-01-16 11:52:39', '2017-01-16 11:52:39', 'ee5eef4c8d09fc3552c4efc140efb8f0.jpeg', '', ''),
(8, 'dezdvfe', 'rvfvervrvervevrervfvervrvervevre', 2587, 398, 22, '2017-01-16 11:52:53', '2017-01-16 11:52:53', '194249cffd9897c26f7dbd0128b7bb97.jpeg', '', ''),
(9, 'Salut', 'kclnzpcen eojc ezcj zec', 58, 936, 18, '2017-01-17 09:28:14', '2017-01-17 09:28:14', 'logo.png', '', ''),
(10, 'vds zrverv', 'kclnzpcen eojc ezcj zec kclnzpcen eojc ezcj zec kclnzpcen eojc ezcj zec', 58, 387, 13, '2017-01-17 09:28:36', '2017-01-17 09:28:36', 'c0b6e53fc44b4b0ad1c888be46aa0ceb.jpeg', '', ''),
(11, 'ezcf ezcfez', 'kclnzpcen eojc ezcj zec kclnzpcen eojc ezcj zec', 2525, 5635, 20, '2017-01-17 09:28:57', '2017-01-17 09:28:57', 'logo.png', '', ''),
(12, 'rtgt vtv', 'kclnzpcen eojc ezcj zec kclnzpcen eojc ezcj zec', 47, 39, 20, '2017-01-17 09:29:41', '2017-01-17 09:29:41', 'logo.png', '', ''),
(13, 'nbyrtn', 'kclnzpcen eojc ezcj zec kclnzpcen eojc ezcj zec', 369, 5852, 13, '2017-01-17 09:30:00', '2017-01-17 09:30:00', 'logo.png', '', ''),
(14, 'Piere fr', 'Salut', 147, 2754, 13, '2017-01-19 14:54:35', '2017-01-19 14:54:35', 'logo.png', 'Pirre EN', 'hello');

-- --------------------------------------------------------

--
-- Structure de la table `products_categories`
--

CREATE TABLE IF NOT EXISTS `products_categories` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`category_id`),
  KEY `IDX_E8ACBE764584665A` (`product_id`),
  KEY `IDX_E8ACBE7612469DE2` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `products_categories`
--

INSERT INTO `products_categories` (`product_id`, `category_id`) VALUES
(1, 36),
(2, 38),
(3, 36),
(3, 49),
(4, 36),
(4, 38),
(5, 36),
(6, 37),
(6, 49),
(7, 36),
(7, 49),
(8, 37),
(9, 37),
(9, 38),
(10, 36),
(10, 37),
(10, 50),
(11, 37),
(11, 38),
(11, 50),
(12, 36),
(12, 37),
(13, 37),
(13, 38),
(14, 36);

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_57698A6A5E237E06` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Contenu de la table `role`
--

INSERT INTO `role` (`id`, `name`) VALUES
(2, 'ROLE_ADMIN'),
(1, 'ROLE_USER');

-- --------------------------------------------------------

--
-- Structure de la table `users_roles`
--

CREATE TABLE IF NOT EXISTS `users_roles` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `IDX_51498A8EA76ED395` (`user_id`),
  KEY `IDX_51498A8ED60322AC` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `users_roles`
--

INSERT INTO `users_roles` (`user_id`, `role_id`) VALUES
(32, 2),
(33, 1),
(35, 1),
(36, 1),
(38, 1),
(39, 1),
(41, 1),
(42, 1),
(43, 1),
(44, 1);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `FK_9474526C4584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Contraintes pour la table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `FK_D34A04ADF2D7B868` FOREIGN KEY (`id_brand`) REFERENCES `brand` (`id`);

--
-- Contraintes pour la table `products_categories`
--
ALTER TABLE `products_categories`
  ADD CONSTRAINT `FK_E8ACBE7612469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_E8ACBE764584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `users_roles`
--
ALTER TABLE `users_roles`
  ADD CONSTRAINT `FK_51498A8EA76ED395` FOREIGN KEY (`user_id`) REFERENCES `app_user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_51498A8ED60322AC` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
