-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Sam 08 Février 2014 à 17:35
-- Version du serveur: 5.5.24-log
-- Version de PHP: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `dev`
--

-- --------------------------------------------------------

--
-- Structure de la table `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `key` varchar(255) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `config`
--

INSERT INTO `config` (`key`, `value`) VALUES
('rank_mbr', '1'),
('rank_adm', '9'),
('rank_modo', '5'),
('maintenance', '0');

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `int_id` int(11) NOT NULL AUTO_INCREMENT,
  `id` varchar(6) NOT NULL,
  `sender` int(11) NOT NULL,
  `recipient` int(11) NOT NULL,
  `content` text NOT NULL,
  `timestamp` bigint(20) NOT NULL,
  PRIMARY KEY (`int_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=67 ;

-- --------------------------------------------------------

--
-- Structure de la table `pre_inscriptions`
--

CREATE TABLE IF NOT EXISTS `pre_inscriptions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `utilisateur` tinyint(1) NOT NULL,
  `videaste` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=557 ;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(40) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pass` varchar(40) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `background` text NOT NULL,
  `subscribers` int(11) NOT NULL,
  `subscriptions` text NOT NULL,
  `reg_timestamp` bigint(20) NOT NULL,
  `reg_ip` varchar(15) NOT NULL,
  `actual_ip` varchar(15) NOT NULL,
  `rank` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=185 ;

-- --------------------------------------------------------

--
-- Structure de la table `users_sessions`
--

CREATE TABLE IF NOT EXISTS `users_sessions` (
  `user_id` int(11) NOT NULL,
  `session_id` varchar(32) NOT NULL,
  `expiration` bigint(20) NOT NULL,
  `remember` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `videos`
--

CREATE TABLE IF NOT EXISTS `videos` (
  `id` varchar(6) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `tags` text NOT NULL,
  `tumbnail` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `views` bigint(20) NOT NULL,
  `likes` int(11) NOT NULL,
  `dislikes` int(11) NOT NULL,
  `timestamp` bigint(20) NOT NULL,
  `visibility` int(11) NOT NULL,
  `flagged` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `videos_comments`
--

CREATE TABLE IF NOT EXISTS `videos_comments` (
  `id` varchar(6) NOT NULL,
  `user_id` int(11) NOT NULL,
  `video_id` varchar(6) NOT NULL,
  `comment` text NOT NULL,
  `timestamp` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `videos_votes`
--

CREATE TABLE IF NOT EXISTS `videos_votes` (
  `user_id` int(11) NOT NULL,
  `type` varchar(7) NOT NULL,
  `obj_id` varchar(6) NOT NULL,
  `action` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
