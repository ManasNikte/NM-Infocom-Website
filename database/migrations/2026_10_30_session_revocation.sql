-- Sessions issued before this time are rejected (set on password change), so a new password signs out other devices.
ALTER TABLE users ADD COLUMN IF NOT EXISTS tokens_valid_after DATETIME NULL DEFAULT NULL;
