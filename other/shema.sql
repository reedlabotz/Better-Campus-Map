# ************************************************************
# Sequel Pro SQL dump
# Version 3408
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: dcs-projects.cs.illinois.edu (MySQL 5.0.92-community)
# Database: labotz1_cs465
# Generation Time: 2011-11-09 16:53:30 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table building_infos
# ------------------------------------------------------------

DROP TABLE IF EXISTS `building_infos`;

CREATE TABLE `building_infos` (
  `building_id` int(11) unsigned NOT NULL,
  `type` varchar(2) default NULL,
  `x` int(11) default NULL,
  `y` int(11) default NULL,
  `interior` tinyint(1) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table building_names
# ------------------------------------------------------------

DROP TABLE IF EXISTS `building_names`;

CREATE TABLE `building_names` (
  `id` int(11) unsigned NOT NULL,
  `name` varchar(255) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table buildings
# ------------------------------------------------------------

DROP TABLE IF EXISTS `buildings`;

CREATE TABLE `buildings` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `address` text,
  `floors` varchar(255) default NULL,
  `x` int(11) default NULL,
  `y` int(11) default NULL,
  `width` int(11) default NULL,
  `height` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table map_elements
# ------------------------------------------------------------

DROP TABLE IF EXISTS `map_elements`;

CREATE TABLE `map_elements` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `type` varchar(2) default NULL,
  `x` int(11) default NULL,
  `y` int(11) default NULL,
  `name` varchar(255) default NULL,
  `details` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
