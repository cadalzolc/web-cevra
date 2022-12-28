-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 28, 2022 at 02:13 PM
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
CREATE PROCEDURE `sp_account_create_business` (IN `p_email` VARCHAR(120), IN `p_password` VARCHAR(120), IN `p_name` VARCHAR(120))  BEGIN
	
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

CREATE PROCEDURE `sp_account_create_customer` (IN `p_email` VARCHAR(120), IN `p_password` VARCHAR(120), IN `p_first_name` VARCHAR(120), IN `p_last_name` VARCHAR(120))  BEGIN
	
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

CREATE PROCEDURE `sp_listings_create` (IN `p_account_id` INT, IN `p_name` VARCHAR(300), IN `p_description` VARCHAR(3000), IN `p_info` VARCHAR(300), IN `p_rates` DECIMAL(10,2))  BEGIN

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

CREATE PROCEDURE `sp_listings_photo_by_listing_id` (IN `p_id` INT)  BEGIN
	SELECT o.id AS orders, 
			(CASE ISNULL(lp.id) WHEN 1 THEN 0 ELSE lp.id END) AS id, 
			(CASE ISNULL(lp.photo) WHEN 1 THEN '' ELSE lp.photo END) AS photo FROM orders o
	LEFT OUTER JOIN 
	 (SELECT id, listing_order, photo FROM listings_photo WHERE listing_id = p_id) lp on lp.listing_order = o.id
    ORDER BY o.id ASC 
    LIMIT 5;
END$$

CREATE PROCEDURE `sp_listings_photo_id` (IN `p_order` INT, IN `p_venue` INT)  BEGIN
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

CREATE PROCEDURE `sp_listings_photo_update` (IN `p_id` INT, IN `p_photo` VARCHAR(300))  BEGIN
	DECLARE p_venue INT;
    
    SET p_venue = (SELECT listing_id FROM listings_photo WHERE id = p_id AND listing_order =  1);
    
	UPDATE listings_photo SET photo = p_photo WHERE id = p_id;
    
    IF p_venue IS NOT NULL THEN
        UPDATE listings SET photo = p_photo WHERE id = p_venue;
    END IF;

END$$

CREATE PROCEDURE `sp_listings_update` (IN `p_id` INT, IN `p_name` VARCHAR(300), IN `p_description` VARCHAR(3000), IN `p_info` VARCHAR(300), IN `p_rates` DECIMAL(10,2))  BEGIN
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

CREATE PROCEDURE `sp_login_admin` (IN `p_username` VARCHAR(100), IN `p_password` VARCHAR(30))  BEGIN

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

CREATE PROCEDURE `sp_login_business` (IN `p_email` VARCHAR(100), IN `p_password` VARCHAR(100))  BEGIN

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

CREATE PROCEDURE `sp_login_customer` (IN `p_email` VARCHAR(100), IN `p_password` VARCHAR(100))  BEGIN

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

CREATE PROCEDURE `sp_reservation` (IN `p_listing_id` INT, IN `p_customer_id` INT, IN `p_date` VARCHAR(35), IN `p_rates` DECIMAL(10,2), IN `p_ref_no` VARCHAR(60))  BEGIN
	
    DECLARE p_id INT;
    
	INSERT INTO reservations
	(
    listing_id, customer_id, booking_date, amount, status, ref_no
    )
	VALUES
    (
	p_listing_id, p_customer_id, p_date, p_rates, 'FV', p_ref_no
    );

	SET p_id = LAST_INSERT_ID();
    SELECT * FROM reservations WHERE id = p_id;

END$$

CREATE PROCEDURE `sp_reservation_by_no` (IN `p_no` VARCHAR(100))  BEGIN
	SELECT * FROM vw_resevation WHERE ref_no = p_no;
END$$

CREATE PROCEDURE `sp_reservation_confirm`(IN p_id INT) BEGIN
	UPDATE reservations SET status = 'PD' WHERE id = p_id;
END$$

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
  `status` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `email_valid` bit(1) DEFAULT b'0',
  `photo` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `account_type_id`, `email`, `password`, `first_name`, `last_name`, `name`, `last_login`, `status`, `email_valid`, `photo`) VALUES
(1, 2, 'niftyers@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', '', '', 'HONEYMOON CASTLE', '2022-12-13 15:00:46', 'NEW', b'0', ''),
(2, 1, 'ozlagame@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Kid', 'Python', 'KID PYTHON', '2022-12-28 18:27:09', 'NEW', b'0', '');

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
  `payment_ref` int(11) DEFAULT 0,
  `ref_no` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `listing_id`, `customer_id`, `booking_date`, `amount`, `status`, `payment_ref`, `ref_no`) VALUES
(1, 2, 2, '2023-01-04', '1500.00', 'FV', 0, '87599120221228200449'),
(2, 2, 2, '2023-01-14', '1500.00', 'FV', 0, '45332020221228210100');

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
-- Stand-in structure for view `vw_resevation`
-- (See below for the actual view)
--
CREATE TABLE `vw_resevation` (
`id` int(11)
,`listing_id` int(11)
,`listing_name` varchar(300)
,`listing_photo` varchar(1000)
,`customer_id` int(11)
,`customer` varchar(45)
,`booking_date` varchar(45)
,`amount` decimal(10,2)
,`status` varchar(45)
,`payment_ref` int(11)
,`ref_no` varchar(100)
,`business_id` int(11)
,`business` varchar(45)
);

-- --------------------------------------------------------

--
-- Structure for view `vw_listing`
--
DROP TABLE IF EXISTS `vw_listing`;

CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vw_listing`  AS  select `l`.`id` AS `id`,`l`.`account_id` AS `account_id`,`a`.`name` AS `account_name`,`l`.`name` AS `name`,`l`.`description` AS `description`,`l`.`subinfo` AS `subinfo`,`l`.`rates` AS `rates`,`l`.`photo` AS `photo`,`l`.`status` AS `status`,`l`.`book_date` AS `book_date` from (`listings` `l` left join `accounts` `a` on(`a`.`id` = `l`.`account_id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `vw_resevation`
--
DROP TABLE IF EXISTS `vw_resevation`;

CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vw_resevation`  AS  select `r`.`id` AS `id`,`r`.`listing_id` AS `listing_id`,`l`.`name` AS `listing_name`,`l`.`photo` AS `listing_photo`,`r`.`customer_id` AS `customer_id`,`c`.`name` AS `customer`,`r`.`booking_date` AS `booking_date`,`r`.`amount` AS `amount`,`r`.`status` AS `status`,`r`.`payment_ref` AS `payment_ref`,`r`.`ref_no` AS `ref_no`,`l`.`account_id` AS `business_id`,`b`.`name` AS `business` from (((`reservations` `r` left join `listings` `l` on(`l`.`id` = `r`.`listing_id`)) left join `accounts` `c` on(`c`.`id` = `r`.`customer_id`)) left join `accounts` `b` on(`b`.`id` = `l`.`account_id`)) ;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
