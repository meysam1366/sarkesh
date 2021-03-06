-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 07, 2015 at 01:00 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sarkeshmvc`
--

-- --------------------------------------------------------

--
-- Table structure for table `blocks`
--

CREATE TABLE IF NOT EXISTS `blocks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `value` text NOT NULL,
  `plugin` int(11) NOT NULL,
  `position` varchar(45) NOT NULL,
  `permissions` varchar(45) DEFAULT NULL,
  `pages` text,
  `pages_ad` varchar(2) NOT NULL DEFAULT '1',
  `rank` int(11) NOT NULL DEFAULT '0',
  `visual` tinyint(1) NOT NULL DEFAULT '0',
  `handel` varchar(255) DEFAULT NULL,
  `show_header` tinyint(4) NOT NULL DEFAULT '1',
  `localize` varchar(200) NOT NULL DEFAULT 'all',
  PRIMARY KEY (`id`),
  KEY `plugin_idx` (`plugin`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `blocks`
--

INSERT INTO `blocks` (`id`, `name`, `value`, `plugin`, `position`, `permissions`, `pages`, `pages_ad`, `rank`, `visual`, `handel`, `show_header`, `localize`) VALUES
(6, 'content', '0', 3, 'content', NULL, '', '0', 0, 0, NULL, 1, 'all'),
(7, 'login_block', '0', 2, 'sidebar1', NULL, '', '1', 1, 0, NULL, 1, 'all'),
(12, 'select_lang', '0', 4, 'sidebar1', NULL, '', '1', 0, 0, NULL, 1, 'all'),
(19, '12', '18', 15, 'main_menu', NULL, '', '1', 0, 1, 'draw_menu', 0, 'all'),
(27, 'SARKESH_SLIDE_SHOW', 'SARKESH_SLIDE_SHOW<::::><div class="jumbotron text-center">    <h2>SarkeshMVC</h2>    <p class="lead">SarkeshMVC is php content managment framework that comes with new futures for build multi language websites.</p>    <p><a class="btn btn-large btn-success" href="http://sarkesh.org" target="ext">Get Started!</a></p>  </div>  ', 3, 'slide_show', NULL, 'frontpage,/?plugin=users&action=profile', '0', 0, 1, 'static_block', 0, 'en_US'),
(28, 'اسلاید شو بالا', 'اسلاید شو بالا<::::><div class="jumbotron text-center">    <h2>SarkeshMVC</h2>    <p class="lead">سرکش فریمورک مدیریت محتوای تحت زبان PHP با کتابخانه های بسیار برای انجام عملیات های پیچیده به صورت رایگان و متن باز در خدمت شماست.</p>    <p><a class="btn btn-large btn-success" href="http://www.sarkesh.org" target="ext">راهنمای شروع</a></p>  </div>', 3, 'slide_show', NULL, '', '1', 0, 1, 'static_block', 0, 'fa_IR'),
(29, 'منو اصلی', '19', 15, 'main_menu', NULL, '', '1', 0, 1, 'draw_menu', 0, 'fa_IR'),
(30, 'blog catalogues', '', 16, 'sidebar1', NULL, NULL, '1', 0, 1, 'block_show_catalog', 1, 'all');

-- --------------------------------------------------------

--
-- Table structure for table `blogcats`
--

CREATE TABLE IF NOT EXISTS `blogcats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `machin_name` varchar(60) NOT NULL,
  `localize` varchar(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `blogcats`
--

INSERT INTO `blogcats` (`id`, `name`, `machin_name`, `localize`) VALUES
(1, 'news', 'news', 'en_US'),
(2, 'release notes', 'release notes', 'en_US'),
(3, 'آخرین خبرها', 'آخرین خبرها', 'fa_IR'),
(4, 'یاداشت های انتشار', 'یاداشت های انتشار', 'fa_IR');

-- --------------------------------------------------------

--
-- Table structure for table `blogposts`
--

CREATE TABLE IF NOT EXISTS `blogposts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` int(11) NOT NULL,
  `catalogue` int(11) NOT NULL,
  `tags` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `contentcatalogue`
--

CREATE TABLE IF NOT EXISTS `contentcatalogue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `access_name` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `contentcatalogue`
--

INSERT INTO `contentcatalogue` (`id`, `access_name`, `name`) VALUES
(17, 'blog', 'blog');

-- --------------------------------------------------------

--
-- Table structure for table `contentcontent`
--

CREATE TABLE IF NOT EXISTS `contentcontent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `header` varchar(200) DEFAULT NULL,
  `date` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `show_author` tinyint(4) NOT NULL,
  `show_date` tinyint(4) NOT NULL,
  `can_comment` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `contentcontent`
--

INSERT INTO `contentcontent` (`id`, `header`, `date`, `user`, `show_author`, `show_date`, `can_comment`) VALUES
(18, 'Start offical sarkesh website', 1423214463, 1, 1, 1, 1),
(19, 'simple header', 1423299584, 1, 1, 1, 1),
(20, '121212', 1423301076, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `contentparts`
--

CREATE TABLE IF NOT EXISTS `contentparts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` int(11) NOT NULL,
  `rank` int(11) NOT NULL,
  `pattern` int(30) NOT NULL,
  `options` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `contentpatterns`
--

CREATE TABLE IF NOT EXISTS `contentpatterns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(30) NOT NULL,
  `catalogue` int(11) NOT NULL,
  `rank` int(11) NOT NULL,
  `type` varchar(30) NOT NULL,
  `options` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `contentpatterns`
--

INSERT INTO `contentpatterns` (`id`, `label`, `catalogue`, `rank`, `type`, `options`) VALUES
(22, 'body', 17, 0, 'textarea', 'editor:1');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_code` varchar(2) NOT NULL DEFAULT '',
  `country_name` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=243 ;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `country_code`, `country_name`) VALUES
(1, 'US', 'United States'),
(2, 'CA', 'Canada'),
(3, 'AF', 'Afghanistan'),
(4, 'AL', 'Albania'),
(5, 'DZ', 'Algeria'),
(6, 'DS', 'American Samoa'),
(7, 'AD', 'Andorra'),
(8, 'AO', 'Angola'),
(9, 'AI', 'Anguilla'),
(10, 'AQ', 'Antarctica'),
(11, 'AG', 'Antigua and/or Barbuda'),
(12, 'AR', 'Argentina'),
(13, 'AM', 'Armenia'),
(14, 'AW', 'Aruba'),
(15, 'AU', 'Australia'),
(16, 'AT', 'Austria'),
(17, 'AZ', 'Azerbaijan'),
(18, 'BS', 'Bahamas'),
(19, 'BH', 'Bahrain'),
(20, 'BD', 'Bangladesh'),
(21, 'BB', 'Barbados'),
(22, 'BY', 'Belarus'),
(23, 'BE', 'Belgium'),
(24, 'BZ', 'Belize'),
(25, 'BJ', 'Benin'),
(26, 'BM', 'Bermuda'),
(27, 'BT', 'Bhutan'),
(28, 'BO', 'Bolivia'),
(29, 'BA', 'Bosnia and Herzegovina'),
(30, 'BW', 'Botswana'),
(31, 'BV', 'Bouvet Island'),
(32, 'BR', 'Brazil'),
(33, 'IO', 'British lndian Ocean Territory'),
(34, 'BN', 'Brunei Darussalam'),
(35, 'BG', 'Bulgaria'),
(36, 'BF', 'Burkina Faso'),
(37, 'BI', 'Burundi'),
(38, 'KH', 'Cambodia'),
(39, 'CM', 'Cameroon'),
(40, 'CV', 'Cape Verde'),
(41, 'KY', 'Cayman Islands'),
(42, 'CF', 'Central African Republic'),
(43, 'TD', 'Chad'),
(44, 'CL', 'Chile'),
(45, 'CN', 'China'),
(46, 'CX', 'Christmas Island'),
(47, 'CC', 'Cocos (Keeling) Islands'),
(48, 'CO', 'Colombia'),
(49, 'KM', 'Comoros'),
(50, 'CG', 'Congo'),
(51, 'CK', 'Cook Islands'),
(52, 'CR', 'Costa Rica'),
(53, 'HR', 'Croatia (Hrvatska)'),
(54, 'CU', 'Cuba'),
(55, 'CY', 'Cyprus'),
(56, 'CZ', 'Czech Republic'),
(57, 'DK', 'Denmark'),
(58, 'DJ', 'Djibouti'),
(59, 'DM', 'Dominica'),
(60, 'DO', 'Dominican Republic'),
(61, 'TP', 'East Timor'),
(62, 'EC', 'Ecuador'),
(63, 'EG', 'Egypt'),
(64, 'SV', 'El Salvador'),
(65, 'GQ', 'Equatorial Guinea'),
(66, 'ER', 'Eritrea'),
(67, 'EE', 'Estonia'),
(68, 'ET', 'Ethiopia'),
(69, 'FK', 'Falkland Islands (Malvinas)'),
(70, 'FO', 'Faroe Islands'),
(71, 'FJ', 'Fiji'),
(72, 'FI', 'Finland'),
(73, 'FR', 'France'),
(74, 'FX', 'France, Metropolitan'),
(75, 'GF', 'French Guiana'),
(76, 'PF', 'French Polynesia'),
(77, 'TF', 'French Southern Territories'),
(78, 'GA', 'Gabon'),
(79, 'GM', 'Gambia'),
(80, 'GE', 'Georgia'),
(81, 'DE', 'Germany'),
(82, 'GH', 'Ghana'),
(83, 'GI', 'Gibraltar'),
(84, 'GR', 'Greece'),
(85, 'GL', 'Greenland'),
(86, 'GD', 'Grenada'),
(87, 'GP', 'Guadeloupe'),
(88, 'GU', 'Guam'),
(89, 'GT', 'Guatemala'),
(90, 'GN', 'Guinea'),
(91, 'GW', 'Guinea-Bissau'),
(92, 'GY', 'Guyana'),
(93, 'HT', 'Haiti'),
(94, 'HM', 'Heard and Mc Donald Islands'),
(95, 'HN', 'Honduras'),
(96, 'HK', 'Hong Kong'),
(97, 'HU', 'Hungary'),
(98, 'IS', 'Iceland'),
(99, 'IN', 'India'),
(100, 'ID', 'Indonesia'),
(101, 'IR', 'Iran (Islamic Republic of)'),
(102, 'IQ', 'Iraq'),
(103, 'IE', 'Ireland'),
(104, 'IL', 'Israel'),
(105, 'IT', 'Italy'),
(106, 'CI', 'Ivory Coast'),
(107, 'JM', 'Jamaica'),
(108, 'JP', 'Japan'),
(109, 'JO', 'Jordan'),
(110, 'KZ', 'Kazakhstan'),
(111, 'KE', 'Kenya'),
(112, 'KI', 'Kiribati'),
(113, 'KP', 'Korea, Democratic People''s Republic of'),
(114, 'KR', 'Korea, Republic of'),
(115, 'XK', 'Kosovo'),
(116, 'KW', 'Kuwait'),
(117, 'KG', 'Kyrgyzstan'),
(118, 'LA', 'Lao People''s Democratic Republic'),
(119, 'LV', 'Latvia'),
(120, 'LB', 'Lebanon'),
(121, 'LS', 'Lesotho'),
(122, 'LR', 'Liberia'),
(123, 'LY', 'Libyan Arab Jamahiriya'),
(124, 'LI', 'Liechtenstein'),
(125, 'LT', 'Lithuania'),
(126, 'LU', 'Luxembourg'),
(127, 'MO', 'Macau'),
(128, 'MK', 'Macedonia'),
(129, 'MG', 'Madagascar'),
(130, 'MW', 'Malawi'),
(131, 'MY', 'Malaysia'),
(132, 'MV', 'Maldives'),
(133, 'ML', 'Mali'),
(134, 'MT', 'Malta'),
(135, 'MH', 'Marshall Islands'),
(136, 'MQ', 'Martinique'),
(137, 'MR', 'Mauritania'),
(138, 'MU', 'Mauritius'),
(139, 'TY', 'Mayotte'),
(140, 'MX', 'Mexico'),
(141, 'FM', 'Micronesia, Federated States of'),
(142, 'MD', 'Moldova, Republic of'),
(143, 'MC', 'Monaco'),
(144, 'MN', 'Mongolia'),
(145, 'ME', 'Montenegro'),
(146, 'MS', 'Montserrat'),
(147, 'MA', 'Morocco'),
(148, 'MZ', 'Mozambique'),
(149, 'MM', 'Myanmar'),
(150, 'NA', 'Namibia'),
(151, 'NR', 'Nauru'),
(152, 'NP', 'Nepal'),
(153, 'NL', 'Netherlands'),
(154, 'AN', 'Netherlands Antilles'),
(155, 'NC', 'New Caledonia'),
(156, 'NZ', 'New Zealand'),
(157, 'NI', 'Nicaragua'),
(158, 'NE', 'Niger'),
(159, 'NG', 'Nigeria'),
(160, 'NU', 'Niue'),
(161, 'NF', 'Norfork Island'),
(162, 'MP', 'Northern Mariana Islands'),
(163, 'NO', 'Norway'),
(164, 'OM', 'Oman'),
(165, 'PK', 'Pakistan'),
(166, 'PW', 'Palau'),
(167, 'PA', 'Panama'),
(168, 'PG', 'Papua New Guinea'),
(169, 'PY', 'Paraguay'),
(170, 'PE', 'Peru'),
(171, 'PH', 'Philippines'),
(172, 'PN', 'Pitcairn'),
(173, 'PL', 'Poland'),
(174, 'PT', 'Portugal'),
(175, 'PR', 'Puerto Rico'),
(176, 'QA', 'Qatar'),
(177, 'RE', 'Reunion'),
(178, 'RO', 'Romania'),
(179, 'RU', 'Russian Federation'),
(180, 'RW', 'Rwanda'),
(181, 'KN', 'Saint Kitts and Nevis'),
(182, 'LC', 'Saint Lucia'),
(183, 'VC', 'Saint Vincent and the Grenadines'),
(184, 'WS', 'Samoa'),
(185, 'SM', 'San Marino'),
(186, 'ST', 'Sao Tome and Principe'),
(187, 'SA', 'Saudi Arabia'),
(188, 'SN', 'Senegal'),
(189, 'RS', 'Serbia'),
(190, 'SC', 'Seychelles'),
(191, 'SL', 'Sierra Leone'),
(192, 'SG', 'Singapore'),
(193, 'SK', 'Slovakia'),
(194, 'SI', 'Slovenia'),
(195, 'SB', 'Solomon Islands'),
(196, 'SO', 'Somalia'),
(197, 'ZA', 'South Africa'),
(198, 'GS', 'South Georgia South Sandwich Islands'),
(199, 'ES', 'Spain'),
(200, 'LK', 'Sri Lanka'),
(201, 'SH', 'St. Helena'),
(202, 'PM', 'St. Pierre and Miquelon'),
(203, 'SD', 'Sudan'),
(204, 'SR', 'Suriname'),
(205, 'SJ', 'Svalbarn and Jan Mayen Islands'),
(206, 'SZ', 'Swaziland'),
(207, 'SE', 'Sweden'),
(208, 'CH', 'Switzerland'),
(209, 'SY', 'Syrian Arab Republic'),
(210, 'TW', 'Taiwan'),
(211, 'TJ', 'Tajikistan'),
(212, 'TZ', 'Tanzania, United Republic of'),
(213, 'TH', 'Thailand'),
(214, 'TG', 'Togo'),
(215, 'TK', 'Tokelau'),
(216, 'TO', 'Tonga'),
(217, 'TT', 'Trinidad and Tobago'),
(218, 'TN', 'Tunisia'),
(219, 'TR', 'Turkey'),
(220, 'TM', 'Turkmenistan'),
(221, 'TC', 'Turks and Caicos Islands'),
(222, 'TV', 'Tuvalu'),
(223, 'UG', 'Uganda'),
(224, 'UA', 'Ukraine'),
(225, 'AE', 'United Arab Emirates'),
(226, 'GB', 'United Kingdom'),
(227, 'UM', 'United States minor outlying islands'),
(228, 'UY', 'Uruguay'),
(229, 'UZ', 'Uzbekistan'),
(230, 'VU', 'Vanuatu'),
(231, 'VA', 'Vatican City State'),
(232, 'VE', 'Venezuela'),
(233, 'VN', 'Vietnam'),
(234, 'VG', 'Virgin Islands (British)'),
(235, 'VI', 'Virgin Islands (U.S.)'),
(236, 'WF', 'Wallis and Futuna Islands'),
(237, 'EH', 'Western Sahara'),
(238, 'YE', 'Yemen'),
(239, 'YU', 'Yugoslavia'),
(240, 'ZR', 'Zaire'),
(241, 'ZM', 'Zambia'),
(242, 'ZW', 'Zimbabwe');

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE IF NOT EXISTS `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `place` int(11) NOT NULL,
  `address` varchar(300) NOT NULL,
  `date` varchar(11) NOT NULL,
  `user` int(11) NOT NULL,
  `size` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `name`, `place`, `address`, `date`, `user`, `size`) VALUES
(5, 'sorkhpost.jpg', 1, 'http://localhostupload/files/sorkhpost.jpg', '1412063025', 0, 173942),
(6, '84825656190514sorkhpost.jpg', 1, 'http://localhostupload/files/84825656190514sorkhpost.jpg', '1412063103', 0, 173942),
(7, '1713023707270sorkhpost.jpg', 1, 'http://localhostupload/files/1713023707270sorkhpost.jpg', '1412063110', 0, 173942),
(8, '90723523637279sorkhpost.jpg', 1, 'http://localhostupload/files/90723523637279sorkhpost.jpg', '1412754683', 0, 173942),
(9, 'libcairo-2.dll', 1, 'http://localhostupload/files/libcairo-2.dll', '1420189744', 0, 921369),
(10, '149241685libcairo-2.dll', 1, 'http://localhostupload/files/149241685libcairo-2.dll', '1420189744', 0, 921369);

-- --------------------------------------------------------

--
-- Table structure for table `file_places`
--

CREATE TABLE IF NOT EXISTS `file_places` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `class_name` varchar(20) NOT NULL,
  `options` text NOT NULL,
  `state` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `file_places`
--

INSERT INTO `file_places` (`id`, `name`, `class_name`, `options`, `state`) VALUES
(1, 'Local Strong', 'files_local', 'upload/files/', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ipblock`
--

CREATE TABLE IF NOT EXISTS `ipblock` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `ipblock`
--

INSERT INTO `ipblock` (`id`, `ip`) VALUES
(7, '-1062731519');

-- --------------------------------------------------------

--
-- Table structure for table `links`
--

CREATE TABLE IF NOT EXISTS `links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ref_id` int(11) NOT NULL,
  `label` varchar(100) NOT NULL,
  `url` text NOT NULL,
  `enable` tinyint(4) NOT NULL DEFAULT '1',
  `rank` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `links`
--

INSERT INTO `links` (`id`, `ref_id`, `label`, `url`, `enable`, `rank`) VALUES
(6, 18, 'Documents', 'https://github.com/morrning/sarkesh/wiki', 1, 0),
(7, 18, 'Download', 'https://github.com/morrning/sarkesh', 1, 0),
(8, 19, 'دریافت', 'https://github.com/morrning/sarkesh', 1, 0),
(9, 19, 'مستندات', 'https://github.com/morrning/sarkesh/wiki', 1, 0);

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
  `calendar` varchar(20) NOT NULL DEFAULT 'gregorian',
  `direction` varchar(4) NOT NULL DEFAULT 'LTR',
  `slogan` varchar(120) DEFAULT NULL,
  `header_tags` text,
  `can_delete` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `localize`
--

INSERT INTO `localize` (`id`, `main`, `name`, `language`, `language_name`, `home`, `email`, `calendar`, `direction`, `slogan`, `header_tags`, `can_delete`) VALUES
(1, 1, 'Sarkesh', 'en_US', 'English - United States', '?plugin=users&action=register', 'info@sarkesh.org', 'gregorian', 'LTR', 'Sarkesh CMF', 'SarkeshMVC is best cms in the world.', 0),
(2, 1, 'سرکش', 'fa_IR', 'فارسی - ایران', '?plugin=users&action=register', 'info@sarkesh.org', 'jallali', 'RTL', 'سرکش بهترین فریمورک', 'سرکش بهترین فریمورک', 1);

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE IF NOT EXISTS `menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `header` varchar(50) DEFAULT NULL,
  `show_header` tinyint(1) NOT NULL DEFAULT '1',
  `localize` varchar(10) NOT NULL DEFAULT 'en_US',
  `horiz` tinyint(1) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `name`, `header`, `show_header`, `localize`, `horiz`) VALUES
(18, 'MAIN_MENU', 'MAIN MENU', 0, 'en_US', 1),
(19, 'منو اصلی', 'منو اصلی', 0, 'fa_IR', 1);

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `enable` tinyint(1) DEFAULT NULL,
  `administrator_admin_panel` tinyint(4) NOT NULL DEFAULT '0',
  `users_admin` tinyint(1) NOT NULL DEFAULT '0',
  `content_cat_insert` int(11) NOT NULL DEFAULT '0',
  `content_cat_edit` tinyint(4) NOT NULL DEFAULT '0',
  `menus_admin_panel` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `enable`, `administrator_admin_panel`, `users_admin`, `content_cat_insert`, `content_cat_edit`, `menus_admin_panel`) VALUES
(1, 'Administrators', 1, 1, 1, 1, 1, 1),
(2, 'users', 1, 0, 0, 0, 0, 0),
(3, 'Not activated', 0, 0, 0, 0, 0, 0),
(4, 'guest', 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `plugins`
--

CREATE TABLE IF NOT EXISTS `plugins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `enable` tinyint(1) NOT NULL,
  `can_edite` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `plugins`
--

INSERT INTO `plugins` (`id`, `name`, `enable`, `can_edite`) VALUES
(2, 'users', 1, 0),
(3, 'administrator', 1, 0),
(4, 'languages', 1, 0),
(6, 'hello', 1, 1),
(11, 'files', 1, 0),
(12, 'msg', 1, 0),
(13, 'log', 1, 0),
(14, 'content', 1, 1),
(15, 'menus', 1, 0),
(16, 'blog', 1, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=32 ;

--
-- Dumping data for table `registry`
--

INSERT INTO `registry` (`id`, `plugin`, `a_key`, `value`) VALUES
(1, 3, 'validator_last_check', '1387753577'),
(2, 3, 'validator_max_time', '77000'),
(4, 3, 'jquery', '1'),
(5, 3, 'editor', '0'),
(6, 2, 'register', '1'),
(7, 3, 'bootstrap', '1'),
(8, 2, 'active_from_email', '0'),
(9, 2, 'default_permation', '2'),
(13, 2, 'register_captcha', '1'),
(15, 3, 'default_timezone', '0.00 - UTC'),
(16, 3, 'active_theme', 'basic'),
(17, 3, '1st_template', '0'),
(18, 2, 'register_date_format', 'y/m/d'),
(19, 14, 'date_format', 'y/m/d'),
(20, 3, 'default_country', 'United States'),
(21, 3, 'header_tags', 'Sarkesh is best cms!'),
(23, 2, 'signatures', '0'),
(24, 2, 'user_can_upload_avatar', '0'),
(25, 2, 'avatar_guidline', NULL),
(26, 2, 'max_file_size', NULL),
(27, 3, 'clean_url', '0'),
(28, 3, 'core_version', '0.7.1'),
(29, 3, 'build_num', '931117'),
(30, 16, 'content_type', '17'),
(31, 16, 'post_date_format', 'y/m/d');

-- --------------------------------------------------------

--
-- Table structure for table `timezones`
--

CREATE TABLE IF NOT EXISTS `timezones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `timezone_name` varchar(30) NOT NULL,
  `pos` varchar(2) DEFAULT NULL,
  `value` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `timezones`
--

INSERT INTO `timezones` (`id`, `timezone_name`, `pos`, `value`) VALUES
(1, '0.00 - UTC', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `urls`
--

CREATE TABLE IF NOT EXISTS `urls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orginal` text NOT NULL,
  `handel` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `urls`
--

INSERT INTO `urls` (`id`, `orginal`, `handel`) VALUES
(1, 'plugin</>users</>action</>register', 'register');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `password` varchar(60) NOT NULL,
  `email` varchar(100) NOT NULL,
  `permission` int(1) NOT NULL,
  `register_date` int(11) NOT NULL,
  `validator` int(11) DEFAULT NULL,
  `forget` varchar(11) DEFAULT NULL,
  `last_login` int(11) DEFAULT NULL,
  `login_key` int(11) unsigned DEFAULT NULL,
  `photo` int(11) NOT NULL DEFAULT '0',
  `permation` int(11) unsigned DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `permission`, `register_date`, `validator`, `forget`, `last_login`, `login_key`, `photo`, `permation`, `state`, `code`) VALUES
(1, 'test', '098f6bcd4621d373cade4e832627b4f6', 'info@test.org', 1, 1412751997, 55, '', 1412751997, 183, 5, NULL, NULL, NULL),
(6, 'morrning', '90deff4b32c134f32e3f0d7e8a2aad92', 'alizadeh.babak@gmail.com', 1, 1412786925, NULL, NULL, NULL, NULL, 0, 2, 'NA', '1d48txim52');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=184 ;

--
-- Dumping data for table `validator`
--

INSERT INTO `validator` (`id`, `source`, `special_id`, `valid_time`) VALUES
(71, 'USERS_LOGIN', '5sn336oa7l', '1413939386'),
(72, 'USERS_LOGIN', '0hki41zbw3', '1414135411'),
(73, 'USERS_LOGIN', 'x560owqe7m', '1414216563'),
(74, 'USERS_LOGIN', '729zwfz4oj', '1414308771'),
(75, 'USERS_LOGIN', 'ktdx4xkenr', '1414402931'),
(78, 'USERS_LOGIN', 'xbu7wq8140', '1414514690'),
(79, 'USERS_LOGIN', 'e5bag4xzqn', '1414591849'),
(81, 'USERS_LOGIN', 'az90gqycdd', '1414776502'),
(82, 'USERS_LOGIN', '04axdn0j00', '1414836657'),
(83, 'USERS_LOGIN', '4v9vy85bhc', '1414997992'),
(84, 'USERS_LOGIN', 'yqj73jy553', '1415263163'),
(85, 'USERS_LOGIN', 'lckuywkymz', '1415351476'),
(86, 'USERS_LOGIN', 'szb3rasbrj', '1415609846'),
(87, 'USERS_LOGIN', 'rfmzyvinqp', '1416196034'),
(88, 'USERS_LOGIN', 'h7zk6rtq70', '1416464195'),
(89, 'USERS_LOGIN', '37zg1v0m7v', '1416890765'),
(90, 'USERS_LOGIN', 'wbvgt5kmkk', '1417082946'),
(91, 'USERS_LOGIN', 'mtylnofl1a', '1417836954'),
(93, 'USERS_LOGIN', '68qpvijy79', '1417191271'),
(96, 'USERS_LOGIN', '8zq2pbjrou', '1420004782'),
(97, 'USERS_LOGIN', '4vgfyn4dvx', '1420227931'),
(98, 'USERS_LOGIN', '8aiungskoc', '1420228699'),
(99, 'USERS_LOGIN', 'csklawex3f', '1420231122'),
(100, 'USERS_LOGIN', '5kl1hjaekf', '1420309614'),
(101, 'USERS_LOGIN', 'jhijqvwd0k', '1420392452'),
(102, 'USERS_LOGIN', 'ky9mdx83d7', '1420491043'),
(103, 'USERS_LOGIN', 'dd5ocgshlf', '1420575780'),
(104, 'USERS_LOGIN', 'm38y8dytdz', '1420659796'),
(105, 'USERS_LOGIN', '4aau64t08q', '1420870559'),
(106, 'USERS_LOGIN', 'rpthh1g6z5', '1421002994'),
(107, 'USERS_LOGIN', 'bxinc2kx39', '1421233422'),
(109, 'USERS_LOGIN', 't30fgdrjxl', '1421403714'),
(111, 'USERS_LOGIN', '6b0feff7dy', '1421510708'),
(115, 'USERS_LOGIN', 't723i8xqu7', '1421644880'),
(118, 'USERS_LOGIN', 'yswai0s85h', '1421759351'),
(119, 'USERS_LOGIN', '6a99svbijl', '1421812713'),
(120, 'USERS_LOGIN', '4azj543ybe', '1421904702'),
(121, 'USERS_LOGIN', 'ppfebeom9j', '1422104861'),
(122, 'USERS_LOGIN', 'b5127btty0', '1422125935'),
(123, 'USERS_LOGIN', 'js1593mhf2', '1422180042'),
(124, 'USERS_LOGIN', 'lbkl4ck02s', '1422183392'),
(125, 'USERS_LOGIN', 'zup5lmdc65', '1422208490'),
(126, 'USERS_LOGIN', 'v0y46blefg', '1422241887'),
(127, 'USERS_LOGIN', 'm02pe878b1', '1422260623'),
(128, 'USERS_LOGIN', 'k5mbimykf4', '1422298334'),
(129, 'USERS_LOGIN', 'ieyoxf11uw', '1422307869'),
(136, 'USERS_LOGIN', 'tywhfdbj9f', '1422344441'),
(138, 'USERS_LOGIN', 'izqrat9qtm', '1422365753'),
(139, 'USERS_LOGIN', '1w9m5r41ug', '1422382805'),
(140, 'USERS_LOGIN', 'sb3a979pr4', '1422429477'),
(144, 'USERS_LOGIN', 'n0ucz9zyzk', '1422472721'),
(145, 'USERS_LOGIN', 'pt4ydgtbpx', '1422504000'),
(150, 'USERS_LOGIN', 'xk754lqj33', '1422607632'),
(151, 'USERS_LOGIN', 'xoq2dc9o8a', '1422615058'),
(153, 'USERS_LOGIN', '2otoya22up', '1422643664'),
(154, 'USERS_LOGIN', 'buetx8ochj', '1422681624'),
(155, 'USERS_LOGIN', 'czk3dki2k0', '1422723214'),
(156, 'USERS_LOGIN', 'x59chis7r8', '1422735546'),
(158, 'USERS_LOGIN', 'lr6jijqqq1', '1422775724'),
(159, 'USERS_LOGIN', 'x74473yy1j', '1422785219'),
(160, 'USERS_LOGIN', 'tz2sw95u0t', '1422790979'),
(161, 'USERS_LOGIN', 'j7xse1d30z', '1422852582'),
(162, 'USERS_LOGIN', 'zk569fpg9k', '1422876431'),
(164, 'USERS_LOGIN', 'w9r7bsumw9', '1422906412'),
(165, 'USERS_LOGIN', 'i54y9jat5o', '1422937755'),
(166, 'USERS_LOGIN', 'yvtl2pct6h', '1422994807'),
(167, 'USERS_LOGIN', 'gbdef7tzwb', '1423011625'),
(168, 'USERS_LOGIN', '698t3s065y', '1423031928'),
(169, 'USERS_LOGIN', 'fk01j7jn0l', '1423052268'),
(170, 'USERS_LOGIN', 'lkjv0uw1zy', '1423078439'),
(171, 'USERS_LOGIN', 'i7a4dap8wr', '1423101500'),
(173, 'USERS_LOGIN', 'ny77gmg706', '1423119250'),
(175, 'USERS_LOGIN', '8guvrwvreq', '1423154689'),
(176, 'USERS_LOGIN', 'byzsdvqtn2', '1423172722'),
(177, 'USERS_LOGIN', 'al08zl6wts', '1423180211'),
(178, 'USERS_LOGIN', 'l5lbmjkqnb', '1423200717'),
(179, 'USERS_LOGIN', '72rk4xrnbu', '1423242815'),
(181, 'USERS_LOGIN', 'r36c0uqmo5', '1423299842'),
(182, 'USERS_LOGIN', '9vbxbqvjob', '1423342149'),
(183, 'USERS_LOGIN', 'lcltxen29l', '1423372647');

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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
