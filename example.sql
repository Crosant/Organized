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
CREATE DATABASE IF NOT EXISTS `planer` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `planer`;


-- Exportiere Struktur von Tabelle planer.example_stundenplan
CREATE TABLE IF NOT EXISTS `example_stundenplan` (
  `Stunde` int(11) NOT NULL AUTO_INCREMENT,
  `Zeit` varchar(50) NOT NULL,
  `Montag` varchar(50) NOT NULL,
  `Dienstag` varchar(50) NOT NULL,
  `Mittwoch` varchar(50) NOT NULL,
  `Donnerstag` varchar(50) NOT NULL,
  `Freitag` varchar(50) NOT NULL,
  PRIMARY KEY (`Stunde`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Daten Export vom Benutzer nicht ausgewählt


-- Exportiere Struktur von Tabelle planer.guest_planer
CREATE TABLE IF NOT EXISTS `guest_planer` (
  `Tag` date DEFAULT NULL,
  `Zeit` varchar(50) DEFAULT NULL,
  `Inhalt` varchar(50) DEFAULT NULL,
  `Entfall` tinyint(4) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Daten Export vom Benutzer nicht ausgewählt
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
