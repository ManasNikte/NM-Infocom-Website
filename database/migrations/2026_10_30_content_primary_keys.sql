-- Website content tables were imported without primary keys or auto-increment IDs, so nothing could be added
-- to them from the CRM. Existing IDs are unique (checked), so they are kept as they are.
-- Safe to run more than once on MariaDB (IF NOT EXISTS).
ALTER TABLE clients     ADD PRIMARY KEY IF NOT EXISTS (client_id),  MODIFY client_id INT(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE faqs        ADD PRIMARY KEY IF NOT EXISTS (faq_id),     MODIFY faq_id INT(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE hero_slides ADD PRIMARY KEY IF NOT EXISTS (slide_id),   MODIFY slide_id INT(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE partners    ADD PRIMARY KEY IF NOT EXISTS (partner_id), MODIFY partner_id INT(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE stats_total ADD PRIMARY KEY IF NOT EXISTS (stats_id),   MODIFY stats_id INT(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE web_data    ADD PRIMARY KEY IF NOT EXISTS (web_id),     MODIFY web_id INT(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE why_us      ADD PRIMARY KEY IF NOT EXISTS (whyus_id),   MODIFY whyus_id INT(11) NOT NULL AUTO_INCREMENT;
