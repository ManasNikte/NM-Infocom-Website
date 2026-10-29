-- Clear the staff list: remove every non-admin user (the admin account is kept so someone can still
-- sign in and add the new team). Tasks and leave requests belonging to removed users go with them;
-- leads and vendors stay, with their links to removed users cleared.
DELETE FROM `tasks`  WHERE `assigned_to` IN (SELECT `id` FROM `users` WHERE `role` <> 'Admin')
                        OR `assigned_by` IN (SELECT `id` FROM `users` WHERE `role` <> 'Admin');
DELETE FROM `leaves` WHERE `user_id` IN (SELECT `id` FROM `users` WHERE `role` <> 'Admin');
UPDATE `leads`  SET `assigned_to` = NULL WHERE `assigned_to` IN (SELECT `id` FROM `users` WHERE `role` <> 'Admin');
UPDATE `leads`  SET `added_by` = NULL    WHERE `added_by`    IN (SELECT `id` FROM `users` WHERE `role` <> 'Admin');
UPDATE `vendor` SET `added_by` = NULL    WHERE `added_by`    IN (SELECT `id` FROM `users` WHERE `role` <> 'Admin');
DELETE FROM `users` WHERE `role` <> 'Admin';
