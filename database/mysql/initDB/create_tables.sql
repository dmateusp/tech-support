-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 28, 2016 at 12:14 PM
-- Server version: 5.5.50-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.19
USE `support-technique`;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `supporttechnique`
--

-- --------------------------------------------------------

--
-- Table structure for table `categorie`
--

CREATE TABLE IF NOT EXISTS `categorie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `departement`
--

CREATE TABLE IF NOT EXISTS `departement` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

--
-- Table structure for table `hotelitem`
--

CREATE TABLE IF NOT EXISTS `hotelitem` (
  `idhotelitem` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `imagesource` varchar(45) DEFAULT NULL,
  `idcreator` int(11) NOT NULL,
  `idcategorie` int(11) NOT NULL,
  PRIMARY KEY (`idhotelitem`),
  UNIQUE KEY `name_UNIQUE` (`name`),
  KEY `idcreator_fk_idx` (`idcreator`),
  KEY `idcategorie_fk_idx` (`idcategorie`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=68 ;

-- --------------------------------------------------------

--
-- Table structure for table `ligne`
--

CREATE TABLE IF NOT EXISTS `ligne` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;


-- --------------------------------------------------------

--
-- Table structure for table `salle`
--

CREATE TABLE IF NOT EXISTS `salle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=56 ;

-- --------------------------------------------------------

--
-- Table structure for table `ticketsupport`
--

CREATE TABLE IF NOT EXISTS `ticketsupport` (
  `idticketSupport` int(11) NOT NULL AUTO_INCREMENT,
  `statut` int(5) NOT NULL,
  `description` varchar(45) NOT NULL,
  `lieu` varchar(45) NOT NULL,
  `commentaire` varchar(250) DEFAULT NULL,
  `dateDemande` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `datePriseEnCharge` datetime DEFAULT NULL,
  `dateClotureTicket` datetime DEFAULT NULL,
  `debDateAttente` timestamp NULL DEFAULT NULL,
  `finDateAttente` timestamp NULL DEFAULT NULL,
  `idutilisateurDemande` int(11) DEFAULT NULL,
  `idtechnicien` int(11) DEFAULT NULL,
  `idhotelitem` int(11) DEFAULT NULL,
  PRIMARY KEY (`idticketSupport`),
  KEY `idutilisateurDemande` (`idutilisateurDemande`),
  KEY `idtechnicien` (`idtechnicien`),
  KEY `fk_idhotelitem` (`idhotelitem`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6034 ;

-- --------------------------------------------------------

--
-- Table structure for table `travailinterne`
--

CREATE TABLE IF NOT EXISTS `travailinterne` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idutilisateurDemande` int(11) NOT NULL,
  `idutilisateurModif` int(11) DEFAULT NULL,
  `idsalle` int(11) NOT NULL,
  `idligne` int(11) DEFAULT NULL,
  `nomClient` varchar(55) DEFAULT NULL,
  `description` varchar(500) NOT NULL,
  `dateDemande` datetime NOT NULL,
  `dateDebut` datetime NOT NULL,
  `dateFin` datetime NOT NULL,
  `dateModif` datetime DEFAULT NULL,
  `docsource` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idutilisateurDemande_fk_idx` (`idutilisateurDemande`),
  KEY `idligne_fk_idx` (`idligne`),
  KEY `idutilisateurModif_fk_idx` (`idutilisateurModif`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=579 ;

-- --------------------------------------------------------

--
-- Table structure for table `utilisateur`
--

CREATE TABLE IF NOT EXISTS `utilisateur` (
  `idutilisateur` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `initiale` varchar(45) DEFAULT NULL,
  `type` varchar(30) DEFAULT NULL,
  `iddepartement` int(11) DEFAULT NULL,
  PRIMARY KEY (`idutilisateur`),
  UNIQUE KEY `login_UNIQUE` (`login`),
  UNIQUE KEY `initiale_UNIQUE` (`initiale`),
  KEY `fk_iddepartement_idx` (`iddepartement`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=117 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `hotelitem`
--
ALTER TABLE `hotelitem`
  ADD CONSTRAINT `idcategorie_fk` FOREIGN KEY (`idcategorie`) REFERENCES `categorie` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `idcreator_fk` FOREIGN KEY (`idcreator`) REFERENCES `utilisateur` (`idutilisateur`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `ticketsupport`
--
ALTER TABLE `ticketsupport`
  ADD CONSTRAINT `fk_idhotelitem` FOREIGN KEY (`idhotelitem`) REFERENCES `hotelitem` (`idhotelitem`),
  ADD CONSTRAINT `ticketsupport_ibfk_1` FOREIGN KEY (`idutilisateurDemande`) REFERENCES `utilisateur` (`idutilisateur`),
  ADD CONSTRAINT `ticketsupport_ibfk_2` FOREIGN KEY (`idtechnicien`) REFERENCES `utilisateur` (`idutilisateur`);

--
-- Constraints for table `travailinterne`
--
ALTER TABLE `travailinterne`
  ADD CONSTRAINT `idligne_fk` FOREIGN KEY (`idligne`) REFERENCES `ligne` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `idsalle_fk` FOREIGN KEY (`idligne`) REFERENCES `ligne` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `idutilisateurDemande_fk` FOREIGN KEY (`idutilisateurDemande`) REFERENCES `utilisateur` (`idutilisateur`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `idutilisateurModif_fk` FOREIGN KEY (`idutilisateurModif`) REFERENCES `utilisateur` (`idutilisateur`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD CONSTRAINT `fk_iddepartement` FOREIGN KEY (`iddepartement`) REFERENCES `departement` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

INSERT INTO utilisateur (login,password,initiale,type)
VALUES ('admin',SHA1('helloworld'),'admin','A')
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
