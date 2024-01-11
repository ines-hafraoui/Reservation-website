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
(3,2,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',NULL),
(3,3,NULL,'2023-05-31 00:00:00','2023-05-31 00:00:00',NULL),
(7,3,NULL,'2019-08-20 10:22:34','0000-00-00 00:00:00',NULL),
(7,2,'2019-08-24 10:22:34','2019-08-20 10:22:34','0000-00-00 00:00:00',NULL),
(7,4,'2019-08-20 10:22:34','2019-08-20 10:22:34','0000-00-00 00:00:00',NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
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
(71,'S4FI');
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Material`
--

LOCK TABLES `Material` WRITE;
/*!40000 ALTER TABLE `Material` DISABLE KEYS */;
INSERT INTO `Material` VALUES
(2,2,1,'Panasonic HC-V770','2023-05-23',NULL,0,0),
(3,3,1,'XA20','2023-05-23',NULL,1,0),
(4,4,1,'5D Mark III','2023-05-23',NULL,0,0);
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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Problem`
--

LOCK TABLES `Problem` WRITE;
/*!40000 ALTER TABLE `Problem` DISABLE KEYS */;
INSERT INTO `Problem` VALUES
(3,2,NULL,'hafraoui','afgzeg'),
(4,4,NULL,'romand','agzzegzeg');
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Reservation`
--

LOCK TABLES `Reservation` WRITE;
/*!40000 ALTER TABLE `Reservation` DISABLE KEYS */;
INSERT INTO `Reservation` VALUES
(3,'lamande',1,0),
(7,'hafraoui',3,0),
(8,'simonlis',1,0),
(10,'simonlis',1,1);
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
(10,4,NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Status_res`
--

LOCK TABLES `Status_res` WRITE;
/*!40000 ALTER TABLE `Status_res` DISABLE KEYS */;
INSERT INTO `Status_res` VALUES
(1,'wishlist'),
(2,'waiting'),
(3,'validated');
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
('alexislamoule','alexis','romand','alexis@gmail.com',1),
('encoreuntest','nonon','ouioui','ouioui@etu-univ.grenoble-alpes.fr',1),
('hafraoui','ines','hafraoui','ines.hafraoui@etu.univ-grenoble-alpes.fr',1),
('lamande','pierre','lamande','pierre.lamande@etu.univ-grenoble-alpes.fr',2),
('romand','alexis','romand','alexis.romand@etu.univ-grenoble-alpes.fr',3),
('romanda','Romand','Alexis','Alexis.Romand@etu.univ-grenoble-alpes.fr',4),
('romando','romand','alexis','alexis.romand@etu.univ-grenoble-alpes.fr',1),
('simonlis','lise','simon','lise.simon@etu.univ-grenoble-alpes.fr',4),
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
  CONSTRAINT `User_Class_ibfk_1` FOREIGN KEY (`login`) REFERENCES `User` (`login`),
  CONSTRAINT `User_Class_ibfk_2` FOREIGN KEY (`id_class`) REFERENCES `Class` (`id_class`)
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
('encoreuntest',4);
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

-- Dump completed on 2023-06-01 10:42:50
