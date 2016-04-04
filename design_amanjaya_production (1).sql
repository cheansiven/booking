-- phpMyAdmin SQL Dump
-- version 4.3.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 03, 2016 at 09:45 PM
-- Server version: 5.5.42-37.1
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `design_amanjaya_production`
--

-- --------------------------------------------------------

--
-- Table structure for table `addon`
--

CREATE TABLE IF NOT EXISTS `addon` (
  `id` smallint(5) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `des` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `addon`
--

INSERT INTO `addon` (`id`, `name`, `des`, `created_at`, `updated_at`) VALUES
(0, '\n                        \n                        \n                        \n                        \n                        \n                        rate for extra bed\n                    \n                    \n                    \n                    \n  ', '', '2015-12-10 23:27:18', '2016-01-18 23:38:49'),
(1, '\n                        \n                        \n                        rate for late check out\n                    \n                    \n                    ', '', '2015-12-10 23:27:29', '2016-01-18 20:56:00'),
(2, '\n                        champagne on arrival\n                    ', '', '2015-12-10 23:27:56', '2016-01-18 20:55:30'),
(3, '\n                        \n                        \n                        early check in\n                    \n                    \n                    ', '', '2015-12-10 23:28:06', '2016-01-18 20:55:32'),
(4, '\n                        \n                        \n                        \n                        \n                        \n                        rate for extra bed\n                    \n                    \n                    \n                    \n  ', '', '2015-12-10 23:28:13', '2016-01-18 21:03:41'),
(5, '\n                        \n                        \n                        \n                        \n                        \n                        rate for extra bed\n                    \n                    \n                    \n                    \n  ', '', '2015-12-10 23:28:23', '2016-01-18 21:03:35'),
(10, '\n                        \n                        \n                        \n                        \n                        \n                        rate for extra bed\n                    \n                    \n                    \n                    \n  ', '', '2015-12-10 23:28:44', '2016-01-18 21:26:15');

-- --------------------------------------------------------

--
-- Table structure for table `addon_room`
--

CREATE TABLE IF NOT EXISTS `addon_room` (
  `id` int(10) unsigned NOT NULL,
  `room_id` tinyint(3) unsigned NOT NULL,
  `addon_id` smallint(5) unsigned NOT NULL,
  `price` decimal(19,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `addon_room`
--

INSERT INTO `addon_room` (`id`, `room_id`, `addon_id`, `price`, `created_at`, `updated_at`) VALUES
(50, 5, 1, '0.00', '2016-01-12 12:42:42', '2016-01-12 12:42:42'),
(51, 5, 2, '45.25', '2016-01-12 12:42:42', '2016-01-12 12:42:42'),
(52, 5, 6, '76.00', '2016-01-12 12:42:42', '2016-01-12 12:42:42'),
(56, 7, 2, '0.00', '2016-01-20 02:22:36', '2016-01-20 02:22:36'),
(57, 7, 6, '234.00', '2016-01-20 02:22:37', '2016-01-20 02:22:37'),
(58, 5, 5, '12.00', '2016-03-29 23:44:23', '2016-03-29 23:44:23'),
(59, 6, 0, '12.00', '2016-04-01 13:06:45', '2016-04-01 13:06:45');

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE IF NOT EXISTS `booking` (
  `id` int(11) NOT NULL,
  `status` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `firstname` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `contact_phone` varchar(50) NOT NULL,
  `country` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `number_of_guests` smallint(5) unsigned NOT NULL,
  `checkin` date NOT NULL,
  `checkout` date NOT NULL,
  `total_nights` tinyint(3) unsigned NOT NULL,
  `total_rooms` tinyint(3) unsigned NOT NULL,
  `total_price` decimal(19,2) NOT NULL,
  `first_time_guest` tinyint(1) NOT NULL DEFAULT '0',
  `is_paid` tinyint(1) NOT NULL,
  `transaction_number` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`id`, `status`, `firstname`, `lastname`, `email`, `contact_phone`, `country`, `number_of_guests`, `checkin`, `checkout`, `total_nights`, `total_rooms`, `total_price`, `first_time_guest`, `is_paid`, `transaction_number`, `created_at`, `updated_at`) VALUES
(1, 'mr', 'lyhong', 'pon', 'lyhong.pon@gmail.com', '+85510824930', 'Cambodia', 2, '0000-00-00', '0000-00-00', 1, 1, '155.25', 0, 0, '', '2016-01-29 12:30:51', '2016-01-29 12:30:51'),
(2, 'mr', 'p', 'Lyhong', 'lyhong.pon@gmail.com', '+85510824930', 'Cambodia', 2, '0000-00-00', '0000-00-00', 1, 1, '155.25', 0, 0, '', '2016-01-29 12:32:05', '2016-01-29 12:32:05'),
(3, 'mr', 'siven', 'chean', 'cheansiven@gmail.com', '092657070', 'Cambodia', 1, '0000-00-00', '0000-00-00', 16, 1, '2484.00', 0, 0, '', '2016-01-29 13:27:48', '2016-01-29 13:27:48'),
(4, 'mr', 'siven', 'chean', 'cheansiven@gmail.com', '092657070', 'Algeria', 2, '2016-01-30', '2016-01-31', 1, 2, '330.00', 0, 0, '', '2016-01-29 13:36:34', '2016-01-29 13:36:34'),
(5, 'mr', 'siven', 'chean', 'sivenchean94@gmail.com', '+85510824930', 'Cambodia', 1, '2016-01-30', '2016-01-31', 1, 1, '190.00', 0, 0, '', '2016-01-29 22:26:30', '2016-01-29 22:26:30'),
(6, 'mr', 'lyhong', 'pon', 'lyhong.pon@gmail.com', '010824930', 'Cambodia', 1, '2016-01-30', '2016-01-31', 1, 1, '155.25', 0, 0, '', '2016-01-29 23:13:32', '2016-01-29 23:13:32'),
(7, 'mr', 'lyhong', 'pon', 'lyhong.pon@gmail.com', '+85510824930', 'Cambodia', 2, '2016-02-01', '2016-02-02', 1, 2, '310.50', 1, 0, '', '2016-02-01 05:33:44', '2016-02-01 05:33:44'),
(8, 'mr', 'Franck', 'Dufrenoy', 'franck@lox-design.com', '', 'Cambodia', 3, '2016-02-02', '2016-02-17', 15, 3, '7425.00', 1, 0, '', '2016-02-01 14:24:32', '2016-02-01 14:24:32'),
(9, 'mr', 'lyhong', 'pon', 'lyhong.pon@gmail.com', '+85510824930', 'Cambodia', 2, '2016-02-02', '2016-02-04', 2, 1, '220.00', 0, 0, '', '2016-02-01 16:18:31', '2016-02-01 16:18:31'),
(10, 'mr', 'lyhong', 'pon', 'lyhong.pon@gmail.com', '+85510824930', 'Cambodia', 2, '2016-02-03', '2016-02-05', 2, 1, '220.00', 0, 0, '', '2016-02-01 16:21:19', '2016-02-01 16:21:19'),
(11, 'mr', 'siven', 'chean', 'cheansiven@gmail.com', '092657070', 'Albania', 2, '2016-02-03', '2016-02-04', 1, 1, '145.00', 1, 0, '', '2016-02-02 21:27:22', '2016-02-02 21:27:22'),
(12, 'mr', 'siven', 'chean', 'cheansiven@gmail.com', '092657070', 'Angola', 3, '2016-02-03', '2016-02-04', 1, 1, '145.00', 1, 0, '', '2016-02-02 21:31:24', '2016-02-02 21:31:24'),
(13, 'mr', 'siven', 'chean', 'cheansiven@gmail.com', '092657070', 'Angola', 2, '2016-02-03', '2016-02-04', 1, 1, '424.00', 1, 0, '', '2016-02-02 21:34:51', '2016-02-02 21:34:51'),
(14, 'mr', 'siven', 'chean', 'cheansiven@gmail.com', '086657070', 'Anguilla', 2, '2016-02-03', '2016-02-04', 1, 1, '424.00', 1, 0, '', '2016-02-02 21:37:00', '2016-02-02 21:37:00'),
(15, 'mr', 'lyhong', 'pon', 'lyhong.pon@gmail.com', '010 824930', 'Cambodia', 2, '2016-03-29', '2016-03-31', 2, 1, '330.00', 1, 0, '', '2016-03-29 20:08:56', '2016-03-29 20:08:56'),
(16, 'mr', 'Franck', 'Dufrenoy', 'info@lox-design.com', '', 'Antigua and Barbuda', 2, '2016-03-30', '2016-04-12', 13, 1, '1888.25', 0, 0, '', '2016-03-29 20:32:48', '2016-03-29 20:32:48');

-- --------------------------------------------------------

--
-- Table structure for table `booking_room`
--

CREATE TABLE IF NOT EXISTS `booking_room` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `room_id` tinyint(3) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `booking_room`
--

INSERT INTO `booking_room` (`id`, `booking_id`, `room_id`, `created_at`, `updated_at`) VALUES
(1, 1, 5, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 1, 5, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 1, 7, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 2, 7, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 1, 5, '2016-01-29 12:30:51', '2016-01-29 12:30:51'),
(6, 2, 5, '2016-01-29 12:32:05', '2016-01-29 12:32:05'),
(7, 3, 5, '2016-01-29 13:27:48', '2016-01-29 13:27:48'),
(8, 4, 6, '2016-01-29 13:36:34', '2016-01-29 13:36:34'),
(9, 4, 6, '2016-01-29 13:36:34', '2016-01-29 13:36:34'),
(10, 5, 7, '2016-01-29 22:26:30', '2016-01-29 22:26:30'),
(11, 6, 5, '2016-01-29 23:13:32', '2016-01-29 23:13:32'),
(12, 7, 5, '2016-02-01 05:33:44', '2016-02-01 05:33:44'),
(13, 7, 5, '2016-02-01 05:33:44', '2016-02-01 05:33:44'),
(14, 8, 6, '2016-02-01 14:24:32', '2016-02-01 14:24:32'),
(15, 8, 6, '2016-02-01 14:24:32', '2016-02-01 14:24:32'),
(16, 8, 6, '2016-02-01 14:24:32', '2016-02-01 14:24:32'),
(17, 9, 5, '2016-02-01 16:18:31', '2016-02-01 16:18:31'),
(18, 10, 5, '2016-02-01 16:21:19', '2016-02-01 16:21:19'),
(19, 11, 6, '2016-02-02 21:27:22', '2016-02-02 21:27:22'),
(20, 12, 6, '2016-02-02 21:31:24', '2016-02-02 21:31:24'),
(21, 13, 7, '2016-02-02 21:34:51', '2016-02-02 21:34:51'),
(22, 14, 7, '2016-02-02 21:37:00', '2016-02-02 21:37:00'),
(23, 15, 6, '2016-03-29 20:08:56', '2016-03-29 20:08:56'),
(24, 16, 5, '2016-03-29 20:32:48', '2016-03-29 20:32:48');

-- --------------------------------------------------------

--
-- Table structure for table `booking_room_addon`
--

CREATE TABLE IF NOT EXISTS `booking_room_addon` (
  `id` int(11) NOT NULL,
  `booking_room_id` int(11) NOT NULL,
  `addon_id` smallint(5) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `booking_room_addon`
--

INSERT INTO `booking_room_addon` (`id`, `booking_room_id`, `addon_id`, `created_at`, `updated_at`) VALUES
(1, 1, 50, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 1, 51, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 1, 52, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 1, 56, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 1, 57, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 2, 56, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 2, 57, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 6, 2, '2016-01-29 06:32:05', '2016-01-29 06:32:05'),
(9, 7, 1, '2016-01-29 07:27:48', '2016-01-29 07:27:48'),
(10, 7, 2, '2016-01-29 07:27:48', '2016-01-29 07:27:48'),
(11, 11, 2, '2016-01-29 17:13:32', '2016-01-29 17:13:32'),
(12, 12, 1, '2016-01-31 23:33:44', '2016-01-31 23:33:44'),
(13, 12, 2, '2016-01-31 23:33:44', '2016-01-31 23:33:44'),
(14, 13, 1, '2016-01-31 23:33:44', '2016-01-31 23:33:44'),
(15, 13, 2, '2016-01-31 23:33:44', '2016-01-31 23:33:44'),
(16, 17, 1, '2016-02-01 10:18:32', '2016-02-01 10:18:32'),
(17, 18, 1, '2016-02-01 10:21:19', '2016-02-01 10:21:19'),
(18, 21, 2, '2016-02-02 15:34:51', '2016-02-02 15:34:51'),
(19, 21, 6, '2016-02-02 15:34:51', '2016-02-02 15:34:51'),
(20, 22, 2, '2016-02-02 15:37:00', '2016-02-02 15:37:00'),
(21, 22, 6, '2016-02-02 15:37:00', '2016-02-02 15:37:00'),
(22, 24, 1, '2016-03-29 15:32:48', '2016-03-29 15:32:48'),
(23, 24, 2, '2016-03-29 15:32:48', '2016-03-29 15:32:48');

-- --------------------------------------------------------

--
-- Table structure for table `include`
--

CREATE TABLE IF NOT EXISTS `include` (
  `id` tinyint(3) unsigned NOT NULL,
  `value` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `include`
--

INSERT INTO `include` (`id`, `value`, `created_at`, `updated_at`) VALUES
(1, 'ALL TAXES INCLUDED', '2015-12-10 17:00:00', '2015-12-10 17:00:00'),
(2, '10% VAT NOT INCL', '2015-12-10 17:00:00', '2015-12-10 17:00:00'),
(3, '2% SERVICE CHARGE NOT INCL', '2015-12-10 17:00:00', '2015-12-10 17:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2015_12_08_082650_create_include', 1),
('2015_12_08_082655_create_addon', 1),
('2015_12_08_082713_create_addons_rate', 2),
('2014_10_12_000000_create_users_table', 3),
('2014_10_12_100000_create_password_resets_table', 3),
('2015_04_24_165608_create_books_table', 4),
('2015_10_28_033848_create_tour_table', 4),
('2015_10_28_034842_create_category_table', 4),
('2015_10_28_034850_create_addons_table', 4),
('2015_10_28_034858_create_extension_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rate`
--

CREATE TABLE IF NOT EXISTS `rate` (
  `id` int(10) unsigned NOT NULL,
  `price` decimal(19,2) NOT NULL,
  `percentage` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `close_date` date NOT NULL,
  `achive` tinyint(1) NOT NULL DEFAULT '0',
  `include_id` tinyint(3) NOT NULL,
  `room_id` tinyint(3) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `rate`
--

INSERT INTO `rate` (`id`, `price`, `percentage`, `start_date`, `close_date`, `achive`, `include_id`, `room_id`, `created_at`, `updated_at`) VALUES
(57, '189.50', 0, '2016-01-12', '2016-01-15', 0, 0, 5, '2016-01-12 12:42:42', '2016-01-12 12:42:42'),
(58, '110.00', 0, '2016-01-29', '2016-02-07', 0, 1, 5, '2016-01-29 10:30:13', '2016-01-29 10:30:13'),
(60, '145.00', 0, '2016-02-01', '2016-02-02', 0, 1, 6, '2016-02-01 18:29:17', '2016-02-01 18:29:17'),
(64, '100.00', 0, '2016-04-04', '2016-04-09', 0, 0, 5, '2016-04-04 13:34:57', '2016-04-04 13:34:57');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE IF NOT EXISTS `room` (
  `id` tinyint(3) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `max_room` smallint(5) unsigned NOT NULL,
  `max_capacity` tinyint(3) unsigned NOT NULL,
  `standard_rate` decimal(19,2) NOT NULL,
  `include_id` tinyint(3) unsigned NOT NULL,
  `photo` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`id`, `name`, `max_room`, `max_capacity`, `standard_rate`, `include_id`, `photo`, `created_at`, `updated_at`) VALUES
(5, 'junior suites', 12, 2, '140.00', 1, 'public/uploads/Junior-Suite.jpg', '2016-01-12 12:43:13', '2016-04-01 13:06:21'),
(6, 'panoramic Suites', 10, 3, '165.00', 1, 'public/img/Panoramic-Suite.jpg', '2016-01-20 02:15:13', '2016-03-31 14:32:02'),
(7, 'executive suites', 10, 3, '190.00', 1, 'public/img/Executive Suite.jpg', '2016-01-20 02:22:36', '2016-01-20 02:22:36');

-- --------------------------------------------------------

--
-- Table structure for table `room_available`
--

CREATE TABLE IF NOT EXISTS `room_available` (
  `id` mediumint(9) NOT NULL,
  `number_room_available` smallint(4) NOT NULL,
  `room_id` tinyint(3) unsigned NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL,
  `start_date` date NOT NULL,
  `close_date` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `room_available`
--

INSERT INTO `room_available` (`id`, `number_room_available`, `room_id`, `created_at`, `updated_at`, `start_date`, `close_date`) VALUES
(2, 4, 7, '2016-01-21', '2016-01-21', '2016-01-21', '2016-01-31'),
(3, 8, 6, '2016-02-01', '2016-02-01', '2016-02-01', '2016-02-02'),
(9, 3, 5, '2016-04-04', '2016-04-04', '2016-04-04', '2016-04-08');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(3, 'admin', 'franck@lox-design.com', '$2y$10$ico06DHrpfetLHCJto5JTuqenNWK0SvvGV9l.zwhjjCY7t8f1gWAO', 'Hc6qCm5FbDA43eZcHKQFkXBOQurwP76Pk8G5h3J2BKdM1lZ3IgUu73oEqvZM', '2015-12-13 23:13:17', '2016-01-29 10:19:55'),
(4, 'siven', 'cheansiven@gmail.com', '$2y$10$KT0FPBpMpEchq38TTscpcO1EwjMXdgn/JhcyLE6gBgm0cLsGJV3Ku', NULL, '2016-02-02 15:21:17', '2016-02-02 15:21:17'),
(5, 'Siven', 'siven@amanjaya-booking.com', '$2y$10$bzgus1ZtHieq3/GKEWUJKeyrJUlEuOP7C.xHKpvq2rvs4uuAHkAJG', NULL, '2016-02-14 05:42:22', '2016-02-14 05:42:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addon`
--
ALTER TABLE `addon`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `addon_room`
--
ALTER TABLE `addon_room`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booking_room`
--
ALTER TABLE `booking_room`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booking_room_addon`
--
ALTER TABLE `booking_room_addon`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `include`
--
ALTER TABLE `include`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`), ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `rate`
--
ALTER TABLE `rate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room_available`
--
ALTER TABLE `room_available`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addon`
--
ALTER TABLE `addon`
  MODIFY `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `addon_room`
--
ALTER TABLE `addon_room`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=60;
--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `booking_room`
--
ALTER TABLE `booking_room`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `booking_room_addon`
--
ALTER TABLE `booking_room_addon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `include`
--
ALTER TABLE `include`
  MODIFY `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `rate`
--
ALTER TABLE `rate`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=65;
--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `room_available`
--
ALTER TABLE `room_available`
  MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
