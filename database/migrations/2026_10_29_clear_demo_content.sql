-- Remove the demo content used while building the site: blog posts (and their comments),
-- events (and speakers), job openings, and the test applications made to those openings.
-- Event photos in uploads/events/ are deleted in the same change.
DELETE FROM `blog_comments`;
DELETE FROM `blogs`;
DELETE FROM `event_speakers`;
DELETE FROM `events`;
DELETE FROM `job_applicants`;
DELETE FROM `careers`;
-- Every job was removed above, so the per-category job counts start again from zero.
UPDATE `career_categories` SET `count` = 0;
