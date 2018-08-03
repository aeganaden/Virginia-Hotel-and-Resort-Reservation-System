-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 03, 2018 at 04:33 PM
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
-- Table structure for table `billing`
--

CREATE TABLE `billing` (
  `billing_id` int(11) NOT NULL,
  `billing_price` bigint(11) NOT NULL,
  `billing_name` varchar(225) NOT NULL,
  `billing_quantity` bigint(11) NOT NULL,
  `reservation_key` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `guest`
--

CREATE TABLE `guest` (
  `guest_id` int(11) NOT NULL,
  `guest_firstname` varchar(45) NOT NULL,
  `guest_lastname` varchar(45) NOT NULL,
  `guest_gender` varchar(10) NOT NULL,
  `guest_phone` bigint(11) NOT NULL,
  `guest_address` text NOT NULL,
  `guest_email` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `reservation_id` int(11) NOT NULL,
  `reservation_in` bigint(11) NOT NULL,
  `reservation_out` bigint(11) NOT NULL,
  `reservation_adult` bigint(11) NOT NULL,
  `reservation_child` bigint(11) NOT NULL,
  `reservation_roomCount` bigint(11) NOT NULL,
  `reservation_day_type` bigint(11) NOT NULL,
  `reservation_status` bigint(11) NOT NULL,
  `reservation_key` varchar(255) NOT NULL,
  `reservation_reserved_at` bigint(15) NOT NULL,
  `reservation_updated_at` bigint(15) NOT NULL,
  `reservation_payment_status` tinyint(1) NOT NULL,
  `reservation_payment_photo` text NOT NULL,
  `reservation_requests` text,
  `guest_id` int(11) NOT NULL,
  `room_type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

-- --------------------------------------------------------

--
-- Table structure for table `room_type`
--

CREATE TABLE `room_type` (
  `room_type_id` int(11) NOT NULL,
  `room_type_name` varchar(255) NOT NULL,
  `room_type_description` text NOT NULL,
  `room_type_pax` int(10) NOT NULL,
  `room_type_image` varchar(225) NOT NULL,
  `room_type_price` bigint(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `room_type`
--

INSERT INTO `room_type` (`room_type_id`, `room_type_name`, `room_type_description`, `room_type_pax`, `room_type_image`, `room_type_price`) VALUES
(1, 'Standard Room', 'This room is fully airconditioned room with television and a best fit for 2 person.', 2, 'room1.jpg', 1500),
(2, 'Double Bedroom', 'This room is a fully airconditioned room with television and best fit for 4 person.', 4, 'room2.jpg', 2000);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `settings_id` int(11) NOT NULL,
  `settings_tax` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`settings_id`, `settings_tax`) VALUES
(1, 12);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `billing`
--
ALTER TABLE `billing`
  ADD PRIMARY KEY (`billing_id`);

--
-- Indexes for table `guest`
--
ALTER TABLE `guest`
  ADD PRIMARY KEY (`guest_id`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`reservation_id`),
  ADD KEY `fk_reservation_guest1_idx` (`guest_id`),
  ADD KEY `fk_reservation_room_type1_idx` (`room_type_id`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`room_id`),
  ADD KEY `fk_room_room_type1_idx` (`room_type_id`),
  ADD KEY `fk_room_reservation1_idx` (`reservation_id`);

--
-- Indexes for table `room_type`
--
ALTER TABLE `room_type`
  ADD PRIMARY KEY (`room_type_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`settings_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `billing`
--
ALTER TABLE `billing`
  MODIFY `billing_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `guest`
--
ALTER TABLE `guest`
  MODIFY `guest_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `room_type`
--
ALTER TABLE `room_type`
  MODIFY `room_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `settings_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `fk_reservation_guest1` FOREIGN KEY (`guest_id`) REFERENCES `guest` (`guest_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_reservation_room_type1` FOREIGN KEY (`room_type_id`) REFERENCES `room_type` (`room_type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

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
