CREATE DATABASE  IF NOT EXISTS `we_blog` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `we_blog`;
-- MySQL dump 10.13  Distrib 8.0.24, for macos11 (x86_64)
--
-- Host: 127.0.0.1    Database: we_blog
-- ------------------------------------------------------
-- Server version	8.0.23

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `blog_post`
--

DROP TABLE IF EXISTS `blog_post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `blog_post` (
  `id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `urlKey` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `text` longtext COLLATE utf8_unicode_ci NOT NULL,
  `author` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dateTime` int NOT NULL,
  `creator` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog_post`
--

LOCK TABLES `blog_post` WRITE;
/*!40000 ALTER TABLE `blog_post` DISABLE KEYS */;
INSERT INTO `blog_post` VALUES ('00345c70-dd16-11eb-a3dd-b864cdd6cb76','lorem-ipsum','Lorem ipsum ','Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.','Lorem ',1625437212,'agornung'),('41c911ba-dd0e-11eb-a3dd-b864cdd6cb76','erster-admin-beitrag','Erster Admin Beitrag','Administering Your Blog -\r\n\r\nGenerally, the daily tasks associated with administering your WordPress site are quick and easy to do, freeing you to concentrate on the content, editorials, and stories you want to share with the world, and allowing you to get back to other activities.\r\n\r\nHere is a quick look at the various activities involved in administering your WordPress site. Some of these may need to be done daily, while others can be done weekly, monthly, or less frequently. It depends upon your blogging activity level and the intent of your WordPress site.','AGornung',1625433886,'admin'),('99221574-dd0e-11eb-a3dd-b864cdd6cb76','this-long-awaited-technology-may-finally-change-the-world','This Long-Awaited Technology May Finally Change the World','Envision this: there is a technology currently undergoing testing that, when released to the public, will become a long-awaited revolution in energy. This new technology promises to be safer and more efficient than anything we have on the market now. It will affect that which we consider mundane — power tools, toys, laptops, smartphones — and that which we consider exceptional — medical devices, spacecraft, and the innovative new vehicle designs needed to wean us off of fossil fuels. We have known about this technology for centuries, yet until now we have only been able to take small steps towards its creation. Billions of dollars are pouring into research and billions more will be made once the technology has been perfected and released.\r\nThis description may sound a lot like that of fusion power. Yet it’s actually referring to the upcoming innovations in the realm of battery technology — specifically that of solid-state batteries. And while both fusion power and solid-state batteries have been labeled technologies of the future but never of today, advancements and investments in solid-state materials have increased tremendously over the years. Today not only are there many major companies and credible researchers involved, it seems we may finally start seeing these batteries released in just the next few years.\r\nWhat can we expect once this elusive, transformative technology is finally ready for mass production?','Ella Alderson',1625434033,'admin'),('cfb1b6b2-dd0e-11eb-a3dd-b864cdd6cb76','delete-this-post','Delete this Post','Try to Delete me without admin-rights.','Gornung',1625434124,'admin'),('d7f858ce-dd15-11eb-a3dd-b864cdd6cb76','ein-weiterer-blogpost','Ein weiterer Blogpost','Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.','Anonym',1625437145,'admin');
/*!40000 ALTER TABLE `blog_post` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-07-05  0:22:10
