-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Ven 21 Mars 2014 à 10:05
-- Version du serveur: 5.5.24-log
-- Version de PHP: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `domhome`
--

-- --------------------------------------------------------

--
-- Structure de la table `acces_appareils`
--

CREATE TABLE IF NOT EXISTS `acces_appareils` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idappareil` int(11) NOT NULL,
  `idcompte` int(10) NOT NULL,
  `acces` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=96 ;

--
-- Contenu de la table `acces_appareils`
--

INSERT INTO `acces_appareils` (`id`, `idappareil`, `idcompte`, `acces`) VALUES
(1, 1, 1, 1),
(2, 2, 1, 1),
(3, 3, 1, 1),
(4, 4, 1, 1),
(5, 5, 1, 1),
(6, 6, 1, 1),
(7, 7, 1, 1),
(8, 8, 1, 1),
(9, 9, 1, 1),
(10, 10, 1, 1),
(11, 11, 1, 1),
(12, 12, 1, 1),
(85, 1, 11, 0),
(86, 2, 11, 0),
(87, 3, 11, 1),
(88, 4, 11, 0),
(89, 5, 11, 1),
(90, 6, 11, 0),
(91, 7, 11, 1),
(92, 8, 11, 0),
(93, 9, 11, 0),
(94, 10, 11, 1),
(95, 11, 11, 0);

-- --------------------------------------------------------

--
-- Structure de la table `acces_groupes_standard`
--

CREATE TABLE IF NOT EXISTS `acces_groupes_standard` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `idgroupe` int(255) NOT NULL,
  `idcompte` int(255) NOT NULL,
  `Acces` int(255) NOT NULL,
  `Visible` int(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `acces_groupes_standard`
--

INSERT INTO `acces_groupes_standard` (`id`, `idgroupe`, `idcompte`, `Acces`, `Visible`) VALUES
(1, 11, 1, 1, 1),
(2, 11, 11, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `appareils`
--

CREATE TABLE IF NOT EXISTS `appareils` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `onoff` varchar(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Contenu de la table `appareils`
--

INSERT INTO `appareils` (`id`, `nom`, `onoff`) VALUES
(1, 'Lampe salon', '0'),
(2, 'Lampe cuisine', '1'),
(3, 'Lampe couloir', '0'),
(4, 'Lampe salle de bain', '0'),
(5, 'Lampe salle a manger', '0'),
(6, 'Lampe bureau', '1'),
(7, 'Lampe chambre fils', '1'),
(8, 'Lampe chambre parent', '1'),
(9, 'Lampe bibliotheque', '1'),
(10, 'Lampe mezzanine', '0'),
(11, 'Lampe escalier', '0'),
(12, 'Cafetière', '0'),
(13, 'Télévision', '0'),
(14, 'Volet roulant', '0'),
(15, 'Porte garage', '0'),
(16, 'Chargeur de pile', '0'),
(17, 'Alarme', '0'),
(18, 'Four', '0');

-- --------------------------------------------------------

--
-- Structure de la table `comptes`
--

CREATE TABLE IF NOT EXISTS `comptes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `usert` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Contenu de la table `comptes`
--

INSERT INTO `comptes` (`id`, `nom`, `mdp`, `usert`) VALUES
(1, 'parent', 'parent', 'admin'),
(2, 'standard', 'fgeucejzhxzjxoivhgvubczizucbvitrnrenczcuiceiuvvuveoevcd', ''),
(11, 'fils', 'fils', 'user');

-- --------------------------------------------------------

--
-- Structure de la table `groupes_comp`
--

CREATE TABLE IF NOT EXISTS `groupes_comp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idgroupe` int(255) NOT NULL,
  `idappareil` int(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=235 ;

--
-- Contenu de la table `groupes_comp`
--

INSERT INTO `groupes_comp` (`id`, `idgroupe`, `idappareil`) VALUES
(41, 5, 1),
(43, 7, 6),
(44, 7, 9),
(47, 9, 8),
(48, 10, 7),
(88, 6, 2),
(224, 5, 2),
(225, 3, 51),
(227, 3, 3),
(228, 3, 8),
(229, 3, 4),
(230, 3, 11),
(231, 3, 7),
(232, 11, 1),
(233, 11, 2),
(234, 11, 3);

-- --------------------------------------------------------

--
-- Structure de la table `groupes_nom`
--

CREATE TABLE IF NOT EXISTS `groupes_nom` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `idcompte` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Contenu de la table `groupes_nom`
--

INSERT INTO `groupes_nom` (`id`, `nom`, `idcompte`) VALUES
(3, 'Favoris', 1),
(5, 'Salon', 1),
(6, 'Salle de bain', 1),
(7, 'Bureau', 1),
(9, 'Chambre parent', 1),
(10, 'Chambre fille', 1),
(11, 'Appcontrolable', 2);

-- --------------------------------------------------------

--
-- Structure de la table `order_groupes`
--

CREATE TABLE IF NOT EXISTS `order_groupes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idgroupe` int(11) NOT NULL,
  `idcompte` int(11) NOT NULL,
  `rang` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

--
-- Contenu de la table `order_groupes`
--

INSERT INTO `order_groupes` (`id`, `idgroupe`, `idcompte`, `rang`) VALUES
(28, 3, 1, 1),
(30, 5, 1, 2),
(31, 6, 1, 3),
(32, 7, 1, 4),
(34, 9, 1, 5),
(35, 10, 1, 6),
(36, 11, 1, 7);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
