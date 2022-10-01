-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 01, 2022 at 11:29 PM
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

CREATE TABLE `Calendar` (
                            `TableID` int(50) DEFAULT NULL,
                            `UID` varchar(50) DEFAULT NULL,
                            `Date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `Table`
--

CREATE TABLE `Table` (
                         `TableID` int(50) DEFAULT NULL,
                         `F_updown` tinyint(1) DEFAULT NULL,
                         `F_monitor` enum('one','two') DEFAULT NULL,
                         `F_vr_setup` tinyint(1) DEFAULT NULL,
                         `Floor` int(50) DEFAULT NULL,
                         `Section` int(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE `User` (
                        `UID` int(50) DEFAULT NULL,
                        `Password` varchar(100) DEFAULT NULL,
                        `Name` varchar(100) DEFAULT NULL,
                        `UserType` enum('Admin','Regular') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
