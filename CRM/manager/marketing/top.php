<?php
$section = [
    'role' => 'Manager',
    'sub_role' => 'marketing',
    'title' => 'Marketing Manager',
    'base' => '../../',
    'nav' => [
        ['dashboard.php', 'fas fa-chart-bar', 'Dashboard'],
        ['profile.php', 'fas fa-user', 'My Profile'],
        ['leave_portal.php', 'fas fa-calendar-alt', 'Leave Portal'],
        ['leads.php', 'fas fa-bullseye', 'Leads'],
        ['emp_list.php', 'fas fa-users', 'Employee List'],
    ],
];
require __DIR__ . '/../../layout/top.php';
