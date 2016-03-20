-- phpMyAdmin SQL Dump
-- version 4.2.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 20, 2016 at 02:18 AM
-- Server version: 5.6.20
-- PHP Version: 5.5.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cab`
--

-- --------------------------------------------------------

--
-- Table structure for table `new_cab_share`
--

CREATE TABLE IF NOT EXISTS `new_cab_share` (
`id` int(6) unsigned NOT NULL,
  `userid` varchar(50) NOT NULL,
  `source_addr` longtext NOT NULL,
  `dest_addr` longtext NOT NULL,
  `date` varchar(50) NOT NULL,
  `start_time` varchar(50) NOT NULL,
  `end_time` varchar(50) NOT NULL,
  `travellers` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `comment` varchar(50) NOT NULL,
  `state` int(6) unsigned NOT NULL,
  `private` varchar(50) NOT NULL,
  `username` varchar(255) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `new_cab_share`
--

INSERT INTO `new_cab_share` (`id`, `userid`, `source_addr`, `dest_addr`, `date`, `start_time`, `end_time`, `travellers`, `phone`, `comment`, `state`, `private`, `username`) VALUES
(15, 'mrinal.dhar@research.iiit.ac.in', 'IIIT, Gachibowli', 'Inorbit Mall Road', '12/18/2015', '0809', '1605', '2', '1231231232', '2 bags', 0, 'No', ''),
(16, 'mrinal.dhar@research.iiit.ac.in', 'Inorbit Mall Road, HITEC City, Hyderabad, Telangana, India', 'Airport Plaza Complex, Begumpet, Hyderabad, Telangana, India', '01/20/2016', '0646', '1700', '2', '7893550837', 'lalal', 0, 'Yes', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `new_cab_share`
--
ALTER TABLE `new_cab_share`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `new_cab_share`
--
ALTER TABLE `new_cab_share`
MODIFY `id` int(6) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
