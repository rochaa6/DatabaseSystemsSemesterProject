-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: December 16, 2022 at 09:22 PM
-- Server version: 5.7.38
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rochaa6_beatlesMerch`
--

-- --------------------------------------------------------

--
-- Table structure for table `CART`
--

CREATE TABLE `CART` (
  `cartID` int(11) NOT NULL,
  `customerID` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `CART`
--

INSERT INTO `CART` (`cartID`, `customerID`) VALUES
(2, 'johndoe'),
(3, 'johndoe'),
(4, 'paul64'),
(5, 'revolution9'),
(6, 'quietbeatle1'),
(8, 'ringo1');

-- --------------------------------------------------------

--
-- Table structure for table `CUSTOMER`
--

CREATE TABLE `CUSTOMER` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `f_name` varchar(255) NOT NULL,
  `l_name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `CUSTOMER`
--

INSERT INTO `CUSTOMER` (`username`, `password`, `email`, `f_name`, `l_name`) VALUES
('johndoe', '$2y$10$GY.zDIXPeqMDnmUPS/It1ex0zw0wv8TTXX.Ccdvb1yjWvlJKyJ0q2', 'johndoe@gmail.com', 'John', 'Doe'),
('ringo1', '$2y$10$1eW5W6XxaPaRuo8vgriu9.SXynIdZfq8x15cpjQAWOnSY8R0gz0.C', 'yellowsub@gmail.com', 'Ringo', 'Stah');

-- --------------------------------------------------------

--
-- Table structure for table `HAS_ORDER`
--

CREATE TABLE `HAS_ORDER` (
  `orderID` int(11) NOT NULL,
  `customerID` varchar(255) NOT NULL,
  `employeeID` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `HAS_ORDER`
--

INSERT INTO `HAS_ORDER` (`orderID`, `customerID`, `employeeID`) VALUES
(1, 'johndoe', 'admin1'),
(7, 'ringo1', 'quietbeatle1');

-- --------------------------------------------------------

--
-- Table structure for table `image_tab`
--

CREATE TABLE `image_tab` (
  `image` longblob NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `IN_CART`
--

CREATE TABLE `IN_CART` (
  `orderID` int(11) NOT NULL,
  `itemID` int(11) NOT NULL,
  `amount` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `IN_ORDER`
--

CREATE TABLE `IN_ORDER` (
  `orderID` int(11) NOT NULL,
  `itemID` int(11) NOT NULL,
  `amount` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `IN_ORDER`
--

INSERT INTO `IN_ORDER` (`orderID`, `itemID`, `amount`) VALUES
(1, 1, 2),
(7, 1, 2),
(7, 13, 1),
(7, 19, 1);

-- --------------------------------------------------------

--
-- Table structure for table `MANAGES`
--

CREATE TABLE `MANAGES` (
  `managerID` varchar(255) NOT NULL,
  `userID` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `MANAGES`
--

INSERT INTO `MANAGES` (`managerID`, `userID`) VALUES
('paul64', ''),
('paul64', 'paul64'),
('paul64', 'revolution9'),
('quietbeatle1', ''),
('quietbeatle1', 'quietbeatle1'),
('revolution9', '');

-- --------------------------------------------------------

--
-- Table structure for table `ORDERS`
--

CREATE TABLE `ORDERS` (
  `orderID` int(11) NOT NULL,
  `ordered_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ORDERS`
--

INSERT INTO `ORDERS` (`orderID`, `ordered_date`, `status`) VALUES
(1, '2022-05-09 20:54:51', b'0'),
(7, '2022-05-10 00:03:20', b'1');

-- --------------------------------------------------------

--
-- Table structure for table `PRODUCT`
--

CREATE TABLE `PRODUCT` (
  `itemID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `genre` varchar(255) NOT NULL,
  `stock` int(11) NOT NULL,
  `cost` int(11) NOT NULL,
  `desc_path` text,
  `phot_path` longblob
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `PRODUCT`
--

INSERT INTO `PRODUCT` (`itemID`, `name`, `genre`, `stock`, `cost`, `desc_path`, `phot_path`) VALUES
(0, 'Please Please Me LP', 'vinyl', 14, 25, 'The Fab Fours debut LP on 180 gram vinyl', NULL),
(1, 'Revolver LP', 'vinyl', 14, 25, 'Their landmark 1966 LP on 180 gram vinyl', NULL),
(2, 'Sgt Peppers Lonely Hearts Club Band LP', 'vinyl', 10, 29, 'Their 1967 psychedelic masterpiece on 180 gram vinyl', NULL),
(3, 'The Beatles LP', 'vinyl', 5, 50, 'The groups sprawling and eclectic 1968 double album', NULL),
(4, 'Abbey Road LP', 'vinyl', 12, 30, 'The groups last album to be recorded on premium heavyweight vinyl', NULL),
(5, 'A Hard Days Night', 'vinyl', 13, 25, 'Their 1964 classic from the film of the same name', NULL),
(6, 'Rubber Soul CD', 'cd', 3, 9, 'Their 1965 album digitally remastered', NULL),
(7, 'With The Beatles CD', 'cd', 6, 9, 'The groups sophomore effort digitally remastered', NULL),
(8, 'Anthology 1 CD', 'cd', 1, 20, 'Outtakes and bootlegged material across 2 discs', NULL),
(9, 'Let It Be Naked CD', 'cd', 6, 12, 'Alternate version of Let It Be sans Phil Spectors orchestrations', NULL),
(10, '1 CD', 'cd', 12, 15, 'The 2003 compilation of their #1 hits!', NULL),
(11, 'Love CD', 'cd', 7, 12, 'The George Martin led remix album for the Cirque du Soleil show of the same name', NULL),
(12, 'T shirt', 'apparel', 23, 20, 'T shirt one size fits all', NULL),
(13, 'Sweatshirt', 'apparel', 7, 30, 'Sweatshirt one size fits all', NULL),
(14, 'Hat', 'apparel', 5, 20, 'Baseball style hat fully adjustable', NULL),
(15, 'Varsity Jacket', 'apparel', 2, 50, 'Varsity jacket with Beatles logo one size fits all', NULL),
(16, 'Scarf', 'apparel', 1, 7, 'Beatles logo scarf', NULL),
(17, 'Socks', 'apparel', 0, 5, 'Beatles socks set of 3', NULL),
(18, 'Shea Stadium Poster', 'poster', 3, 25, 'Mounted facsimile of the groups Shea Stadium poster', NULL),
(19, 'Hollywood Bowl Poster', 'poster', 2, 25, 'Mounted facsimile of the groups Hollywood Bowl poster', NULL),
(20, 'Help Poster', 'poster', 3, 25, 'Mounted facsimile of the Help film poster', NULL),
(21, 'Psychedelic Poster', 'poster', 3, 25, 'The Fab Four in a psychedelic swirl design', NULL),
(22, 'Abbey Road Walking Poster', 'poster', 3, 25, 'Mounted poster of the iconic album cover', NULL),
(23, 'Let It Be Movie Poster', 'poster', 3, 25, 'Mounted facsimile of the Let It Be film poster', NULL),
(24, 'Keychain', 'misc', 4, 8, 'Beatles keychain', NULL),
(25, 'Sticker lot', 'misc', 2, 15, 'Lot of Beatles related stickers', NULL),
(26, 'Coffee Mug', 'misc', 3, 9, 'Beatles themed coffee mug', NULL),
(27, 'Lunchbox', 'misc', 1, 10, 'Vintage style hard lunch box', NULL),
(28, 'Pin', 'misc', 18, 1, 'Beatles pin', NULL),
(29, 'Penny Lane sign', 'misc', 5, 13, 'Faux Penny Lane street sign', NULL),
(30, 'Strawberry Fields Sign', 'misc', 5, 13, 'Faux Strawberry Fields street sign', NULL),
(31, 'Beatles CD box set', 'cd', 2, 100, 'Box set of their complete discography', NULL),
(32, 'Mono CD box set', 'cd', 2, 80, 'Box set of all their albums originally released in mono', NULL),
(33, 'Rubber Soul LP', 'vinyl', 3, 29, '1965 release', ''),
(34, 'Red Album 1962 1966', 'vinyl', 10, 40, 'Iconic 1973 compilation', ''),
(35, 'Let It Be', 'vinyl', 25, 30, 'Final album', '');

-- --------------------------------------------------------

--
-- Table structure for table `STAFF`
--

CREATE TABLE `STAFF` (
  `username` varchar(255) NOT NULL,
  `passcode` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `f_name` varchar(255) NOT NULL,
  `l_name` varchar(255) NOT NULL,
  `staff_group` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `STAFF`
--

INSERT INTO `STAFF` (`username`, `passcode`, `email`, `f_name`, `l_name`, `staff_group`) VALUES
('', '', '', '', '', ''),
('quietbeatle1', '$2y$10$kJxdqrfHya7sP2WvlB/Brem1eQ9JkjnjNCE/kjhhZAW7p4YmNZsgq', 'whilemyguitargentlyweeps@gmail.com', 'George', 'Harrington', 'employee'),
('revolution9', '$2y$10$84J301g5gLd96syBMg/Is.VAFkseMirXBmKk2ueGQB6l7qIM18ok.', 'john40@gmail.com', 'John', 'Lemon', 'admin'),
('paul64', '$2y$10$NFZVyR.MSoychJiAJpgiR.RqLXwy6lPc4Jg1yZ86aWyJGwXpusxya', 'paul64@gmail.com', 'Paul', 'McArty', 'owner');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `CART`
--
ALTER TABLE `CART`
  ADD PRIMARY KEY (`cartID`,`customerID`),
  ADD KEY `customerID` (`customerID`);

--
-- Indexes for table `CUSTOMER`
--
ALTER TABLE `CUSTOMER`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `HAS_ORDER`
--
ALTER TABLE `HAS_ORDER`
  ADD PRIMARY KEY (`orderID`,`customerID`,`employeeID`),
  ADD KEY `customerID` (`customerID`),
  ADD KEY `employeeID` (`employeeID`);

--
-- Indexes for table `IN_CART`
--
ALTER TABLE `IN_CART`
  ADD PRIMARY KEY (`orderID`,`itemID`),
  ADD KEY `itemID` (`itemID`);

--
-- Indexes for table `IN_ORDER`
--
ALTER TABLE `IN_ORDER`
  ADD PRIMARY KEY (`orderID`,`itemID`),
  ADD KEY `itemID` (`itemID`);

--
-- Indexes for table `MANAGES`
--
ALTER TABLE `MANAGES`
  ADD PRIMARY KEY (`managerID`,`userID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `ORDERS`
--
ALTER TABLE `ORDERS`
  ADD PRIMARY KEY (`orderID`);

--
-- Indexes for table `STAFF`
--
ALTER TABLE `STAFF`
  ADD PRIMARY KEY (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
