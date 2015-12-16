-- phpMyAdmin SQL Dump
-- version 4.2.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 16, 2015 at 06:46 PM
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
  `state` int(6) unsigned NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `new_cab_share`
--

INSERT INTO `new_cab_share` (`id`, `userid`, `source_addr`, `dest_addr`, `date`, `start_time`, `end_time`, `travellers`, `phone`, `comment`, `state`) VALUES
(12, 'mrinal.dhar', 'IIIT, Gachibowli', 'Inorbit Mall Road, HITEC City', '12/12/2012', '0122', '0212', '0312', '9797682837', 'Hello', 0),
(13, 'mrinal.dhar@research.iiit.ac.in', 'a', 'n', '12/17/2015', '0900', '1700', '2', '213124', '5', 0),
(14, 'mrinal.dhar@research.iiit.ac.in', 'a', 'asdasd', '12/24/2015', '0900', '1700', '1', '1231231231', 'we', 0),
(15, 'mrinal.dhar@research.iiit.ac.in', 'IIIT, Gachibowli', 'Inorbit Mall Road', '12/18/2015', '0809', '1605', '2', '1231231232', '2 bags', 0);

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
MODIFY `id` int(6) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
