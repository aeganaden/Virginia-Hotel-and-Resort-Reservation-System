-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 03, 2018 at 04:16 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `virginia`
--

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `room_id` int(11) NOT NULL,
  `room_name` varchar(100) NOT NULL,
  `room_status` int(11) NOT NULL,
  `room_type_id` int(11) NOT NULL,
  `reservation_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`room_id`, `room_name`, `room_status`, `room_type_id`, `reservation_id`) VALUES
(1, 'S01', 3, 1, NULL),
(2, 'S02', 3, 1, NULL),
(3, 'S03', 3, 1, NULL),
(4, 'S04', 3, 1, NULL),
(5, 'S05', 3, 1, NULL),
(6, 'S06', 3, 1, NULL),
(7, 'S07', 3, 1, NULL),
(8, 'S08', 3, 1, NULL),
(9, 'S09', 3, 1, NULL),
(10, 'D01', 3, 2, NULL),
(11, 'D02', 3, 2, NULL),
(12, 'D03', 3, 2, NULL),
(13, 'D04', 3, 2, NULL),
(14, 'D05', 3, 2, NULL),
(15, 'D06', 3, 2, NULL),
(16, 'D07', 3, 2, NULL),
(17, 'D08', 3, 2, NULL),
(18, 'D09', 3, 2, NULL),
(19, 'D10', 3, 2, NULL),
(20, 'D11', 3, 2, NULL),
(21, 'D12', 3, 2, NULL),
(22, 'D13', 3, 2, NULL),
(23, 'D14', 3, 2, NULL),
(24, 'D15', 3, 2, NULL),
(25, 'D16', 3, 2, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`room_id`),
  ADD KEY `fk_room_room_type1_idx` (`room_type_id`),
  ADD KEY `fk_room_reservation1_idx` (`reservation_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `room`
--
ALTER TABLE `room`
  ADD CONSTRAINT `fk_room_reservation1` FOREIGN KEY (`reservation_id`) REFERENCES `reservation` (`reservation_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_room_room_type1` FOREIGN KEY (`room_type_id`) REFERENCES `room_type` (`room_type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
