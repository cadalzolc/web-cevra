-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 18, 2022 at 02:02 AM
-- Server version: 10.5.12-MariaDB-cll-lve
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u485374257_cevra`
--

DELIMITER $$
--
-- Procedures
--
$$

$$

$$

$$

$$

$$

$$

$$

$$

$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `account_type_id` int(11) DEFAULT 0,
  `email` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `password` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `first_name` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `last_name` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `name` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `last_login` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `status` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `account_type_id`, `email`, `password`, `first_name`, `last_name`, `name`, `last_login`, `status`) VALUES
(1, 2, 'niftyers@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', '', '', 'HONEYMOON CASTLE', '2022-12-13 15:00:46', 'NEW');

-- --------------------------------------------------------

--
-- Table structure for table `accounts_type`
--

CREATE TABLE `accounts_type` (
  `id` int(11) NOT NULL,
  `name` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accounts_type`
--

INSERT INTO `accounts_type` (`id`, `name`) VALUES
(1, 'CUSTOMER'),
(2, 'BUSINESS');

-- --------------------------------------------------------

--
-- Table structure for table `listings`
--

CREATE TABLE `listings` (
  `id` int(11) NOT NULL,
  `account_id` int(11) DEFAULT 0,
  `name` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `description` varchar(3000) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `subinfo` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `rates` decimal(10,2) DEFAULT 0.00,
  `photo` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `status` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `book_date` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `listings`
--

INSERT INTO `listings` (`id`, `account_id`, `name`, `description`, `subinfo`, `rates`, `photo`, `status`, `book_date`) VALUES
(1, 1, 'Wedding Ceremonial', 'If your dream is to celebrate in its cool ambiance and natural charms, then you have visited the right page.', 'Wedding', '5000.00', 'FAA60B84-B599-D7FC-84CD-994178121D6C.jpg', 'NEW', ''),
(2, 1, 'Birthday Rockwell', 'The venue or events place for your upcoming kiddie party will have an effect on such matters as the theme, the logistics, the suppliers (some venues only allow a certain set of suppliers), the caterer, and ultimately, the costing or fee for styling the event.', 'Birthday', '1500.00', '641710C3-4E91-339B-3F1D-2421EDDDA625.jpg', 'NEW', '');

-- --------------------------------------------------------

--
-- Table structure for table `listings_photo`
--

CREATE TABLE `listings_photo` (
  `id` int(11) NOT NULL,
  `listing_id` int(11) DEFAULT 0,
  `listing_order` int(11) DEFAULT 0,
  `photo` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `listings_photo`
--

INSERT INTO `listings_photo` (`id`, `listing_id`, `listing_order`, `photo`) VALUES
(1, 1, 1, 'FAA60B84-B599-D7FC-84CD-994178121D6C.jpg'),
(2, 1, 2, 'C85953FE-B187-8B2D-0FBA-2D519573F898.jpg'),
(3, 1, 3, '223818DD-1C68-E06E-8922-4138FD6E5F70.jpg'),
(4, 1, 4, 'F169E450-2A64-DFE3-BFDE-815B838DFAE7.jpg'),
(5, 2, 1, '641710C3-4E91-339B-3F1D-2421EDDDA625.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `name` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `name`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7),
(8, 8),
(9, 9),
(10, 10),
(11, 11),
(12, 12),
(13, 13),
(14, 14),
(15, 15),
(16, 16),
(17, 17),
(18, 18),
(19, 19),
(20, 20);

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `listing_id` int(11) DEFAULT 0,
  `customer_id` int(11) DEFAULT 0,
  `booking_date` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `amount` decimal(10,2) DEFAULT 0.00,
  `status` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `payment_ref` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(45) DEFAULT '',
  `password` varchar(45) DEFAULT '',
  `name` varchar(45) DEFAULT '',
  `last_login` varchar(30) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `name`, `last_login`) VALUES
(1, 'cevra', '123456', 'Administrator', '2022-12-10 06:09:06');

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_listing`
-- (See below for the actual view)
--
CREATE TABLE `vw_listing` (
`id` int(11)
,`account_id` int(11)
,`account_name` varchar(45)
,`name` varchar(300)
,`description` varchar(3000)
,`subinfo` varchar(300)
,`rates` decimal(10,2)
,`photo` varchar(1000)
,`status` varchar(45)
,`book_date` varchar(45)
);

-- --------------------------------------------------------

--
-- Structure for view `vw_listing`
--
DROP TABLE IF EXISTS `vw_listing`;

CREATE VIEW `vw_listing`  AS SELECT `l`.`id` AS `id`, `l`.`account_id` AS `account_id`, `a`.`name` AS `account_name`, `l`.`name` AS `name`, `l`.`description` AS `description`, `l`.`subinfo` AS `subinfo`, `l`.`rates` AS `rates`, `l`.`photo` AS `photo`, `l`.`status` AS `status`, `l`.`book_date` AS `book_date` FROM (`listings` `l` left join `accounts` `a` on(`a`.`id` = `l`.`account_id`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `accounts_type`
--
ALTER TABLE `accounts_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `listings`
--
ALTER TABLE `listings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `listings_photo`
--
ALTER TABLE `listings_photo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `accounts_type`
--
ALTER TABLE `accounts_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `listings`
--
ALTER TABLE `listings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `listings_photo`
--
ALTER TABLE `listings_photo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
