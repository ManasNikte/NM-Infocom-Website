<?php
$section = [
    'role' => 'Admin',
    'sub_role' => null,
    'title' => 'Admin',
    'base' => '../',
    'heading' => $adminHeading ?? null,
    'nav' => [
        ['dashboard.php', 'fas fa-chart-bar', 'Dashboard'],
        ['profile.php', 'fas fa-user', 'My Profile'],
        ['emp_list.php', 'fas fa-users', 'Employee List'],
        ['leave_portal.php', 'fas fa-calendar-alt', 'Leave Portal'],
        ['task.php', 'fas fa-tasks', 'Tasks'],
        ['leads.php', 'fas fa-bullseye', 'Leads'],
        ['vendors.php', 'fas fa-truck', 'Vendors'],
        ['careers.php', 'fas fa-briefcase', 'Careers'],
        ['departments.php', 'fas fa-sitemap', 'Departments'],
    ],
];
require __DIR__ . '/../layout/top.php';
