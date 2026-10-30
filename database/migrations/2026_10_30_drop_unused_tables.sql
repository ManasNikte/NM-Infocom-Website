-- Tables no page or endpoint uses any more.
--   benefits       the Web Development page lists its benefits in code (webdev.php)
--   blog_comments  the site has no blog comments feature
-- Back up first (phpMyAdmin → Export) if you want to keep a copy.
DROP TABLE IF EXISTS `benefits`;
DROP TABLE IF EXISTS `blog_comments`;
