-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 25, 2024 at 05:42 AM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `virtual_card`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
`aid` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`aid`, `username`, `password`) VALUES
(1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `card`
--

CREATE TABLE IF NOT EXISTS `card` (
`cid` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `input_box` varchar(50) NOT NULL,
  `note` varchar(50) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `card`
--

INSERT INTO `card` (`cid`, `image`, `description`, `input_box`, `note`) VALUES
(1, 'img_675ac756b1f3b4.05778277.jpg', 'Company name: food restauarant & Owner Name : Jhon Smith         Working : Chef', 'https://www.facebook.com/', 'All meals starts from rs .250'),
(2, 'img_676151d5be1097.87631537.png', 'Company Name : It Solutions\\r\\nWorking : Specialist', 'https://www.facebook.com/', 'Hi'),
(3, 'img_67669610dd7599.86193774.jpg', 'working : departmental', 'https://www.facebook.com/', 'departmental store');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE IF NOT EXISTS `cart` (
`cart_id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` varchar(200) NOT NULL,
  `input_box` varchar(100) NOT NULL,
  `note` text NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `uid`, `image`, `description`, `input_box`, `note`) VALUES
(3, 7, 'img_675ac756b1f3b4.05778277.jpg', 'Company name: food restauarant & Owner Name : Jhon Smith         Working : Chef', 'https://www.facebook.com/', 'All meals starts from rs .250');

-- --------------------------------------------------------

--
-- Table structure for table `shop_owner`
--

CREATE TABLE IF NOT EXISTS `shop_owner` (
`sid` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `shop_name` varchar(50) NOT NULL,
  `mobile` bigint(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `shop_owner`
--

INSERT INTO `shop_owner` (`sid`, `username`, `password`, `shop_name`, `mobile`, `email`, `city`) VALUES
(1, 'Priyanka', '123', 'Thynk Kitchen', 9365412578, 'thynk@gmail.com', 'Coimbatore');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`uid` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `mobile` bigint(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `pincode` varchar(10) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `username`, `password`, `email`, `mobile`, `city`, `pincode`) VALUES
(6, 'Harini', '123', 'harini@gmail.com', 9632587412, 'Coimbatore', '632541'),
(7, 'Lavanya', '123', 'lavanya@gmail.com', 9632587416, 'Salem', '632541');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
 ADD PRIMARY KEY (`aid`);

--
-- Indexes for table `card`
--
ALTER TABLE `card`
 ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
 ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `shop_owner`
--
ALTER TABLE `shop_owner`
 ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
MODIFY `aid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `card`
--
ALTER TABLE `card`
MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `shop_owner`
--
ALTER TABLE `shop_owner`
MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
