-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.18-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             9.2.0.4947
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping database structure for ecommers
CREATE DATABASE IF NOT EXISTS `ecommers` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `ecommers`;


-- Dumping structure for table ecommers.tbl_mst_courier
CREATE TABLE IF NOT EXISTS `tbl_mst_courier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `path_img` varchar(255) DEFAULT NULL,
  `parent` int(11) NOT NULL DEFAULT 0,
  `type` tinyint(4) NOT NULL DEFAULT 1,
  `orderby` tinyint(4) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` tinyint(4) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table ecommers.tbl_mst_courier: ~10 rows (approximately)
DELETE FROM `tbl_mst_courier`;
/*!40000 ALTER TABLE `tbl_mst_courier` DISABLE KEYS */;
INSERT INTO `tbl_mst_courier` (`id`, `code`, `name`, `path_img`, `parent`, `type`, `orderby`, `created_at`, `created_by`) VALUES
	(1, 'jne', 'JNE', NULL, 0, 1, NULL, '2021-04-03 18:07:52', 1),
	(2, 'tiki', 'TIKI', NULL, 0, 1, NULL, '2021-04-03 18:09:11', 1),
	(3, 'pos', 'Pos Indonesia', NULL, 0, 1, NULL, '2021-04-03 18:09:31', 1),
	(4, 'jne-reg', 'Reguler', NULL, 1, 1, NULL, '2021-04-03 18:09:55', 1),
	(5, 'jne-yes', 'YES', NULL, 1, 1, NULL, '2021-04-03 18:10:23', 1),
	(6, 'jne-oke', 'OKE', NULL, 1, 1, NULL, '2021-04-03 18:10:48', 1),
	(7, 'jne-truck', 'Trucking', NULL, 1, 1, NULL, '2021-04-03 18:11:18', 1),
	(8, 'tiki-reg', 'Reguler', NULL, 2, 1, NULL, '2021-04-03 18:12:04', 1),
	(9, 'tiki-ons', 'One Night Service', NULL, 2, 1, NULL, '2021-04-03 18:12:38', 1),
	(10, 'pos-kilat', 'Pos Kilat Khusus', NULL, 2, 1, NULL, '2021-04-03 18:13:30', 1);
/*!40000 ALTER TABLE `tbl_mst_courier` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

CREATE TABLE `tbl_shipping` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`id_mst_courier` INT(11) NOT NULL,
	`created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
)
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB;

ALTER TABLE `tbl_addresses`
	ALTER `building_name` DROP DEFAULT;
ALTER TABLE `tbl_addresses`
	CHANGE COLUMN `building_name` `building_name` TEXT NULL AFTER `pincode`,
	CHANGE COLUMN `road_area_colony` `road_area_colony` TEXT NULL AFTER `building_name`,
	CHANGE COLUMN `landmark` `landmark` VARCHAR(100) NULL AFTER `country`;
	
	