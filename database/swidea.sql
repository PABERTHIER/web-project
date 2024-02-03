-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  lun. 29 avr. 2019 à 12:02
-- Version du serveur :  5.7.24
-- Version de PHP :  7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `swidea`
--

-- --------------------------------------------------------

--
-- Structure de la table `manage`
--

DROP TABLE IF EXISTS `manage`;
CREATE TABLE IF NOT EXISTS `manage` (
  `ref_user` int(11) NOT NULL,
  `ref_project` int(11) NOT NULL,
  PRIMARY KEY (`ref_user`,`ref_project`),
  KEY `ref_user` (`ref_user`),
  KEY `ref_project` (`ref_project`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `project`
--

DROP TABLE IF EXISTS `project`;
CREATE TABLE IF NOT EXISTS `project` (
  `id_ref` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(20) NOT NULL,
  `Date_Début` date DEFAULT NULL,
  `Nombre_taches` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_ref`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `project`
--

INSERT INTO `project` (`id_ref`, `Nom`, `Date_Début`, `Nombre_taches`) VALUES
(2, 'Web Project', '2019-04-28', 1);

--
-- Déclencheurs `project`
--
DROP TRIGGER IF EXISTS `Delet_Project`;
DELIMITER $$
CREATE TRIGGER `Delet_Project` BEFORE DELETE ON `project` FOR EACH ROW DELETE FROM manage
WHERE ref_project IN (SELECT id_ref FROM project)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `subtask`
--

DROP TABLE IF EXISTS `subtask`;
CREATE TABLE IF NOT EXISTS `subtask` (
  `id_ref` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(20) NOT NULL,
  `Contenue` text NOT NULL,
  `Importance` int(11) NOT NULL DEFAULT '0',
  `Durée` int(11) DEFAULT NULL,
  `ref_task` int(11) NOT NULL,
  PRIMARY KEY (`id_ref`),
  KEY `Task` (`ref_task`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `task`
--

DROP TABLE IF EXISTS `task`;
CREATE TABLE IF NOT EXISTS `task` (
  `id_ref` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(20) NOT NULL,
  `Contenue` text NOT NULL,
  `Durée` int(11) DEFAULT NULL,
  `Importance` int(11) DEFAULT '0',
  `Vote` int(11) NOT NULL DEFAULT '0',
  `ref_projet` int(11) NOT NULL,
  `Nombre_taches` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_ref`),
  KEY `ref_projet` (`ref_projet`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Déclencheurs `task`
--
DROP TRIGGER IF EXISTS `Decrease_nbTask`;
DELIMITER $$
CREATE TRIGGER `Decrease_nbTask` AFTER DELETE ON `task` FOR EACH ROW UPDATE project
SET Nombre_taches = Nombre_taches-1
WHERE id_ref IN (SELECT ref_projet FROM task)
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `Delete_Task`;
DELIMITER $$
CREATE TRIGGER `Delete_Task` BEFORE DELETE ON `task` FOR EACH ROW DELETE FROM subtask
WHERE ref_task IN (SELECT id_ref FROM task)
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `Increase_nbTask`;
DELIMITER $$
CREATE TRIGGER `Increase_nbTask` AFTER INSERT ON `task` FOR EACH ROW UPDATE project
SET Nombre_taches = Nombre_taches+1
WHERE id_ref IN (SELECT ref_projet FROM task)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(15) NOT NULL,
  `Prenom` varchar(15) NOT NULL,
  `Date_Naissance` date NOT NULL,
  `Mail` varchar(40) NOT NULL,
  `Login` varchar(15) NOT NULL,
  `Password` varchar(15) NOT NULL,
  `Admin` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='Table des utilisateurs';

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id_user`, `Nom`, `Prenom`, `Date_Naissance`, `Mail`, `Login`, `Password`, `Admin`) VALUES
(1, 'PIPERAUD', 'Alexandre', '1997-01-31', 'apiperaud@gmail.com', 'login', 'password', 1),
(2, 'BERTHIER', 'Pierre-Antoine', '2019-04-26', 'pa.berthier15@gmail.com', 'root', 'root', 1),
(3, 'RAYER', 'Florian', '2019-04-26', 'florianrayer@hotmail.fr', 'admin', 'admin', 1),
(4, 'Lambda', 'Lambda', '2019-04-28', 'none', 'none', 'none', 0);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `manage`
--
ALTER TABLE `manage`
  ADD CONSTRAINT `Project` FOREIGN KEY (`ref_project`) REFERENCES `project` (`id_ref`),
  ADD CONSTRAINT `User` FOREIGN KEY (`ref_user`) REFERENCES `user` (`id_user`);

--
-- Contraintes pour la table `subtask`
--
ALTER TABLE `subtask`
  ADD CONSTRAINT `Task` FOREIGN KEY (`ref_task`) REFERENCES `task` (`id_ref`);

--
-- Contraintes pour la table `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `Project2` FOREIGN KEY (`ref_projet`) REFERENCES `project` (`id_ref`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
