-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 02, 2022 at 01:49 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ShareTable`
--

-- --------------------------------------------------------

--
-- Table structure for table `Calendar`
--

CREATE TABLE `Calendar` (
                            `TableID` int(50) NOT NULL,
                            `UID` varchar(50) NOT NULL,
                            `Date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `Table`
--

CREATE TABLE `Table` (
                         `TableID` int(50) NOT NULL,
                         `F_updown` tinyint(1) DEFAULT NULL,
                         `F_monitor` enum('one','two') DEFAULT NULL,
                         `F_vr_setup` tinyint(1) DEFAULT NULL,
                         `Floor` int(50) NOT NULL,
                         `Section` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE `User` (
                        `UID` int(50) NOT NULL,
                        `Password` varchar(100) DEFAULT NULL,
                        `Name` varchar(100) DEFAULT NULL,
                        `UserType` enum('Admin','Regular') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`UID`, `Password`, `Name`, `UserType`) VALUES
                                                               (1, '111222', 'Annie', 'Admin'),
                                                               (2, '111222', 'Tina', 'Regular');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Calendar`
--
ALTER TABLE `Calendar`
    ADD PRIMARY KEY (`TableID`,`UID`,`Date`),
    ADD KEY `UID` (`UID`),
    ADD KEY `TableID` (`TableID`);

--
-- Indexes for table `Table`
--
ALTER TABLE `Table`
    ADD PRIMARY KEY (`TableID`,`Floor`,`Section`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
    ADD PRIMARY KEY (`UID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
