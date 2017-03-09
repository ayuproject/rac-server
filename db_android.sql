-- MySqlBackup.NET 2.0.9.2
-- Dump Time: 2017-03-08 15:33:23
-- --------------------------------------
-- Server version 5.7.13 MySQL Community Server (GPL)


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES latin1 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- 
-- Definition of tb_app
-- 

DROP TABLE IF EXISTS `tb_app`;
CREATE TABLE IF NOT EXISTS `tb_app` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(55) DEFAULT NULL,
  `description` text,
  `app` varchar(255) DEFAULT NULL,
  `pdf` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table tb_app
-- 

/*!40000 ALTER TABLE `tb_app` DISABLE KEYS */;

/*!40000 ALTER TABLE `tb_app` ENABLE KEYS */;

-- 
-- Definition of tb_client
-- 

DROP TABLE IF EXISTS `tb_client`;
CREATE TABLE IF NOT EXISTS `tb_client` (
  `email` varchar(45) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table tb_client
-- 

/*!40000 ALTER TABLE `tb_client` DISABLE KEYS */;

/*!40000 ALTER TABLE `tb_client` ENABLE KEYS */;

-- 
-- Definition of tb_rateapp
-- 

DROP TABLE IF EXISTS `tb_rateapp`;
CREATE TABLE IF NOT EXISTS `tb_rateapp` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email_client` varchar(45) DEFAULT NULL,
  `id_app` int(10) unsigned DEFAULT NULL,
  `rate` tinyint(4) DEFAULT NULL,
  `comment` text,
  PRIMARY KEY (`id`),
  KEY `id_app_idx` (`id_app`),
  KEY `femail_client_idx` (`email_client`),
  CONSTRAINT `femail_client` FOREIGN KEY (`email_client`) REFERENCES `tb_client` (`email`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fid_app` FOREIGN KEY (`id_app`) REFERENCES `tb_app` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table tb_rateapp
-- 

/*!40000 ALTER TABLE `tb_rateapp` DISABLE KEYS */;

/*!40000 ALTER TABLE `tb_rateapp` ENABLE KEYS */;

-- 
-- Definition of tb_users
-- 

DROP TABLE IF EXISTS `tb_users`;
CREATE TABLE IF NOT EXISTS `tb_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(10) DEFAULT NULL,
  `password` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table tb_users
-- 

/*!40000 ALTER TABLE `tb_users` DISABLE KEYS */;

/*!40000 ALTER TABLE `tb_users` ENABLE KEYS */;


/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;


-- Dump completed on 2017-03-08 15:33:23
-- Total time: 0:0:0:0:608 (d:h:m:s:ms)
