-- phpMyAdmin SQL Dump
-- version 4.0.6deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 02, 2014 at 08:36 PM
-- Server version: 5.5.35-0ubuntu0.13.10.1
-- PHP Version: 5.5.3-1ubuntu2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sarkesho`
--

-- --------------------------------------------------------

--
-- Table structure for table `blocks`
--

CREATE TABLE IF NOT EXISTS `blocks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `plugin` int(11) NOT NULL,
  `position` varchar(45) NOT NULL,
  `permations` varchar(45) DEFAULT NULL,
  `pages` varchar(45) DEFAULT NULL,
  `show_header` tinyint(1) DEFAULT NULL,
  `rank` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `plugin_idx` (`plugin`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `blocks`
--

INSERT INTO `blocks` (`id`, `name`, `plugin`, `position`, `permations`, `pages`, `show_header`, `rank`) VALUES
(6, 'content', 3, 'content', NULL, NULL, 0, 0),
(7, 'login', 2, 'sidebar1', NULL, NULL, 0, 3),
(9, 'language_select', 4, 'sidebar1', NULL, NULL, 0, 1),
(10, 'forget_password', 2, 'off', NULL, NULL, NULL, 2);

-- --------------------------------------------------------

--
-- Table structure for table `localize`
--

CREATE TABLE IF NOT EXISTS `localize` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `main` int(1) NOT NULL,
  `name` varchar(90) NOT NULL,
  `language` varchar(7) NOT NULL,
  `language_name` varchar(30) DEFAULT 'English - United States',
  `home` varchar(100) NOT NULL,
  `email` varchar(30) NOT NULL,
  `theme` varchar(45) NOT NULL,
  `direction` varchar(4) NOT NULL DEFAULT 'LTR',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `localize`
--

INSERT INTO `localize` (`id`, `main`, `name`, `language`, `language_name`, `home`, `email`, `theme`, `direction`) VALUES
(1, 1, 'Sarkesh', 'en_US', 'English - United States', '?plugin=permations&action=action', 'info@sarkesh.org', 'blog', 'LTR'),
(2, 0, 'سرکش', 'fa_IR', 'فارسی - ایران', '?plugin=permations&action=action', 'info@sarkesh.org', 'blog', 'RTL');

-- --------------------------------------------------------

--
-- Table structure for table `permations`
--

CREATE TABLE IF NOT EXISTS `permations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `enable` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `permations`
--

INSERT INTO `permations` (`id`, `name`, `enable`) VALUES
(1, 'Administrators', 1),
(2, 'users', 1),
(3, 'Not activated', 0);

-- --------------------------------------------------------

--
-- Table structure for table `plugins`
--

CREATE TABLE IF NOT EXISTS `plugins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `enable` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `plugins`
--

INSERT INTO `plugins` (`id`, `name`, `enable`) VALUES
(1, 'permations', 1),
(2, 'users', 1),
(3, 'core', 1),
(4, 'languages', 1);

-- --------------------------------------------------------

--
-- Table structure for table `registry`
--

CREATE TABLE IF NOT EXISTS `registry` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plugin` int(11) NOT NULL,
  `a_key` varchar(45) NOT NULL,
  `value` text,
  PRIMARY KEY (`id`),
  KEY `fk_plugin_idx` (`plugin`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `registry`
--

INSERT INTO `registry` (`id`, `plugin`, `a_key`, `value`) VALUES
(1, 3, 'validator_last_check', '1387753577'),
(2, 3, 'validator_max_time', '77000'),
(3, 3, 'cookie_max_time', '77000'),
(4, 3, 'jquery', '1'),
(5, 3, 'editor', '1'),
(6, 2, 'register', '1'),
(7, 3, 'bootstrap', '1'),
(8, 2, 'active_from_email', '1'),
(9, 2, 'default_permation', '2');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `validator` int(11) DEFAULT NULL,
  `forget` int(11) NOT NULL,
  `permation` int(11) NOT NULL,
  `last_login` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `permation_idx` (`permation`),
  KEY `validator_idx` (`validator`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `validator`, `forget`, `permation`, `last_login`) VALUES
(1, 'sarkesh', '90deff4b32c134f32e3f0d7e8a2aad92', 'alizadeh.babak@gmail.com', 359, 358, 1, NULL),
(5, 'reza', '1766011045c0297ff9dc46f7afdbbb3a', 'adada', 359, 0, 2, NULL),
(6, 'neda', 'e70ccbda673efeb4ef020ddc89d0e72d', 'kamari', NULL, 0, 2, NULL),
(7, 'feri', 'a07bd10e108f608b2c916400d9883332', 'sdfsdfgh', NULL, 0, 2, NULL),
(8, 'sdfsdfghr', 'd793be65e543b36b9c65908af7158274', 'sdfsdfghr', NULL, 0, 2, NULL),
(9, 'sdsdsdddddd', 'c7c1f3b1c48296c8f598f5aac15f8ee7', 'sdsdsdddddd', NULL, 0, 2, NULL),
(10, 'mintlinux', '515706a52ac7013a10718afca452aef3', 'mintlinux', NULL, 0, 2, NULL),
(11, 'trerewwerrr', 'c7747c01c16fab26cf6140cbb8948946', 'trerewwerrr', NULL, 0, 3, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `validator`
--

CREATE TABLE IF NOT EXISTS `validator` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `source` varchar(45) NOT NULL,
  `special_id` varchar(45) NOT NULL,
  `valid_time` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=361 ;

--
-- Dumping data for table `validator`
--

INSERT INTO `validator` (`id`, `source`, `special_id`, `valid_time`) VALUES
(340, 'USERS_FORGET', 'zf0lb2rg33', '1389642108'),
(341, 'USERS_FORGET', 'h8cqr93509', '1389642181'),
(342, 'USERS_FORGET', 'vlit8hfur2', '1389642429'),
(343, 'USERS_FORGET', 't7tzvw3tqr', '1389642971'),
(344, 'USERS_FORGET', 'k72p1m5ppo', '1389643275'),
(345, 'USERS_FORGET', 'dmnu45uo2k', '1389643443'),
(350, 'USERS_FORGET', 'j6t9c93q22', '1389723758'),
(351, 'USERS_FORGET', 'o4x6irr37n', '1389723854'),
(352, 'USERS_FORGET', 'zme87xo50m', '1389725157'),
(353, 'USERS_FORGET', '6kfuctfgtb', '1389725456'),
(354, 'USERS_FORGET', 'y5lqa9b9nr', '1389727630'),
(357, 'USERS_FORGET', 'coh29rves9', '1389806134'),
(358, 'USERS_FORGET', 'knzx0hjfxy', '1390475069'),
(360, 'USERS_ACTIVE', 'bl2b0ifhu3', '1391409828');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blocks`
--
ALTER TABLE `blocks`
  ADD CONSTRAINT `plugin` FOREIGN KEY (`plugin`) REFERENCES `plugins` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `registry`
--
ALTER TABLE `registry`
  ADD CONSTRAINT `fk_plugin` FOREIGN KEY (`plugin`) REFERENCES `plugins` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `permation` FOREIGN KEY (`permation`) REFERENCES `permations` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;