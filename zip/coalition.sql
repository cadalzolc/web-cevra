SET collation_connection = 'utf8mb4_unicode_ci';
ALTER DATABASE db_events CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE accounts CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE accounts_type CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE listings CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE listings_photo CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE orders CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE reservations CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;