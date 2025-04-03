-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 03, 2025 at 08:42 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `johnd6_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `getOpponent`
--

CREATE TABLE `getOpponent` (
  `player_ID` int(11) NOT NULL,
  `player_name` varchar(100) NOT NULL,
  `player_position` enum('Center','Power Forward','Small Forward','Point Guard','Shooting Guard') NOT NULL,
  `player_team` varchar(100) NOT NULL,
  `three_point_percentage` decimal(5,2) DEFAULT NULL CHECK (`three_point_percentage` between 0 and 100),
  `two_point_percentage` decimal(5,2) DEFAULT NULL CHECK (`two_point_percentage` between 0 and 100),
  `free_throw_percentage` decimal(5,2) DEFAULT NULL CHECK (`free_throw_percentage` between 0 and 100),
  `blocks_per_game` decimal(3,1) DEFAULT NULL,
  `steals_per_game` decimal(3,1) DEFAULT NULL,
  `personal_fouls_per_game` decimal(3,1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `getOpponent`
--

INSERT INTO `getOpponent` (`player_ID`, `player_name`, `player_position`, `player_team`, `three_point_percentage`, `two_point_percentage`, `free_throw_percentage`, `blocks_per_game`, `steals_per_game`, `personal_fouls_per_game`) VALUES
(1, 'Kevin Durant', 'Small Forward', 'Suns', 38.20, 55.10, 88.50, 0.7, 1.3, 2.2),
(2, 'Luka Dončić', 'Point Guard', 'Mavericks', 35.60, 53.70, 77.90, 0.4, 1.5, 2.6),
(3, 'Jayson Tatum', 'Power Forward', 'Celtics', 36.40, 56.80, 82.70, 0.9, 1.2, 3.0),
(4, 'Nikola Jokić', 'Center', 'Nuggets', 33.80, 60.20, 83.90, 1.1, 1.1, 3.1),
(5, 'Devin Booker', 'Shooting Guard', 'Suns', 37.70, 49.50, 86.40, 0.3, 1.6, 2.5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `getOpponent`
--
ALTER TABLE `getOpponent`
  ADD PRIMARY KEY (`player_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `getOpponent`
--
ALTER TABLE `getOpponent`
  MODIFY `player_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
