-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 24, 2020 at 06:14 AM
-- Server version: 5.7.19
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dronate`
--

-- --------------------------------------------------------

--
-- Table structure for table `donate_info`
--

DROP TABLE IF EXISTS `donate_info`;
CREATE TABLE IF NOT EXISTS `donate_info` (
  `info_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) DEFAULT NULL,
  `latitude` text,
  `longitutde` text,
  `user_mobile` int(11) NOT NULL,
  `user_email` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `entry_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `description` text,
  PRIMARY KEY (`info_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `donate_info`
--

INSERT INTO `donate_info` (`info_id`, `user_name`, `latitude`, `longitutde`, `user_mobile`, `user_email`, `city`, `entry_time`, `description`) VALUES
(2, 'Ayush', '26.80510228830098', '80.96348818798057', 1231231231, 'ayush@gmail.com', 'Lucknow', '2020-05-22 11:00:20', 'Some rice'),
(3, 'Abhay', '26.79214252321754', '80.96613892857705', 123123123, 'ayush@gmail.com', 'Lucknow', '2020-05-22 12:37:17', 'Some food from home 1 kg approx'),
(6, 'Anubhav', '26.79213517650962', '80.96621183633629', 99999999, 'anubhav@gmail.com', 'lucknow', '2020-05-23 09:29:41', 'I have some left over pulses and rotis'),
(7, 'ayush', '26.774415140187774', '80.88698892614717', 1111111, 'ayush@gmail.com', 'lucknow', '2020-05-23 09:52:59', 'We have some noodles and soup'),
(8, 'Anubhav', '26.456542349278696', '80.3514564710464', 1111111, 'anubhav@gmail.com', 'kanpur', '2020-05-23 09:57:11', 'We have curd and rice');

-- --------------------------------------------------------

--
-- Table structure for table `request_info`
--

DROP TABLE IF EXISTS `request_info`;
CREATE TABLE IF NOT EXISTS `request_info` (
  `request_id` int(11) NOT NULL AUTO_INCREMENT,
  `latitude` varchar(255) DEFAULT NULL,
  `longitutde` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `entry_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_active` int(11) DEFAULT '1',
  `description` text,
  PRIMARY KEY (`request_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `request_info`
--

INSERT INTO `request_info` (`request_id`, `latitude`, `longitutde`, `city`, `entry_time`, `is_active`, `description`) VALUES
(1, '26.825044452418467', '80.9411846719081', 'Lucknow', '2020-05-22 13:01:02', 1, 'We are two people starving'),
(2, '26.841424678656292', '80.94869121185849', 'Lucknow', '2020-05-22 13:28:52', 1, 'Please help'),
(3, '26.83638543939423', '80.9441344640833', 'lucknow', '2020-05-22 13:30:49', 1, 'we need food'),
(4, '26.79023672159186', '80.90321367915833', 'lucknow', '2020-05-22 19:01:42', 1, ''),
(5, '27.56742259881298', '80.6954743500507', 'sitapur', '2020-05-23 10:29:20', 1, 'Please help us, we don\'t have any food to eat'),
(6, '26.797614324236424', '80.98753879964843', 'lucknow', '2020-05-23 21:28:27', 1, '');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
