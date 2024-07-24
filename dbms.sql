-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 18, 2024 at 02:01 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbms`
--

-- --------------------------------------------------------

--
-- Table structure for table `auction`
--

CREATE TABLE `auction` (
  `auction_id` int(11) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `max_price` decimal(10,0) DEFAULT NULL,
  `p_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `auction`
--

INSERT INTO `auction` (`auction_id`, `start_date`, `end_date`, `max_price`, `p_id`) VALUES
(1, '2024-05-18 12:47:00', '2024-05-18 13:00:00', NULL, 1),
(2, '2024-05-18 13:12:00', '2024-05-18 15:15:00', 2000, 2),
(3, '2024-05-18 16:48:00', '2024-05-19 16:48:00', NULL, 5),
(4, '2024-05-18 17:06:00', '2024-05-19 17:06:00', NULL, 6);

-- --------------------------------------------------------

--
-- Table structure for table `bids`
--

CREATE TABLE `bids` (
  `id` int(11) NOT NULL,
  `bid_amount` decimal(10,2) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `auction_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bids`
--

INSERT INTO `bids` (`id`, `bid_amount`, `timestamp`, `auction_id`, `user_id`) VALUES
(10, 2500.00, '2024-05-18 10:46:02', NULL, NULL),
(11, 2500.00, '2024-05-18 10:46:43', NULL, 1),
(12, 250.00, '2024-05-18 10:47:15', NULL, 1),
(13, 250.00, '2024-05-18 10:47:42', NULL, 1),
(14, 2500.00, '2024-05-18 11:06:55', 0, 1),
(15, 2500.00, '2024-05-18 11:08:23', 0, NULL),
(16, 2000.00, '2024-05-18 11:23:05', 0, NULL),
(17, 2000.00, '2024-05-18 11:25:52', 0, 1),
(18, 2000.00, '2024-05-18 11:27:02', 0, 1),
(19, 2000.00, '2024-05-18 11:31:41', 0, 1),
(20, 20000.00, '2024-05-18 11:38:13', 0, 1),
(21, 2000.00, '2024-05-18 11:39:35', 0, 1),
(22, 2000.00, '2024-05-18 11:40:27', 0, 1),
(23, 2000.00, '2024-05-18 11:40:29', 0, 1),
(24, 2000.00, '2024-05-18 11:44:36', 0, 1),
(25, 20000.00, '2024-05-18 11:45:01', 0, 1),
(26, 200.00, '2024-05-18 11:45:50', 0, 1),
(27, 2000.00, '2024-05-18 11:48:00', 0, 1),
(28, 2000.00, '2024-05-18 11:48:22', 0, 1),
(29, 2000.00, '2024-05-18 11:48:25', 0, 1),
(30, 2000.00, '2024-05-18 11:52:38', 0, 1),
(31, 2000.00, '2024-05-18 11:56:18', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `p_id` int(11) NOT NULL,
  `p_name` varchar(100) NOT NULL,
  `p_image` longblob DEFAULT NULL,
  `p_desc` text NOT NULL,
  `p_price` decimal(10,0) NOT NULL,
  `p_category` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `reg_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`p_id`, `p_name`, `p_image`, `p_desc`, `p_price`, `p_category`, `user_id`, `reg_date`) VALUES
(1, 'mobile phone', NULL, 'dfasf', 5000, 'electronics', 1, '2024-05-18'),
(2, 'mobile phone', '', 'Galaxy J7', 5000, 'electronics', 1, '2024-05-18'),
(3, 'mobile phone', NULL, 'android', 5000, 'electronics', 1, '2024-05-18'),
(6, 'Chain', '', 'Gold', 10000, 'jewel', 1, '2024-05-18');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `full_name`, `email`, `password`) VALUES
(1, 'kiruthika', 'kiruthikasermadurai1234@gmail.com', '$2y$10$LqEPgSXmolJXDdMfqDZMy.vxQEIYnSA3l349PRAgESw5CVQtSjyPW');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auction`
--
ALTER TABLE `auction`
  ADD PRIMARY KEY (`auction_id`);

--
-- Indexes for table `bids`
--
ALTER TABLE `bids`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`p_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `auction`
--
ALTER TABLE `auction`
  MODIFY `auction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `bids`
--
ALTER TABLE `bids`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
