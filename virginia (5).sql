-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 25, 2018 at 10:50 AM
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
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `admin_username` varchar(225) NOT NULL,
  `admin_password` varchar(225) NOT NULL,
  `admin_firstname` varchar(225) NOT NULL,
  `admin_lastname` varchar(224) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_username`, `admin_password`, `admin_firstname`, `admin_lastname`) VALUES
(1, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'Angelo', 'Ganaden');

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

--
-- Dumping data for table `billing`
--

INSERT INTO `billing` (`billing_id`, `billing_price`, `billing_name`, `billing_quantity`, `reservation_key`) VALUES
(1, 7160, 'Reservation Fee', 1, '5B74CAE48077C'),
(2, 7160, 'Reservation Fee', 1, '5B74CAE5E2454'),
(3, 1630, 'Reservation Fee', 1, '5B81150B91A39');

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

--
-- Dumping data for table `guest`
--

INSERT INTO `guest` (`guest_id`, `guest_firstname`, `guest_lastname`, `guest_gender`, `guest_phone`, `guest_address`, `guest_email`) VALUES
(1, 'Trial', 'Trial', 'male', 12312312312, '123123', 'aefa@gmail.com'),
(2, 'Trial', 'Trial', 'male', 12312312312, '123123', 'aefa@gmail.com'),
(3, 'Angelo', 'Ganaden', 'male', 12312312312, 'HAHAH', 'angelojrganaden@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `moderator`
--

CREATE TABLE `moderator` (
  `moderator_id` int(11) NOT NULL,
  `moderator_username` varchar(225) NOT NULL,
  `moderator_password` varchar(225) NOT NULL,
  `moderator_firstname` varchar(225) NOT NULL,
  `moderator_lastname` varchar(225) NOT NULL,
  `moderator_status` tinyint(4) NOT NULL,
  `moderator_created_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `moderator`
--

INSERT INTO `moderator` (`moderator_id`, `moderator_username`, `moderator_password`, `moderator_firstname`, `moderator_lastname`, `moderator_status`, `moderator_created_at`) VALUES
(1, 'aeganaden', '601f1889667efaebb33b8c12572835da3f027f78', 'Angelo', 'Ganaden', 1, 1534380738);

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

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`reservation_id`, `reservation_in`, `reservation_out`, `reservation_adult`, `reservation_child`, `reservation_roomCount`, `reservation_day_type`, `reservation_status`, `reservation_key`, `reservation_reserved_at`, `reservation_updated_at`, `reservation_payment_status`, `reservation_payment_photo`, `reservation_requests`, `guest_id`, `room_type_id`) VALUES
(1, 1534464000, 1534496400, 1, 0, 1, 1, 5, '5B74CAE48077C', 1534380772, 1534380772, 1, '', '', 1, 1),
(2, 1534464000, 1534496400, 1, 0, 1, 1, 5, '5B74CAE48077C', 1534380772, 1534380772, 1, '', '', 1, 2),
(3, 1534464000, 1534496400, 1, 0, 1, 1, 1, '5B74CAE5E2454', 1534380773, 1534380773, 1, '', '', 2, 1),
(4, 1534464000, 1534496400, 1, 0, 1, 1, 1, '5B74CAE5E2454', 1534380774, 1534380774, 1, '', '', 2, 2),
(5, 1535155200, 1535187600, 1, 1, 1, 1, 2, '5B81150B91A39', 1535186187, 1535186363, 1, 'Capture.PNG', '', 3, 1),
(6, 1535155200, 1535187600, 1, 1, 0, 1, 2, '5B81150B91A39', 1535186187, 1535186363, 1, 'Capture.PNG', '', 3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `room_id` int(11) NOT NULL,
  `room_name` varchar(100) NOT NULL,
  `room_status` int(11) NOT NULL,
  `room_type_id` int(11) NOT NULL,
  `reservation_key` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`room_id`, `room_name`, `room_status`, `room_type_id`, `reservation_key`) VALUES
(1, 'S01', 1, 1, '5B6D6B3164726'),
(2, 'S02', 2, 1, ''),
(3, 'S03', 3, 1, ''),
(4, 'S04', 1, 1, '5B6D6BB40852B'),
(5, 'S05', 1, 1, '5B6D6C9EA215E'),
(6, 'S06', 1, 1, '5B74CAE5E2454'),
(7, 'S07', 3, 1, ''),
(8, 'S08', 3, 1, ''),
(9, 'S09', 3, 1, ''),
(10, 'D01', 1, 2, '5B6D6B3164726'),
(11, 'D02', 1, 2, '5B6D6BB40852B'),
(12, 'D03', 1, 2, '5B6D6C9EA215E'),
(13, 'D04', 3, 2, ''),
(14, 'D05', 1, 2, '5B74CAE5E2454'),
(15, 'D06', 3, 2, ''),
(16, 'D07', 3, 2, ''),
(17, 'D08', 3, 2, ''),
(18, 'D09', 3, 2, ''),
(19, 'D10', 3, 2, ''),
(20, 'D11', 3, 2, ''),
(21, 'D12', 3, 2, ''),
(22, 'D13', 3, 2, ''),
(23, 'D14', 3, 2, ''),
(24, 'D15', 3, 2, ''),
(25, 'D16', 3, 2, ''),
(27, 'S10', 3, 1, ''),
(28, 'S11', 3, 1, ''),
(29, 'S12', 3, 1, ''),
(30, 'S13', 3, 1, ''),
(31, 'D17', 3, 2, ''),
(32, 'S14', 3, 1, ''),
(33, 'S15', 3, 1, '');

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
(1, 'Standard Room', 'This room is fully airconditioned room with television and a best fit for 2 person!', 2, 'room1.jpg', 1500),
(2, 'Double Bedroom', 'This room is a fully airconditioned room with television and best fit for 4 person!!', 4, 'room2.jpg', 2000);

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
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

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
-- Indexes for table `moderator`
--
ALTER TABLE `moderator`
  ADD PRIMARY KEY (`moderator_id`);

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
  ADD KEY `fk_room_room_type1_idx` (`room_type_id`);

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
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `billing`
--
ALTER TABLE `billing`
  MODIFY `billing_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `guest`
--
ALTER TABLE `guest`
  MODIFY `guest_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `moderator`
--
ALTER TABLE `moderator`
  MODIFY `moderator_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

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
  ADD CONSTRAINT `fk_room_room_type1` FOREIGN KEY (`room_type_id`) REFERENCES `room_type` (`room_type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
