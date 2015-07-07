-- MySQL dump 10.13  Distrib 5.6.13, for osx10.7 (x86_64)
--
-- Host: localhost    Database: incentive_ads
-- ------------------------------------------------------
-- Server version	5.6.13

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
-- Table structure for table `partner_config`
--

DROP TABLE IF EXISTS `partner_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `partner_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `partner_name` char(255) DEFAULT NULL,
  `partner_id` int(11) DEFAULT NULL,
  `partner_username` char(255) DEFAULT NULL,
  `partner_apikey` char(255) DEFAULT NULL,
  `campaign_id` varchar(255) DEFAULT NULL,
  `banner_location` char(255) DEFAULT NULL,
  `cta_text` char(255) DEFAULT NULL,
  `api_base_url` char(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `partner_config`
--

LOCK TABLES `partner_config` WRITE;
/*!40000 ALTER TABLE `partner_config` DISABLE KEYS */;
INSERT INTO `partner_config` VALUES (1,'Fashion',6,'Aaron2','Aaron2',NULL,'https://flashfotoapi.com/api/get/3689617','Get 20% Off Your Next Purchase!','http://dev.flashfotoapi.com/api/'),(2,'Lexus',12,'Aaron2','Aaron2','6020916282398','https://flashfotoapi.com/api/get/3689618','Earn $500 Cash Back With Any New Vehicle Purchase','http://dev.flashfotoapi.com/api/'),(3,'Fashion',33,'anna','N68NiThCGapPK0YCceYloq5Ua2jUdzQS',NULL,'https://flashfotoapi.com/api/get/3689617','Get 20% Off Your Next Purchase!','http://www.flashfotoapi.com/api/'),(4,'Lexus',32,'anna','N68NiThCGapPK0YCceYloq5Ua2jUdzQS','6022795555198','https://flashfotoapi.com/api/get/3689618','Earn $500 Cash Back With Any New Vehicle Purchase','http://www.flashfotoapi.com/api/'),(5,'Anheuser-Busch',35,'anna','N68NiThCGapPK0YCceYloq5Ua2jUdzQS',NULL,'https://flashfotoapi.com/api/get/3689616','Participate for a free drink coupon!','http://www.flashfotoapi.com/api/');
/*!40000 ALTER TABLE `partner_config` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-07-06 17:12:47
