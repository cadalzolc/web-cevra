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

CREATE PROCEDURE `sp_login_business` (IN `p_email` VARCHAR(100), IN `p_password` VARCHAR(30))  BEGIN

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

CREATE PROCEDURE `sp_login_customer` (IN `p_email` VARCHAR(100), IN `p_password` VARCHAR(30))  BEGIN

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