# NM INFOCOM CRM: user guide

This guide is for everyone at NM INFOCOM who uses the CRM: the administrator, the five department managers
(HR, Marketing, Sales, Purchase, Website) and the employees in Marketing, Sales and Purchase.

It explains what each screen is for, the workflows that connect the departments, and the habits that keep the CRM
useful. Screenshots use fictional demo data.

**Contents**

1. [Signing in for the first time](#1-signing-in-for-the-first-time)
2. [Finding your way around](#2-finding-your-way-around)
3. [Who can do what](#3-who-can-do-what)
4. [How work flows between departments](#4-how-work-flows-between-departments)
5. [Features shared by every role](#5-features-shared-by-every-role)
6. [Administrator](#6-administrator)
7. [HR manager](#7-hr-manager)
8. [Marketing manager and employees](#8-marketing-manager-and-employees)
9. [Sales manager and employees](#9-sales-manager-and-employees)
10. [Purchase manager and employees](#10-purchase-manager-and-employees)
11. [Website manager](#11-website-manager)
12. [Emails the CRM sends](#12-emails-the-crm-sends)
13. [Working efficiently: routines and tips](#13-working-efficiently-routines-and-tips)
14. [Security and good practice](#14-security-and-good-practice)
15. [Questions and problems](#15-questions-and-problems)

---

## 1. Signing in for the first time

1. You'll receive an email titled **"Your NM INFOCOM CRM login details"** with the sign-in link, your work email and a
   temporary password. If it isn't in your inbox, check the spam folder.
2. Open the link (it ends in `/CRM/index.html`), enter your email and the temporary password, and select **Sign in**.
   Use the eye icon to check what you typed.
3. You land on your own dashboard; the CRM knows your role and department from your account.
4. **Change the temporary password right away:** open **My Profile** → *Change password*. Use at least 8 characters
   with a mix of letters, numbers and symbols (the strength bar turns green when it's good).

![Sign-in page](screenshots/20-crm-login.png)

> **Forgot your password?** Ask the administrator or HR. They can't see your password, but they can create a
> fresh login for you.
>
> **Too many wrong attempts:** after 10 failed sign-ins in 15 minutes, sign-in is paused for 15 minutes for that
> network. Wait, then try again carefully.

---

## 2. Finding your way around

Every screen in the CRM has the same layout:

| Area | What it does |
|---|---|
| **Sidebar** (left) | Your menu. The highlighted item is the page you're on. Your name and email are at the bottom, with the **sign-out** button (arrow icon). |
| **Top bar** | The page name and today's date. The **moon / sun button** switches between dark and light mode. |
| **Greeting banner** | On every dashboard: a greeting and shortcuts (Leave portal, My profile). |
| **KPI tiles** | The headline numbers for your work. Many tiles are links: select one to jump to the page behind it. |
| **Charts** | Hover over (or tap) a bar or slice to see the exact number. Select a legend item to hide or show that series. |

![Admin dashboard](screenshots/21-crm-admin-dashboard.png)

**Dark mode.** Select the moon icon in the top bar. The CRM remembers your choice on that browser; until you choose, it
follows your device's setting. Charts recolour automatically.

![Dark mode](screenshots/21b-crm-admin-dashboard-dark.png)

**On a phone.** The CRM works on phones and tablets. Tap the **☰ menu** at the top left to open the sidebar; tap
outside it to close it. Tables scroll sideways inside their card.

| Phone dashboard | Phone menu |
|---|---|
| ![Phone dashboard](screenshots/37-crm-mobile-dashboard.png) | ![Phone menu](screenshots/28-crm-mobile-menu.png) |

**Up-to-date numbers.** Lists, tiles and charts refresh by themselves when you come back to the CRM tab, and right
after you save something in another CRM tab, so there's no need to keep reloading the page.

**Tables.** Most lists have a **search box** (searches every column), **filters** (status, date, person) and
**pagination** at the bottom. Filters combine: for example *status = Pending* plus a date.

**Pop-up forms.** Adding or editing something opens a form in a pop-up. Required fields are marked; if something is
missing, a red message under the form tells you what. **Cancel** or the Esc key closes it without saving.

---

## 3. Who can do what

| Capability | Admin | HR mgr | Marketing mgr | Sales mgr | Purchase mgr | Website mgr | Employees |
|---|:-:|:-:|:-:|:-:|:-:|:-:|:-:|
| Company-wide dashboard and departments overview | ✅ | | | | | | |
| Work inside any department's desk ([§6.9](#69-workspaces-work-as-any-role)) | ✅ | | | | | | |
| Create user accounts | any role | managers, employees | | | | | |
| Remove (fire) staff | anyone except admins | anyone except admins | own team | own team | own team | own team | |
| Assign tasks | anyone | own team | own team | own team | own team | own team | |
| Approve / reject leave | all | own team | own team | own team | own team | own team | |
| Leads | all | | all marketing leads | assign + track | purchase orders | | marketing: add · sales: work assigned leads |
| Vendors | all | | | | add, edit, allot | | purchase: add, edit own |
| Jobs and applicants | ✅ | ✅ | | | | | |
| Website content (blog, events, products, reviews, …) | via workspace | | | | | ✅ | |
| Own profile, password, tasks, leave requests | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ |

---

## 4. How work flows between departments

### From enquiry to closed deal

```
Website enquiry / phone call / event
        │
        ▼
Marketing (or Purchase) adds a LEAD ─────────────► status: New
        │
        ▼
Sales manager ASSIGNS it to a sales employee
        │
        ▼
Sales employee calls the customer and updates it ► status: Connected / Not connected / Confused
        │                                            + remarks after every call
        ▼
Deal done ─────────────────────────────────────► status: Closed, response: Positive (won) or Negative (lost)
        │
        ▼
Purchase manager ALLOTS a VENDOR to the order (Purchase Orders) so the goods can be sourced
```

Everything along the way feeds the dashboards: *open leads*, *leads won*, *deals won* and the monthly charts.

**For it to work:** every lead needs a real contact number and product; sales must update the status after every
contact; and a lead is only *Closed* once the outcome (positive / negative) is set.

### Tasks

```
Manager (or admin) assigns a task with a due date ──► employee gets an email
        │
        ▼
Employee: Pending ──► In Progress ──► Completed (the completion date is recorded)
        │
        ▼
Manager sees it live: team task chart, overdue and due-this-week tiles, completion rate
```

### Leave

```
Employee requests leave (Leave Portal) ──► their department manager gets an email
Manager requests leave                ──► the administrator gets an email
        │
        ▼
Approver approves or rejects ──► the requester gets an email with the decision
```

### Hiring

```
HR / admin posts a job (Careers) ──► it appears on the public Careers page until its deadline
        │
        ▼
Candidates apply on the website (with a PDF résumé) ──► Jobs Applications list in the CRM
        │
        ▼
HR shortlists or rejects ──► the selected person gets a CRM account through "Add user"
```

---

## 5. Features shared by every role

### 5.1 Your dashboard

The banner greets you and the tiles below it show your numbers. Managers see their **team**; employees see
**their own** work.

| Tile | Meaning |
|---|---|
| Tasks pending · in progress | Open work right now |
| Tasks overdue · due this week | What needs attention first |
| Completion rate · completed | Share of tasks finished |
| Leave requests | Requests waiting (managers: your team's; employees: your own) |
| Department tiles | Leads (marketing/sales), vendors (purchase), jobs and staff (HR), website inbox (website) |

![Sales manager dashboard](screenshots/25-crm-manager-dashboard.png)

**Charts with date ranges.** Under each dashboard chart, **Custom** opens the same chart with a date range of your
choice: for example *tasks completed last quarter* or *leads added in March*.

### 5.2 To Do list (your own tasks)

Every dashboard has a **To Do List** with the tasks assigned to you. Change a task's status from its dropdown:
**Pending → In Progress → Completed**. Search and filter by status at the top.

![Employee dashboard](screenshots/27-crm-employee-dashboard.png)

### 5.3 Leave Portal

* **Request leave:** select **Request Leave**, give the reason and the dates, and submit. Your approver is emailed.
* **Track it:** the list shows each request's status: *Pending*, *Approved* or *Rejected*. While a request is still
  pending you can edit it.
* **Managers** see a second table, *Employee Leave Management*, with their team's requests and ✓ / ✗ buttons to
  approve or reject.

![Leave portal](screenshots/36-crm-leave-portal.png)

### 5.4 My Profile

Your details at a glance (email, phone, date of birth, joining date and time with the company), plus:

* **Contact details:** update your phone number and email (your email is also your sign-in).
* **Change password:** current password, new password (8+ characters) and confirmation.

![My profile](screenshots/33-crm-profile.png)

---

## 6. Administrator

The admin sees the whole company and can do everything any role can.

### 6.1 Dashboard

* **Tiles:** active employees and managers, open leads, vendors, open and overdue tasks, pending leave, job applicants
  and open jobs, product enquiries, contact messages. Select a tile to open its page.
* **Trend range** (top right): show the monthly charts for the last 6, 12 or 24 months.
* **Charts:** new leads per month, leads by status, lead responses (won / lost), tasks by department, staff by
  department, leave requests, website activity (contact messages and job applications per month), applicants by status.
* **Tables:** latest leads, pending leave (with a *Review* shortcut) and most-enquired products.

### 6.2 Departments

Pick a department at the top (Marketing, Sales, Purchase, Website, HR) to see its staff and workload: open, overdue and
completed tasks, leads added, assigned and won, vendors added, pending leave and each person's last sign-in.
**Use it in reviews:** sort out who is overloaded and who has capacity before assigning new work.

![Departments](screenshots/22-crm-admin-departments.png)

### 6.3 Employee List: adding and removing people

1. Select **Add user**.
2. Fill in full name, **work email** (the login details are sent there), role (*Admin*, *Manager* or *Employee*),
   department (not needed for admins), phone, date of birth and date of joining. A PDF résumé (up to 5 MB) is optional.
3. Select **Create user & email login**. The person receives their sign-in link and a temporary password.
   *If the email can't be sent*, the CRM shows the temporary password once so you can pass it on securely.

**Removing someone** (they left the company): use **Fire Employee** in their row and give a reason. Their account is
deactivated and the date is recorded; their past work stays in the CRM.

![Add user](screenshots/23-crm-add-user.png)

### 6.4 Leave Portal

Every leave request in the company, with search and status / date filters, and ✓ / ✗ to decide. Managers' leave
requests come here.

### 6.5 Tasks

The company-wide task board: every manager's and employee's tasks, with search and filters by status and person.
**Assign New Task** lets you give a task to any manager or employee (grouped by department); they get an email.

![Assign a task](screenshots/34-crm-assign-task.png)

### 6.6 Leads

All leads in the company. The cards at the top count new, closed, won and lost leads. You can **add**, **edit**,
**assign** to a sales employee, set **status** and **response**, and add **remarks**. Filter by status, response or
employee.

![Leads](screenshots/24-crm-leads.png)

### 6.7 Vendors

The supplier list (company, product category, contact, whether you've dealt with them before, remarks). Add, edit or
delete vendors; the cards at the top show how many were added today, this month and in the last 7 days.

### 6.8 Careers

* **Add New Job:** title, category, type (full time, part time, contract, internship, remote), location, salary in
  rupees (for example *₹25,000 - ₹40,000 per month* or *6 - 9 LPA*), deadline, experience, education, description,
  and skills / responsibilities / requirements, **one per line**.
* The job shows on the public Careers page until its **deadline**, then disappears automatically.
* **Jobs Applications:** every applicant with contact details and **View PDF** for the résumé. **Shortlist** or
  **Reject** each one; the cards at the top count this month's jobs, applicants, shortlisted and rejected.

| Careers and applicants | Add a job |
|---|---|
| ![Careers](screenshots/38-crm-careers.png) | ![Add job](screenshots/35-crm-add-job.png) |

### 6.9 Workspaces: work as any role

The admin can step into any department's desk and use its tools exactly as that manager or employee would. This is
how the admin covers for someone who is away, or handles work that only a department screen offers (website content,
purchase orders, the sales pipeline…).

1. In the sidebar under **Work as**, select a desk, or select **All workspaces** (also **Work as any role** on the
   dashboard).
2. An **amber bar** at the top confirms *"Admin mode: you're working as Manager · Sales"*. Use its **Switch workspace**
   menu to jump to another desk, or **Back to admin** to return.
3. Inside a desk you follow that desk's rules. For example, the HR desk can't create other admins; use the admin
   Employee List for that.

**Everything you do in a desk is recorded under your admin account**, so a leave you approve in the Sales desk shows
that the admin approved it.

| All workspaces | Working in the Sales desk |
|---|---|
| ![Workspaces](screenshots/31-crm-workspaces.png) | ![Admin in the Sales desk](screenshots/32-crm-admin-in-sales-desk.png) |

---

## 7. HR manager

* **Dashboard:** your own tasks, applicant trends and the company's staffing numbers (active staff, open jobs,
  applicants, leave pending across the company).
* **Employee List:** add managers and employees (they're emailed their login), view résumés, and remove people who
  have left. HR can't create admin accounts.
* **Careers:** post, edit and delete jobs; shortlist or reject applicants ([§6.8](#68-careers) works the same way).
* **Leave Portal:** your own leave, and approval of your team's.

**Good routine:** check *Careers → Jobs Applications* daily, so candidates hear back quickly; when someone joins,
create their account on their first day so the welcome email arrives on time.

---

## 8. Marketing manager and employees

**Marketing employees**

* **Leads:** select **Add New Lead** for every enquiry: name, contact number, email, product and quantity. Then keep
  its status and remarks up to date.
* **Dashboard:** your tasks, leads you've added this month and their outcome.

**Marketing manager**

* **Leads:** every lead the marketing team added, with search and filters; edit, add remarks, and see who added each.
* **Dashboard:** team task board (**Assign New Task**), team task chart, leads added per month, your own tasks.
* **Employee List:** your team, with their details and résumés; remove someone who has left.
* **Leave Portal:** approve or reject the team's leave.

**Tip:** add the lead *while you're still on the call*. A lead with a correct phone number and product is far more
likely to be closed by sales.

---

## 9. Sales manager and employees

**Sales manager**

* **Sales Data:** the sales pipeline. **Assign** (or **Re-Assign**) each lead to a sales employee and filter by
  employee to see each person's pipeline. Track status (*New, Connected, Not connected, Confused, Closed*) and
  response (*Positive* = won, *Negative* = lost).
* **Dashboard:** team tasks, monthly progress (new, in progress, won, lost) and *Sales this month*.
* **Employee List** and **Leave Portal** for your team.

**Sales employees**

* **Sales Data:** the leads assigned to you. After every call, update the **status**, the **response** once the
  customer decides, and the **remarks** (what was said, when to call back).
* **Dashboard:** your tasks and your pipeline trend.

**Tip:** the remarks are your memory and your manager's. "Called 30 Oct, wants a quote for 10 laptops, call back
Monday" is worth far more than "called".

---

## 10. Purchase manager and employees

**Purchase manager**

* **Vendors:** the supplier list: add, edit, delete, search by category. Mark whether you've dealt with them before.
* **Purchase Orders:** customer orders that need sourcing. Select **Allot** to choose the supplier (vendor) for each
  order; update its status and remarks.
* **Dashboard:** team tasks and vendors added over time; **Employee List** and **Leave Portal** for your team.

**Purchase employees**

* **Vendors:** add new suppliers and keep the ones you added up to date.
* **Dashboard:** your tasks and vendors added over time.

**Tip:** always fill *product category* and *previous deal* on a vendor. That's what makes the list searchable when
an order comes in.

---

## 11. Website manager

Everything on the public website is edited from here, so there is no need to touch code.

| Page | What you manage |
|---|---|
| **Enquiries** | Product enquiries from the website, by product and date. |
| **Products** | The product catalogue: name, category, price (₹), description, image, catalogue PDF, status (active / discontinued) and *featured*. Categories are managed on the same page. |
| **NM Reviews** | Customer reviews. Make each one **public** (shown on the website) or **private** (hidden). |
| **Contact Submits** | Messages from the website's contact form. Contact the customer, then select **Respond** to record your reply; the message is marked *Responded*. (The CRM records the reply; it doesn't email it.) |
| **Blogs** | Write posts: title, author, topic, summary, article and cover image. Save as **Draft**, then **Publish**; *Hide* takes a post off the site without deleting it. The editor supports simple formatting: `## heading`, `**bold**`, `- bullet`, `[link](https://…)`. |
| **Events** | Events with date, time, mode (in person, virtual, hybrid), location, image and the **registration link** behind the website's *Register* button. They move from *Upcoming* to *Past* on the website automatically, using Indian time. |
| **NM Newsletter** | Everyone who signed up on the website: active and unsubscribed counts, search, **Unsubscribe / Resubscribe**, delete, and **Export CSV** for your email tool. |
| **NM Web Data** | Shortcuts to the homepage sections. **Team**, **Client logos**, **Stats**, ***Why choose us* cards** and **FAQs** each have **Add**, **Edit** and **Delete**; **Web line** (site name, phone, email, address, social links) can be edited. Changes appear on the website immediately. |
| **Hero slides** | Managed here, but the current homepage uses its own built-in slider, so changes don't show on the live site yet. |

| Blog posts | Blog editor |
|---|---|
| ![Blog manager](screenshots/29-crm-blog-manager.png) | ![Blog editor](screenshots/30-crm-blog-editor.png) |

**Tips:** use a wide image (about 1600 × 900 px, under 5 MB) for blog covers; answer contact messages within one
working day; check reviews weekly and make the good ones public.

---

## 12. Emails the CRM sends

All CRM email comes from **mcnikte@nminfocom.com**.

| When | Who receives it |
|---|---|
| An account is created | The new person: sign-in link and temporary password |
| A task is assigned | The person it's assigned to |
| Leave is requested | The employee's department managers (for a manager's request: the administrator) |
| Leave is approved or rejected | The person who asked |

If an email doesn't arrive, check the spam folder first. The action itself (task, leave) is saved even if the email
can't be delivered.

---

## 13. Working efficiently: routines and tips

**Everyone, every day (5 minutes)**

1. Open your dashboard and look at the **overdue** and **due this week** tiles first.
2. Move tasks along as you work, and mark them **Completed** the moment they're done. That's what keeps your
   completion rate and your manager's charts truthful.
3. Request leave as early as possible.

**Managers, every week**

1. Look at the team task chart and the overdue tile; reassign work when someone is overloaded.
2. Clear pending leave requests so nobody waits.
3. Use **Custom** on the dashboard charts to compare this month with last month.

**Administrator, every week**

1. Dashboard with **Trend range = 12 months**: are leads, wins and website activity growing?
2. **Departments:** check workload and last sign-in per person.
3. Handle leave from managers, and step into a department's **workspace** when someone is away.

**Small things that save time**

* Select a **KPI tile** to jump straight to its page.
* The **search box** searches every column: try a phone number, a company name or a date.
* **Filters combine.** *Status = Pending* plus *employee* gives you one person's open work.
* Use **dark mode** for long sessions and the **phone layout** for quick updates on the go.
* Write **remarks** that someone else could act on without calling you.

---

## 14. Security and good practice

* **Never share your account.** Everything you do is recorded under your name.
* **Sign out** (arrow next to your name) on shared or office computers. Sessions end automatically after 24 hours.
* **Keep your password private** and change it if you think someone has seen it. Nobody from NM INFOCOM will ever ask
  for it.
* **Personal data:** résumés, phone numbers and customer details are confidential. Don't download or forward them
  unless your work needs it.
* **People leaving:** HR or the manager should remove their access on their last day.

---

## 15. Questions and problems

| Problem | What to do |
|---|---|
| I didn't receive my login email | Check spam. Otherwise ask HR or the admin to create the account again. |
| "Invalid email or password" | Check for typos with the eye icon. After 10 failures, wait 15 minutes. |
| I'm sent back to the sign-in page | Your session expired (24 hours), your password was changed (which signs out your other devices), or your account was changed or removed. Sign in again, or ask the admin. |
| A page looks broken or empty | Refresh the page (Ctrl+F5 / Cmd+Shift+R). If it persists, tell the admin which page and what you did. |
| I can't see a menu item a colleague has | Menus depend on role and department. Ask the admin if you need access. |
| The Assign task form says *No one to assign yet* | Your department has no active employees yet. HR or the admin can add them. |
| Charts say *No data yet* | Nothing has been recorded for that period yet. Try a wider range with **Custom**. |
| A job disappeared from the website | Its deadline passed. Edit the job and move the deadline to show it again. |

For anything else, contact the administrator at **mcnikte@nminfocom.com**.
