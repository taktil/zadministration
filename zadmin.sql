-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mar 28 Octobre 2014 à 10:48
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `zadmin`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE IF NOT EXISTS `categorie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `categorie`
--

INSERT INTO `categorie` (`id`, `libelle`, `description`) VALUES
(1, 'Iphone', 'sdfsdf'),
(2, 'Ipad / mini ipad', ''),
(3, 'Autres mobiles', ''),
(4, 'Informatique', ''),
(5, 'Consoles de jeux', '');

-- --------------------------------------------------------

--
-- Structure de la table `newsletter`
--

CREATE TABLE IF NOT EXISTS `newsletter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `valide` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `page`
--

CREATE TABLE IF NOT EXISTS `page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `soustitre` text NOT NULL,
  `minidescription` text NOT NULL,
  `description` text NOT NULL,
  `description2` text NOT NULL,
  `url` varchar(255) NOT NULL,
  `meta` text NOT NULL,
  `titre_en` varchar(255) NOT NULL,
  `soustitre_en` text NOT NULL,
  `minidescription_en` text NOT NULL,
  `description_en` text NOT NULL,
  `description2_en` text NOT NULL,
  `url_en` varchar(255) NOT NULL,
  `meta_en` text NOT NULL,
  `visible` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `lien` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `page`
--

INSERT INTO `page` (`id`, `titre`, `soustitre`, `minidescription`, `description`, `description2`, `url`, `meta`, `titre_en`, `soustitre_en`, `minidescription_en`, `description_en`, `description2_en`, `url_en`, `meta_en`, `visible`, `image`, `lien`) VALUES
(1, 'Home', 'fsdfsdf', '', 'sdfsd', '', '', '', '', '', '', '', '', '', '', 1, '', '');

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE IF NOT EXISTS `produit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categorie_id` int(11) NOT NULL,
  `libelle` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `ordre` int(11) NOT NULL,
  `visible` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `categorie_id` (`categorie_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

--
-- Contenu de la table `produit`
--

INSERT INTO `produit` (`id`, `categorie_id`, `libelle`, `image`, `ordre`, `visible`) VALUES
(2, 1, 'Iphone 3g', 'iphone-3g.gif', 1, 1),
(3, 1, 'Iphone 3gs', 'iphone-3gs.gif', 2, 1),
(4, 1, 'Iphone 4', 'iphone-4.gif', 3, 1),
(5, 2, 'Mini ipad', 'mini-ipad.jpg', 1, 1),
(6, 2, 'Ipad 2', 'ipad2.jpg', 2, 1),
(7, 2, 'Ipad rentina', 'ipad-rentina.jpg', 3, 1),
(8, 3, 'Samsung', 'samsung2.jpg', 1, 1),
(9, 3, 'Sony ericson', 'sony-ericson2.jpg', 2, 1),
(10, 3, 'Htc ', 'htc-smart-phone2.jpg', 3, 1),
(11, 3, 'BlackBerry', 'blackberry2.jpg', 4, 1),
(12, 3, 'Nokia', 'nokia2.jpg', 5, 1),
(13, 3, 'Motorola', 'motorola2.jpg', 6, 1),
(14, 3, 'Lg', 'lg2.jpg', 7, 1),
(15, 3, 'Sagem', 'sagem2.jpg', 8, 1),
(23, 4, 'PC Portable', 'pc_portable.png', 1, 1),
(24, 4, 'PC Bureau', 'pc_bureau.png', 2, 1),
(26, 5, 'Playstation', 'playstation2.jpg', 1, 1),
(27, 5, 'Xbox', 'xbox2.jpg', 2, 1),
(28, 5, 'Nintendo', 'nintendo2.jpg', 3, 1);

-- --------------------------------------------------------

--
-- Structure de la table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `tel` varchar(255) NOT NULL,
  `fax` varchar(255) NOT NULL,
  `gsm` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `adresse` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `settings`
--

INSERT INTO `settings` (`id`, `name`, `url`, `description`, `tel`, `fax`, `gsm`, `email`, `adresse`) VALUES
(1, 'Zend Admin', 'http://www.zadmin.ma', '', '+33 00000000', '+33 00000000', '+33 00000000', 'contact@zadmin.ma', '');

-- --------------------------------------------------------

--
-- Structure de la table `social`
--

CREATE TABLE IF NOT EXISTS `social` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `visible` int(11) NOT NULL,
  `facebook` varchar(255) NOT NULL,
  `twitter` varchar(255) NOT NULL,
  `google` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `social`
--

INSERT INTO `social` (`id`, `visible`, `facebook`, `twitter`, `google`) VALUES
(1, 1, 'https://www.facebook.com/', 'https://www.twitter.com/', 'https://plus.google.com/');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL,
  `username` varchar(250) NOT NULL,
  `password` varchar(250) CHARACTER SET latin1 NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `date_creation`) VALUES
(1, 'zadmin', 'f865b53623b121fd34ee5426c792e5c33af8c227', '2014-10-28 09:47:48');

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `produit`
--
ALTER TABLE `produit`
  ADD CONSTRAINT `fk_categorie_produit` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
