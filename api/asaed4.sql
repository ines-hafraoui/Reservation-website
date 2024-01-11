-- Adminer 4.8.1 MySQL 10.9.6-MariaDB-1:10.9.6+maria~deb10 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `Cart`;
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

INSERT INTO `Cart` (`id_res`, `id_material`, `date_return`, `date_end`, `date_begin`, `id_room`) VALUES
(3,	2,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00',	NULL),
(3,	3,	NULL,	'2023-05-31 00:00:00',	'2023-05-31 00:00:00',	NULL);

DROP TABLE IF EXISTS `Class`;
CREATE TABLE `Class` (
  `id_class` int(11) NOT NULL AUTO_INCREMENT,
  `name_class` varchar(20) NOT NULL,
  PRIMARY KEY (`id_class`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `Class` (`id_class`, `name_class`) VALUES
(1,	'S1A1'),
(2,	'S1A2'),
(3,	'S1B1'),
(4,	'S1B2'),
(5,	'S1C1'),
(6,	'S1C2'),
(7,	'S1D1'),
(8,	'S1D2'),
(9,	'S2A1'),
(10,	'S2A2'),
(11,	'S2B1'),
(12,	'S2B2'),
(13,	'S2C1'),
(14,	'S2C2'),
(15,	'S2D1'),
(16,	'S2D2'),
(17,	'S3Alt1'),
(18,	'S3Alt2'),
(19,	'S3B1'),
(20,	'S3B2'),
(21,	'S3C1'),
(22,	'S3C2'),
(23,	'S3D1'),
(24,	'S3D2'),
(25,	'S4CreaA1'),
(26,	'S4CreaA2'),
(27,	'S4CreaB1'),
(28,	'S4CreaB2'),
(29,	'S4DevA1'),
(30,	'S4DevA2'),
(31,	'S4StratA1'),
(32,	'S4StratA2'),
(65,	'S3'),
(66,	'S3B'),
(67,	'S4D'),
(68,	'S4D2'),
(69,	'S4Dév'),
(70,	'S4Dév2'),
(71,	'S4FI');

DROP TABLE IF EXISTS `Material`;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `Material` (`id_material`, `id_model`, `number`, `description_material`, `date_add`, `id_room`, `obsolete`, `in_repair`) VALUES
(2,	2,	1,	'Panasonic HC-V770',	'2023-05-23',	NULL,	0,	0),
(3,	3,	1,	'XA20',	'2023-05-23',	NULL,	1,	0),
(4,	4,	1,	'5D Mark III',	'2023-05-23',	NULL,	0,	0);

DROP TABLE IF EXISTS `Member`;
CREATE TABLE `Member` (
  `id_res` int(11) NOT NULL,
  `login` varchar(255) NOT NULL,
  KEY `id_res` (`id_res`),
  KEY `login` (`login`),
  CONSTRAINT `Member_ibfk_1` FOREIGN KEY (`id_res`) REFERENCES `Reservation` (`id_res`),
  CONSTRAINT `Member_ibfk_2` FOREIGN KEY (`login`) REFERENCES `User` (`login`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `Model`;
CREATE TABLE `Model` (
  `id_model` int(11) NOT NULL AUTO_INCREMENT,
  `name_model` varchar(255) NOT NULL,
  `id_type` int(11) NOT NULL,
  `description` text NOT NULL,
  `image` longblob DEFAULT NULL,
  PRIMARY KEY (`id_model`),
  KEY `id_type` (`id_type`),
  CONSTRAINT `Model_ibfk_1` FOREIGN KEY (`id_type`) REFERENCES `Type_material` (`id_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `Model` (`id_model`, `name_model`, `id_type`, `description`, `image`) VALUES
(2,	'Caméra Panasonic',	1,	'caméra de type caméscope',	NULL),
(3,	'Canon Camescope',	1,	'camera de type camescope',	NULL),
(4,	'Canon reflex',	1,	'tuto fonctionnement',	NULL),
(5,	'Lumix G80',	1,	'tuto fonctionnement',	NULL),
(6,	'Metabones bague d\'adaptation',	1,	'tuto fonctionnement',	NULL),
(7,	'Objectif Canon 24mm f2.8',	1,	'tuto fonctionnement',	NULL),
(8,	'Objectif Canon 50mm f1.8',	1,	'tuto fonctionnement',	NULL),
(9,	'Trépied Vidéo Manfrotto',	2,	'tuto fonctionnement',	NULL),
(10,	'Kit Mandarine',	3,	'tuto fonctionnement',	NULL),
(11,	'kit son',	4,	'info d\'utilisation',	NULL);

DROP TABLE IF EXISTS `Problem`;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `Problem` (`id_problem`, `id_material`, `id_res`, `login`, `problem_desc`) VALUES
(3,	2,	8,	'hafraoui',	'retardp'),
(4,	4,	NULL,	'romand',	'agzzegzeg'),
(5,	NULL,	NULL,	'simonlis',	'A rendu en retard'),
(6,	NULL,	NULL,	'simonlis',	'A rendu en retard'),
(7,	NULL,	NULL,	'simonlis',	'A rendu en retard');

DROP TABLE IF EXISTS `Reservation`;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `Reservation` (`id_res`, `login`, `id_status`, `res_tp`) VALUES
(3,	'lamande',	1,	0),
(8,	'simonlis',	1,	0),
(10,	'simonlis',	1,	1),
(11,	'hafraoui',	1,	0),
(12,	'hafraoui',	1,	0);

DROP TABLE IF EXISTS `Reservation_tp`;
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

INSERT INTO `Reservation_tp` (`id_res`, `id_class`, `login`) VALUES
(10,	4,	NULL);

DROP TABLE IF EXISTS `Role`;
CREATE TABLE `Role` (
  `id_role` int(11) NOT NULL AUTO_INCREMENT,
  `name_role` varchar(15) NOT NULL,
  PRIMARY KEY (`id_role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `Role` (`id_role`, `name_role`) VALUES
(1,	'super-admin'),
(2,	'admin'),
(3,	'enseignant'),
(4,	'étudiant');

DROP TABLE IF EXISTS `Room`;
CREATE TABLE `Room` (
  `id_room` int(11) NOT NULL AUTO_INCREMENT,
  `name_room` varchar(255) NOT NULL,
  PRIMARY KEY (`id_room`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `Room` (`id_room`, `name_room`) VALUES
(1,	'studio 604');

DROP TABLE IF EXISTS `Status_res`;
CREATE TABLE `Status_res` (
  `id_status` int(11) NOT NULL AUTO_INCREMENT,
  `name_status` varchar(255) NOT NULL,
  PRIMARY KEY (`id_status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `Status_res` (`id_status`, `name_status`) VALUES
(1,	'wishlist'),
(2,	'waiting'),
(3,	'validated');

DROP TABLE IF EXISTS `Type_material`;
CREATE TABLE `Type_material` (
  `id_type` int(11) NOT NULL AUTO_INCREMENT,
  `name_type` varchar(255) NOT NULL,
  PRIMARY KEY (`id_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `Type_material` (`id_type`, `name_type`) VALUES
(1,	'caméra'),
(2,	'trépieds'),
(3,	'lumière'),
(4,	'son');

DROP TABLE IF EXISTS `User`;
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

INSERT INTO `User` (`login`, `first_name`, `name`, `email`, `id_role`) VALUES
('alexislamoule',	'alexis',	'jul',	'alexis@gmail.com',	1),
('encoreuntest',	'nonon',	'ouioui',	'ouioui@etu-univ.grenoble-alpes.fr',	1),
('hafraoui',	'ines',	'hafraoui',	'ines.hafraoui@etu.univ-grenoble-alpes.fr',	1),
('lamande',	'pierre',	'lamande',	'pierre.lamande@etu.univ-grenoble-alpes.fr',	2),
('lamandep',	'Lamandé',	'Pierre',	'Pierre.Lamande@etu.univ-grenoble-alpes.fr',	4),
('romand',	'alexis',	'romand',	'alexis.romand@etu.univ-grenoble-alpes.fr',	3),
('romanda',	'Romand',	'Alexis',	'Alexis.Romand@etu.univ-grenoble-alpes.fr',	4),
('romando',	'romand',	'alexis',	'alexis.romand@etu.univ-grenoble-alpes.fr',	1),
('simonlis',	'lise',	'simon',	'lise.simon@etu.univ-grenoble-alpes.fr',	4),
('test',	'testing',	'toust',	'tst.tist@toast.ts',	1),
('test2',	'testing',	'toust',	'tst.tist@toast.ts',	1),
('test3',	'testing',	'toust',	'tst.tist@toast.ts',	1);

DROP TABLE IF EXISTS `User_Class`;
CREATE TABLE `User_Class` (
  `login` varchar(255) NOT NULL,
  `id_class` int(11) NOT NULL,
  KEY `login` (`login`),
  KEY `id_class` (`id_class`),
  CONSTRAINT `User_Class_ibfk_3` FOREIGN KEY (`login`) REFERENCES `User` (`login`) ON DELETE CASCADE,
  CONSTRAINT `User_Class_ibfk_4` FOREIGN KEY (`id_class`) REFERENCES `Class` (`id_class`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `User_Class` (`login`, `id_class`) VALUES
('romando',	3),
('romanda',	65),
('romanda',	66),
('romanda',	19),
('romanda',	67),
('romanda',	68),
('romanda',	69),
('romanda',	70),
('romanda',	71),
('encoreuntest',	4),
('lamandep',	65),
('lamandep',	66),
('lamandep',	19),
('lamandep',	67),
('lamandep',	68),
('lamandep',	69),
('lamandep',	70),
('lamandep',	71);

-- 2023-06-01 13:50:45
