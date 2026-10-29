-- Fresh start for the CRM: remove every user account and all data created through the CRM
-- (leads, vendors, tasks, leave requests, job applications, sign-in attempt log).
-- Website content (pages, products, reviews, team, FAQs, contact submissions, newsletter) is kept.
-- Afterwards create the administrator on the server with:
--   php database/create_admin.php "Manish Nikte" mcnikte@nminfocom.com
DELETE FROM `tasks`;
DELETE FROM `leaves`;
DELETE FROM `leads`;
DELETE FROM `vendor`;
DELETE FROM `job_applicants`;
DELETE FROM `form_submission_log`;
DELETE FROM `users`;
