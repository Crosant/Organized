-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server Version:               5.6.17-log - MySQL Community Server (GPL)
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- Exportiere Daten aus Tabelle planer.example_stundenplan: ~8 rows (ungefähr)
DELETE FROM `example_stundenplan`;
/*!40000 ALTER TABLE `example_stundenplan` DISABLE KEYS */;
INSERT INTO `example_stundenplan` (`Stunde`, `Zeit`, `Montag`, `Dienstag`, `Mittwoch`, `Donnerstag`, `Freitag`) VALUES
	(1, '7:50-8:35', 'Sport', 'Politik', 'Chemie', 'Mathe', 'Mathe'),
	(2, '8:40-9:25', 'Sport', 'Politik', 'Chemie', 'Mathe', 'Mathe'),
	(3, '9:40-10:25', 'Musik', 'Religion', 'Erdkunde', 'Deutsch', 'Französisch'),
	(4, '10:30-11:15', 'Musik', 'Religion', 'Erdkunde', 'Englisch', 'Französisch'),
	(5, '11:30-12:15', 'Biologie', 'Französisch', 'Physik', 'Kunst', 'Englisch'),
	(6, '12:20-13:05', 'Biologie', 'Französisch', 'Physik', 'Kunst', 'Englisch'),
	(7, '13:15-14:00', 'Pause', '-', 'Pause', '-', 'Pause'),
	(8, '14:05-14:50', 'Geschichte', '-', 'Deutsch', '-', 'Informatik'),
	(9, '14:50-15:35', 'Geschichte', '-', 'Deutsch', '-', 'Informatik');
/*!40000 ALTER TABLE `example_stundenplan` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
