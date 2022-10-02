-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 02, 2022 at 04:24 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

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
DROP TABLE IF EXISTS `Calendar`;
DROP TABLE IF EXISTS `User`;
DROP TABLE IF EXISTS `Table`;


CREATE TABLE `Calendar` (
                            `TableID` int(50) DEFAULT NULL,
                            `UID` varchar(50) DEFAULT NULL,
                            `DateStart` datetime DEFAULT NULL,
                            `DateFinish` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Calendar`
--

INSERT INTO `Calendar` (`TableID`, `UID`, `DateStart`, `DateFinish`) VALUES
                                                                         (11, '1', '2022-10-01 09:00:00', '2022-10-17 17:00:00'),
                                                                         (25, '2', '2022-10-05 19:20:01', '2022-10-31 19:20:01'),
                                                                         (36, '44', '2025-11-01 19:20:18', NULL),
                                                                         (36, '5', '2022-10-20 19:20:42', '2022-10-21 19:20:42'),
                                                                         (44, '44', '2022-10-27 19:21:03', '2022-10-29 19:21:03'),
                                                                         (36, '5', '2022-10-07 10:22:02', '2022-10-07 19:22:02');

-- --------------------------------------------------------

--
-- Table structure for table `Table`
--

CREATE TABLE `Table` (
                         `TableID` int(50) NOT NULL,
                         `F_updown` enum('Yes','No') DEFAULT NULL,
                         `F_monitor` enum('one','two') DEFAULT NULL,
                         `F_vr_setup` enum('Yes','No') DEFAULT NULL,
                         `Floor` int(50) NOT NULL,
                         `Section` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Table`
--

INSERT INTO `Table` (`TableID`, `F_updown`, `F_monitor`, `F_vr_setup`, `Floor`, `Section`) VALUES
                                                                                               (11, 'Yes', 'two', NULL, 2, 5),
                                                                                               (12, NULL, NULL, NULL, 2, 9),
                                                                                               (13, 'No', 'one', 'No', 1, 4),
                                                                                               (23, 'Yes', NULL, 'Yes', 3, 8),
                                                                                               (25, 'No', 'two', 'Yes', 3, 9),
                                                                                               (34, 'No', NULL, 'Yes', 3, 4),
                                                                                               (36, 'Yes', 'two', NULL, 2, 4),
                                                                                               (44, 'No', 'one', 'Yes', 2, 5);

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
                                                               (2, '111222', 'Tina', 'Regular'),
                                                               (5, '111222', 'Luna', 'Admin'),
                                                               (44, '111222', 'Jason', 'Regular');


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

--
-- Indexes for table Calendar
--
ALTER TABLE Calendar
    ADD PRIMARY KEY (TableID,UID, DateStart, DateFinish),
    ADD KEY UID (UID),
    ADD KEY TableID (TableID);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;