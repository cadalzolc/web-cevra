-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 23, 2023 at 11:45 AM
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

CREATE PROCEDURE `sp_account_document` (IN `p_id` INT, IN `p_doc` VARCHAR(300))  BEGIN

	DECLARE p_date VARCHAR(45);
    
	SET p_date = DATE_FORMAT(now(),'%Y-%m-%d');
    
    UPDATE accounts
    SET		verify_date = p_date,
			proof = p_doc
    WHERE id = p_id;

END$$

CREATE PROCEDURE `sp_account_payment` (IN `p_id` INT, IN `p_payment` VARCHAR(3000))  BEGIN
	UPDATE accounts SET payment_method = p_payment WHERE id = p_id;
END$$

CREATE PROCEDURE `sp_account_update` (IN `p_id` INT, IN `p_name` VARCHAR(100), IN `p_photo` VARCHAR(300), IN `p_contact` VARCHAR(100))  BEGIN

	UPDATE accounts 
    SET name = p_name,
		photo = p_photo,
        contact_no = p_contact
    WHERE id = p_id;

END$$

CREATE PROCEDURE `sp_account_verify_business` (IN `p_id` INT)  BEGIN

	DECLARE p_date VARCHAR(45);
    
	SET p_date = DATE_FORMAT(now(),'%Y-%m-%d');
        
	UPDATE 	accounts 
	SET 	verify = 1,
			proof_date = p_date
    WHERE id = p_id;
     
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

CREATE PROCEDURE `sp_reservation_confirm` (IN `p_id` INT)  BEGIN
	UPDATE reservations SET status = 'PD' WHERE id = p_id;
END$$

DELIMITER ;

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

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
