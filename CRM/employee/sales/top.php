<?php
$section = [
    'role' => 'Employee',
    'sub_role' => 'sales',
    'title' => 'Sales',
    'base' => '../../',
    'nav' => [
        ['main.php', 'fas fa-chart-bar', 'Dashboard'],
        ['profile.php', 'fas fa-user', 'My Profile'],
        ['leave_portal.php', 'fas fa-calendar-alt', 'Leave Portal'],
        ['sales.php', 'fas fa-chart-line', 'Sales'],
    ],
];
require __DIR__ . '/../../layout/top.php';
