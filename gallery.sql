-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           5.6.17 - MySQL Community Server (GPL)
-- Serveur OS:                   Win64
-- HeidiSQL Version:             8.0.0.4396
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping database structure for gallery
CREATE DATABASE IF NOT EXISTS `gallery` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_520_ci */;
USE `gallery`;


-- Dumping structure for table gallery.about
CREATE TABLE IF NOT EXISTS `about` (
  `id` int(11) NOT NULL,
  `content` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table gallery.comments
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `gallery` int(10) NOT NULL,
  `pics` int(10) NOT NULL,
  `author` varchar(50) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `comment` text NOT NULL,
  `ip` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_comments_pictures` (`gallery`),
  KEY `FK_comments_pictures_2` (`pics`),
  CONSTRAINT `FK_comments_pictures` FOREIGN KEY (`gallery`) REFERENCES `pictures` (`gallery`),
  CONSTRAINT `FK_comments_pictures_2` FOREIGN KEY (`pics`) REFERENCES `pictures` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table gallery.galleries
CREATE TABLE IF NOT EXISTS `galleries` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `folder` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `folder` (`folder`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table gallery.pictures
CREATE TABLE IF NOT EXISTS `pictures` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `gallery` int(10) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `info` text NOT NULL,
  `nbcomment` int(11) NOT NULL DEFAULT '0',
  `link` varchar(255) NOT NULL,
  `thumb` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `link` (`link`),
  KEY `FK__galleries` (`gallery`),
  CONSTRAINT `FK__galleries` FOREIGN KEY (`gallery`) REFERENCES `galleries` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
