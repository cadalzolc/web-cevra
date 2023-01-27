-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 27, 2023 at 11:34 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.8

USE db_events;

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
CREATE .l-form-controlPROCEDURE `sp_account_create_business` (IN `p_email` VARCHAR(120), IN `p_password` VARCHAR(120), IN `p_name` VARCHAR(120))  BEGIN
	
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

CREATE .l-form-controlPROCEDURE `sp_account_create_customer` (IN `p_email` VARCHAR(120), IN `p_password` VARCHAR(120), IN `p_first_name` VARCHAR(120), IN `p_last_name` VARCHAR(120))  BEGIN
	
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

CREATE .l-form-controlPROCEDURE `sp_account_document` (IN `p_id` INT, IN `p_doc` VARCHAR(300))  BEGIN

	DECLARE p_date VARCHAR(45);
    
	SET p_date = DATE_FORMAT(now(),'%Y-%m-%d');
    
    UPDATE accounts
    SET		verify_date = p_date,
			proof = p_doc
    WHERE id = p_id;

END$$

CREATE .l-form-controlPROCEDURE `sp_account_payment` (IN `p_id` INT, IN `p_payment` VARCHAR(3000))  BEGIN
	UPDATE accounts SET payment_method = p_payment WHERE id = p_id;
END$$

CREATE .l-form-controlPROCEDURE `sp_account_update` (IN `p_id` INT, IN `p_name` VARCHAR(100), IN `p_photo` VARCHAR(300), IN `p_contact` VARCHAR(100))  BEGIN

	UPDATE accounts 
    SET name = p_name,
		photo = p_photo,
        contact_no = p_contact
    WHERE id = p_id;

END$$

CREATE .l-form-controlPROCEDURE `sp_account_verify_business` (IN `p_id` INT)  BEGIN

	DECLARE p_date VARCHAR(45);
    
	SET p_date = DATE_FORMAT(now(),'%Y-%m-%d');
        
	UPDATE 	accounts 
	SET 	verify = 1,
			proof_date = p_date
    WHERE id = p_id;
     
END$$

CREATE .l-form-controlPROCEDURE `sp_listings_create` (IN `p_account_id` INT, IN `p_name` VARCHAR(300), IN `p_description` VARCHAR(3000), IN `p_info` VARCHAR(300), IN `p_rates` DECIMAL(10,2))  BEGIN

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

CREATE .l-form-controlPROCEDURE `sp_listings_photo_by_listing_id` (IN `p_id` INT)  BEGIN
	SELECT o.id AS orders, 
			(CASE ISNULL(lp.id) WHEN 1 THEN 0 ELSE lp.id END) AS id, 
			(CASE ISNULL(lp.photo) WHEN 1 THEN '' ELSE lp.photo END) AS photo FROM orders o
	LEFT OUTER JOIN 
	 (SELECT id, listing_order, photo FROM listings_photo WHERE listing_id = p_id) lp on lp.listing_order = o.id
    ORDER BY o.id ASC 
    LIMIT 5;
END$$

CREATE .l-form-controlPROCEDURE `sp_listings_photo_id` (IN `p_order` INT, IN `p_venue` INT)  BEGIN
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

CREATE .l-form-controlPROCEDURE `sp_listings_photo_update` (IN `p_id` INT, IN `p_photo` VARCHAR(300))  BEGIN
	DECLARE p_venue INT;
    
    SET p_venue = (SELECT listing_id FROM listings_photo WHERE id = p_id AND listing_order =  1);
    
	UPDATE listings_photo SET photo = p_photo WHERE id = p_id;
    
    IF p_venue IS NOT NULL THEN
        UPDATE listings SET photo = p_photo WHERE id = p_venue;
    END IF;

END$$

CREATE .l-form-controlPROCEDURE `sp_listings_update` (IN `p_id` INT, IN `p_name` VARCHAR(300), IN `p_description` VARCHAR(3000), IN `p_info` VARCHAR(300), IN `p_rates` DECIMAL(10,2))  BEGIN
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

CREATE .l-form-controlPROCEDURE `sp_login_admin` (IN `p_username` VARCHAR(100), IN `p_password` VARCHAR(30))  BEGIN

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

CREATE .l-form-controlPROCEDURE `sp_login_business` (IN `p_email` VARCHAR(100), IN `p_password` VARCHAR(100))  BEGIN

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

CREATE .l-form-controlPROCEDURE `sp_login_customer` (IN `p_email` VARCHAR(100), IN `p_password` VARCHAR(100))  BEGIN

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

CREATE .l-form-controlPROCEDURE `sp_reservation` (IN `p_listing_id` INT, IN `p_customer_id` INT, IN `p_date` VARCHAR(35), IN `p_rates` DECIMAL(10,2), IN `p_ref_no` VARCHAR(60))  BEGIN
	
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

CREATE .l-form-controlPROCEDURE `sp_reservation_by_no` (IN `p_no` VARCHAR(100))  BEGIN
	SELECT * FROM vw_resevation WHERE ref_no = p_no;
END$$

CREATE .l-form-controlPROCEDURE `sp_reservation_confirm` (IN `p_id` INT)  BEGIN
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
  `photo` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `payment_method` varchar(3000) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `verify` bit(1) DEFAULT b'0',
  `verify_date` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `proof` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `proof_date` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `contact_no` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `account_type_id`, `email`, `password`, `first_name`, `last_name`, `name`, `last_login`, `status`, `email_valid`, `photo`, `payment_method`, `verify`, `verify_date`, `proof`, `proof_date`, `contact_no`) VALUES
(1, 1, 'begontemarlyn@gmail.com', 'e819fa04c29ebf6705531e6c4bcb9ebed910462d', 'Marlyn', 'Begonte', 'MARLYN BEGONTE', '2023-01-23 15:24:34', 'NEW', b'1', ' ', '', b'0', '', '', '', '+1639122507605'),
(2, 1, 'dlcrzjam1@gmail.com', 'a2dc44fa3b8e43bfa94624217133bf4e60284ad9', 'Jam', 'jam1', 'JAM JAM1', '2023-01-05 18:10:17', 'NEW', b'1', '', '', b'0', '', '', '', ''),
(3, 2, 'riverfront.resortcy@gmail.com', '0c7663adc6ac7be0fada3c0973c143d80310cd7b', '', '', 'The Riverfront Resort', '2023-01-23 04:24:47', 'NEW', b'1', '92084820-11C3-01CD-1890-C71A60F6E3B3.jpg ', 'Pay with Gcash 3 simple steps!\r\n\r\n1. Send your payment (exact amount) to GCASH Number 09655291005. Make sure you take a screenshot.\r\n\r\n2. Send the screenshot of your transaction to our email riverfront.resortcy@gmail.com. Make sure the Gcash Reference Number is visible.\r\n\r\n3. Wait for a confirmation of your payment in the Calbayog Events Venue Rentals Web App. This usually takes a few minutes after you send us your payment.\r\n\r\nPlease note that your reservation will not be processed if no payment is received.  ', b'1', '2023-01-05', 'A1D2F658-E067-1950-7B2F-273104B9DE17.pdf ', '2023-01-05', '09155624221'),
(4, 2, 'niftyers@gmail.com', '21bd12dc183f740ee76f27b78eb39c8ad972a757', '', '', 'MOON VALLEY', '2023-01-22 22:03:58', 'NEW', b'1', '801DBDF7-DA0A-3191-C6EC-336B08170FBB.jpg  ', 'Pay with Gcash 3 simple steps!\r\n\r\n1. Send your payment (exact amount) to GCASH Number 09655291005. Make sure you take a screenshot.\r\n\r\n2. Send the screenshot of your transaction to our official Facebook page. Make sure the Gcash Reference Number is visible.\r\n\r\n3. Wait for a confirmation of your payment in the Calbayog Events Venue Rentals Web App. This usually takes a few minutes after you send us your payment.\r\n\r\nPlease note that your reservation will not be processed if no payment is received. ', b'1', '2023-01-05', 'E92E42F7-CB67-1804-CA5D-8F8A92A15E86.pdf ', '2023-01-05', '123456'),
(5, 2, 'bayparkhotelcy@gmail.com', '46ad83d6cb477b8d8173a85f898032a0ebed60b3', '', '', 'Baypark Hotel ', '2023-01-24 16:34:06', 'NEW', b'1', '863459EE-7644-239E-D8C3-297872064DE2.png ', 'Pay with Gcash 3 simple steps!\r\n\r\n1. Send your payment (exact amount) to GCASH Number 09655291005. Make sure you take a screenshot.\r\n\r\n2. Send the screenshot of your transaction to our email bayparkhotelcy@gmail.com. Make sure the Gcash Reference Number is visible.\r\n\r\n3. Wait for a confirmation of your payment in the Calbayog Events Venue Rentals Web App. This usually takes a few minutes after you send us your payment.\r\n\r\nPlease note that your reservation will not be processed if no payment is received.  ', b'1', '2023-01-05', '6505645D-D29B-A111-1409-C0EED96555B8.pdf ', '2023-01-05', '09155624221'),
(6, 2, 'isplant.hotel@gmail.com', '79922674a263671768a74fd827e0b5efc1785530', '', '', 'The Is Plant Hotel', '2023-01-25 03:46:29', 'NEW', b'1', '88674401-24A1-F594-6222-BC967D6E1F3A.jpg ', 'Pay with Gcash 3 simple steps!\r\n\r\n1. Send your payment (exact amount) to GCASH Number 09655291005. Make sure you take a screenshot.\r\n\r\n2. Send the screenshot of your transaction to our email isplant.hotel@gmail.com. Make sure the Gcash Reference Number is visible.\r\n\r\n3. Wait for a confirmation of your payment in the Calbayog Events Venue Rentals Web App. This usually takes a few minutes after you send us your payment.\r\n\r\nPlease note that your reservation will not be processed if no payment is received.      ', b'1', '2023-01-05', 'EE7ECCAD-1E7C-FD5A-2FEE-8C5600887806.pdf ', '2023-01-06', '09122502705'),
(7, 1, 'micoljona8@gmail.com', 'a94e22c6f7be6c99089095028cdec2cde464b45b', 'Jona', 'Micol', 'JONA MICOL', '2023-01-05 20:02:06', 'NEW', b'0', '', '', b'0', '', '', '', ''),
(8, 1, 'lindagaudencio7@gmail.com', '7a493e7c6842da37138f67188d8530e108c4847f', 'Linda', 'Gaudencio', 'LINDA GAUDENCIO', '2023-01-05 20:06:11', 'NEW', b'0', '', '', b'0', '', '', '', ''),
(9, 1, 'doinogkristine85@gmail.com', 'c29fee996dc6cc13b03df382e9769dac9ecd43dc', 'Kristine', 'Doinog', 'KRISTINE DOINOG', '', 'NEW', b'1', '', '', b'0', '', '', '', ''),
(10, 1, 'gailabby503@gmail.com', 'a40fcd6544b71d49eaf54dfcf6221d2cfcfbf546', 'Abby', 'Gail', 'ABBY GAIL', '2023-01-05 20:27:40', 'NEW', b'0', '', '', b'0', '', '', '', ''),
(11, 1, 'alonapalacio004@gmail.com', 'dec7dd342a499dfd4d283d872ccf598d8a7b6039', 'Alona', 'Palacio', 'ALONA PALACIO', '2023-01-26 13:41:54', 'NEW', b'1', '', '', b'0', '', '', '', ''),
(12, 1, 'bernardoermz@gmail.com', 'b1519b81b1aecab398a7ee03c143f316b3c44d45', 'Ermz', 'Bernardo', 'ERMZ BERNARDO', '2023-01-05 20:38:18', 'NEW', b'0', '', '', b'0', '', '', '', ''),
(13, 1, 'zylamae48@gmail.com', 'ca04f2fbb2597f0df9397d61a61f9e0aa3d419f1', 'Zylq', 'Mae', 'ZYLQ MAE', '2023-01-05 20:40:14', 'NEW', b'0', '', '', b'0', '', '', '', ''),
(14, 1, 'jamdlcrz2@gmail.com', '007dd8e4af736f610c8d016c71f76dc92908dc1d', 'Jam', 'Jam', 'JAM JAM', '2023-01-24 05:58:19', 'NEW', b'1', 'A8846B3F-1836-6C37-4A88-5DF75DFD6D9B.png  ', '', b'0', '', '', '', '09305241081'),
(15, 1, 'katepansoy19@gmail.com', 'cc3cedc0e0bf7d024c7c900dd879cdd181182a2a', 'Kate', 'Pansoy', 'KATE PANSOY', '2023-01-05 21:00:05', 'NEW', b'1', '', '', b'0', '', '', '', ''),
(16, 1, 'chardzzz66@gmail.com', '759750fbfcb5d53192a3e4c482f99e3be757c0e1', 'Richard', 'Gallego', 'RICHARD GALLEGO', '2023-01-05 21:03:18', 'NEW', b'1', '', '', b'0', '', '', '', ''),
(17, 1, 'Gcasidsid84@gmail.com', '1ba3bf9ae1f8d4462a82e4f3ba06e6e3a907e748', 'Genevieve', 'Cassidy', 'GENEVIEVE CASSIDY', '2023-01-05 21:20:19', 'NEW', b'1', '', '', b'0', '', '', '', ''),
(18, 1, 'JTangzo5678@gmail.com', 'e39225bfc64493f3532775e8f53e29dfae0e9142', 'Joanalyn', 'Tangzo', 'JOANALYN TANGZO', '', 'NEW', b'0', '', '', b'0', '', '', '', ''),
(19, 2, 'bellebegonte35@gmail.com', '870089874f945a921f74a799ee4e34af793c00c1', '', '', 'The Venue', '2023-01-06 00:53:04', 'NEW', b'1', '8A922975-5F19-8130-4DAE-2D64BE8542ED.png ', '', b'1', '2023-01-06', '41D104D0-770F-4EEB-5602-A720349B8017.pdf ', '2023-01-06', ''),
(20, 1, 'delacruzcarol230@gmail.com', '79ef50d32cbac1107d58ceed95098ea079ab3c7d', 'Carol', 'Dela Cruz', 'CAROL DELA CRUZ', '2023-01-06 06:14:24', 'NEW', b'1', '', '', b'0', '', '', '', ''),
(21, 2, 'zhiandelacruz2021@gmail.com', 'fb16a38582b6ae671dad0fa39835f7957fa22fdd', '', '', 'CEVRA', '2023-01-06 08:05:12', 'NEW', b'1', '', 'Pay with Gcash 3 simple steps!\r\n\r\n1. Send your payment (exact amount) to GCASH Number 09655291005. Make sure you take a screenshot.\r\n\r\n2. Send the screenshot of your transaction to our email zhiandelacruz2021@gmail.com. Make sure the Gcash Reference Number is visible.\r\n\r\n3. Wait for a confirmation of your payment in the Calbayog Events Venue Rentals Web App. This usually takes a few minutes after you send us your payment.\r\n\r\nPlease note that your reservation will not be processed if no payment is received.  ', b'1', '2023-01-06', '074C67A0-5D30-521B-D3BA-E9D58E39C588.pdf ', '2023-01-06', ''),
(22, 1, 'jrepol2014@gmail.com', '9fc42a7864b89e79ff6f8650dbe35d4a312c09e3', 'Jay', 'Repol', 'JAY REPOL', '2023-01-23 04:27:55', 'NEW', b'1', '', '', b'0', '', '', '', ''),
(23, 2, 'Oceanview@gmail.com', 'b1f18ec98274bfef7562a58b76c4ff84c140682c', '', '', 'Oceanview Resort', '2023-01-06 08:41:37', 'NEW', b'0', '', '', b'0', '', '', '', ''),
(24, 1, 'palacio.alona143@gmail.com', '3d36cf82aac1d25ac3c22abf060537820b5d1cc6', 'Karen', 'Dela Cruz ', 'KAREN DELA CRUZ ', '2023-01-06 09:13:08', 'NEW', b'1', '', '', b'0', '', '', '', ''),
(25, 2, 'cevrwa04@gmail.com', '2bbc083d9f49f90e23e0976a03ce704d73f0da7a', '', '', 'CEVRWA', '2023-01-06 09:14:14', 'NEW', b'0', '', '', b'0', '', '', '', ''),
(26, 2, 'vangieramada16@gmail.com', '785f22d61326d5fd4c57d6201f578e50e7be228a', '', '', 'CEVRWA', '2023-01-06 09:17:15', 'NEW', b'1', '', 'Pay with Gcash 3 simple steps!\r\n\r\n1. Send your payment (exact amount) to GCASH Number 09655291005. Make sure you take a screenshot.\r\n\r\n2. Send the screenshot of your transaction to  our email cevrwa04@gmail.com. Make sure the Gcash Reference Number is visible.\r\n\r\n3. Wait for a confirmation of your payment in the Calbayog Events Venue Rentals Web App. This usually takes a few minutes after you send us your payment.\r\n\r\nPlease note that your reservation will not be processed if no payment is received. ', b'1', '2023-01-06', 'B645E9AD-F62D-3548-45E2-62FD98C76A84.pdf ', '2023-01-06', ''),
(27, 1, 'palacioalona7@gmail.com', '1b6f9acd18d207bcd851292901809f000957d0c5', 'Alona Marie', 'Castillo', 'ALONA MARIE CASTILLO', '2023-01-23 11:00:13', 'NEW', b'1', '', '', b'0', '', '', '', ''),
(28, 2, 'ISplanthotel@gmail.com', '9a8f7ee9873e6dbb892155db4d87b85d6bfa7c0d', '', '', 'The ISplant Hotel', '2023-01-23 13:40:37', 'NEW', b'0', '', '', b'0', '', '', '', ''),
(29, 2, 'ceriacohotel@gmail.com', '812cdc5f0d00049439bf793096e31c8033346a3d', '', '', 'ceriaco hotel', '2023-01-24 15:11:07', 'NEW', b'1', '', '', b'1', '2023-01-24', 'A1077480-281D-079E-8939-25848D6DA835.pdf ', '2023-01-25', ''),
(30, 1, 'delacruz.kareng@gmail.com', '812467fa64a6eeaaf3cf9a9bcb391c4a3e8bfaea', 'karen', 'dela cruz', 'KAREN DELA CRUZ', '2023-01-24 12:35:32', 'NEW', b'0', '', '', b'0', '', '', '', '');

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
(1, 4, 'Moon Cakes Ballroom', 'In Moonvalley, inspiration comes easily. On the steep, ancient trails that zigzag the fjord sides, our founders Ida, Mimmi and Emelie, put in the hard hours that keep them among the elite in ultra-trail running. But our home offers much more than spectacular scenery and a fantastic training environment. It’s also the place where we sow the seeds for a healthier, more sustainable life – literally and metaphorically. The valley and nature provide, and we gratefully accept', 'Holidays', '5000.00', '1C9822E1-BDAD-6220-145C-6F1B13292D98.jpg', 'NEW', ''),
(2, 4, 'El Jardin de Zaida', 'Is a resort, spa, and events place combined, so you can enjoy everything you need all in one place. It has a villa, a pool, a restaurant, and even picture-worthy spots like a bahay kubo, a scenic bridge over a man-made lake, a gazebo, and a calamansi orchard. Of course, the main attractions are the private gardens and pavilions that can accommodate between 20 to 500 guests.', 'Wedding Reception', '10000.00', '539928AB-7B6E-C737-D609-A525C486DFCD.png', 'NEW', ''),
(3, 6, 'Rotary Hall', 'Good for 6 hours  INCLUSION (Sound System, Table & Chairs)\r\n', '10-15 PAX', '4000.00', '8862BBA8-525B-77A5-218A-D06F2186B753.jpg', 'NEW', ''),
(4, 6, 'Isabela Hall', 'Good for 6 hours  INCLUSION (Sound System, Table & Chairs)', 'Venue 1 (70 - 80 PAX)', '7000.00', 'FD66CA37-B7D6-50A4-44FE-B5861AF9F7D3.jpg', 'NEW', ''),
(5, 6, 'Juan Miguel Ballroom', 'Good for 6 hours  INCLUSION (Sound System, Table & Chairs)\r\n', 'Venue 3 (100-200 PAX)', '14000.00', 'A479EFC6-8C43-0588-C9D0-F606C570C42A.jpg', 'NEW', ''),
(6, 5, 'Angela Function Hall', 'Package Amenities \r\nExclusive use of venue for the first five hours\r\nComplete Banquet Service and Set-up\r\nStandard Lights and Sound System\r\n5% Discount on 1 Room Hotel Accommodation with Free Breakfast\r\nWaived corkage for 1 cake\r\n', '150 PAX', '12000.00', '2084F157-A904-8B2D-2618-C66F2D466FAB.webp', 'NEW', ''),
(7, 5, 'Rosario Function Hall', 'Package Amenities \r\n\r\nExclusive use of venue for the first five hours\r\nComplete Banquet Service and Set-up\r\nStandard Lights and Sound System\r\n5% Discount on 1 Room Hotel Accommodation with Free Breakfast\r\nWaived corkage for 1 cake\r\n', '60 PAX', '5000.00', '630C5015-76DA-C489-2179-A767F25EE984.jpg', 'NEW', ''),
(8, 3, 'The Selina Hall', 'SELINA HALL \r\nAmenities:\r\nFully air-conditioned main hall with (2) man made cliff waterfalls background\r\n(1) Center stage with (2) upstairs mini stage\r\n(2) Garden see through lobby for guests\r\nCatering room for food storage access\r\n (2) White House for guests\r\n\r\n‼️ FREE ‼️\r\nFREE ( Channel CCTV recording camera for the security during the event\r\nFREE tiffany tables and chairs upgrade\r\nFREE (2) guide marshals for guests\r\n\r\nRate:\r\n6 Hours maximum \r\n', '100 PAX', '12000.00', 'D367FE34-D9D3-55FF-670B-7D8FFDD6F6BC.jpg', 'NEW', ''),
(9, 19, 'Conference  Room', 'Good for 6 Hours\r\nInclusion:\r\nSound System\r\nTables & Chairs', '20-40 PAX', '6000.00', '52DE1985-58C3-5934-807F-DACAAA505D26.jpg', 'NEW', ''),
(10, 21, 'hotel', 'fjdjd', 'dyd', '15000.00', '28AFBCCA-5312-F7A4-D9ED-1B8AF3297C8F.jpg', 'NEW', ''),
(11, 26, 'The Riverfront Resort', 'TEST', 'TEST', '20.00', '6B38D6FD-D7F4-B420-631B-F986E97FB380.jpg', 'NEW', '');

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
(1, 1, 1, '1C9822E1-BDAD-6220-145C-6F1B13292D98.jpg'),
(2, 1, 3, 'C988290E-1770-CA2C-A08A-1B7B84E305DF.jpg'),
(3, 1, 2, '3340E32C-A0AA-5299-756B-AFBE695BF135.jpg'),
(4, 2, 1, '539928AB-7B6E-C737-D609-A525C486DFCD.png'),
(5, 2, 2, 'F3AB377A-6398-AA30-99C9-512160096272.jpg'),
(6, 2, 3, 'EF210FA4-AB87-05C3-F789-C4E0A05C066B.jpg'),
(7, 4, 1, 'FD66CA37-B7D6-50A4-44FE-B5861AF9F7D3.jpg'),
(8, 4, 2, '1B5F3AA1-0368-5C94-F98A-BC6B2A5A2104.jpg'),
(9, 5, 1, 'A479EFC6-8C43-0588-C9D0-F606C570C42A.jpg'),
(10, 5, 2, 'E46A47C6-9EB8-2864-5A5B-0251D8464A66.jpg'),
(11, 5, 3, '97E634EA-46CB-944D-85DF-49077FF6F8B9.jpg'),
(12, 3, 1, '8862BBA8-525B-77A5-218A-D06F2186B753.jpg'),
(13, 7, 1, '630C5015-76DA-C489-2179-A767F25EE984.jpg'),
(14, 6, 1, '2084F157-A904-8B2D-2618-C66F2D466FAB.webp'),
(15, 8, 2, 'D0FB8250-A3BD-1BF8-5861-EC6845101EE1.jpg'),
(16, 8, 1, 'D367FE34-D9D3-55FF-670B-7D8FFDD6F6BC.jpg'),
(17, 8, 3, '54682659-234A-F6C9-88B6-7DA71BDF922E.jpg'),
(18, 9, 1, '52DE1985-58C3-5934-807F-DACAAA505D26.jpg'),
(19, 10, 1, '28AFBCCA-5312-F7A4-D9ED-1B8AF3297C8F.jpg'),
(20, 11, 1, '6B38D6FD-D7F4-B420-631B-F986E97FB380.jpg');

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
(12, 12);

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
(1, 8, 14, '2023-01-24', '12000.00', 'PD', 0, '30934020230106055916'),
(2, 7, 14, '2023-01-28', '5000.00', 'PD', 0, '49265520230106082909'),
(3, 7, 1, '2023-01-27', '5000.00', 'PD', 0, '91330520230106083237'),
(4, 6, 14, '2023-01-31', '12000.00', 'PD', 0, '76432820230106085138'),
(5, 9, 14, '2023-01-20', '6000.00', 'PD', 0, '98993820230106090509'),
(6, 9, 14, '2023-01-18', '6000.00', 'PD', 0, '25085420230106090632'),
(7, 9, 1, '2023-05-02', '6000.00', 'PD', 0, '69871320230106090940'),
(8, 5, 14, '2023-01-15', '14000.00', 'PD', 0, '42028620230106093624'),
(9, 5, 14, '2023-02-11', '14000.00', 'PD', 0, '29824220230106111835'),
(10, 4, 20, '2023-01-27', '7000.00', 'PD', 0, '26839820230106141532'),
(11, 10, 20, '2023-01-25', '15000.00', 'FV', 0, '55222320230106142226'),
(12, 5, 22, '2023-01-23', '14000.00', 'PD', 0, '51551920230106160033'),
(13, 10, 22, '2023-01-21', '15000.00', 'PD', 0, '12205120230106160148'),
(14, 11, 24, '2023-01-25', '15000.00', 'PD', 0, '38334820230106172318'),
(15, 3, 11, '2023-03-01', '4000.00', 'PD', 0, '70710620230123124906'),
(16, 5, 11, '2023-01-31', '14000.00', 'PD', 0, '53380720230123152905'),
(17, 5, 1, '2023-02-01', '14000.00', 'PD', 0, '51961420230123153934'),
(18, 5, 1, '2023-02-08', '14000.00', 'PD', 0, '46341920230123160305'),
(19, 6, 11, '2023-02-23', '12000.00', 'FV', 0, '97506620230124202611'),
(20, 6, 11, '2023-02-11', '12000.00', 'FV', 0, '51701120230124202837'),
(21, 10, 11, '2023-02-01', '15000.00', 'FV', 0, '54254220230124223350'),
(22, 3, 11, '2023-03-30', '4000.00', 'FV', 0, '71583220230126214230');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `password` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `name` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `last_login` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `name`, `last_login`) VALUES
(1, 'cevra', '123456', 'Administrator', '2023-01-06 09:15:30');

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_admin_dashboard`
-- (See below for the actual view)
--
CREATE TABLE `vw_admin_dashboard` (
`business` decimal(42,0)
,`clients` decimal(42,0)
,`verify` bigint(21)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_business_count`
-- (See below for the actual view)
--
CREATE TABLE `vw_business_count` (
`business_id` int(11)
,`listing` bigint(21)
,`reserve` decimal(22,0)
,`sales` decimal(32,2)
);

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
-- Structure for view `vw_admin_dashboard`
--
DROP TABLE IF EXISTS `vw_admin_dashboard`;

CREATE ALGORITHM=UNDEFINED .l-form-controlSQL SECURITY DEFINER VIEW `vw_admin_dashboard`  AS  select sum(`rec`.`business`) AS `business`,sum(`rec`.`clients`) AS `clients`,(select count(0) AS `N` from `accounts` where `accounts`.`verify` = 0 and `accounts`.`proof` <> '' and `accounts`.`account_type_id` = 2) AS `verify` from (select count(0) AS `clients`,0 AS `business` from `accounts` where `accounts`.`account_type_id` = 1 union all select 0 AS `clients`,count(0) AS `business` from `accounts` where `accounts`.`account_type_id` = 2) `rec` ;

-- --------------------------------------------------------

--
-- Structure for view `vw_business_count`
--
DROP TABLE IF EXISTS `vw_business_count`;

CREATE ALGORITHM=UNDEFINED .l-form-controlSQL SECURITY DEFINER VIEW `vw_business_count`  AS  select `r`.`business_id` AS `business_id`,count(`r`.`listing_id`) AS `listing`,sum(case `r`.`status` when 'FV' then 1 else 0 end) AS `reserve`,sum(case `r`.`status` when 'PD' then `r`.`amount` else 0 end) AS `sales` from `vw_resevation` `r` group by `r`.`business_id` ;

-- --------------------------------------------------------

--
-- Structure for view `vw_listing`
--
DROP TABLE IF EXISTS `vw_listing`;

CREATE ALGORITHM=UNDEFINED .l-form-controlSQL SECURITY DEFINER VIEW `vw_listing`  AS  select `l`.`id` AS `id`,`l`.`account_id` AS `account_id`,`a`.`name` AS `account_name`,`l`.`name` AS `name`,`l`.`description` AS `description`,`l`.`subinfo` AS `subinfo`,`l`.`rates` AS `rates`,`l`.`photo` AS `photo`,`l`.`status` AS `status`,`l`.`book_date` AS `book_date` from (`listings` `l` left join `accounts` `a` on(`a`.`id` = `l`.`account_id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `vw_resevation`
--
DROP TABLE IF EXISTS `vw_resevation`;

CREATE ALGORITHM=UNDEFINED .l-form-controlSQL SECURITY DEFINER VIEW `vw_resevation`  AS  select `r`.`id` AS `id`,`r`.`listing_id` AS `listing_id`,`l`.`name` AS `listing_name`,`l`.`photo` AS `listing_photo`,`r`.`customer_id` AS `customer_id`,`c`.`name` AS `customer`,`r`.`booking_date` AS `booking_date`,`r`.`amount` AS `amount`,`r`.`status` AS `status`,`r`.`payment_ref` AS `payment_ref`,`r`.`ref_no` AS `ref_no`,`l`.`account_id` AS `business_id`,`b`.`name` AS `business` from (((`reservations` `r` left join `listings` `l` on(`l`.`id` = `r`.`listing_id`)) left join `accounts` `c` on(`c`.`id` = `r`.`customer_id`)) left join `accounts` `b` on(`b`.`id` = `l`.`account_id`)) ;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `accounts_type`
--
ALTER TABLE `accounts_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `listings`
--
ALTER TABLE `listings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `listings_photo`
--
ALTER TABLE `listings_photo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
