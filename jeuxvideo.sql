-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 15 mars 2024 à 11:20
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `jeuxvideo`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `parent` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `nom`, `parent`) VALUES
(14, 'microsoft', 0),
(15, 'xbox', 14),
(16, 'xbox360', 14),
(17, 'nintendo', 0),
(18, 'wii', 17),
(19, 'switch', 17),
(20, 'gamecube', 17);

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

DROP TABLE IF EXISTS `clients`;
CREATE TABLE IF NOT EXISTS `clients` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` text,
  `email` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `mdp` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `clients`
--

INSERT INTO `clients` (`id`, `nom`, `email`, `mdp`) VALUES
(1, 'Serge Weber', 'serge@gmail.com', '$2y$10$dCxiaOskeK/jpIZb/g1sk.h5A8QjmnfrfKLyw7zkDzk/3tN.VCtg6'),
(2, 'Akram', 'akram@gmail.com', '$2y$10$XsubXKMA.eiiRUMKTw0wje5OOovG/Za0QsaAOjMmbexEm1onrW29.');

-- --------------------------------------------------------

--
-- Structure de la table `panier`
--

DROP TABLE IF EXISTS `panier`;
CREATE TABLE IF NOT EXISTS `panier` (
  `id` int NOT NULL AUTO_INCREMENT,
  `produit_id` int DEFAULT NULL,
  `qte` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `panier`
--

INSERT INTO `panier` (`id`, `produit_id`, `qte`, `user_id`, `date`) VALUES
(3, 4, 1, 2, '2024-03-14'),
(2, 1, 1, 2, '2024-03-14');

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

DROP TABLE IF EXISTS `produits`;
CREATE TABLE IF NOT EXISTS `produits` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `img` varchar(255) NOT NULL,
  `qte` int NOT NULL,
  `categorie_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`id`, `nom`, `description`, `prix`, `img`, `qte`, `categorie_id`) VALUES
(1, 'Mariokart Delux', '8ème jeux vidéo de course et de combat motorisé produite par Nintendo,', '69.99', 'marioKartD.jpg', 9, 19),
(2, 'Inazuma Eleven Strickers', ' Jeu de foot, de rôle, également adaptée en manga et anime.', '14.99', 'InazumaEleven.jpg', 0, 18),
(3, 'Splinter Cell', 'Sam Fisher un agent spécial du groupe secret de la NSA', '49.99', 'splinterCell.jpg', 20, 15),
(4, 'Seuper Smash Bros Ultimate', ' Jeu vidéo de combat et de plates-formes', '49.99', 'smashUltim.jpg', 14, 19),
(5, 'Star Wars jedi outcast', 'Jeu de tir à la fois subjectif et objectif. ', '49.99', 'SatrWars.jpg', 25, 20),
(6, 'Fable 3', 'Pour devenir roi, le héros a besoin du support du peuple.', '69.99', 'fable.jpeg', 30, 16),
(7, 'Naruto Storm Generation', 'Jeu de la séries, manga, Naruto et Naruto Shippuden.', '49.99', 'naruto.jpg', 30, 16),
(8, 'Crysis 3', 'un jeu vidéo du genre FPS développé par Crytek ', '59.99', 'crysis.jpg', 25, 16),
(9, 'Super Mario Party', 'Le but du jeu est de gagner le plus de point que ses adversaires.', '59.99', 'marioParty.jpg', 20, 19),
(10, 'Mario Kart', 'Jeux vidéo de course et de combat motorisé produite par Nintendo.', '13.99', 'MarioKart.jpg', 10, 18),
(11, 'Super Smash Bros Brawl', 'Jeu vidéo de combat et de plates-formes sur wii', '24.99', 'SmashBrawl.jpg', 8, 18),
(12, 'Burnout Revenge', 'un jeu vidéo de course développé par Criterion Games', '29.99', 'Burnout.jpg', 15, 15),
(13, 'Star Wars Lego', 'jeu vidéo action, aventure se déroulant dans Star Wars', '14.99', 'LegoStarWars.jpg', 10, 20),
(14, 'Ghost Recon 2', 'Un jeu vidéo de tir tactique, le joueur doit neutraliser les ennemies', '59.99', 'ghostRecon.jpg', 50, 15),
(15, 'Sonic Gems Collection', 'Une compilation de jeux vidéo Sega et ce bon vieu Sonic', '10.99', 'sonic.jpg', 100, 20);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
