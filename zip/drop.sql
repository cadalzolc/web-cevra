DROP TABLE accounts;
DROP TABLE accounts_type;
DROP TABLE listings;
DROP TABLE listings_photo;
DROP TABLE orders;
DROP TABLE reservations;
DROP TABLE users;

DROP VIEW vw_listing;

DROP PROCEDURE sp_account_create_business;
DROP PROCEDURE sp_account_create_customer;
DROP PROCEDURE sp_listings_create;
DROP PROCEDURE sp_listings_photo_by_listing_id;
DROP PROCEDURE sp_listings_photo_id;
DROP PROCEDURE sp_listings_photo_update;
DROP PROCEDURE sp_listings_update;
DROP PROCEDURE sp_login_admin;
DROP PROCEDURE sp_login_business;
DROP PROCEDURE sp_login_customer;
DROP PROCEDURE sp_reservation_confirm;