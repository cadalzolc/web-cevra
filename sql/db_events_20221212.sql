-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 12, 2022 at 12:08 AM
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
-- Database: `db_events`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_account_create_business` (IN `p_email` VARCHAR(120), IN `p_password` VARCHAR(120), IN `p_name` VARCHAR(120))  BEGIN
	
    DECLARE p_id INT;
    
    IF EXISTS(SELECT email FROM accounts WHERE email = p_email) THEN BEGIN
  
		 SELECT CONCAT(p_email, ' is already in used.') as message, 0 as id, '' as name;
         
	END;
    ELSE BEGIN
		
        INSERT INTO accounts 
		(
			account_type_id, email, password, first_name, last_name, name, status
		)
		VALUES 
		(
			2, p_email, p_password, '', '', p_name, 'NEW'
		);
        
        SET p_id = LAST_INSERT_ID();
        SELECT '' as message, p_id as id, p_name as name;
        
    END;
    END IF;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_account_create_customer` (IN `p_email` VARCHAR(120), IN `p_password` VARCHAR(120), IN `p_first_name` VARCHAR(120), IN `p_last_name` VARCHAR(120))  BEGIN
	
    DECLARE p_id INT;
    DECLARE p_name VARCHAR(300);
    
    IF EXISTS(SELECT email FROM accounts WHERE email = p_email) THEN BEGIN
  
		 SELECT CONCAT(p_email, ' is already in used.') as message, 0 as id, '' as name;
         
	END;
    ELSE BEGIN
    
		SET p_name = CONCAT(UPPER(p_first_name), ' ', UPPER(p_last_name));
		
        INSERT INTO accounts 
		(
			account_type_id, email, password, first_name, last_name, name, status
		)
		VALUES 
		(
			1, p_email, p_password, p_first_name, p_last_name, p_name, 'NEW'
		);
        
        SET p_id = LAST_INSERT_ID();
        SELECT '' as message, p_id as id, p_name as name;
        
    END;
    END IF;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_listings_create` (IN `p_account_id` INT, IN `p_name` VARCHAR(300), IN `p_description` VARCHAR(3000), IN `p_info` VARCHAR(300), IN `p_rates` DECIMAL(10,2))  BEGIN

	DECLARE p_id INT;

	IF EXISTS(SELECT name FROM listings WHERE name = p_name) THEN BEGIN
		 SELECT CONCAT(p_name, ' is already in used.') as message, 0 as id;
	END;
    ELSE BEGIN
    
        INSERT INTO listings 
		(
			account_id, name, description, subinfo, rates, status
		)
		VALUES 
		(
			p_account_id, p_name, p_description, p_info, p_rates, 'NEW'
		);
        
        SET p_id = LAST_INSERT_ID();
        SELECT '' as message, p_id as id;
        
    END;
    END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_listings_photo_by_listing_id` (IN `p_id` INT)  BEGIN
	SELECT o.id AS orders, 
			(CASE ISNULL(lp.id) WHEN 1 THEN 0 ELSE lp.id END) AS id, 
			(CASE ISNULL(lp.photo) WHEN 1 THEN '' ELSE lp.photo END) AS photo FROM orders o
	LEFT OUTER JOIN 
	 (SELECT id, listing_order, photo FROM listings_photo WHERE listing_id = p_id) lp on lp.listing_order = o.id
    ORDER BY o.id ASC 
    LIMIT 5;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_listings_photo_id` (IN `p_order` INT, IN `p_venue` INT)  BEGIN
	DECLARE p_id INT;
    
    SET p_id = (SELECT id FROM listings_photo WHERE listing_id = p_venue AND listing_order = p_order);

	IF p_id IS NOT NULL THEN BEGIN
		SELECT * FROM listings_photo WHERE id = p_id;
	END;
    ELSE BEGIN
        INSERT INTO listings_photo (listing_id, listing_order, photo) VALUES (p_venue, p_order, '');
        SET p_id = LAST_INSERT_ID();
        SELECT '' as photo, p_id as id;
    END;
    END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_listings_photo_update` (IN `p_id` INT, IN `p_photo` VARCHAR(300))  BEGIN
	DECLARE p_venue INT;
    
    SET p_venue = (SELECT listing_id FROM listings_photo WHERE id = p_id AND listing_order =  1);
    
	UPDATE listings_photo SET photo = p_photo WHERE id = p_id;
    
    IF p_venue IS NOT NULL THEN
        UPDATE listings SET photo = p_photo WHERE id = p_venue;
    END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_listings_update` (IN `p_id` INT, IN `p_name` VARCHAR(300), IN `p_description` VARCHAR(3000), IN `p_info` VARCHAR(300), IN `p_rates` DECIMAL(10,2))  BEGIN
	IF EXISTS(SELECT name FROM listings WHERE name = p_name AND id <> p_id) THEN BEGIN
		 SELECT CONCAT(p_name, ' is already in used.') as message, p_id as id;
	END;
    ELSE BEGIN
		UPDATE 	listings
        SET		name = p_name, description = p_description, rates = p_rates, subinfo = p_info
        WHERE id = p_id;
        SELECT '' as message, p_id as id;
    END;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_login_admin` (IN `p_username` VARCHAR(100), IN `p_password` VARCHAR(30))  BEGIN

	DECLARE p_id INT;
	DECLARE p_date VARCHAR(45);
    
	SET p_date = DATE_FORMAT(now(),'%Y-%m-%d %H:%i:%s');
     
    SET p_id = (SELECT id FROM users WHERE username = p_username AND password = p_password );

	 IF p_id IS NOT NULL THEN
		UPDATE users SET last_login = p_date WHERE id = p_id;
		SELECT * FROM users WHERE id = p_id LIMIT 1;
     ELSE
		SELECT * FROM users WHERE id = 0 LIMIT 1;
     END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_login_business` (IN `p_email` VARCHAR(100), IN `p_password` VARCHAR(30))  BEGIN

	DECLARE p_id INT;
	DECLARE p_date VARCHAR(45);
    
	SET p_date = DATE_FORMAT(now(),'%Y-%m-%d %H:%i:%s');
     
    SET p_id = (SELECT id FROM accounts WHERE account_type_id = 2 AND email = p_email AND password = p_password );

	 IF p_id IS NOT NULL THEN
		UPDATE accounts SET last_login = p_date WHERE id = p_id;
		SELECT * FROM accounts WHERE id = p_id LIMIT 1;
     ELSE
		SELECT * FROM accounts WHERE id = 0 LIMIT 1;
     END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_login_customer` (IN `p_email` VARCHAR(100), IN `p_password` VARCHAR(30))  BEGIN

	DECLARE p_id INT;
	DECLARE p_date VARCHAR(45);
    
	SET p_date = DATE_FORMAT(now(),'%Y-%m-%d %H:%i:%s');
     
    SET p_id = (SELECT id FROM accounts WHERE account_type_id = 1 AND email = p_email AND password = p_password );

	 IF p_id IS NOT NULL THEN
		UPDATE accounts SET last_login = p_date WHERE id = p_id;
		SELECT * FROM accounts WHERE id = p_id LIMIT 1;
     ELSE
		SELECT * FROM accounts WHERE id = 0 LIMIT 1;
     END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `account_type_id` int(11) DEFAULT 0,
  `email` varchar(120) DEFAULT '',
  `password` varchar(45) DEFAULT '',
  `first_name` varchar(45) DEFAULT '',
  `last_name` varchar(45) DEFAULT '',
  `name` varchar(45) DEFAULT '',
  `last_login` varchar(45) DEFAULT '',
  `status` varchar(15) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `account_type_id`, `email`, `password`, `first_name`, `last_name`, `name`, `last_login`, `status`) VALUES
(1, 1, 'ozlagame@gmail.com', '123456', 'ozla', 'game', 'ozla game', '2022-12-10 05:03:09', 'NEW'),
(2, 2, 'niftyers@gmail.com', '123456', '', '', 'World of Warcraft', '2022-12-11 17:09:35', 'NEW');

-- --------------------------------------------------------

--
-- Table structure for table `accounts_type`
--

CREATE TABLE `accounts_type` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `name` varchar(300) DEFAULT '',
  `description` varchar(3000) DEFAULT '',
  `subinfo` varchar(300) DEFAULT '',
  `rates` decimal(10,2) DEFAULT 0.00,
  `photo` varchar(1000) DEFAULT '',
  `status` varchar(45) DEFAULT '',
  `book_date` varchar(45) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `listings`
--

INSERT INTO `listings` (`id`, `account_id`, `name`, `description`, `subinfo`, `rates`, `photo`, `status`, `book_date`) VALUES
(1, 2, 'Wedding Ceremonial', 'Wedding Ceremonial', 'Wedding', '2500.00', 'BE56FF59-59EF-E922-641C-ECB9A7D2448F.jpg', 'NEW', ''),
(2, 2, 'Events Ground', 'Events Ground\r\n - Birthday\r\n- Wedding\r\n- Conference', 'Free All', '3000.00', '80A60708-A8DE-9DA2-D470-EA57208AC630.jpg', 'NEW', '');

-- --------------------------------------------------------

--
-- Table structure for table `listings_photo`
--

CREATE TABLE `listings_photo` (
  `id` int(11) NOT NULL,
  `listing_id` int(11) DEFAULT 0,
  `listing_order` int(11) DEFAULT 0,
  `photo` varchar(300) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `listings_photo`
--

INSERT INTO `listings_photo` (`id`, `listing_id`, `listing_order`, `photo`) VALUES
(1, 1, 1, 'BE56FF59-59EF-E922-641C-ECB9A7D2448F.jpg'),
(5, 2, 1, '80A60708-A8DE-9DA2-D470-EA57208AC630.jpg'),
(6, 2, 2, '95B9AC1B-7830-0398-500F-24620CB46AA1.jpg'),
(9, 1, 3, '0F8AF15A-B7B9-F0EE-90B3-6306B3C40330.jpg'),
(10, 1, 2, 'B3E83A8B-A860-43C7-72C9-CAFC856213DE.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `name` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `booking_date` varchar(45) DEFAULT '',
  `amount` decimal(10,2) DEFAULT 0.00,
  `status` varchar(45) DEFAULT '',
  `payment_ref` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_listing`  AS  select `l`.`id` AS `id`,`l`.`account_id` AS `account_id`,`a`.`name` AS `account_name`,`l`.`name` AS `name`,`l`.`description` AS `description`,`l`.`subinfo` AS `subinfo`,`l`.`rates` AS `rates`,`l`.`photo` AS `photo`,`l`.`status` AS `status`,`l`.`book_date` AS `book_date` from (`listings` `l` left join `accounts` `a` on(`a`.`id` = `l`.`account_id`)) ;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

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
