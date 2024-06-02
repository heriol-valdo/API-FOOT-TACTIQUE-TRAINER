-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour ecf_api
CREATE DATABASE IF NOT EXISTS `ecf_api` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `ecf_api`;

-- Listage de la structure de table ecf_api. player
CREATE TABLE IF NOT EXISTS `player` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `age` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table ecf_api.player : ~4 rows (environ)
INSERT INTO `player` (`id`, `lastname`, `firstname`, `email`, `age`, `telephone`, `adresse`) VALUES
	(1, 'valdo', 'heriol', 'valdo@gmail.com', '45', '0753868021', 'vichy'),
	(2, 'foot', 'foot', 'foot@gmail;com', '45', '0753868021', 'Vichy'),
	(3, 'foot1', 'foot1', 'foot1@gmail.com', '46', '0753868021', 'Paris'),
	(4, 'foot2', 'foot2', 'foot2@gmail.com', '47', '0753868021', 'Vichy');

-- Listage de la structure de table ecf_api. selection
CREATE TABLE IF NOT EXISTS `selection` (
  `id` int NOT NULL AUTO_INCREMENT,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `idjoueur` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table ecf_api.selection : ~2 rows (environ)
INSERT INTO `selection` (`id`, `date`, `nom`, `idjoueur`) VALUES
	(7, '12/12/2026', 'Cameroun', 1),
	(8, '12/12/2027', 'France', 1);

-- Listage de la structure de table ecf_api. statistique
CREATE TABLE IF NOT EXISTS `statistique` (
  `id` int NOT NULL AUTO_INCREMENT,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lieu` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `but` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jaune` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rouge` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `idjoueur` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table ecf_api.statistique : ~3 rows (environ)
INSERT INTO `statistique` (`id`, `date`, `lieu`, `but`, `jaune`, `rouge`, `idjoueur`) VALUES
	(5, '12/02/2025', 'Paris', '2', '2', '0', 4),
	(24, '12/12/2023', 'Vichy', '1', '1', '1', 1),
	(25, '12/12/2024', 'Douala', '2', '1', '1', 1),
	(26, '12/12/2025', 'Paris', '1', '1', '1', 1);

-- Listage de la structure de table ecf_api. trophe
CREATE TABLE IF NOT EXISTS `trophe` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `motif` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `idjoueur` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table ecf_api.trophe : ~2 rows (environ)
INSERT INTO `trophe` (`id`, `nom`, `motif`, `date`, `idjoueur`) VALUES
	(2, 'Ballon d\’or', 'Best Player', '12/08/2023', '1'),
	(9, 'Soulier d\’or', 'Buteur', '12/12/2024', '1');

-- Listage de la structure de table ecf_api. users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `lastname` varchar(250) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

-- Listage des données de la table ecf_api.users : 1 rows
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `email`, `password`, `lastname`, `firstname`) VALUES
	(1, 'valdo@gmail.com', '$2y$10$fJXitAe1V0mkBK1iPr4cB.zqvv1SCguB5IceII4WRXH4ySFOeCtoy', 'valdo', 'heriol');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
