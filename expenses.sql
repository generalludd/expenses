# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: localhost (MySQL 5.6.15)
# Database: cereb4_expenses
# Generation Time: 2013-12-30 02:11:03 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table bill
# ------------------------------------------------------------

DROP TABLE IF EXISTS `bill`;

CREATE TABLE `bill` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `b_year` int(4) NOT NULL,
  `b_month` int(2) NOT NULL,
  `b_due` float NOT NULL,
  `b_paid` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table expense
# ------------------------------------------------------------

DROP TABLE IF EXISTS `expense`;

CREATE TABLE `expense` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL COMMENT 'description',
  `amt` float NOT NULL,
  `mo` int(2) NOT NULL,
  `yr` int(4) NOT NULL,
  `dt` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table fee
# ------------------------------------------------------------

DROP TABLE IF EXISTS `fee`;

CREATE TABLE `fee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(25) NOT NULL,
  `amt` float NOT NULL,
  `mo` int(2) NOT NULL,
  `yr` int(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='General fees paid each month';



# Dump of table menu
# ------------------------------------------------------------

DROP TABLE IF EXISTS `menu`;

CREATE TABLE `menu` (
  `kMenu` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `rank` int(11) NOT NULL,
  PRIMARY KEY (`kMenu`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table menu_item
# ------------------------------------------------------------

DROP TABLE IF EXISTS `menu_item`;

CREATE TABLE `menu_item` (
  `kItem` int(11) NOT NULL AUTO_INCREMENT,
  `kMenu` int(11) NOT NULL COMMENT 'fk->menu',
  `label` text NOT NULL,
  `type` varchar(60) NOT NULL,
  `user_role` varchar(60) NOT NULL DEFAULT 'all',
  `href` varchar(255) DEFAULT NULL,
  `class` varchar(255) DEFAULT NULL,
  `id` varchar(60) DEFAULT NULL,
  `id_prefix` varchar(60) DEFAULT NULL,
  `enclosure` varchar(255) DEFAULT NULL,
  `rank` int(11) NOT NULL,
  PRIMARY KEY (`kItem`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table override
# ------------------------------------------------------------

DROP TABLE IF EXISTS `override`;

CREATE TABLE `override` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `type_id` varchar(255) NOT NULL,
  `mo` int(2) NOT NULL,
  `yr` int(4) NOT NULL,
  `amt` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table payment
# ------------------------------------------------------------

DROP TABLE IF EXISTS `payment`;

CREATE TABLE `payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `mo` int(11) NOT NULL,
  `yr` int(11) NOT NULL,
  `amt` double NOT NULL,
  `date_paid` date NOT NULL,
  `rec_modifier` int(11) NOT NULL,
  `rec_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table preference
# ------------------------------------------------------------

DROP TABLE IF EXISTS `preference`;

CREATE TABLE `preference` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT 'FK to user',
  `type` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table preference_type
# ------------------------------------------------------------

DROP TABLE IF EXISTS `preference_type`;

CREATE TABLE `preference_type` (
  `type` varchar(25) NOT NULL,
  `name` varchar(255) NOT NULL COMMENT 'human-readable name of the preference',
  `description` text NOT NULL,
  `options` varchar(40) NOT NULL,
  `format` varchar(26) NOT NULL,
  `sort_order` int(11) NOT NULL,
  PRIMARY KEY (`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(55) NOT NULL,
  `password` varchar(32) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `is_verified` tinyint(1) DEFAULT NULL,
  `reset_hash` varchar(32) NOT NULL COMMENT 'used for verifying password resets',
  `is_active` tinyint(1) NOT NULL,
  `role` enum('user','admin') NOT NULL,
  `start_date` date DEFAULT NULL COMMENT 'Date joined the household',
  `end_date` date DEFAULT NULL COMMENT 'Date left the household',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table user_sessions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_sessions`;

CREATE TABLE `user_sessions` (
  `session_id` varchar(32) NOT NULL,
  `ip_address` varchar(18) NOT NULL,
  `user_agent` varchar(120) DEFAULT NULL,
  `last_activity` int(11) NOT NULL,
  `user_data` text NOT NULL,
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table variable
# ------------------------------------------------------------

DROP TABLE IF EXISTS `variable`;

CREATE TABLE `variable` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class` varchar(25) NOT NULL,
  `name` varchar(55) NOT NULL,
  `value` varchar(55) NOT NULL,
  `type` enum('varchar','int') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


# INSERTION OF BASIC VALUES
# --------------------------------------------------------------
INSERT INTO `variable` (`id`, `class`, `name`, `value`, `type`)
VALUES
	(1, 'month', '1', 'January', 'varchar'),
	(2, 'month', '2', 'February', 'varchar'),
	(3, 'month', '3', 'March', 'varchar'),
	(4, 'month', '4', 'April', 'varchar'),
	(5, 'month', '5', 'May', 'varchar'),
	(6, 'month', '6', 'June', 'varchar'),
	(7, 'month', '7', 'July', 'varchar'),
	(8, 'month', '8', 'August', 'varchar'),
	(9, 'month', '9', 'September', 'varchar'),
	(10, 'month', '10', 'October', 'varchar'),
	(11, 'month', '11', 'November', 'varchar'),
	(12, 'month', '12', 'December', 'varchar');


INSERT INTO `menu` (`kMenu`, `name`, `rank`)
VALUES
	(2, 'User', 2);


INSERT INTO `menu_item` (`kItem`, `kMenu`, `label`, `type`, `user_role`, `href`, `class`, `id`, `id_prefix`, `enclosure`, `rank`)
VALUES
	(1, 2, 'Feedback', 'span', 'user', NULL, 'button create_feedback', NULL, NULL, NULL, 3),
	(2, 2, 'Preferences', 'a', 'all', 'preference/view', 'button', NULL, NULL, NULL, 2),
	(3, 2, 'User List', 'a', 'admin', 'index.php/user/show_all', 'button', NULL, NULL, NULL, 1),
	(6, 2, 'Log Out', 'a', 'all', 'index.php/user/logout', 'button', NULL, NULL, NULL, 4),
	(7, 2, 'Site Admin', 'a', 'all', 'menu', 'button', NULL, NULL, NULL, 3);



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
