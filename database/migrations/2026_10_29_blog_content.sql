-- Blog posts get a full article body (previously only an excerpt existed) and a fixed category on post 1.
ALTER TABLE `blogs` ADD COLUMN `blog_content` LONGTEXT NULL AFTER `blog_excerpt`;
UPDATE `blogs` SET `blog_category` = 'cybersecurity', `blog_category_label` = 'Cybersecurity' WHERE `blog_category` = '1';
