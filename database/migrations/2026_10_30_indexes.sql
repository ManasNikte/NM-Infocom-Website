-- Indexes for the lookups every dashboard and list makes (tasks / leads / leave per person and status).
-- Safe to run more than once (MariaDB 10.5+: IF NOT EXISTS).
CREATE INDEX IF NOT EXISTS idx_tasks_assignee_status ON tasks (assigned_to, status);
CREATE INDEX IF NOT EXISTS idx_tasks_assigner ON tasks (assigned_by);
CREATE INDEX IF NOT EXISTS idx_tasks_due ON tasks (due_date);
CREATE INDEX IF NOT EXISTS idx_leads_added_by ON leads (added_by);
CREATE INDEX IF NOT EXISTS idx_leads_assigned_to ON leads (assigned_to);
CREATE INDEX IF NOT EXISTS idx_leads_status_added ON leads (status, added_on);
CREATE INDEX IF NOT EXISTS idx_leaves_user_status ON leaves (user_id, status);
CREATE INDEX IF NOT EXISTS idx_users_role_dept ON users (role, sub_role);
CREATE INDEX IF NOT EXISTS idx_vendor_added_by ON vendor (added_by);
CREATE INDEX IF NOT EXISTS idx_applicants_job ON job_applicants (job_id);
CREATE INDEX IF NOT EXISTS idx_careers_deadline ON careers (deadline);
CREATE INDEX IF NOT EXISTS idx_contacts_added ON contact_submits (added_on);
CREATE INDEX IF NOT EXISTS idx_events_date ON events (event_date);
