-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 06, 2020 at 08:38 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `player_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `id` int(11) NOT NULL,
  `country_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`id`, `country_name`) VALUES
(1, 'Spain'),
(2, 'England');

-- --------------------------------------------------------

--
-- Table structure for table `player`
--

CREATE TABLE `player` (
  `id` int(11) NOT NULL,
  `player_name` varchar(100) NOT NULL,
  `age` int(11) NOT NULL,
  `salary` decimal(15,2) NOT NULL,
  `team_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `player`
--

INSERT INTO `player` (`id`, `player_name`, `age`, `salary`, `team_id`, `country_id`) VALUES
(1, 'Lionel Messi', 33, '2500000.00', 1, 1),
(2, 'De Jong', 22, '60000.00', 1, 1),
(3, 'David Silva', 33, '70000.00', 2, 2),
(4, 'De Bruyne', 28, '90000.00', 2, 2),
(6, 'Gerrard Pique', 33, '220000.00', 1, 1),
(7, 'Sergi Roberto', 28, '130000.00', 1, 1),
(8, 'Ederson Moraes', 26, '87000.00', 2, 2),
(9, 'Kyle Walker', 29, '130000.00', 2, 2),
(10, 'Sergio Busquets', 32, '210000.00', 1, 1),
(12, 'Sergio Aguero', 32, '234000.00', 2, 2),
(13, 'Jordi Alba', 29, '123000.00', 1, 1),
(18, 'Raheem Sterling', 23, '42000.00', 2, 2),
(19, 'Dembele', 23, '100000.00', 1, 1),
(25, 'Ter Stegen', 28, '79000.00', 1, 1),
(26, 'Clement Lenglet', 24, '120000.00', 1, 1),
(27, 'Rafinha', 27, '25800.00', 1, 1),
(28, 'John Stone', 26, '160000.00', 2, 2),
(29, 'Laporte', 23, '110000.00', 2, 2),
(31, 'Mahrez', 26, '210000.00', 2, 2),
(32, 'Gabriel Jesus', 22, '168000.00', 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `id` int(11) NOT NULL,
  `team_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`id`, `team_name`) VALUES
(1, 'Barcelona'),
(2, 'Manchester City');

-- --------------------------------------------------------

--
-- Table structure for table `transfer_history`
--

CREATE TABLE `transfer_history` (
  `id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `from_team_id` int(11) NOT NULL,
  `to_team_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `transfer_fee` decimal(20,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transfer_history`
--

INSERT INTO `transfer_history` (`id`, `player_id`, `from_team_id`, `to_team_id`, `date`, `transfer_fee`) VALUES
(5, 8, 2, 1, '2020-08-02 09:25:00', '50000000.00'),
(7, 7, 1, 2, '2020-08-02 15:05:53', '70000000.00'),
(8, 7, 2, 1, '2020-08-03 08:36:40', '30000000.00'),
(9, 1, 1, 2, '2020-08-03 15:07:21', '400000000.00'),
(10, 1, 2, 1, '2020-08-03 15:09:04', '45000000.00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'zeyarnaing', '$2y$10$80oq0GHOlWjDD3REkYxlGuuuk4/zeRLhGWdfaycfvBrrogKEPimK6', '2020-08-03'),
(2, 'thanzawmyint', '$2y$10$LKCz0UFJF4hd9jYApkPQjejEC0JyhF/Yd4ciCLsP4kWqXFdmThWXu', '2020-08-03'),
(3, 'pyae', '$2y$10$AYdYIkoCMdMnmDnNv3xpEOESa5iyHLvgfseq2BtPXj9VSUI4EOFsq', '2020-08-04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `player`
--
ALTER TABLE `player`
  ADD PRIMARY KEY (`id`),
  ADD KEY `team_constraint` (`team_id`),
  ADD KEY `country_constraint` (`country_id`);

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transfer_history`
--
ALTER TABLE `transfer_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `player_constraint` (`player_id`),
  ADD KEY `from_team_constraint` (`from_team_id`),
  ADD KEY `to_team_constraint` (`to_team_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `player`
--
ALTER TABLE `player`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transfer_history`
--
ALTER TABLE `transfer_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `player`
--
ALTER TABLE `player`
  ADD CONSTRAINT `country_constraint` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`),
  ADD CONSTRAINT `team_constraint` FOREIGN KEY (`team_id`) REFERENCES `team` (`id`);

--
-- Constraints for table `transfer_history`
--
ALTER TABLE `transfer_history`
  ADD CONSTRAINT `from_team_constraint` FOREIGN KEY (`from_team_id`) REFERENCES `team` (`id`),
  ADD CONSTRAINT `player_constraint` FOREIGN KEY (`player_id`) REFERENCES `player` (`id`),
  ADD CONSTRAINT `to_team_constraint` FOREIGN KEY (`to_team_id`) REFERENCES `team` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
