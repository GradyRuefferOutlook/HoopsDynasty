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
-- Table structure for table `getTeam`
--

CREATE TABLE `getTeam` (
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
-- Dumping data for table `getTeam`
--

INSERT INTO `getTeam` (`player_ID`, `player_name`, `player_position`, `player_team`, `three_point_percentage`, `two_point_percentage`, `free_throw_percentage`, `blocks_per_game`, `steals_per_game`, `personal_fouls_per_game`) VALUES
(1, 'Stephen Curry', 'Point Guard', 'Warriors', 42.80, 54.30, 91.10, 0.3, 1.7, 1.8),
(2, 'LeBron James', 'Small Forward', 'Lakers', 35.50, 58.20, 76.30, 0.8, 1.2, 2.0),
(3, 'Giannis Antetokounmpo', 'Power Forward', 'Bucks', 28.60, 62.50, 71.20, 1.4, 1.1, 3.3),
(4, 'Joel Embiid', 'Center', '76ers', 31.20, 57.90, 84.20, 1.9, 1.0, 3.6),
(5, 'Klay Thompson', 'Shooting Guard', 'Warriors', 39.40, 51.60, 85.90, 0.5, 1.4, 2.3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `getTeam`
--
ALTER TABLE `getTeam`
  ADD PRIMARY KEY (`player_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `getTeam`
--
ALTER TABLE `getTeam`
  MODIFY `player_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
