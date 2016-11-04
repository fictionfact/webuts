-- MySQL dump 10.13  Distrib 5.7.12, for Win64 (x86_64)
--
-- Host: localhost    Database: webuts
-- ------------------------------------------------------
-- Server version	5.5.24

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comment` (
  `id_comment` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_post` int(10) unsigned NOT NULL,
  `username` varchar(45) NOT NULL,
  `comment` text NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id_comment`),
  KEY `FK_username` (`username`),
  CONSTRAINT `FK_username` FOREIGN KEY (`username`) REFERENCES `member` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comment`
--

LOCK TABLES `comment` WRITE;
/*!40000 ALTER TABLE `comment` DISABLE KEYS */;
INSERT INTO `comment` VALUES (6,8,'Yohanes','Wow!!','2016-11-04 08:51:01'),(7,8,'Yohanes','asdf;kljasdl;fjkal;sdfkjl;ajksdf;jaskdfj;lajksdfl;aksdjf;klasjdfl;kjasl;dfkjl;asdjkfl;asdjkfl;aksdfjl;asjkdfl;jasdl;fjkasl;dkfjl;asdfjkl;asdjfl;ajksdl;fjas;dfljkasl;dfkjl;asdfjl;','2016-11-04 15:10:00'),(8,7,'Yohanes','Nerd.','2016-11-04 11:36:07'),(9,9,'Yohanes','LOL','2016-11-04 11:46:43'),(10,9,'fictionfact26','wuttt','2016-11-04 12:53:51'),(11,11,'Yohanes','SHE\r\n\r\nIS\r\n\r\nSO\r\n\r\nPRETTY!','2016-11-04 13:21:14'),(12,13,'Yohanes','testas;aklsdjfl;aksdfjakl;jsdfl;ajksdf;klasjdfl;kajsdfkljaskl;dfj;alsjkdf;aklsjfl;ajksdfl;jkasl;dfkjal;skdfjl;asdfjl;akjdf;lajks;dfljkal;sjkdfl;aksdjfl;aksjdfl;ajks;dfljkal;sdkfj;alsjkdfl;aksjdf;lajksdl;fkjasl;dkfjal;sdkfjl;asdjkf;lajksdfasdf','2016-11-04 13:21:51'),(13,12,'fictionfact26','chill bro.\r\n\r\nchill.','2016-11-04 13:22:20');
/*!40000 ALTER TABLE `comment` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-11-04 22:02:26
