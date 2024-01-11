-- MariaDB dump 10.19  Distrib 10.9.6-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: asaed4
-- ------------------------------------------------------
-- Server version	10.9.6-MariaDB-1:10.9.6+maria~deb10

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Cart`
--

DROP TABLE IF EXISTS `Cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Cart` (
  `id_res` int(11) DEFAULT NULL,
  `id_material` int(11) DEFAULT NULL,
  `date_return` datetime DEFAULT NULL,
  `date_end` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_begin` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `id_room` int(11) DEFAULT NULL,
  KEY `id_res` (`id_res`),
  KEY `id_material` (`id_material`),
  KEY `id_room` (`id_room`),
  CONSTRAINT `Cart_ibfk_1` FOREIGN KEY (`id_res`) REFERENCES `Reservation` (`id_res`),
  CONSTRAINT `Cart_ibfk_2` FOREIGN KEY (`id_material`) REFERENCES `Material` (`id_material`),
  CONSTRAINT `Cart_ibfk_3` FOREIGN KEY (`id_room`) REFERENCES `Room` (`id_room`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Cart`
--

LOCK TABLES `Cart` WRITE;
/*!40000 ALTER TABLE `Cart` DISABLE KEYS */;
INSERT INTO `Cart` VALUES
(13,4,NULL,'2023-06-22 10:00:00','2023-06-20 15:45:00',NULL),
(13,3,NULL,'2023-06-22 10:00:00','2023-06-20 15:45:00',NULL),
(14,4,NULL,'2023-06-22 10:15:00','2023-06-19 10:15:00',NULL),
(14,2,NULL,'2023-06-22 10:15:00','2023-06-19 10:15:00',NULL),
(15,4,NULL,'2023-06-24 10:15:00','2023-06-22 10:15:00',NULL),
(15,3,NULL,'2023-06-24 10:15:00','2023-06-22 10:15:00',NULL),
(16,NULL,NULL,'2023-06-19 10:15:00','2023-06-19 12:15:00',1),
(25,2,NULL,'2023-06-24 00:00:00','2023-06-22 00:00:00',NULL),
(26,2,NULL,'2023-06-28 00:00:00','2023-06-26 00:00:00',NULL),
(26,4,NULL,'2023-06-28 00:00:00','2023-06-26 00:00:00',NULL),
(26,3,NULL,'2023-06-28 00:00:00','2023-06-26 00:00:00',NULL),
(26,NULL,NULL,'2023-06-28 00:00:00','2023-06-26 00:00:00',1),
(46,16,NULL,'2023-06-24 10:00:00','2023-06-22 15:45:00',NULL),
(55,16,NULL,'2023-06-25 00:00:00','2023-06-24 00:00:00',NULL),
(56,16,NULL,'2023-07-13 00:00:00','2023-07-12 00:00:00',NULL),
(57,4,NULL,'2023-06-25 00:00:00','2023-06-24 00:00:00',NULL),
(58,3,NULL,'2023-06-24 10:00:00','2023-06-23 15:45:00',NULL),
(59,3,NULL,'2023-06-25 00:00:00','2023-06-24 00:00:00',NULL),
(59,22,NULL,'2023-06-25 00:00:00','2023-06-24 00:00:00',NULL),
(59,21,NULL,'2023-06-25 00:00:00','2023-06-24 00:00:00',NULL),
(59,18,NULL,'2023-06-25 00:00:00','2023-06-24 00:00:00',NULL),
(61,3,NULL,'2023-06-29 00:00:00','2023-06-28 00:00:00',NULL),
(62,4,NULL,'2023-06-30 00:00:00','2023-06-28 00:00:00',NULL),
(62,16,NULL,'2023-06-30 00:00:00','2023-06-28 00:00:00',NULL),
(62,20,NULL,'2023-06-30 00:00:00','2023-06-28 00:00:00',NULL),
(73,3,NULL,'2023-06-23 10:00:00','2023-06-23 08:00:00',NULL),
(73,18,NULL,'2023-06-23 10:00:00','2023-06-23 08:00:00',NULL),
(74,4,NULL,'2023-06-24 15:45:00','2023-06-24 13:45:00',NULL),
(74,18,NULL,'2023-06-24 15:45:00','2023-06-24 13:45:00',NULL),
(75,16,NULL,'2023-06-23 10:00:00','2023-06-23 08:00:00',NULL),
(76,19,NULL,'2023-06-25 10:00:00','2023-06-23 15:45:00',NULL),
(76,23,NULL,'2023-06-25 10:00:00','2023-06-23 15:45:00',NULL),
(78,4,NULL,'2023-07-01 00:00:00','2023-06-30 00:00:00',NULL),
(79,16,NULL,'2023-07-01 00:00:00','2023-06-30 00:00:00',NULL);
/*!40000 ALTER TABLE `Cart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Class`
--

DROP TABLE IF EXISTS `Class`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Class` (
  `id_class` int(11) NOT NULL AUTO_INCREMENT,
  `name_class` varchar(20) NOT NULL,
  PRIMARY KEY (`id_class`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Class`
--

LOCK TABLES `Class` WRITE;
/*!40000 ALTER TABLE `Class` DISABLE KEYS */;
INSERT INTO `Class` VALUES
(1,'S1A1'),
(2,'S1A2'),
(3,'S1B1'),
(4,'S1B2'),
(5,'S1C1'),
(6,'S1C2'),
(7,'S1D1'),
(8,'S1D2'),
(9,'S2A1'),
(10,'S2A2'),
(11,'S2B1'),
(12,'S2B2'),
(13,'S2C1'),
(14,'S2C2'),
(15,'S2D1'),
(16,'S2D2'),
(17,'S3Alt1'),
(18,'S3Alt2'),
(19,'S3B1'),
(20,'S3B2'),
(21,'S3C1'),
(22,'S3C2'),
(23,'S3D1'),
(24,'S3D2'),
(25,'S4CreaA1'),
(26,'S4CreaA2'),
(27,'S4CreaB1'),
(28,'S4CreaB2'),
(29,'S4DevA1'),
(30,'S4DevA2'),
(31,'S4StratA1'),
(32,'S4StratA2'),
(65,'S3'),
(66,'S3B'),
(67,'S4D'),
(68,'S4D2'),
(69,'S4Dév'),
(70,'S4Dév2'),
(71,'S4FI'),
(72,'S3Alt'),
(73,'S4ALT'),
(74,'S4D1'),
(75,'S4Dév1'),
(76,'S1'),
(77,'S1D'),
(78,'S2'),
(79,'S2D');
/*!40000 ALTER TABLE `Class` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Material`
--

DROP TABLE IF EXISTS `Material`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Material` (
  `id_material` int(11) NOT NULL AUTO_INCREMENT,
  `id_model` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `description_material` text DEFAULT NULL,
  `date_add` date NOT NULL,
  `id_room` int(11) DEFAULT NULL,
  `obsolete` tinyint(4) NOT NULL,
  `in_repair` tinyint(4) NOT NULL,
  PRIMARY KEY (`id_material`),
  KEY `id_model` (`id_model`),
  KEY `id_room` (`id_room`),
  CONSTRAINT `Material_ibfk_1` FOREIGN KEY (`id_model`) REFERENCES `Model` (`id_model`),
  CONSTRAINT `Material_ibfk_2` FOREIGN KEY (`id_room`) REFERENCES `Room` (`id_room`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Material`
--

LOCK TABLES `Material` WRITE;
/*!40000 ALTER TABLE `Material` DISABLE KEYS */;
INSERT INTO `Material` VALUES
(2,2,1,'Panasonic HC-V770','2023-05-23',1,0,0),
(3,3,1,'XA20','2023-05-23',NULL,0,0),
(4,4,1,'5D Mark III','2023-05-23',NULL,0,0),
(16,7,1,NULL,'2023-06-20',NULL,0,0),
(18,7,2,NULL,'2023-06-20',NULL,0,0),
(19,2,2,NULL,'2000-10-20',NULL,0,0),
(20,2,3,NULL,'2000-10-20',NULL,0,0),
(21,2,4,NULL,'2023-06-20',NULL,0,0),
(22,11,1,NULL,'2023-10-25',NULL,0,0),
(23,9,1,'bonjour','2023-06-20',NULL,0,0),
(25,3,9,'c\'est la desc','2023-06-07',NULL,0,0),
(26,2,5,NULL,'2023-06-22',NULL,0,0),
(27,2,6,NULL,'2023-06-22',NULL,0,0),
(28,2,7,NULL,'2023-06-22',NULL,0,0),
(29,2,8,NULL,'2023-06-22',NULL,0,0);
/*!40000 ALTER TABLE `Material` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Member`
--

DROP TABLE IF EXISTS `Member`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Member` (
  `id_res` int(11) NOT NULL,
  `login` varchar(255) NOT NULL,
  KEY `id_res` (`id_res`),
  KEY `login` (`login`),
  CONSTRAINT `Member_ibfk_1` FOREIGN KEY (`id_res`) REFERENCES `Reservation` (`id_res`),
  CONSTRAINT `Member_ibfk_2` FOREIGN KEY (`login`) REFERENCES `User` (`login`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Member`
--

LOCK TABLES `Member` WRITE;
/*!40000 ALTER TABLE `Member` DISABLE KEYS */;
INSERT INTO `Member` VALUES
(46,'lamandep'),
(46,'romando'),
(55,'lamandep'),
(55,'simonlis'),
(56,'lamandep'),
(57,'test'),
(58,'renauldy'),
(58,'simonlis'),
(61,'romanda'),
(61,'lamande'),
(59,'lamandep'),
(59,'renauldy'),
(62,'roboa'),
(62,'lamande'),
(78,'lamandep'),
(78,'roboa'),
(78,'lamandep'),
(78,'lamandep'),
(79,'renauldy'),
(79,'simonlis'),
(79,'lamandep');
/*!40000 ALTER TABLE `Member` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Model`
--

DROP TABLE IF EXISTS `Model`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Model` (
  `id_model` int(11) NOT NULL AUTO_INCREMENT,
  `name_model` varchar(255) NOT NULL,
  `id_type` int(11) NOT NULL,
  `description` text NOT NULL,
  `image` longblob DEFAULT NULL,
  PRIMARY KEY (`id_model`),
  KEY `id_type` (`id_type`),
  CONSTRAINT `Model_ibfk_1` FOREIGN KEY (`id_type`) REFERENCES `Type_material` (`id_type`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Model`
--

LOCK TABLES `Model` WRITE;
/*!40000 ALTER TABLE `Model` DISABLE KEYS */;
INSERT INTO `Model` VALUES
(2,'Caméra Panasonic',1,'caméra de type caméscope',NULL),
(3,'Canon Camescope',1,'camera de type camescope',NULL),
(4,'Canon reflex',1,'tuto fonctionnement',NULL),
(5,'Lumix G80',1,'tuto fonctionnement',NULL),
(6,'Metabones bague d\'adaptation',1,'tuto fonctionnement',NULL),
(7,'Objectif Canon 24mm f2.8',1,'tuto fonctionnement',NULL),
(8,'Objectif Canon 50mm f1.8',1,'tuto fonctionnement',NULL),
(9,'Trépied Vidéo Manfrotto',2,'tuto fonctionnement',NULL),
(10,'Kit Mandarine',3,'tuto fonctionnement',NULL),
(11,'kit son',4,'info d\'utilisation',NULL);
/*!40000 ALTER TABLE `Model` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Problem`
--

DROP TABLE IF EXISTS `Problem`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Problem` (
  `id_problem` int(11) NOT NULL AUTO_INCREMENT,
  `id_material` int(11) DEFAULT NULL,
  `id_res` int(11) DEFAULT NULL,
  `login` varchar(255) DEFAULT NULL,
  `problem_desc` text NOT NULL,
  PRIMARY KEY (`id_problem`),
  KEY `id_material` (`id_material`),
  KEY `id_res` (`id_res`),
  KEY `login` (`login`),
  CONSTRAINT `Problem_ibfk_1` FOREIGN KEY (`id_material`) REFERENCES `Material` (`id_material`),
  CONSTRAINT `Problem_ibfk_2` FOREIGN KEY (`id_res`) REFERENCES `Reservation` (`id_res`),
  CONSTRAINT `Problem_ibfk_3` FOREIGN KEY (`login`) REFERENCES `User` (`login`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Problem`
--

LOCK TABLES `Problem` WRITE;
/*!40000 ALTER TABLE `Problem` DISABLE KEYS */;
INSERT INTO `Problem` VALUES
(4,4,NULL,'romand','agzzegzeg'),
(8,NULL,13,'romanda','fdfgygefrjgbjergbujbvdjger'),
(9,NULL,13,'romanda','Alexis le plus gentil garçon !'),
(10,NULL,14,NULL,'ines est vraiment la meilleur de tout les gens de la terre (et autre planètes) <3'),
(11,NULL,NULL,'roboa','Axelle est une gentille fille mais elle oublie trop souvent son cartable'),
(12,NULL,15,'roboa','Axelle est une gentille fille mais elle oublie trop souvent son cartable'),
(14,3,NULL,NULL,'yep'),
(15,3,NULL,NULL,'encore'),
(16,NULL,NULL,'renauldy','il est NUL'),
(17,NULL,NULL,'renauldy','en fAIT NON\n'),
(18,NULL,NULL,'renauldy','an + ile é BG');
/*!40000 ALTER TABLE `Problem` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Reservation`
--

DROP TABLE IF EXISTS `Reservation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Reservation` (
  `id_res` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `id_status` int(11) NOT NULL,
  `res_tp` tinyint(4) NOT NULL,
  PRIMARY KEY (`id_res`),
  KEY `login` (`login`),
  KEY `id_status` (`id_status`),
  CONSTRAINT `Reservation_ibfk_1` FOREIGN KEY (`login`) REFERENCES `User` (`login`),
  CONSTRAINT `Reservation_ibfk_2` FOREIGN KEY (`id_status`) REFERENCES `Status_res` (`id_status`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Reservation`
--

LOCK TABLES `Reservation` WRITE;
/*!40000 ALTER TABLE `Reservation` DISABLE KEYS */;
INSERT INTO `Reservation` VALUES
(13,'romanda',6,0),
(14,'hafraoui',4,0),
(15,'roboa',3,0),
(16,'simonlis',3,0),
(25,'lamandep',3,0),
(26,'romanda',4,0),
(46,'lamandep',3,0),
(55,'lamandep',2,0),
(56,'lamandep',4,0),
(57,'lamandep',4,0),
(58,'hafraoui',2,0),
(59,'hafraoui',2,0),
(61,'lamandep',2,0),
(62,'romanda',2,0),
(73,'lamandep',2,1),
(74,'lamandep',2,1),
(75,'lamandep',2,1),
(76,'simonlis',1,0),
(77,'lamandep',2,0),
(78,'lamandep',2,0),
(79,'lamandep',2,0);
/*!40000 ALTER TABLE `Reservation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Reservation_tp`
--

DROP TABLE IF EXISTS `Reservation_tp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Reservation_tp` (
  `id_res` int(11) NOT NULL,
  `id_class` int(11) NOT NULL,
  `login` varchar(255) DEFAULT NULL,
  KEY `id_res` (`id_res`),
  KEY `id_class` (`id_class`),
  KEY `login` (`login`),
  CONSTRAINT `Reservation_tp_ibfk_1` FOREIGN KEY (`id_res`) REFERENCES `Reservation` (`id_res`),
  CONSTRAINT `Reservation_tp_ibfk_2` FOREIGN KEY (`id_class`) REFERENCES `Class` (`id_class`),
  CONSTRAINT `Reservation_tp_ibfk_3` FOREIGN KEY (`login`) REFERENCES `User` (`login`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Reservation_tp`
--

LOCK TABLES `Reservation_tp` WRITE;
/*!40000 ALTER TABLE `Reservation_tp` DISABLE KEYS */;
INSERT INTO `Reservation_tp` VALUES
(73,10,NULL),
(74,9,NULL),
(75,11,NULL);
/*!40000 ALTER TABLE `Reservation_tp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Role`
--

DROP TABLE IF EXISTS `Role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Role` (
  `id_role` int(11) NOT NULL AUTO_INCREMENT,
  `name_role` varchar(15) NOT NULL,
  PRIMARY KEY (`id_role`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Role`
--

LOCK TABLES `Role` WRITE;
/*!40000 ALTER TABLE `Role` DISABLE KEYS */;
INSERT INTO `Role` VALUES
(1,'super-admin'),
(2,'admin'),
(3,'enseignant'),
(4,'étudiant');
/*!40000 ALTER TABLE `Role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Room`
--

DROP TABLE IF EXISTS `Room`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Room` (
  `id_room` int(11) NOT NULL AUTO_INCREMENT,
  `name_room` varchar(255) NOT NULL,
  PRIMARY KEY (`id_room`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Room`
--

LOCK TABLES `Room` WRITE;
/*!40000 ALTER TABLE `Room` DISABLE KEYS */;
INSERT INTO `Room` VALUES
(1,'studio 604');
/*!40000 ALTER TABLE `Room` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Status_res`
--

DROP TABLE IF EXISTS `Status_res`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Status_res` (
  `id_status` int(11) NOT NULL AUTO_INCREMENT,
  `name_status` varchar(255) NOT NULL,
  PRIMARY KEY (`id_status`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Status_res`
--

LOCK TABLES `Status_res` WRITE;
/*!40000 ALTER TABLE `Status_res` DISABLE KEYS */;
INSERT INTO `Status_res` VALUES
(1,'wishlist'),
(2,'waiting'),
(3,'validated'),
(4,'given'),
(5,'reclaimed'),
(6,'refused');
/*!40000 ALTER TABLE `Status_res` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Type_material`
--

DROP TABLE IF EXISTS `Type_material`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Type_material` (
  `id_type` int(11) NOT NULL AUTO_INCREMENT,
  `name_type` varchar(255) NOT NULL,
  PRIMARY KEY (`id_type`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Type_material`
--

LOCK TABLES `Type_material` WRITE;
/*!40000 ALTER TABLE `Type_material` DISABLE KEYS */;
INSERT INTO `Type_material` VALUES
(1,'caméra'),
(2,'trépieds'),
(3,'lumière'),
(4,'son');
/*!40000 ALTER TABLE `Type_material` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `User`
--

DROP TABLE IF EXISTS `User`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `User` (
  `login` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `id_role` int(11) NOT NULL,
  PRIMARY KEY (`login`),
  KEY `id_role` (`id_role`),
  CONSTRAINT `User_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `Role` (`id_role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `User`
--

LOCK TABLES `User` WRITE;
/*!40000 ALTER TABLE `User` DISABLE KEYS */;
INSERT INTO `User` VALUES
('alexislamoule','alexis','jul','alexis@gmail.com',1),
('encoreuntest','nonon','ouioui','ouioui@etu-univ.grenoble-alpes.fr',1),
('hafraoui','Hafraoui','Ines','Ines.Hafraoui@etu.univ-grenoble-alpes.fr',4),
('lamande','pierre','lamande','pierre.lamande@etu.univ-grenoble-alpes.fr',2),
('lamandep','Lamandé','Pierre','Pierre.Lamande@etu.univ-grenoble-alpes.fr',4),
('renauldy','Renauld','Yohann','Yohann.Renauld@etu.univ-grenoble-alpes.fr',4),
('roboa','Robo','Axelle','Axelle.Robo@etu.univ-grenoble-alpes.fr',4),
('romand','alexis','romand','alexis.romand@etu.univ-grenoble-alpes.fr',3),
('romanda','Romand','Alexis','Alexis.Romand@etu.univ-grenoble-alpes.fr',1),
('romando','romand','alexis','alexis.romand@etu.univ-grenoble-alpes.fr',1),
('simonlis','Simon','Lise','Lise.Simon@etu.univ-grenoble-alpes.fr',1),
('test','testing','toust','tst.tist@toast.ts',1),
('test2','testing','toust','tst.tist@toast.ts',1),
('test3','testing','toust','tst.tist@toast.ts',1);
/*!40000 ALTER TABLE `User` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `User_Class`
--

DROP TABLE IF EXISTS `User_Class`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `User_Class` (
  `login` varchar(255) NOT NULL,
  `id_class` int(11) NOT NULL,
  KEY `login` (`login`),
  KEY `id_class` (`id_class`),
  CONSTRAINT `User_Class_ibfk_3` FOREIGN KEY (`login`) REFERENCES `User` (`login`) ON DELETE CASCADE,
  CONSTRAINT `User_Class_ibfk_4` FOREIGN KEY (`id_class`) REFERENCES `Class` (`id_class`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `User_Class`
--

LOCK TABLES `User_Class` WRITE;
/*!40000 ALTER TABLE `User_Class` DISABLE KEYS */;
INSERT INTO `User_Class` VALUES
('romando',3),
('romanda',65),
('romanda',66),
('romanda',19),
('romanda',67),
('romanda',68),
('romanda',69),
('romanda',70),
('romanda',71),
('encoreuntest',4),
('lamandep',65),
('lamandep',66),
('lamandep',19),
('lamandep',67),
('lamandep',68),
('lamandep',69),
('lamandep',70),
('lamandep',71),
('renauldy',72),
('renauldy',17),
('renauldy',73),
('renauldy',67),
('renauldy',74),
('renauldy',69),
('renauldy',75),
('hafraoui',65),
('hafraoui',66),
('hafraoui',20),
('hafraoui',67),
('hafraoui',68),
('hafraoui',69),
('hafraoui',70),
('hafraoui',71),
('roboa',76),
('roboa',77),
('roboa',8),
('roboa',78),
('roboa',79),
('roboa',16),
('simonlis',65),
('simonlis',66),
('simonlis',20),
('simonlis',67),
('simonlis',68),
('simonlis',69),
('simonlis',70),
('simonlis',71);
/*!40000 ALTER TABLE `User_Class` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-06-22 11:54:01
