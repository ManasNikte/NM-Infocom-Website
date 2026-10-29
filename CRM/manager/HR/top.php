<?php
$section = [
    'role' => 'Manager',
    'sub_role' => 'hr',
    'title' => 'HR Manager',
    'base' => '../../',
    'nav' => [
        ['dashboard.php', 'fas fa-chart-bar', 'Dashboard'],
        ['profile.php', 'fas fa-user', 'My Profile'],
        ['leave_portal.php', 'fas fa-calendar-alt', 'Leave Portal'],
        ['career.php', 'fas fa-briefcase', 'Career Portal'],
        ['emp_list.php', 'fas fa-users', 'Employee List'],
    ],
];
require __DIR__ . '/../../layout/top.php';
