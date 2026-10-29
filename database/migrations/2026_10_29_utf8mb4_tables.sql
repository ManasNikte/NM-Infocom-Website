-- These tables were created as latin1, which cannot store characters such as ₹ (used for salaries and prices),
-- Indian-language text or curly quotes. Convert them to utf8mb4 like the rest of the database.
ALTER TABLE `careers`            CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
ALTER TABLE `career_categories`  CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
ALTER TABLE `benefits`           CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
ALTER TABLE `products`           CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
ALTER TABLE `product_categories` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
ALTER TABLE `events`             CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
ALTER TABLE `event_speakers`     CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
