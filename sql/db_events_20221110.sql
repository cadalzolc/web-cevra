-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 09, 2022 at 11:19 PM
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
(2, 2, 'niftyers@gmail.com', '123456', '', '', 'World of Warcraft', '2022-12-10 05:30:04', 'NEW');

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
  `name` varchar(150) DEFAULT '',
  `description` varchar(3000) DEFAULT '',
  `subinfo` varchar(45) DEFAULT '',
  `price` varchar(45) DEFAULT '',
  `photo` varchar(1000) DEFAULT '',
  `status` varchar(45) DEFAULT '',
  `book_date` varchar(45) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
