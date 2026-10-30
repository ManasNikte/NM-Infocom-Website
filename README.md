# NM INFOCOM: website and CRM

The public website for **NM INFOCOM** (IT security, infrastructure, cloud, Apple enterprise mobility and web development
services) and the internal **CRM** used by its admin, managers and employees.

Plain PHP 8 + MySQL/MariaDB, no framework. Bootstrap 5 on the public site, Bootstrap 4 (CoolAdmin) under a custom
shell in the CRM.

![Homepage](docs/screenshots/01-home-hero.png)

> **Using the CRM?** Start with the [CRM user guide](docs/CRM-USER-GUIDE.md): every role, every feature, step by step.
>
> A full write-up of the recent redesign, security work and testing is in [docs/REPORT.md](docs/REPORT.md).

---

## Contents

- [Features](#features)
- [Screenshots](#screenshots)
- [CRM user guide](docs/CRM-USER-GUIDE.md)
- [Project structure](#project-structure)
- [Requirements](#requirements)
- [Local setup](#local-setup)
- [Configuration (.env)](#configuration-env)
- [Deploying to Hostinger](#deploying-to-hostinger)
- [CRM roles and permissions](#crm-roles-and-permissions)
- [Database migrations](#database-migrations)
- [Security model](#security-model)
- [Troubleshooting](#troubleshooting)

---

## Features

**Public website**
- Conversion-focused homepage: hero with calls to action, client logos, services, process, testimonials, FAQ, contact form.
- Service pages for IT Security, IT Infrastructure, Cloud, Mobility and a dedicated **Web Development** page (`webdev.php`).
- Products priced in ₹ with downloadable PDF catalogues and an enquiry form that creates CRM leads.
- **Careers**: salaries always in Indian rupees (₹, Indian digit grouping; other currencies are rejected when a job is
  saved); open roles with team/type/search filters, expandable job details, in-page application with PDF CV upload,
  general applications, and `JobPosting` structured data.
- **Events**: automatically split into *upcoming* and *past* by date and time (IST), a featured next event with
  countdown, year/format filters for past events, and `Event` structured data.
- **Blog**: featured post, topic filters and search, full articles with light formatting, share buttons, related posts
  and `BlogPosting` structured data; written and published from the CRM.
- Moderated reviews and a newsletter sign-up.
- Every public form is validated, rate-limited per IP and has a spam honeypot.

**CRM** (`/CRM/`)
- One shared layout for every role: sidebar, top bar, responsive off-canvas menu on phones.
- **Live data without polling**: tables, KPI tiles and charts refresh when you come back to the tab (after 30 s away)
  and as soon as you save something in another open CRM tab (`crmLiveRefresh` in `CRM/layout/crm-ui.js`, using the
  browser's BroadcastChannel). Idle pages make no requests at all.
- **Dark and light mode**: toggle in the top bar (sun/moon). It follows the device setting until someone picks one;
  the choice is saved per browser. Every chart re-colours with the theme (`CRM/layout/crm-charts.js`).
- Every dashboard opens with a greeting banner and live KPI tiles (`CRM/layout/dashboard_hero.php`, fed by
  `CRM/shared/dashboard_summary.php`): team or personal task status, overdue and due-this-week counts, completion
  rate, leave requests, plus leads, vendors, jobs or website inbox numbers for the department.
- **Admin**: live dashboard (KPIs, leads, tasks, staff, leave, website activity), departments overview, staff
  directory with **Add user** (any role; login details emailed over SMTP), leads, vendors, careers, tasks, leave approvals.
  **Workspaces** (sidebar → *Work as*) open every manager and employee desk, so the admin can do anything any role can.
- **Managers** (marketing, sales, purchase, HR, website): department dashboard, team list, team leave approvals, task
  assignment; HR adds staff; website manager edits site content: blog posts, products, events, reviews, FAQs, team,
  client logos, stats, why-us cards, site details, and the newsletter subscriber list (with CSV export).
- **Employees**: personal dashboard, own tasks, leave requests, leads/sales/vendors for their department.

## Screenshots

| Public site | |
|---|---|
| ![Services](docs/screenshots/02-home-services.png) | ![Process](docs/screenshots/03-home-process-why.png) |
| ![Contact](docs/screenshots/04-home-contact.png) | ![Web development](docs/screenshots/07-webdev-hero.png) |
| ![Web dev process](docs/screenshots/08-webdev-process.png) | ![IT security cards](docs/screenshots/09-it-security-cards.png) |
| ![Cloud services](docs/screenshots/10-cloud-cards.png) | ![Mobile](docs/screenshots/06-home-mobile.png) |
| ![Blog](docs/screenshots/12-blog.png) | ![Careers](docs/screenshots/14-careers.png) |
| ![Events](docs/screenshots/15-events.png) | |

| CRM | |
|---|---|
| ![Login](docs/screenshots/20-crm-login.png) | ![Admin dashboard](docs/screenshots/21-crm-admin-dashboard.png) |
| ![Admin dashboard, dark mode](docs/screenshots/21b-crm-admin-dashboard-dark.png) | ![Departments](docs/screenshots/22-crm-admin-departments.png) |
| ![Workspaces](docs/screenshots/31-crm-workspaces.png) | ![Admin working in the Sales desk](docs/screenshots/32-crm-admin-in-sales-desk.png) |
| ![Add user](docs/screenshots/23-crm-add-user.png) | ![Leads](docs/screenshots/24-crm-leads.png) |
| ![Sales manager dashboard](docs/screenshots/25-crm-manager-dashboard.png) | ![Team list](docs/screenshots/26-crm-manager-team.png) |
| ![Assign a task](docs/screenshots/34-crm-assign-task.png) | ![Leave portal](docs/screenshots/36-crm-leave-portal.png) |
| ![Employee dashboard](docs/screenshots/27-crm-employee-dashboard.png) | ![My profile](docs/screenshots/33-crm-profile.png) |
| ![Careers and applicants](docs/screenshots/38-crm-careers.png) | ![Add job](docs/screenshots/35-crm-add-job.png) |
| ![Blog manager](docs/screenshots/29-crm-blog-manager.png) | ![Blog editor](docs/screenshots/30-crm-blog-editor.png) |
| ![Phone: dashboard](docs/screenshots/37-crm-mobile-dashboard.png) | ![Phone: menu](docs/screenshots/28-crm-mobile-menu.png) |

The CRM screenshots use fictional demo data.
For a guided tour of every feature, see the **[CRM user guide](docs/CRM-USER-GUIDE.md)**.

All screenshots are in [`docs/screenshots/`](docs/screenshots/).

## Project structure

```
.
├── index.php, webdev.php, ITsec*.php, ITInfra*.php, cloud.php, mobility*.php, …   public pages
├── components/          header, footer, homepage sections, shared <head>
├── data/                public data access (blog_lib, events_lib, career_data) + form endpoints
├── assets/              css (main.css = template, nm.css = design system), js, images, vendor libraries
├── config/
│   ├── app.php          nm_config(): reads .env / environment
│   ├── database.php     PDO connection (Database class, getDBConnection())
│   └── mailer.php       nm_send_mail(): PHPMailer over SMTP
├── CRM/
│   ├── index.html       sign-in page
│   ├── config/          auth.php (JWT sessions, role checks, CSRF guard), login.php, uploads.php
│   ├── layout/          shared shell (top.php / bottom.php / layout.css), dark/light theme, crm-charts.js
│   │                    (chart styling), crm-ui.js (dialogs), dashboard_hero.php (KPI tiles), shared page bodies
│   ├── shared/          endpoints used by several roles (profile, leaves, tasks, users, …)
│   ├── admin/           admin pages + data/ endpoints; workspaces.php opens every department desk
│   ├── manager/<dept>/  marketing, sales, purchase, HR, website
│   └── employee/<dept>/ marketing, sales, purchase
├── database/
│   ├── schema.sql       full table structure (no data)
│   ├── migrations/      dated SQL changes to apply to an existing database
│   └── create_admin.php CLI: create the first administrator
├── uploads/             user uploads (scripts can't execute here; résumés are git-ignored)
├── vendor/              Composer dependencies (firebase/php-jwt, phpmailer/phpmailer)
├── .env.example         every configuration key, documented
└── docs/                CRM-USER-GUIDE.md (for staff), REPORT.md and screenshots
```

## Requirements

- PHP **8.1+** with `pdo_mysql`, `mysqli`, `fileinfo`, `mbstring`, `openssl`, `curl`
- MySQL 5.7+ / MariaDB 10.4+
- Apache or LiteSpeed with `.htaccess` enabled (Hostinger: yes, by default)
- Composer (only if you change dependencies; `vendor/` is committed)

## Local setup

```bash
git clone https://github.com/ManasNikte/NM-Infocom-1.git && cd NM-Infocom-1
```

1. **Database**

   ```bash
   mysql -u root -e "CREATE DATABASE nm CHARACTER SET utf8mb4"
   ```

   ```bash
   mysql -u root nm < database/schema.sql
   ```

2. **Configuration**

   ```bash
   cp .env.example .env
   ```

   Set `APP_DEBUG=1`, your local `DB_*` values and a `CRM_JWT_SECRET` from:

   ```bash
   php -r "echo bin2hex(random_bytes(32));"
   ```

3. **First admin**

   ```bash
   php database/create_admin.php "Your Name" you@example.com
   ```

4. **Run** (the PHP built-in server ignores `.htaccess`, so it is for development only):

   ```bash
   php -S 127.0.0.1:8099 -t ..
   ```

   Website: `http://127.0.0.1:8099/NM-Infocom-1/`, CRM: `http://127.0.0.1:8099/NM-Infocom-1/CRM/`

5. **Email (optional)**: run [Mailpit](https://mailpit.axllent.org/) and point `SMTP_HOST=127.0.0.1`, `SMTP_PORT=1025`,
   `SMTP_SECURE=` at it to see the "new user" emails at `http://127.0.0.1:8025`.

## Configuration (.env)

All secrets and server settings live in a `.env` file. It is **never committed** (see `.gitignore`).
`config/app.php` reads keys in this order: real environment variables → `.env` one folder **above** the project →
`.env` in the project root. See [`.env.example`](.env.example) for every key.

| Key | Purpose |
|---|---|
| `APP_URL` | Public site URL, used in emailed links |
| `APP_DEBUG` | `1` shows PHP errors and allows a development JWT key. **Keep `0` in production.** |
| `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS` | Main database |
| `CRM_JWT_SECRET` | Signs CRM sessions. **Required, 32+ characters.** Without it the CRM refuses to sign anyone in. |
| `SMTP_HOST`, `SMTP_PORT`, `SMTP_SECURE`, `SMTP_USER`, `SMTP_PASS` | Outgoing mail |
| `MAIL_FROM`, `MAIL_FROM_NAME` | Sender of system emails |
| `NM_IP_SALT` | Salt for hashed visitor IPs in the form rate-limit log |

## Deploying to Hostinger

Hostinger's shared/cloud hosting has no panel for PHP environment variables, but a `.env` file works well and keeps
secrets out of the repository:

1. Upload the project into `public_html/` (Git deployment in hPanel, File Manager or SFTP).
2. Create the `.env` file **one level above `public_html`**, i.e. `domains/<your-domain>/.env`.
   That folder is not reachable from the web. (A `.env` inside `public_html` also works and is blocked by `.htaccess`,
   but outside is safer.)
3. Fill in the database credentials from **hPanel → Databases**, a fresh `CRM_JWT_SECRET`, and SMTP from a mailbox
   created in **hPanel → Emails**: `SMTP_HOST=smtp.hostinger.com`, `SMTP_PORT=465`, `SMTP_SECURE=ssl`,
   `SMTP_USER`/`MAIL_FROM` = `mcnikte@nminfocom.com` (the company mailbox used for all site email), `SMTP_PASS` = its password.
4. In **hPanel → Advanced → PHP Configuration** select PHP 8.1 or newer.
5. Import `database/schema.sql` into a new database, or apply `database/migrations/*.sql` (in date order) to the
   existing one with phpMyAdmin.
6. Create the administrator over SSH: `php database/create_admin.php "Manish Nikte" mcnikte@nminfocom.com`
   (prints a temporary password; change it after signing in).
7. Once the site is HTTPS-only, uncomment the `Strict-Transport-Security` header in `.htaccess`.

Alternative: `SetEnv KEY value` lines work in `.htaccess` on Hostinger's LiteSpeed servers, but `.htaccess` lives in the
web root and is usually committed, so prefer the `.env` file.

## CRM roles and permissions

| Capability | Admin | HR manager | Other managers | Employees |
|---|:-:|:-:|:-:|:-:|
| Admin dashboard, departments, all leads/vendors/careers | ✅ | | | |
| Create users | any role | managers & employees | | |
| Fire staff | anyone (not admins) | anyone (not admins) | own department's employees | |
| Approve / reject leave | all | own team | own team | |
| Assign tasks | anyone | own department | own department | |
| Own profile, password, tasks, leave requests | ✅ | ✅ | ✅ | ✅ |
| Work inside any manager or employee desk | ✅ | | | |

### Admin workspaces

From **Work as** in the sidebar (or **Work as any role** on the dashboard) the admin opens any department desk:
HR, Marketing, Sales, Purchase and Website manager, and the Marketing, Sales and Purchase employee desks. An amber
bar shows which role is in use, with a switcher and **Back to admin**.

How it stays safe (`crm_admin_workspace_token()` in `CRM/config/auth.php`):

- Only a signed-in **admin** token is ever converted; managers and employees get nothing new.
- The desk comes from the page's own folder (`/CRM/manager/<dept>/…`), or, for `CRM/shared/` endpoints, from the
  same-origin page that called them. Inside a desk the admin is treated as that desk's manager/employee, so every
  existing department rule applies unchanged (e.g. the HR desk can't create admins; use the admin Employee List).
- Records keep the admin's own user id (`assigned_by`, `action_by`, `added_by`), so it is always visible who acted.

New users receive an email with the sign-in link and a random temporary password and should change it under
**My Profile → Update Password**. If email isn't configured, the admin is shown the temporary password once instead.

### Emails the CRM sends

| Event | Recipient |
|---|---|
| User created | the new user (sign-in link + temporary password) |
| Task assigned (by a manager or the admin) | the assignee |
| Leave requested | the employee's department managers; for managers, the admins |
| Leave approved / rejected | the person who asked for it |

Notifications are best-effort: if SMTP is down, the task or leave is still saved and the error is logged.

## Database migrations

`database/schema.sql` is the complete current structure. When upgrading an existing installation, apply the files in
`database/migrations/` in filename order:

| File | Change |
|---|---|
| `2026_10_29_remove_manas_from_team.sql` | Removes a team member from the public "People" section |
| `2026_10_29_public_forms.sql` | Adds `newsletter_subscribers` and `form_submission_log` (rate limiting) |
| `2026_10_29_decode_contact_text.sql` | Converts old HTML-encoded contact messages back to plain text |
| `2026_10_29_product_image_paths.sql` | Makes product image paths independent of the install folder |
| `2026_10_29_delete_all_products.sql` | Clears the product catalogue |
| `2026_10_29_remove_staff_users.sql` | Removes all non-admin users and their tasks/leave |
| `2026_10_29_blog_content.sql` | Adds a full article body to blog posts; fixes one post's category |
| `2026_10_29_clear_demo_content.sql` | Deletes the demo blog posts, events, job openings and test applications |
| `2026_10_29_reset_crm_users.sql` | Deletes every CRM user and all CRM data (leads, vendors, tasks, leave, applications); website content is kept |
| `2026_10_29_contact_email.sql` | Sets the public contact email to `mcnikte@nminfocom.com` |
| `2026_10_29_utf8mb4_tables.sql` | Converts the remaining latin1 tables to utf8mb4 so ₹ and Indian-language text can be stored |
| `2026_10_30_admin_name.sql` | Names the administrator account Manish Nikte |
| `2026_10_30_partner_paths.sql` | Fixes one partner logo stored with a root-relative path |
| `2026_10_30_drop_unused_tables.sql` | Drops `benefits` and `blog_comments` (nothing uses them) |
| `2026_10_30_indexes.sql` | Indexes for the per-person / per-status lookups every dashboard makes (safe to re-run) |
| `2026_10_30_session_revocation.sql` | Adds `users.tokens_valid_after` so a password change signs out other devices |
| `2026_10_30_content_primary_keys.sql` | Gives the website content tables (clients, FAQs, slides, partners, stats, site details, why-us) primary keys and auto-increment IDs, so the CRM can add to them |

## Security model

- **Sessions**: HS256 JWT in an `HttpOnly`, `SameSite=Lax` (and `Secure` over HTTPS) cookie, 24-hour expiry. Every CRM
  page and endpoint calls `crm_require_page()` / `crm_require_api()` with the allowed roles and department. Each
  request also re-checks the account in the database: a fired user, a changed role or department, or a password
  change (`users.tokens_valid_after`) ends existing sessions immediately.
- **CSRF**: `SameSite=Lax` plus a server-side check that rejects cross-site state-changing requests.
- **Brute force**: 10 failed sign-ins per IP per 15 minutes; inactive/fired accounts cannot sign in.
- **XSS**: output is escaped in PHP (`htmlspecialchars`) and in JavaScript templates (global `esc()` helper), including
  values read back from `data-*` attributes into edit dialogs. A browser test plants script payloads in every
  user-editable field and opens every list and dialog; none run.
- **Input validation**: lead statuses/responses, vendor fields, dates (no 31 Feb), page sizes and links (`https://`
  only) are checked on the server; lead assignment only goes to active sales employees.
- **Errors**: database and internal errors are logged; users only see a generic message (`crm_public_error()`).
- **SQL injection**: prepared statements throughout; dynamic `LIMIT` values are cast to integers.
- **Uploads**: type checked by file content, server-chosen file names, size limits, and `uploads/.htaccess` blocks
  script execution. Deletes are confined to `uploads/`.
- **Public forms**: honeypot field, per-IP rate limits, length limits, generic error messages.
- **Hardening**: `.htaccess` disables directory listings and blocks dotfiles; `config/`, `database/` and `vendor/` have
  their own deny-all `.htaccess`; security headers are sent; PHP errors are logged, not displayed, unless `APP_DEBUG=1`.
  No endpoint sends `Access-Control-Allow-Origin`, and every state change requires POST.

Found a vulnerability? Please email the address on the website's contact page instead of opening a public issue.

## Troubleshooting

| Symptom | Fix |
|---|---|
| CRM says "CRM is not configured" | Set `CRM_JWT_SECRET` (32+ chars) in `.env` |
| New-user email not sent | Check `SMTP_*` in `.env`; the admin sees the SMTP error and the temporary password |
| A page works locally but breaks on Hostinger with "Failed to open stream" | Linux file names are case-sensitive: the path's letter case must match the folder exactly (e.g. `Analytics/` vs `analytics/`) |
| Not sure email works | Add a test user from the Employee List: if sending fails, the admin sees the exact SMTP error |
| Blank page / 500 | Check the PHP error log in hPanel; temporarily set `APP_DEBUG=1` |
| Images or PDFs 404 after moving folders | Paths are stored relative to the site root (`uploads/...`); run the migrations |
