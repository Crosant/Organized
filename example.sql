-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server Version:               5.6.19-log - MySQL Community Server (GPL)
-- Server Betriebssystem:        Win32
-- HeidiSQL Version:             8.3.0.4694
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Exportiere Datenbank Struktur für planer
DROP DATABASE IF EXISTS `planer`;
CREATE DATABASE IF NOT EXISTS `planer` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `planer`;


-- Exportiere Struktur von Tabelle planer.moe_planer
DROP TABLE IF EXISTS `moe_planer`;
CREATE TABLE IF NOT EXISTS `moe_planer` (
  `Tag` date DEFAULT NULL,
  `Zeit` varchar(50) DEFAULT NULL,
  `Inhalt` varchar(50) DEFAULT NULL,
  `Entfall` tinyint(4) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Exportiere Daten aus Tabelle planer.moe_planer: ~2 rows (ungefähr)
DELETE FROM `moe_planer`;
/*!40000 ALTER TABLE `moe_planer` DISABLE KEYS */;
INSERT INTO `moe_planer` (`Tag`, `Zeit`, `Inhalt`, `Entfall`) VALUES
	('2014-08-22', '17:30-18:30', 'Ferien!', 0),
	('2014-08-22', '18:30-19:30', 'Ferien!', 0),
	('2014-08-20', '17:30-18:30', 'Ferien!', 0),
	('2014-08-21', '00:00-24:00', 'Finish Phase1', 0);
/*!40000 ALTER TABLE `moe_planer` ENABLE KEYS */;


-- Exportiere Struktur von Tabelle planer.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL,
  `class` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Exportiere Daten aus Tabelle planer.users: ~0 rows (ungefähr)
DELETE FROM `users`;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `username`, `password`, `class`) VALUES
	(1, 'Moe', '098f6bcd4621d373cade4e832627b4f6', 'TGI');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
